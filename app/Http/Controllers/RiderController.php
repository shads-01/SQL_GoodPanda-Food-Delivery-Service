<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class RiderController extends Controller
{
    /**
     * Helper – load a raw SQL file from the rider queries folder.
     */
    private function getQuery(string $filename): string
    {
        return file_get_contents(database_path('sql/queries/rider/' . $filename));
    }

    /**
     * Helper – manual array-based pagination for raw SQL result sets.
     */
    private function manualPaginate(array $results, int $perPage, string $pageName = 'page'): LengthAwarePaginator
    {
        $page  = Paginator::resolveCurrentPage($pageName);
        $total = count($results);
        $items = array_slice($results, ($page - 1) * $perPage, $perPage);

        return new LengthAwarePaginator(
            $items, $total, $perPage, $page,
            ['path' => request()->url(), 'pageName' => $pageName, 'query' => request()->query()]
        );
    }

    // -------------------------------------------------------
    // DASHBOARD
    // -------------------------------------------------------
    public function dashboard()
    {
        $userId = session('user_id');

        $statsSql       = $this->getQuery('get_rider_dashboard_stats.sql');
        $stats          = DB::selectOne($statsSql, [$userId, $userId]);

        $activeSql      = $this->getQuery('get_rider_active_delivery.sql');
        $activeDelivery = DB::selectOne($activeSql, [$userId]);

        $availableSql   = $this->getQuery('get_available_deliveries.sql');
        $availableList  = DB::select($availableSql);
        $availablePagin = $this->manualPaginate($availableList, 5);

        return view('rider.dashboard', [
            'stats'          => $stats,
            'activeDelivery' => $activeDelivery,
            'availableList'  => $availablePagin
        ]);
    }

    // -------------------------------------------------------
    // ACCEPT DELIVERY
    // -------------------------------------------------------
    public function acceptDelivery(Request $request)
    {
        $request->validate(['order_id' => 'required|integer']);
        $userId = session('user_id');

        // Check if rider already has an active delivery
        $activeSql = $this->getQuery('get_rider_active_delivery.sql');
        $active    = DB::selectOne($activeSql, [$userId]);
        if ($active) {
            return back()->with('error', 'You already have an active delivery.');
        }

        $acceptSql = $this->getQuery('accept_delivery.sql');
        DB::statement($acceptSql, [$userId, $request->order_id, $request->order_id]);

        return back()->with('success', 'Delivery accepted successfully. Head to the restaurant!');
    }

    // -------------------------------------------------------
    // UPDATE DELIVERY STATUS
    // -------------------------------------------------------
    public function updateDeliveryStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:picked_up,delivered']);
        $userId = session('user_id');

        // Verify ownership and fetch order_id
        $del = DB::selectOne("SELECT order_id, delivery_status FROM deliveries WHERE delivery_id = ? AND partner_id = ?", [$id, $userId]);
        if (!$del) abort(404, 'Delivery not found or not assigned to you.');

        if ($request->status === 'picked_up') {
            if ($del->delivery_status !== 'assigned') return back()->with('error', 'Invalid state transition.');
            
            $order = DB::selectOne("SELECT order_status FROM orders WHERE order_id = ?", [$del->order_id]);
            if ($order && $order->order_status !== 'ready') {
                return back()->with('error', 'You can only pick up an order when it is marked as Ready by the restaurant.');
            }

            $sql = $this->getQuery('mark_delivery_picked_up.sql');
            DB::statement($sql, [$id, $userId, $del->order_id]);
            return back()->with('success', 'Marked as Picked Up. Now deliver to the customer!');
        } 
        else if ($request->status === 'delivered') {
            if (!in_array($del->delivery_status, ['picked_up', 'on_the_way'])) return back()->with('error', 'Invalid state transition.');
            $sql = $this->getQuery('mark_delivery_delivered.sql');
            DB::statement($sql, [$id, $userId, $del->order_id, $del->order_id, $userId]);
            return back()->with('success', 'Delivery completed! Your earnings have been updated.');
        }

        return back();
    }

    // -------------------------------------------------------
    // FULL DELIVERY HISTORY PAGE
    // -------------------------------------------------------
    public function deliveryHistory()
    {
        $userId = session('user_id');
        $deliveriesSql = $this->getQuery('get_rider_deliveries.sql');
        $allDeliveries = DB::select($deliveriesSql, [$userId]);
        $deliveries    = $this->manualPaginate($allDeliveries, 15);

        return view('rider.deliveries', compact('deliveries'));
    }

    // -------------------------------------------------------
    // PROFILE PAGE
    // -------------------------------------------------------
    public function profile()
    {
        $userId = session('user_id');

        $profileSql = $this->getQuery('get_rider_profile.sql');
        $user       = DB::selectOne($profileSql, [$userId]);

        if (!$user) {
            abort(404, 'Rider profile not found.');
        }

        $deliveriesSql   = $this->getQuery('get_rider_deliveries.sql');
        $allDeliveries   = DB::select($deliveriesSql, [$userId]);
        $deliveries      = $this->manualPaginate($allDeliveries, 10);

        return view('rider.profile', compact('user', 'deliveries'));
    }

    // -------------------------------------------------------
    // UPDATE PROFILE
    // -------------------------------------------------------
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'         => 'required|min:2',
            'phone_number' => 'required|regex:/^01[0-9]{9}$/',
            'email'        => 'required|email|max:100',
        ]);

        $userId = session('user_id');

        // Check uniqueness via raw SQL
        $exists = DB::selectOne("
            SELECT id FROM users 
            WHERE (email = ? OR phone_number = ?) 
            AND id != ? 
            AND is_active = 1
        ", [$request->email, $request->phone_number, $userId]);

        if ($exists) {
            return back()->with('error', 'The email or phone number is already registered to another active account.');
        }

        DB::transaction(function () use ($request, $userId) {
            // Update users table for basic info
            $updateUserSql = $this->getQuery('update_rider_profile.sql');
            DB::statement($updateUserSql, [
                $request->name,
                $request->email,
                $request->phone_number,
                $userId
            ]);

            // Update session data
            session([
                'user_name'  => $request->name,
                'user_email' => $request->email,
            ]);
        });

        return back()->with('success', 'Profile updated successfully.');
    }

    // -------------------------------------------------------
    // UPDATE VEHICLE DETAILS
    // -------------------------------------------------------
    public function updateVehicle(Request $request)
    {
        $request->validate([
            'vehicle_type' => 'required|in:bike,scooter,bicycle,car',
            'is_available' => 'required|boolean'
        ]);

        $userId = session('user_id');

        $updateVehicleSql = $this->getQuery('update_rider_vehicle.sql');
        DB::statement($updateVehicleSql, [
            $request->vehicle_type,
            $request->is_available,
            $userId
        ]);

        return back()->with('success', 'Vehicle details updated successfully.');
    }

    // -------------------------------------------------------
    // DELETE ACCOUNT
    // -------------------------------------------------------
    public function deleteAccount(Request $request)
    {
        $userId = session('user_id');

        $user = DB::selectOne("SELECT email, phone_number FROM users WHERE id = ?", [$userId]);
        if (!$user) {
            return redirect()->route('login');
        }

        $randStr = Str::random(5);
        $deletedEmail = 'deleted_' . $randStr . '_' . $user->email;
        $deletedPhone = 'deleted_' . $randStr . '_' . $user->phone_number;

        $deleteSql = $this->getQuery('soft_delete_rider_account.sql');
        DB::statement($deleteSql, [$deletedEmail, $deletedPhone, $userId]);

        Session::flush();
        return redirect()->route('login')->with('success', 'Your Rider account has been permanently closed.');
    }
}
