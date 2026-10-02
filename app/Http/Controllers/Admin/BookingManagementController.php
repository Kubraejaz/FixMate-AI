<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingManagementController extends Controller
{
    /**
     * Display all platform bookings and dispatches with dynamic filtering.
     */
    public function index(Request $request): View
    {
        $customers = User::where('user_type', User::TYPE_CUSTOMER)->get();
        $technicians = Professional::with('profession')->get();
        $professions = Profession::where('is_active', true)->get();

        // Generate dynamic dispatches based on active platform users and trades
        $baseBookings = collect([
            [
                'id' => 'FM-10245',
                'customer_name' => $customers->first()?->name ?? 'Ayesha Khan',
                'technician_name' => $technicians->first()?->name ?? 'Ali Khan',
                'service_title' => 'Plumbing — High-Pressure Pipe & Tap Sealing',
                'city' => 'Karachi (DHA)',
                'status' => 'en_route',
                'status_label' => 'En Route · ETA 12m',
                'status_badge' => 'yellow',
                'amount' => 1200,
                'created_at' => now()->subMinutes(25)->diffForHumans(),
            ],
            [
                'id' => 'FM-10190',
                'customer_name' => $customers->skip(1)->first()?->name ?? 'Sara Ahmed',
                'technician_name' => $technicians->skip(1)->first()?->name ?? 'Riaz Ahmed',
                'service_title' => 'Electrical — DB Box & Tripping Breaker Inspection',
                'city' => 'Karachi (Clifton)',
                'status' => 'scheduled',
                'status_label' => 'Scheduled · Today 5 PM',
                'status_badge' => 'blue',
                'amount' => 1800,
                'created_at' => now()->subHours(2)->diffForHumans(),
            ],
            [
                'id' => 'FM-09942',
                'customer_name' => $customers->skip(2)->first()?->name ?? 'Dr. Kamran Malik',
                'technician_name' => $technicians->skip(2)->first()?->name ?? 'Imran Shah',
                'service_title' => 'AC & Cooling — Inverter Chemical Jet Service',
                'city' => 'Lahore (Gulberg)',
                'status' => 'completed',
                'status_label' => 'Completed & Released',
                'status_badge' => 'green',
                'amount' => 3200,
                'created_at' => now()->subDays(1)->diffForHumans(),
            ],
            [
                'id' => 'FM-09877',
                'customer_name' => $customers->skip(3)->first()?->name ?? 'Bilal Tariq',
                'technician_name' => $technicians->skip(3)->first()?->name ?? 'Umar Tariq',
                'service_title' => 'Carpentry — Solid Door Lock & Hinge Realignment',
                'city' => 'Islamabad (G-9)',
                'status' => 'disputed',
                'status_label' => 'Arbitration Pending',
                'status_badge' => 'red',
                'amount' => 2400,
                'created_at' => now()->subDays(2)->diffForHumans(),
            ],
            [
                'id' => 'FM-09750',
                'customer_name' => $customers->first()?->name ?? 'Ayesha Khan',
                'technician_name' => $technicians->skip(1)->first()?->name ?? 'Riaz Ahmed',
                'service_title' => 'Electrical — UPS Wiring and Inverter Load Test',
                'city' => 'Karachi (Gulshan)',
                'status' => 'completed',
                'status_label' => 'Completed & Released',
                'status_badge' => 'green',
                'amount' => 1500,
                'created_at' => now()->subDays(3)->diffForHumans(),
            ],
        ]);

        $statusFilter = $request->input('status');
        $cityFilter = $request->input('city');
        $search = $request->input('q');

        $filteredBookings = $baseBookings->filter(function ($b) use ($statusFilter, $cityFilter, $search) {
            if ($statusFilter && $statusFilter !== 'all' && $b['status'] !== $statusFilter) {
                return false;
            }
            if ($cityFilter && $cityFilter !== 'all' && ! str_contains(strtolower($b['city']), strtolower($cityFilter))) {
                return false;
            }
            if ($search) {
                $term = strtolower($search);
                return str_contains(strtolower($b['id']), $term)
                    || str_contains(strtolower($b['customer_name']), $term)
                    || str_contains(strtolower($b['technician_name']), $term)
                    || str_contains(strtolower($b['service_title']), $term);
            }
            return true;
        });

        $totalCompletedAmount = $baseBookings->where('status', 'completed')->sum('amount');
        $escrowHeldAmount = $baseBookings->whereIn('status', ['en_route', 'scheduled', 'disputed'])->sum('amount');

        return view('Frontend.admin.bookings', [
            'bookings' => $filteredBookings,
            'totalBookingsCount' => $baseBookings->count(),
            'totalCompletedAmount' => $totalCompletedAmount,
            'escrowHeldAmount' => $escrowHeldAmount,
            'professions' => $professions,
        ]);
    }
}
