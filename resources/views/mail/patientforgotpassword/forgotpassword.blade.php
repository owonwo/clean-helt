@extends('auth.base')

@section('content')
    <div id="osq-login">
        <div class="container">
            <div class="has-text-centered">
                <div class="menu-label">Forgot Password</div>
                <img 
                    class="logo" 
                    src="/images/assets/logo.png"/>
            </div>
            <div class="columns is-centered">
                <div class="column is-one-third">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="has-text-centered" role="form" method="POST" action="{{ route('patient.password.email') }}">
                        {{ csrf_field() }}

                        <div class="field {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="is-hidden">Enter Email Address</label>
                            <div class="control">
                                <input id="email" type="email" class="input" 
                                    name="email"
                                    placeholder="john.doe@domain.org" 
                                    value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="buttons is-centered">
                            <button type="submit" class="button is-primary">
                                Reset
                            </button>
                            <a href="/login" class="button is-outlined">
                                Back
                            </a>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection