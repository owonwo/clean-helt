<?php

namespace Tests\Feature\Patient;

use App\Events\PatientSharedProfile;
use App\Events\ProfileShareExtended;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\ProfileShare;
use App\Notifications\ProfileShareExpiredNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientSharesProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_patient_can_share_his_profile_to_anyone()
    {
        $patient = create(Patient::class);
        $provider = create(Doctor::class);
        $this->signIn($patient, 'patient');
        $this->makeAuthRequest()
            ->post(route('patient.profile.share'), [
                'chcode' => $provider->chcode,
                'expiration' => Carbon::now()->addDay(1)->format('Y-m-d h:i:s')
            ]);

        $this->assertDatabaseHas('profile_shares', [
            'patient_id' => $patient->id,
        ]);
    }
    /** @test */
    public function a_notification_is_sent_to_providers_that_patient_profile_has_been_shared_with(){
        //Given i have a patient who is signed in
        $patient = create('App\Models\Patient');
        $provider = create('App\Models\Doctor');
        //And the type of provider who is profile is been shared with
        $this->signIn($patient, 'patient');
        $this->makeAuthRequest() ->post(route('patient.profile.share'), [
            'chcode' => $provider->chcode,
            'expiration' => Carbon::now()->addDay(1)->format('Y-m-d h:i:s')
        ]);
        $this->assertCount(1,$provider->notifications);
//        $logfileFullpath = storage_path("logs/laravel.log");
//
//        $file = readfile($logfileFullpath);
//        $this->assertEventIsBroadcasted("App\Event\PatientSharedProfile",'private-channel-name');
//        // Then the provider receives a notification
    }

    /** @test */
    public function a_provider_receives_a_notification_when_a_patient_extends_share(){
        $patient = create(Patient::class);

        $shareOne = create(ProfileShare::class, ['patient_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        // New expiration
        $expiration = $shareOne->expired_at->addDays(1)->format('Y-m-d h:i:s');

        $update = ['extension' => $expiration];

        $this->makeAuthRequest()
            ->patch("/api/patient/profile/shares/{$shareOne->id}/extend", $update);
        $provider = $shareOne->provider;
        $this->assertDatabaseHas('profile_shares',['expired_at' => $update]);
        $this->assertCount(1,$provider->notifications);
    }
    /** @test */
    public function a_provider_recieves_a_notification_when_a_profile_shared_has_been_canceled(){
       // Notification::fake();
        $patient = create(Patient::class);

        $shareOne = create(ProfileShare::class, ['patient_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->patch("/api/patient/profile/shares/{$shareOne->id}/expire");

        $this->assertFalse($shareOne->fresh()->isActive);
        $provider = $shareOne->provider;
        //Notification for a profile share has been cancelled
        $this->assertCount(1,$provider->notifications);
       // Notification::assertSentTo($provider,ProfileShareExpiredNotification::class);
    }

    /** @test */
    public function a_patient_can_not_share_his_profile_with_a_date_lesser_than_now()
    {
        $patient = create(Patient::class);

        $provider = create(Doctor::class);

        $this->signIn($patient, 'patient');

        $this->expectException(ValidationException::class);

        $this->makeAuthRequest()
            ->post('/api/patient/profile/shares', [
                'chcode' => $provider->chcode,
                'expiration' => Carbon::now()->subDay()->format('Y-m-d h:i:s')
            ]);
    }

    /** @test */
    public function a_patient_can_view_a_log_of_his_profile_shares()
    {
        $patient = create(Patient::class);

        $shareOne = create(ProfileShare::class, ['patient_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->get('/api/patient/profile/shares')
            ->assertSee($shareOne->patient_id);
    }

    /** @test */
    public function a_patient_can_expire_a_share()
    {
        $patient = create(Patient::class);

        $shareOne = create(ProfileShare::class, ['patient_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->patch("/api/patient/profile/shares/{$shareOne->id}/expire");

        $this->assertFalse($shareOne->fresh()->isActive);
    }

    /** @test */
    public function a_patient_can_extend_a_share()
    {
        $patient = create(Patient::class);

        $shareOne = create(ProfileShare::class, ['patient_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        // New expiration
        $expiration = $shareOne->expired_at->addDays(1)->format('Y-m-d h:i:s');

        $update = ['extension' => $expiration];

        $this->makeAuthRequest()
            ->patch("/api/patient/profile/shares/{$shareOne->id}/extend", $update);

        $this->assertDatabaseHas('profile_shares',['expired_at' => $update]);
    }
}
