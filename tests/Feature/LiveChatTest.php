<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Message;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LiveChatTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;
    protected User $technicianUser;
    protected Professional $professional;
    protected Profession $profession;
    protected Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create([
            'user_type' => User::TYPE_CUSTOMER,
            'name' => 'Sara Ahmed',
            'phone' => '+923001112233',
        ]);

        $this->profession = Profession::firstOrCreate(
            ['slug' => 'electrician'],
            [
                'name' => 'Electrician Specialist',
                'icon' => 'bolt',
                'description' => 'Electrical repairs',
                'base_price' => 800,
                'is_active' => true,
            ]
        );

        $this->technicianUser = User::factory()->create([
            'user_type' => User::TYPE_TECHNICIAN,
            'name' => 'Tariq Mehmood',
            'phone' => '+923114445566',
        ]);

        $this->professional = Professional::create([
            'user_id' => $this->technicianUser->id,
            'profession_id' => $this->profession->id,
            'name' => 'Tariq Mehmood',
            'phone' => '+923114445566',
            'email' => 'tariq.tech@example.com',
            'city' => 'Lahore',
            'rating' => 4.8,
            'is_verified' => true,
        ]);

        $this->booking = Booking::create([
            'booking_number' => 'FM-77221',
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Electrical Short Circuit Repair',
            'service_date' => now()->toDateString(),
            'service_time_slot' => '02:00 PM - 04:00 PM',
            'service_address' => 'Gulberg III, Lahore',
            'city' => 'Lahore',
            'status' => 'confirmed',
            'arrival_otp' => '1234',
            'base_price' => 800,
            'total_price' => 1200,
        ]);
    }

    public function test_customer_can_send_message_via_ajax_and_receive_json(): void
    {
        $response = $this->actingAs($this->customer)
            ->postJson(route('customer.messages.send'), [
                'technician_id' => $this->professional->id,
                'booking_id' => $this->booking->id,
                'message' => 'Hello Tariq, are you on your way?',
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message.message', 'Hello Tariq, are you on your way?')
            ->assertJsonPath('message.is_me', true);

        $this->assertDatabaseHas('messages', [
            'sender_id' => $this->customer->id,
            'receiver_id' => $this->technicianUser->id,
            'message' => 'Hello Tariq, are you on your way?',
        ]);
    }

    public function test_customer_can_stream_incoming_technician_messages(): void
    {
        // Technician sends a message to customer
        $msg = Message::create([
            'sender_id' => $this->technicianUser->id,
            'receiver_id' => $this->customer->id,
            'booking_id' => $this->booking->id,
            'message' => 'Yes, reaching in 10 minutes!',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->customer)
            ->getJson(route('customer.messages.stream', [
                'tech_id' => $this->professional->id,
            ]));

        $response->assertOk()
            ->assertJsonCount(1, 'messages')
            ->assertJsonPath('messages.0.id', $msg->id)
            ->assertJsonPath('messages.0.message', 'Yes, reaching in 10 minutes!')
            ->assertJsonPath('messages.0.is_me', false);

        // Assert message marked as read
        $this->assertTrue($msg->fresh()->is_read);
    }

    public function test_technician_can_send_message_via_ajax_and_receive_json(): void
    {
        $response = $this->actingAs($this->technicianUser)
            ->postJson(route('technician.messages.send'), [
                'receiver_id' => $this->customer->id,
                'booking_id' => $this->booking->id,
                'message' => 'I have arrived outside the gate.',
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message.message', 'I have arrived outside the gate.')
            ->assertJsonPath('message.is_me', true);

        $this->assertDatabaseHas('messages', [
            'sender_id' => $this->technicianUser->id,
            'receiver_id' => $this->customer->id,
            'message' => 'I have arrived outside the gate.',
        ]);
    }

    public function test_technician_can_stream_incoming_customer_messages_with_after_id_filter(): void
    {
        // Customer sends first message
        $msg1 = Message::create([
            'sender_id' => $this->customer->id,
            'receiver_id' => $this->technicianUser->id,
            'message' => 'First older message',
            'is_read' => true,
        ]);

        // Customer sends second message
        $msg2 = Message::create([
            'sender_id' => $this->customer->id,
            'receiver_id' => $this->technicianUser->id,
            'message' => 'Second brand new message',
            'is_read' => false,
        ]);

        // Technician requests stream with after_id set to msg1 id
        $response = $this->actingAs($this->technicianUser)
            ->getJson(route('technician.messages.stream', [
                'client_id' => $this->customer->id,
                'after_id' => $msg1->id,
            ]));

        $response->assertOk()
            ->assertJsonCount(1, 'messages')
            ->assertJsonPath('messages.0.id', $msg2->id)
            ->assertJsonPath('messages.0.message', 'Second brand new message')
            ->assertJsonPath('messages.0.is_me', false);

        // Assert msg2 marked as read
        $this->assertTrue($msg2->fresh()->is_read);
    }
}
