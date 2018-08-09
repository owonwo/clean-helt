<?php

namespace Tests\Feature\Admin;

use App\Models\Laboratory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesLaboratoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_admin_can_view_all_registered_laboratories()
    {
        $laboratory = create(Laboratory::class);

        $this->signIn(null, 'admin');

        $this->makeAuthRequest()
            ->get('/api/admin/laboratories')
            ->assertStatus(200)
            ->assertSee($laboratory->name);
    }

    /** @test */
    public function an_authenticated_admin_can_register_laboratories()
    {
        $this->signIn(null, 'admin');

        $laboratory = make(Laboratory::class)->toArray();

        $this->makeAuthRequest()
            ->post('/api/admin/laboratories', $laboratory)
            ->assertStatus(200);

        $this->makeAuthRequest()
            ->get('/api/admin/laboratories')
            ->assertSee($laboratory['name']);
    }

    /** @test */
    public function an_authenticated_admin_can_view_a_registered_laboratories()
    {
        $this->signIn(null, 'admin');

        $laboratory = create(Laboratory::class);

        $this->makeAuthRequest()
            ->get("/api/admin/laboratories/{$laboratory->chcode}")
            ->assertSee($laboratory->name);
    }

    /** @test */
    public function an_authenticated_admin_can_update_a_registered_laboratories()
    {
        $this->signIn(null, 'admin');

        $laboratory = create(Laboratory::class);

        $update = [
            'name' => "New Laboratory Name"
        ];

        $this->makeAuthRequest()
            ->patch("/api/admin/laboratories/{$laboratory->chcode}/laboratories", $update)
            ->assertStatus(200);

        $this->makeAuthRequest()
            ->get("/api/admin/laboratories/{$laboratory->chcode}")
            ->assertSee($update['name']);
    }

    /** @test */
    public function an_authenticated_admin_can_delete_a_registered_laboratories()
    {
        $this->signIn(null, 'admin');

        $laboratory = create(Laboratory::class);

        $this->makeAuthRequest()
            ->delete("/api/admin/laboratories/{$laboratory->chcode}")
            ->assertStatus(200);

        $this->withExceptionHandling()
            ->makeAuthRequest()
            ->get("/api/admin/laboratories/{$laboratory->chcode}")
            ->assertDontSee($laboratory->name)
            ->assertStatus(404);
    }

    public function an_authenticated_admin_can_deactivate_a_laboratory(){
        $this->signIn(null, 'admin');
        $patient = create(Laboratory::class);

        $this->makeAuthRequest()->patch("/api/admin/laboratories/deactivate/{$patient->chcode}",[$patient->active => false]);
        $this->assertDatabaseHas('laboratories',['active' => false]);
    }
}
