<?php

namespace Tests\Feature\Admin;

use App\Models\Pharmacy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesPharmacyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_admin_can_view_all_registered_pharmacies()
    {
        $pharmacy = create(Pharmacy::class);

        $this->signIn(null, 'admin');

        $this->makeAuthRequest()
            ->get('/api/admin/pharmacies')
            ->assertStatus(200)
            ->assertSee($pharmacy->name);
    }

    /** @test */
    public function an_authenticated_admin_can_register_pharmacies()
    {
        $this->signIn(null, 'admin');

        $pharmacy = make(Pharmacy::class)->toArray();

        $this->makeAuthRequest()
            ->post('/api/admin/pharmacies', $pharmacy)
            ->assertStatus(200);

        $this->makeAuthRequest()
            ->get('/api/admin/pharmacies')
            ->assertSee($pharmacy['name']);
    }

    /** @test */
    public function an_authenticated_admin_can_view_a_registered_pharmacy()
    {
        $this->signIn(null, 'admin');

        $pharmacy = create(Pharmacy::class);

        $this->makeAuthRequest()
            ->get("/api/admin/pharmacies/{$pharmacy->chcode}")
            ->assertSee($pharmacy->name);
    }

    /** @test */
    public function an_authenticated_admin_can_update_a_registered_pharmacy()
    {
        $this->signIn(null, 'admin');

        $pharmacy = create(Pharmacy::class);

        $update = [
            'name' => "New Pharmacy Name"
        ];

        $this->makeAuthRequest()
            ->patch("/api/admin/pharmacies/{$pharmacy->chcode}", $update)
            ->assertStatus(200);

        $this->makeAuthRequest()
            ->get("/api/admin/pharmacies/{$pharmacy->chcode}")
            ->assertSee($update['name']);
    }

    /** @test */
    public function an_authenticated_admin_can_delete_a_registered_pharmacy()
    {
        $this->signIn(null, 'admin');

        $pharmacy = create(Pharmacy::class);

        $this->makeAuthRequest()
            ->delete("/api/admin/pharmacies/{$pharmacy->chcode}")
            ->assertStatus(200);

        $this->withExceptionHandling()
            ->makeAuthRequest()
            ->get("/api/admin/pharmacies/{$pharmacy->chcode}")
            ->assertDontSee($pharmacy->name)
            ->assertStatus(404);
    }

    /** @test */
    public function a_pharmacy_registration_requires_a_name()
    {
        $this->signIn(null, 'admin');

        $pharmacy = make(Pharmacy::class, ['name' => null])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/pharmacies', $pharmacy)
            ->assertStatus(422);
    }

    /** @test */
    public function a_pharmacy_registration_requires_a_valid_unique_email()
    {
        $this->signIn(null, 'admin');

        $email = 'pharmacy@cleanhelt.com';

        create(Pharmacy::class, ['email' => $email]);
        $pharmacy = make(Pharmacy::class, ['email' => $email])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/pharmacies', $pharmacy)
            ->assertStatus(422);

        $pharmacyTwo = make(Pharmacy::class, ['email' => null])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/pharmacies', $pharmacyTwo)
            ->assertStatus(422);
    }

    /** @test */
    public function a_pharmacy_registration_requires_a_phone_number()
    {
        $this->signIn(null, 'admin');

        $pharmacy = make(Pharmacy::class, ['phone' => null])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/pharmacies', $pharmacy)
            ->assertStatus(422);
    }

    /** @test */
    public function a_hospital_registration_requires_the_chief_pharmacists_registration_number()
    {
        $this->signIn(null, 'admin');

        $pharmacy = make(Pharmacy::class, ['chief_pharmacist_reg' => null])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/pharmacies', $pharmacy)
            ->assertStatus(422);
    }
}
