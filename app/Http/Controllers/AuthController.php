<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Helper to load SQL statement
     */
    private function getQuery(string $filename): string
    {
        $path = database_path('sql/queries/auth/' . $filename);
        if (!file_exists($path)) {
            throw new \Exception("Query file missing: " . $path);
        }
        return file_get_contents($path);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $query = $this->getQuery('find_user_by_email.sql');
        $users = DB::select($query, [$request->email]);

        if (count($users) === 0) {
            return back()->withErrors(['email' => 'These credentials do not match our records.'])->withInput();
        }

        $user = $users[0];

        // Check password hash
        if (Hash::check($request->password, $user->password)) {
            Session::put('user_id', $user->id);
            return redirect()->intended('/')->with('success', 'Successfully logged in!');
        }

        return back()->withErrors(['email' => 'These credentials do not match our records.'])->withInput();
    }

    public function register(Request $request)
    {
        // For SQL Server the table is referenced directly in unique string 'unique:table,column'
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'number' => 'required|string|max:20|unique:users,phone_number',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $hashedPassword = Hash::make($request->password);

        try {
            DB::beginTransaction();

            $insertUserQuery = $this->getQuery('insert_user.sql');
            
            // `DB::select` is used here because SQL Server `OUTPUT INSERTED.id` returns a result set
            $result = DB::select($insertUserQuery, [
                $request->name,
                $request->email,
                $hashedPassword,
                $request->number,
                1 // is_active
            ]);
            
            $userId = $result[0]->id;

            $insertAddressQuery = $this->getQuery('insert_address.sql');
            DB::insert($insertAddressQuery, [
                $userId,
                'Home',
                $request->address,
                'Unknown', // defaulting city
                1 // is_default
            ]);

            DB::commit();

            Session::put('user_id', $userId);
            return redirect('/')->with('success', 'Successfully registered!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['email' => 'DB Error: ' . $e->getMessage()])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Session::forget('user_id');
        Session::flush();
        return redirect('/login')->with('success', 'Successfully logged out!');
    }
}
