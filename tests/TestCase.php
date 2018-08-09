<?php

namespace Tests;

use App\Models\Admin;
use App\Models\Hospital;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\User;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

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
        $this->actingAs($user, $guard);
        $this->setUpToken($guard);
        return $this;
    }

    protected function makeAuthRequest()
    {
        return $this->withHeaders(['Authorization' =>  'Bearer ' . $this->token]);
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
}
