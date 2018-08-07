<?php

namespace Tests\Feature\Admin;

use App\Models\Hospital;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesHospitalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_admin_can_view_all_registered_hospitals()
    {
        $hospital = create(Hospital::class);

        $this->signIn(null, 'admin');

        $this->makeAuthRequest()
            ->get('/api/admin/hospitals')
            ->assertStatus(200)
            ->assertSee($hospital->name);
    }

    /** @test */
    public function an_authenticated_admin_can_register_hospitals()
    {
        $this->signIn(null, 'admin');

        $hospital = make(Hospital::class)->toArray();

        $this->makeAuthRequest()
            ->post('/api/admin/hospitals', $hospital)
            ->assertStatus(200);

        $this->makeAuthRequest()
            ->get('/api/admin/hospitals')
            ->assertSee($hospital['name']);
    }

    /** @test */
    public function an_authenticated_admin_can_view_a_registered_hospital()
    {
        $this->signIn(null, 'admin');

        $hospital = create(Hospital::class);

        $this->makeAuthRequest()
            ->get("/api/admin/hospitals/{$hospital->chcode}")
            ->assertSee($hospital->name);
    }

    /** @test */
    public function an_authenticated_admin_can_update_a_registered_hospital()
    {
        $this->signIn(null, 'admin');

        $hospital = create(Hospital::class);

        $update = [
            'name' => "New Hospital Name"
        ];

        $this->makeAuthRequest()
            ->patch("/api/admin/hospitals/{$hospital->chcode}", $update);
        $this->assertDatabaseHas('hospitals',$update);
    }

    /** @test */
    public function an_authenticated_admin_can_delete_a_registered_hospital()
    {
        $this->signIn(null, 'admin');

        $hospital = create(Hospital::class);

        $this->makeAuthRequest()
            ->delete("/api/admin/hospitals/{$hospital->chcode}");
        $this->assertDatabaseMissing('hospitals',['chcode' => $hospital->chcode]);


    }

    /** @test */
    public function a_hospital_registration_requires_a_name()
    {
        $this->signIn(null, 'admin');

        $hospital = make(Hospital::class, ['name' => null])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/hospitals', $hospital)
            ->assertStatus(422);
    }

    /** @test */
    public function a_hospital_registration_requires_a_unique_email()
    {
        $this->signIn(null, 'admin');

        $email = 'hospital@cleanhelt.com';

        create(Hospital::class, ['email' => $email]);
        $hospital = make(Hospital::class, ['email' => $email])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/hospitals', $hospital)
            ->assertStatus(422);

        $hospitalTwo = make(Hospital::class, ['email' => null])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/hospitals', $hospitalTwo)
            ->assertStatus(422);
    }

    /** @test */
    public function a_hospital_registration_requires_a_phone_number()
    {
        $this->signIn(null, 'admin');

        $hospital = make(Hospital::class, ['phone' => null])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/hospitals', $hospital)
            ->assertStatus(422);
    }

    /** @test */
    public function a_hospital_registration_requires_the_director_mdcn()
    {
        $this->signIn(null, 'admin');

        $hospital = make(Hospital::class, ['director_mdcn' => null])->toArray();

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->postJson('/api/admin/hospitals', $hospital)
            ->assertStatus(422);
    }
}
