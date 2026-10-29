<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\CommunityIssue;
use App\Models\CommunityIssueUpvote;
use App\Models\ContactInquiry;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\Review;
use App\Models\TechnicianApplication;
use App\Models\TechnicianSubscription;
use App\Models\User;
use App\Models\VideoMeeting;
use App\Support\Permissions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class RolesPermissionsAndRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_roles_identification_and_helpers(): void
    {
        $admin = User::factory()->create(['user_type' => User::TYPE_ADMIN]);
        $customer = User::factory()->create(['user_type' => User::TYPE_CUSTOMER]);
        $technician = User::factory()->create(['user_type' => User::TYPE_TECHNICIAN]);

        // Role booleans
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isCustomer());
        $this->assertFalse($admin->isTechnician());

        $this->assertTrue($customer->isCustomer());
        $this->assertFalse($customer->isAdmin());
        $this->assertFalse($customer->isTechnician());

        $this->assertTrue($technician->isTechnician());
        $this->assertFalse($technician->isAdmin());
        $this->assertFalse($technician->isCustomer());

        // Role string names
        $this->assertEquals('admin', $admin->role_name);
        $this->assertEquals('customer', $customer->role_name);
        $this->assertEquals('technician', $technician->role_name);

        // Role labels
        $this->assertEquals('Administrator', $admin->role_label);
        $this->assertEquals('Customer', $customer->role_label);
        $this->assertEquals('Technician / Partner', $technician->role_label);

        // hasRole helper
        $this->assertTrue($admin->hasRole('admin'));
        $this->assertTrue($admin->hasRole(User::TYPE_ADMIN));
        $this->assertTrue($customer->hasRole('customer'));
        $this->assertTrue($technician->hasRole('technician'));
        $this->assertTrue($technician->hasRole('provider'));

        // hasAnyRole helper
        $this->assertTrue($customer->hasAnyRole('admin', 'customer'));
        $this->assertTrue($technician->hasAnyRole(['admin', 'technician']));
        $this->assertFalse($customer->hasAnyRole('admin', 'technician'));

        // Dashboard routes
        $this->assertEquals('/admin/dashboard', $admin->dashboardRoute());
        $this->assertEquals('/customer/dashboard', $customer->dashboardRoute());
        $this->assertEquals('/technician/dashboard', $technician->dashboardRoute());
    }

    public function test_permissions_system_and_helpers(): void
    {
        $admin = User::factory()->create(['user_type' => User::TYPE_ADMIN]);
        $customer = User::factory()->create(['user_type' => User::TYPE_CUSTOMER]);
        $technician = User::factory()->create(['user_type' => User::TYPE_TECHNICIAN]);

        // Admin permissions
        $this->assertTrue($admin->hasPermission(Permissions::SERVICES_MANAGE));
        $this->assertTrue($admin->hasPermission(Permissions::TECHNICIANS_VERIFY));
        $this->assertTrue($admin->hasPermission(Permissions::COMMUNITY_MODERATE));

        // Customer permissions
        $this->assertTrue($customer->hasPermission(Permissions::BOOKINGS_CREATE));
        $this->assertTrue($customer->hasPermission(Permissions::COMMUNITY_REPORT));
        $this->assertFalse($customer->hasPermission(Permissions::SERVICES_MANAGE));
        $this->assertFalse($customer->hasPermission(Permissions::JOBS_ACCEPT));

        // Technician permissions
        $this->assertTrue($technician->hasPermission(Permissions::JOBS_ACCEPT));
        $this->assertTrue($technician->hasPermission(Permissions::KYC_SUBMIT));
        $this->assertFalse($technician->hasPermission(Permissions::SERVICES_MANAGE));

        // Permissions array
        $this->assertNotEmpty($admin->getPermissions());
        $this->assertContains(Permissions::ADMIN_ACCESS, $admin->getPermissions());
        $this->assertContains(Permissions::CUSTOMER_ACCESS, $customer->getPermissions());
        $this->assertContains(Permissions::TECHNICIAN_ACCESS, $technician->getPermissions());
    }

    public function test_gates_evaluation(): void
    {
        $admin = User::factory()->create(['user_type' => User::TYPE_ADMIN]);
        $customer = User::factory()->create([
            'user_type' => User::TYPE_CUSTOMER,
            'subscription_plan' => 'vip_monthly',
            'subscribed_until' => now()->addMonth(),
        ]);
        $technicianUser = User::factory()->create(['user_type' => User::TYPE_TECHNICIAN]);
        $pro = Professional::create([
            'user_id' => $technicianUser->id,
            'name' => 'Pro Tech',
            'phone' => '+923001234567',
            'is_verified' => true,
            'subscription_plan' => 'pro_annual',
            'subscribed_until' => now()->addYear(),
        ]);

        $this->assertTrue(Gate::forUser($admin)->allows('admin'));
        $this->assertTrue(Gate::forUser($customer)->allows('customer'));
        $this->assertTrue(Gate::forUser($customer)->allows('vip-customer'));
        $this->assertTrue(Gate::forUser($technicianUser)->allows('technician'));
        $this->assertTrue(Gate::forUser($technicianUser)->allows('verified-technician'));
        $this->assertTrue(Gate::forUser($technicianUser)->allows('pro-technician'));

        // Admin bypass before gate
        $this->assertTrue(Gate::forUser($admin)->allows('verified-technician'));
    }

    public function test_all_model_relationships(): void
    {
        $profession = Profession::firstOrCreate(
            ['slug' => 'electrician'],
            [
                'name' => 'Electrician',
                'base_price' => 700,
                'is_active' => true,
            ]
        );

        $customer = User::factory()->create(['user_type' => User::TYPE_CUSTOMER, 'email' => 'customer@fixmate.pk']);
        $techUser = User::factory()->create(['user_type' => User::TYPE_TECHNICIAN, 'profession_id' => $profession->id]);

        $pro = Professional::create([
            'user_id' => $techUser->id,
            'profession_id' => $profession->id,
            'name' => 'Tariq Electrician',
            'phone' => '+923009998888',
            'is_verified' => true,
        ]);

        $booking = Booking::create([
            'booking_number' => Booking::generateBookingNumber(),
            'user_id' => $customer->id,
            'professional_id' => $pro->id,
            'profession_id' => $profession->id,
            'service_title' => 'Fan Repair',
            'service_date' => now()->toDateString(),
            'status' => 'confirmed',
            'arrival_otp' => '1234',
            'base_price' => 700,
            'total_price' => 700,
        ]);

        $review = Review::create([
            'booking_id' => $booking->id,
            'user_id' => $customer->id,
            'professional_id' => $pro->id,
            'rating' => 5,
            'comment' => 'Great work!',
        ]);

        $msg = Message::create([
            'sender_id' => $customer->id,
            'receiver_id' => $techUser->id,
            'booking_id' => $booking->id,
            'message' => 'Hello, ETA please?',
        ]);

        $notification = Notification::create([
            'user_id' => $customer->id,
            'type' => 'booking_update',
            'title' => 'Confirmed',
            'message' => 'Technician assigned',
        ]);

        $meeting = VideoMeeting::create([
            'meeting_code' => 'MTG-1234',
            'booking_id' => $booking->id,
            'caller_id' => $customer->id,
            'receiver_id' => $techUser->id,
            'status' => 'initiated',
        ]);

        $application = TechnicianApplication::create([
            'reference_no' => 'APP-1234',
            'user_id' => $techUser->id,
            'profession_id' => $profession->id,
            'name' => 'Tariq Electrician',
            'email' => 'tariq@fixmate.pk',
            'phone' => '+923009998888',
            'cnic_number' => '42101-1234567-1',
            'status' => 'approved',
        ]);

        $subscription = TechnicianSubscription::create([
            'professional_id' => $pro->id,
            'plan_name' => 'FixMate Pro',
            'price' => 2000,
            'payment_method' => 'wallet',
            'transaction_reference' => TechnicianSubscription::generateReference(),
            'status' => 'active',
        ]);

        $issue = CommunityIssue::create([
            'reference_no' => 'ISSUE-01',
            'user_id' => $customer->id,
            'reporter_name' => 'Citizen Customer',
            'title' => 'Broken street lamp',
            'description' => 'Dark road at night',
            'category' => 'street_light',
            'city' => 'Karachi',
            'location' => 'Block 5',
            'status' => 'reported',
            'is_approved' => true,
        ]);

        $upvote = CommunityIssueUpvote::create([
            'community_issue_id' => $issue->id,
            'user_id' => $customer->id,
            'ip_address' => '127.0.0.1',
        ]);

        $inquiry = ContactInquiry::create([
            'reference_no' => 'INQ-100',
            'department' => 'booking',
            'name' => 'Customer Inquiry',
            'email' => 'customer@fixmate.pk',
            'phone' => '03001234567',
            'city' => 'Karachi',
            'message' => 'Need help with booking',
            'status' => 'new',
        ]);

        // User relationships
        $this->assertEquals(1, $customer->bookings->count());
        $this->assertEquals(1, $customer->reviews->count());
        $this->assertEquals(1, $customer->notifications->count());
        $this->assertEquals(1, $customer->sentMessages->count());
        $this->assertEquals(1, $customer->communityIssues->count());
        $this->assertEquals(1, $customer->communityIssueUpvotes->count());
        $this->assertEquals(1, $customer->callerMeetings->count());
        $this->assertEquals(1, $customer->contactInquiries->count());

        $this->assertEquals(1, $techUser->receivedMessages->count());
        $this->assertEquals(1, $techUser->receiverMeetings->count());
        $this->assertEquals(1, $techUser->technicianApplications->count());
        $this->assertNotNull($techUser->technicianApplication);
        $this->assertEquals($profession->id, $techUser->profession->id);
        $this->assertEquals($pro->id, $techUser->professional->id);

        // Professional relationships
        $this->assertEquals($techUser->id, $pro->user->id);
        $this->assertEquals($profession->id, $pro->profession->id);
        $this->assertEquals(1, $pro->bookings->count());
        $this->assertEquals(1, $pro->reviews->count());
        $this->assertEquals(1, $pro->subscriptions->count());
        $this->assertNotNull($pro->application);

        // Profession relationships
        $this->assertEquals(1, $profession->professionals->count());
        $this->assertEquals(1, $profession->technicians->count());
        $this->assertEquals(1, $profession->bookings->count());
        $this->assertEquals(1, $profession->applications->count());

        // Booking relationships
        $this->assertEquals($customer->id, $booking->user->id);
        $this->assertEquals($pro->id, $booking->professional->id);
        $this->assertEquals($profession->id, $booking->profession->id);
        $this->assertEquals($review->id, $booking->review->id);
        $this->assertEquals(1, $booking->messages->count());
        $this->assertEquals(1, $booking->videoMeetings->count());
        $this->assertNotNull($booking->latestVideoMeeting);

        // Booking helper authorization
        $this->assertTrue($booking->isCustomer($customer));
        $this->assertFalse($booking->isCustomer($techUser));
        $this->assertTrue($booking->isAssignedTechnician($techUser));
        $this->assertTrue($booking->canBeManagedBy($customer));
        $this->assertTrue($booking->canBeManagedBy($techUser));

        // Review relationships
        $this->assertEquals($booking->id, $review->booking->id);
        $this->assertEquals($customer->id, $review->user->id);
        $this->assertEquals($pro->id, $review->professional->id);

        // Message relationships
        $this->assertEquals($customer->id, $msg->sender->id);
        $this->assertEquals($techUser->id, $msg->receiver->id);
        $this->assertEquals($booking->id, $msg->booking->id);

        // VideoMeeting relationships
        $this->assertEquals($booking->id, $meeting->booking->id);
        $this->assertEquals($customer->id, $meeting->caller->id);
        $this->assertEquals($techUser->id, $meeting->receiver->id);

        // TechnicianApplication relationships
        $this->assertEquals($techUser->id, $application->user->id);
        $this->assertEquals($profession->id, $application->profession->id);
        $this->assertEquals($pro->id, $application->professional->id);

        // TechnicianSubscription relationships
        $this->assertEquals($pro->id, $subscription->professional->id);

        // CommunityIssue & Upvotes
        $this->assertEquals($customer->id, $issue->user->id);
        $this->assertEquals(1, $issue->upvotes->count());
        $this->assertEquals($issue->id, $upvote->issue->id);
        $this->assertEquals($customer->id, $upvote->user->id);
    }

    public function test_policies_evaluation(): void
    {
        $customer = User::factory()->create(['user_type' => User::TYPE_CUSTOMER]);
        $otherCustomer = User::factory()->create(['user_type' => User::TYPE_CUSTOMER]);
        $techUser = User::factory()->create(['user_type' => User::TYPE_TECHNICIAN]);

        $pro = Professional::create([
            'user_id' => $techUser->id,
            'name' => 'Pro Tech',
            'phone' => '+923001112222',
            'is_verified' => true,
        ]);

        $profession = Profession::firstOrCreate(
            ['slug' => 'electrician'],
            ['name' => 'Electrician', 'base_price' => 700, 'is_active' => true]
        );

        $booking = Booking::create([
            'booking_number' => Booking::generateBookingNumber(),
            'user_id' => $customer->id,
            'professional_id' => $pro->id,
            'profession_id' => $profession->id,
            'service_title' => 'AC Cleaning',
            'service_date' => now()->toDateString(),
            'status' => 'confirmed',
        ]);

        // Customer can view their own booking
        $this->assertTrue(Gate::forUser($customer)->allows('view', $booking));
        $this->assertFalse(Gate::forUser($otherCustomer)->allows('view', $booking));
        $this->assertTrue(Gate::forUser($techUser)->allows('view', $booking));

        // Customer can cancel confirmed booking
        $this->assertTrue(Gate::forUser($customer)->allows('cancel', $booking));
        $this->assertFalse(Gate::forUser($otherCustomer)->allows('cancel', $booking));

        // Technician can start route
        $this->assertTrue(Gate::forUser($techUser)->allows('startRoute', $booking));
        $this->assertFalse(Gate::forUser($customer)->allows('startRoute', $booking));

        // Review policy
        $review = Review::create([
            'booking_id' => $booking->id,
            'user_id' => $customer->id,
            'professional_id' => $pro->id,
            'rating' => 5,
            'comment' => 'Awesome service',
        ]);

        $this->assertTrue(Gate::forUser($techUser)->allows('reply', $review));
        $this->assertFalse(Gate::forUser($otherCustomer)->allows('reply', $review));
    }

    public function test_role_and_permission_middlewares(): void
    {
        $admin = User::factory()->create(['user_type' => User::TYPE_ADMIN]);
        $customer = User::factory()->create(['user_type' => User::TYPE_CUSTOMER]);
        $techUser = User::factory()->create(['user_type' => User::TYPE_TECHNICIAN]);

        // Customer portal allows customer
        $response = $this->actingAs($customer)->get(route('customer.dashboard'));
        $response->assertStatus(200);

        // Wrong role redirected to own portal
        $response = $this->actingAs($techUser)->get(route('customer.dashboard'));
        $response->assertRedirect('/technician/dashboard');

        // Admin can access admin portal
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);

        // Customer cannot access admin portal
        $response = $this->actingAs($customer)->get(route('admin.dashboard'));
        $response->assertRedirect('/customer/dashboard');

        // Test middleware directly with multi-role support
        $roleMiddleware = new \App\Http\Middleware\EnsureUserHasRole;
        $request = \Illuminate\Http\Request::create('/test', 'GET');
        $request->setUserResolver(fn () => $customer);

        $nextCalled = false;
        $next = function ($req) use (&$nextCalled) {
            $nextCalled = true;
            return response('OK');
        };

        // Multi-role pipe check: 'admin|customer' should pass for customer
        $roleMiddleware->handle($request, $next, 'admin|customer');
        $this->assertTrue($nextCalled);

        // Permission middleware
        $permMiddleware = new \App\Http\Middleware\EnsureUserHasPermission;
        $nextCalled = false;
        $permMiddleware->handle($request, $next, Permissions::BOOKINGS_CREATE);
        $this->assertTrue($nextCalled);
    }
}
