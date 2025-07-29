<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use Laravel\Sanctum\Sanctum;

class BookingServiceApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Seed admin and services
        $this->artisan('db:seed');
    }

    public function test_customer_can_list_services()
    {
        $user = User::factory()->create(['role' => 'customer']);
        Sanctum::actingAs($user, ['*']);
        $response = $this->getJson('/api/services');
        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    public function test_admin_can_create_service()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin, ['*']);
        $payload = [
            'name' => 'Test Service',
            'description' => 'Desc',
            'price' => 100,
            'status' => 'active',
        ];
        $response = $this->postJson('/api/services', $payload);
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'data' => ['id','name','description','price','status'], 'message']);
    }

    public function test_customer_cannot_create_service()
    {
        $user = User::factory()->create(['role' => 'customer']);
        Sanctum::actingAs($user, ['*']);
        $payload = [
            'name' => 'Test Service',
            'description' => 'Desc',
            'price' => 100,
            'status' => 'active',
        ];
        $response = $this->postJson('/api/services', $payload);
        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_customer_can_create_booking()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create(['status' => 'active']);
        Sanctum::actingAs($user, ['*']);
        $payload = [
            'service_id' => $service->id,
            'booking_date' => now()->addDays(1)->toDateString()
        ];
        $response = $this->postJson('/api/bookings', $payload);
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'data' => ['id','service','user','booking_date','created_at'], 'message']);
    }

    public function test_customer_cannot_book_past_date()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create(['status' => 'active']);
        Sanctum::actingAs($user, ['*']);
        $payload = [
            'service_id' => $service->id,
            'booking_date' => now()->subDays(1)->toDateString()
        ];
        $response = $this->postJson('/api/bookings', $payload);
        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_customer_can_list_own_bookings()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create(['status' => 'active']);
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'booking_date' => now()->addDays(1)->toDateString()
        ]);
        Sanctum::actingAs($user, ['*']);
        $response = $this->getJson('/api/bookings');
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    public function test_admin_can_list_all_bookings()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create(['status' => 'active']);
        $user = User::factory()->create(['role' => 'customer']);
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'booking_date' => now()->addDays(1)->toDateString()
        ]);
        Sanctum::actingAs($admin, ['*']);
        $response = $this->getJson('/api/admin/bookings');
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    public function test_admin_can_update_service()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create(['status' => 'active']);
        Sanctum::actingAs($admin, ['*']);
        $payload = [
            'name' => 'Updated Service',
            'description' => 'Updated Desc',
            'price' => 200,
            'status' => 'inactive',
        ];
        $response = $this->putJson("/api/services/{$service->id}", $payload);
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonPath('data.name', 'Updated Service');
    }

    public function test_admin_can_delete_service()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create(['status' => 'active']);
        Sanctum::actingAs($admin, ['*']);
        $response = $this->deleteJson("/api/services/{$service->id}");
        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_customer_cannot_update_service()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create(['status' => 'active']);
        Sanctum::actingAs($user, ['*']);
        $payload = [
            'name' => 'Hacked Service',
            'description' => 'Hacked Desc',
            'price' => 999,
            'status' => 'inactive',
        ];
        $response = $this->putJson("/api/services/{$service->id}", $payload);
        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_customer_cannot_delete_service()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create(['status' => 'active']);
        Sanctum::actingAs($user, ['*']);
        $response = $this->deleteJson("/api/services/{$service->id}");
        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }
}
