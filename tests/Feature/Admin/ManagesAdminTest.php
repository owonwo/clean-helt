<?php

namespace Tests\Feature\Admin;


use App\Events\NewUserRegistered;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Testing\Fakes\NotificationFake;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesAdminTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function an_admin_can_create_an_admin(){

        $this->signIn(null, 'admin');
        $admin = [
            'name' =>'Biscuit Bread',
            'email' => 'yarrowbradley@gmail.com',
            'roles' => 1,
            'active' => false,
            'avatar' => 'avatar/default.jpeg',
            'remember_token' => str_random(10),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        ];
        $this->makeAuthRequest()->post('api/admin/create',$admin);
        $this->assertDatabaseHas('admins',["name" => "Biscuit Bread"]);
    }
    /** @test */
    public function an_admin_can_receive_notification_on_users_registration(){
        $admin = create(Admin::class);
        $this->signIn($admin, 'admin');
        $doctor = create(Patient::class);
        event(new NewUserRegistered($admin,$doctor));

        $this->post(route('doctor.create'),$doctor->toArray());
        $this->assertCount(1, $admin->notifications);
    }
}
