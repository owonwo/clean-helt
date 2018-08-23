<?php

namespace Tests\Feature\Pharmacy;

use App\Models\Pharmacy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_pharmacy_can_view_her_profile()
    {
        $pharmacy = create(Pharmacy::class);

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->get('api/pharmacy/profile')
            ->assertStatus(200)
            ->assertSee($pharmacy->name);
    }

    /** @test */
    public function an_authenticated_pharmacy_can_update_her_pharmacy()
    {
        $pharmacy = create(Pharmacy::class);

        $this->signIn($pharmacy, 'pharmacy');

        $update = ['name' => 'New Era Pharmacy'];

        $this->makeAuthRequest()
            ->patch("api/pharmacy/profile", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('pharmacies', [
            'name' => $update['name']
        ]);
    }
}
