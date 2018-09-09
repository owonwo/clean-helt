<?php

namespace Tests;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\User;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use SMartins\PassportMultiauth\PassportMultiauth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var
     * Auth Access Token
     */
    protected $token;

    protected function setUp()
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }

    protected function signIn($user = null, $guard = null)
    {
        Artisan::call('passport:install');
        $user = $user ?: $this->getUserFromGuard($guard);
        PassportMultiauth::actingAs($user);
        //$this->setUpToken($guard);
        return $this;
    }

    protected function makeAuthRequest()
    {
        return $this;//->withHeaders(['Authorization' =>  'Bearer ' . $this->token]);
    }

    protected function setUpToken($guard)
    {
        $this->token = auth()->guard($guard)->user()
                ->createToken(config('app.name'))
                ->accessToken;
    }

    protected function getUserFromGuard($guard)
    {
        switch ($guard) {
            case 'hospital':
                return create(Hospital::class);
            case 'admin':
                return create(Admin::class);
            case 'doctor':
                return create(Doctor::class);
            case 'laboratory':
                return create(Laboratory::class);
            case 'patience':
                return create(Patient::class);
            default:
                return create(User::class);
        }
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }
    public function assertEventIsBroadcasted($eventClassName, $channel=""){
        $logfileFullpath = storage_path("logs/laravel.log");
        $logfile = explode("\n", file_get_contents($logfileFullpath));

        if(count($logfile) > 4){
            $supposedLastEventLogged = $logfile[count($logfile)-5];

            $this->assertContains("Broadcasting [", $supposedLastEventLogged, "No broadcast were found.\n");

            $this->assertContains("Broadcasting [".$eventClassName."]", $supposedLastEventLogged, "A broadcast was found, but not for the classname '".$eventClassName."'.\n");

            if($channel != "")
                $this->assertContains("Broadcasting [".$eventClassName."] on channels [".$channel."]", $supposedLastEventLogged, "The expected broadcast (".$eventClassName.") event was found, but not on the expected channel '".$channel."'.\n");
        }else{
            $this->fail("No informations found in the file log '".$logfileFullpath."'.");
        }
    }
}
