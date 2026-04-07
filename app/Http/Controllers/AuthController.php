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
            Session::put('user_role', $user->role);

            return match($user->role) {
                'restaurant_owner' => redirect()->route('restaurant.dashboard')->with('success', 'Welcome back!'),
                'delivery_partner' => redirect()->route('rider.dashboard')->with('success', 'Welcome back!'),
                default            => redirect()->route('home')->with('success', 'Welcome back!'),
            };
        }

        return back()->withErrors(['email' => 'These credentials do not match our records.'])->withInput();
    }

    public function register(Request $request)
    {
        // For SQL Server the table is referenced directly in unique string 'unique:table,column'
        $request->validate([
            'role' => 'required|in:customer,restaurant_owner,delivery_partner',
            'name' => 'required|string|max:100',
            'email' => ['required','string','email','max:100', \Illuminate\Validation\Rule::unique('users','email')->where('is_active', 1)],
            'number' => ['required','string','max:20', \Illuminate\Validation\Rule::unique('users','phone_number')->where('is_active', 1)],
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8',

            // Conditional: required only for owners
            'restaurant_name' => 'required_if:role,restaurant_owner|nullable|string|max:255',
            'restaurant_location' => 'required_if:role,restaurant_owner|nullable|string|max:255',
            'restaurant_phone' => 'required_if:role,restaurant_owner|nullable|string|max:20', // Added missing validation
            'restaurant_cover' => 'required_if:role,restaurant_owner|image|mimes:jpeg,png,jpg|max:2048',

            // Conditional: required only for riders
            'vehicle_type' => 'required_if:role,delivery_partner|nullable|in:bike,scooter,bicycle,car',
        ]);

        $hashedPassword = Hash::make($request->password);

        try {
            DB::beginTransaction();

            $insertUserQuery = $this->getQuery('insert_user.sql');

            // `DB::select` is used here because SQL Server `OUTPUT INSERTED.id` returns a result set
            $result = DB::select($insertUserQuery, [
                $request->role,
                $request->name,
                $request->email,
                $hashedPassword,
                $request->number,
                1 // is_active
            ]);

            if (empty($result)) {
                throw new \Exception('User could not be created. The users table may be missing or the insert failed.');
            }
            $userId = $result[0]->id;

            if ($request->role === 'restaurant_owner') {
                
                // 1. Handle the Cloudinary Upload
                $coverImageUrl = null;
                $coverImagePublicId = null; 

                if ($request->hasFile('restaurant_cover')) {
                    try {
                        $file = $request->file('restaurant_cover');
                        $cloudName = env('CLOUDINARY_CLOUD_NAME');
                        $apiKey    = env('CLOUDINARY_API_KEY');
                        $apiSecret = env('CLOUDINARY_API_SECRET');
                        $timestamp = time();
                        $folder = 'goodpanda/assets';

                        // Build signature
                        $paramsToSign = "folder={$folder}&timestamp={$timestamp}";
                        $signature = sha1($paramsToSign . $apiSecret);

                        // Upload via curl directly (bypasses SDK parsing bugs)
                        $ch = curl_init("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload");
                        curl_setopt_array($ch, [
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST           => true,
                            CURLOPT_POSTFIELDS     => [
                                'file'      => new \CURLFile($file->getRealPath(), $file->getMimeType(), $file->getClientOriginalName()),
                                'api_key'   => $apiKey,
                                'timestamp' => $timestamp,
                                'folder'    => $folder,
                                'signature' => $signature,
                            ],
                        ]);
                        $response = curl_exec($ch);
                        curl_close($ch);

                        $result = json_decode($response, true);
                        if (isset($result['secure_url'])) {
                            $coverImageUrl = $result['secure_url'];
                            $coverImagePublicId = $result['public_id'] ?? null;
                        } else {
                            \Illuminate\Support\Facades\Log::warning('Cloudinary upload returned no URL: ' . $response);
                        }
                    } catch (\Throwable $cloudinaryEx) {
                        \Illuminate\Support\Facades\Log::error('Cloudinary upload failed: [' . get_class($cloudinaryEx) . '] ' . $cloudinaryEx->getMessage());
                        $coverImageUrl = null;
                    }
                }

                $insertOwnerProfileQuery = $this->getQuery('insert_owner_profile.sql');
                DB::insert($insertOwnerProfileQuery, [$userId]);

                // 2. Insert into database using the new Cloudinary URL
                $insertRestaurantQuery = $this->getQuery('insert_restaurant.sql');
                DB::insert($insertRestaurantQuery, [
                    $userId,
                    $request->restaurant_name,
                    $request->restaurant_location,
                    $request->restaurant_phone,
                    'https://ui-avatars.com/api/?name=' . urlencode($request->restaurant_name),
                    $coverImageUrl, // Replaced the "null" placeholder with the actual URL
                    1
                ]);
            } elseif ($request->role === 'delivery_partner') {
                $insertDeliveryProfileQuery = $this->getQuery('insert_delivery_profile.sql');
                DB::insert($insertDeliveryProfileQuery, [$userId, $request->vehicle_type]);
            } else {
                $insertCustomerProfileQuery = $this->getQuery('insert_customer_profile.sql');
                DB::insert($insertCustomerProfileQuery, [$userId]);

                $insertAddressQuery = $this->getQuery('insert_address.sql');
                DB::insert($insertAddressQuery, [
                    $userId,
                    'Home',
                    $request->address,
                    'Unknown', // defaulting city
                    1 // is_default
                ]);
            }

            DB::commit();

            Session::put('user_id', $userId);
            Session::put('user_role', $request->role);

            return match($request->role) {
                'restaurant_owner' => redirect()->route('restaurant.dashboard')->with('success', 'Registration successful! Welcome aboard.'),
                'delivery_partner' => redirect()->route('rider.dashboard')->with('success', 'Registration successful! Welcome aboard.'),
                default            => redirect()->route('home')->with('success', 'Registration successful! Welcome aboard.'),
            };

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['email' => 'DB Error: [' . get_class($e) . '] ' . $e->getMessage()])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Session::forget('user_id');
        Session::flush();
        return redirect('/login')->with('success', 'Successfully logged out!');
    }
}