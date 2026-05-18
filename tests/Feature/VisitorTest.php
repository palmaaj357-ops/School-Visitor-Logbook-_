<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest users are redirected to login.
     */
    public function test_guest_cannot_access_visitors(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can view dashboard.
     */
    public function test_authenticated_user_can_view_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('School Visitor Logbook');
    }

    /**
     * Test creating a visitor.
     */
    public function test_can_create_visitor(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/visitors', [
            'name' => 'Alice Cooper',
            'purpose' => 'Meeting with principal',
            'time_in' => now()->format('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('visitors', [
            'name' => 'Alice Cooper',
            'purpose' => 'Meeting with principal',
        ]);
    }

    /**
     * Test checking out a visitor.
     */
    public function test_can_checkout_visitor(): void
    {
        $user = User::factory()->create();
        $visitor = Visitor::create([
            'name' => 'Bob Marley',
            'purpose' => 'Deliver packages',
            'time_in' => now()->subHour(),
        ]);

        $response = $this->actingAs($user)->patch("/visitors/{$visitor->id}/checkout");

        $response->assertStatus(302);
        $visitor->refresh();
        $this->assertNotNull($visitor->time_out);
    }

    /**
     * Test deleting a visitor.
     */
    public function test_can_delete_visitor(): void
    {
        $user = User::factory()->create();
        $visitor = Visitor::create([
            'name' => 'Charlie Chaplin',
            'purpose' => 'Performance',
            'time_in' => now(),
        ]);

        $response = $this->actingAs($user)->delete("/visitors/{$visitor->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('visitors', [
            'id' => $visitor->id,
        ]);
    }
}
