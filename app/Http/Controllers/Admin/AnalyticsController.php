<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityIssue;
use App\Models\ContactInquiry;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    /**
     * Display the platform growth analytics dashboard.
     */
    public function analytics(): View
    {
        $totalCustomers = User::where('user_type', User::TYPE_CUSTOMER)->count();
        $totalTechnicians = Professional::count();
        $verifiedTechnicians = Professional::where('is_verified', true)->count();
        $totalInquiries = ContactInquiry::count();
        $resolvedIssues = CommunityIssue::where('status', 'resolved')->count();
        $activeAlerts = CommunityIssue::where('status', 'alert_active')->count();

        $professions = Profession::where('is_active', true)->withCount('professionals')->get();

        return view('Frontend.admin.analytics', compact(
            'totalCustomers',
            'totalTechnicians',
            'verifiedTechnicians',
            'totalInquiries',
            'resolvedIssues',
            'activeAlerts',
            'professions'
        ));
    }

    /**
     * Display the AI Diagnostics inspection and neural confidence logs.
     */
    public function aiDiagnostics(): View
    {
        $professions = Profession::where('is_active', true)->get();
        $technicians = Professional::with('profession')->get();
        $customers = User::where('user_type', User::TYPE_CUSTOMER)->get();

        $scans = collect([
            [
                'image' => asset('assets/images/image_6.png'),
                'problem' => 'Under-sink P-trap PVC hairline crack',
                'customer_name' => $customers->first()?->name ?? 'Ayesha Khan',
                'time_ago' => '18 mins ago',
                'detected_trade' => 'Plumbing',
                'confidence' => '94.6%',
                'confidence_class' => 'green',
                'predicted_cost' => 'Rs. 750 – 1,100',
                'matched_technician' => $technicians->first()?->name ?? 'Ali Khan',
                'status' => 'Verified Accurate',
                'status_class' => 'green',
            ],
            [
                'image' => asset('assets/images/image_5.png'),
                'problem' => 'Main distribution board circuit breaker tripping',
                'customer_name' => $customers->skip(1)->first()?->name ?? 'Sara Ahmed',
                'time_ago' => '42 mins ago',
                'detected_trade' => 'Electrical',
                'confidence' => '97.2%',
                'confidence_class' => 'green',
                'predicted_cost' => 'Rs. 1,400 – 2,200',
                'matched_technician' => $technicians->skip(1)->first()?->name ?? 'Riaz Ahmed',
                'status' => 'Verified Accurate',
                'status_class' => 'green',
            ],
            [
                'image' => asset('assets/images/image_7.png'),
                'problem' => 'Inverter condenser coil icing and refrigerant leak',
                'customer_name' => $customers->skip(2)->first()?->name ?? 'Dr. Kamran Malik',
                'time_ago' => '2 hours ago',
                'detected_trade' => 'AC & Refrigeration',
                'confidence' => '91.0%',
                'confidence_class' => 'green',
                'predicted_cost' => 'Rs. 2,800 – 4,500',
                'matched_technician' => $technicians->skip(2)->first()?->name ?? 'Imran Shah',
                'status' => 'Verified Accurate',
                'status_class' => 'green',
            ],
            [
                'image' => asset('assets/images/image_8.png'),
                'problem' => 'Solid wooden door lock misaligned with frame groove',
                'customer_name' => $customers->skip(3)->first()?->name ?? 'Bilal Tariq',
                'time_ago' => '5 hours ago',
                'detected_trade' => 'Carpentry',
                'confidence' => '88.5%',
                'confidence_class' => 'yellow',
                'predicted_cost' => 'Rs. 1,000 – 1,500',
                'matched_technician' => $technicians->skip(3)->first()?->name ?? 'Umar Tariq',
                'status' => 'Pending Calibration',
                'status_class' => 'yellow',
            ],
        ]);

        return view('Frontend.admin.ai-diagnostics', compact('scans', 'professions'));
    }
}
