<?php

namespace Tests\Feature\Hospital;

use App\Models\Hospital;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_hospital_can_view_her_profile()
    {
        $hospital = create(Hospital::class);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get('api/hospital/profile')
            ->assertStatus(200)
            ->assertSee($hospital->name);
    }

    /** @test */
    public function an_authenticated_hospital_can_update_her_profile()
    {
        $hospital = create(Hospital::class);

        $this->signIn($hospital, 'hospital');

        $update = ['name' => 'New Era Hospital'];

        $this->makeAuthRequest()
            ->patch("api/hospital/profile", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('hospitals', [
            'name' => $update['name']
        ]);
    }
}
