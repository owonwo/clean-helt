<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SharesAssignedClientsTest extends TestCase
{
   use RefreshDatabase;
   
   protected $hospital, $doctor, $share, $extension;
   
   public function setUp()
   {
        parent::setUp();   
        
        $this->hospital = create('App\Models\Hospital');

        $this->share = create('App\Models\ProfileShare', [
            'provider_id' => $this->hospital->id,
            'provider_type' => get_class($this->hospital),
            'status' => "1"
        ]);
        
        $this->doctor = create('App\Models\Doctor');
        $this->hospital->doctors()->attach($this->doctor, ['status' => 1]);
        
        $this->extension = create('App\Models\ShareExtension', [
            'share_id' => $this->share->id,
            'sharer_id' => $this->hospital->id,
            'sharer_type' => get_class($this->hospital),
            'provider_id' => $this->doctor->id,
            'provider_type' => get_class($this->doctor),
            'status' => '1'
        ]);
        
        $this->signIn($this->doctor, 'doctor');
   }
   
   
   /** @test **/
   public function an_authenticated_doctor_can_get_a_list_of_doctors_eligible_for_profile_referral()
   {
        $doctorOne = create('App\Models\Doctor');
        $doctorTwo = create('App\Models\Doctor');

        $this->hospital->doctors()->attach($doctorOne, ['status' => 1]);
        $this->hospital->doctors()->attach($doctorTwo, ['status' => 1]);
        
        $this->get("api/doctor/doctors-eligible/{$this->extension->id}")
            ->assertSee($doctorOne->chcode)
            ->assertSee($doctorTwo->chcode)
            ->assertDontSee($this->doctor->chcode);
   }
   
   /** @test **/
   public function an_authenticated_doctor_can_refer_a_clients_profile_to_another_doctor_in_same_hospital()
   {
        $otherDoctor = create('App\Models\Doctor');
        $this->hospital->doctors()->attach($otherDoctor, ['status' => 1]);
        
        $this->post("api/doctor/patients/{$this->extension->id}/refer/{$otherDoctor->chcode}")
            ->assertStatus(200);
            
        $this->assertDatabaseHas('share_extensions', [
            'share_id' => $this->share->id,
            'sharer_id' => $this->doctor->id,
            'sharer_type' => get_class($this->doctor),
            'provider_id' => $otherDoctor->id,
            'provider_type' => get_class($otherDoctor),
            'status' => '0'
        ]);
   }
}
