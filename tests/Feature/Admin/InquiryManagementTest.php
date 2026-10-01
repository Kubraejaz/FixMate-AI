<?php

namespace Tests\Feature\Admin;

use App\Models\ContactInquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InquiryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_submit_contact_form(): void
    {
        $payload = [
            'department' => 'emergency',
            'name' => 'Usman Ali',
            'phone' => '0321-9988776',
            'email' => 'usman@example.com',
            'city' => 'Lahore',
            'message' => 'Sudden power trip in main DB box, need emergency electrician ASAP.',
        ];

        $response = $this->post(route('contact.submit'), $payload);

        $response->assertRedirect(route('contact') . '#inquiry-form');
        $response->assertSessionHas('success_inquiry');
        $response->assertSessionHas('inquiry_ref');

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'Usman Ali',
            'phone' => '0321-9988776',
            'email' => 'usman@example.com',
            'city' => 'Lahore',
            'department' => 'emergency',
            'status' => 'new',
        ]);

        $inquiry = ContactInquiry::where('email', 'usman@example.com')->first();
        $this->assertNotNull($inquiry);
        $this->assertStringStartsWith('FM-INQ-', $inquiry->reference_no);
    }

    public function test_admin_can_view_inquiries_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        ContactInquiry::create([
            'reference_no' => 'FM-INQ-123456',
            'department' => 'escrow',
            'name' => 'Hamza Tariq',
            'phone' => '0300-1122334',
            'email' => 'hamza@example.com',
            'city' => 'Islamabad',
            'message' => 'Escrow payment confirmation not received.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.inquiries'));

        $response->assertOk();
        $response->assertSee('FM-INQ-123456');
        $response->assertSee('Hamza Tariq');
        $response->assertSee('Support Inquiries &amp; Portal Tickets', false);
    }

    public function test_admin_can_manually_create_inquiry(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.inquiries.store'), [
            'department' => 'corporate',
            'name' => 'Zubair Enterprises',
            'phone' => '0333-5554443',
            'email' => 'contact@zubair.pk',
            'city' => 'Karachi',
            'message' => 'Requesting proposal for commercial AC maintenance contract.',
            'status' => 'in_progress',
            'admin_notes' => 'Forwarded RFP to regional operations manager.',
        ]);

        $response->assertRedirect(route('admin.inquiries'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'Zubair Enterprises',
            'phone' => '0333-5554443',
            'department' => 'corporate',
            'status' => 'in_progress',
            'admin_notes' => 'Forwarded RFP to regional operations manager.',
        ]);
    }

    public function test_admin_can_update_inquiry_status_and_notes(): void
    {
        $admin = User::factory()->admin()->create();

        $inquiry = ContactInquiry::create([
            'reference_no' => 'FM-INQ-998877',
            'department' => 'booking',
            'name' => 'Fatima Noor',
            'phone' => '0345-6677889',
            'city' => 'Rawalpindi',
            'message' => 'Reschedule booking date for plumber visit.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.inquiries.update', $inquiry->id), [
            'status' => 'resolved',
            'department' => 'booking',
            'admin_notes' => 'Customer called, visit rescheduled to Oct 3rd at 11am.',
        ]);

        $response->assertRedirect(route('admin.inquiries'));
        $response->assertSessionHas('success');

        $inquiry->refresh();
        $this->assertEquals('resolved', $inquiry->status);
        $this->assertEquals('Customer called, visit rescheduled to Oct 3rd at 11am.', $inquiry->admin_notes);
    }

    public function test_admin_can_delete_inquiry(): void
    {
        $admin = User::factory()->admin()->create();

        $inquiry = ContactInquiry::create([
            'reference_no' => 'FM-INQ-DEL001',
            'department' => 'general',
            'name' => 'Spam Bot Test',
            'phone' => '000-0000000',
            'city' => 'Unknown',
            'message' => 'Test spam text delete me.',
            'status' => 'closed',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.inquiries.destroy', $inquiry->id));

        $response->assertRedirect(route('admin.inquiries'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('contact_inquiries', [
            'id' => $inquiry->id,
            'reference_no' => 'FM-INQ-DEL001',
        ]);
    }

    public function test_non_admin_cannot_access_inquiries_portal(): void
    {
        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($customer)->get(route('admin.inquiries'));
        $response->assertRedirect(route('customer.dashboard'));

        $technician = User::factory()->technician()->create();
        $responseTech = $this->actingAs($technician)->get(route('admin.inquiries'));
        $responseTech->assertRedirect(route('technician.dashboard'));
    }
}
