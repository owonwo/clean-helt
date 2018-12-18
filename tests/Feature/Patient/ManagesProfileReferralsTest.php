<?php

namespace Tests\Feature\Patient;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesProfileReferralsTest extends TestCase
{
    use RefreshDatabase;
    
    protected $extension;
    
    public function setUp()
    {
        parent::setUp();    
        
        $patient = create('App\Models\Patient');
        
        $share = create('App\Models\ProfileShare', ['patient_id' => $patient->id]);
        
        $this->extension = create('App\Models\ShareExtension', [
            'share_id' => $share->id, 'status' => '0'
        ]);
        
        $this->signIn($patient, 'patient');
    }
    
    /** @test **/
    public function an_authenticated_patient_can_approve_his_profile_referrals()
    {
        $this->patch("api/patient/profile/share-extensions/{$this->extension->id}/approve")
            ->assertStatus(200);
            
        $this->assertEquals("1", $this->extension->fresh()->status);
    }
    
    /** @test **/
    public function an_authenticated_patient_can_decline_his_profile_referrals()
    {
        $this->patch("api/patient/profile/share-extensions/{$this->extension->id}/decline")
            ->assertStatus(200);
            
        $this->assertEquals("2", $this->extension->fresh()->status);
    }
    
    /** @test **/
    public function an_authenticated_patient_can_view_his_profile_referrals()
    {
        $this->get("api/patient/profile/share-extensions")
            ->assertSee($this->extension->id);
    }
    
}
