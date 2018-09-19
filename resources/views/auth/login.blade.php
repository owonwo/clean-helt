@extends('auth.base')

@section('content')
    <Login model="{{ request('type') ? request('type') : 'PATIENT' }}">
        <template>
            @if($errors->has('login'))
                <div class="notification is-warning">
                    {{ $errors->first('login') }}
                </div>
            @endif
        </template>
        @csrf
    </Login>
@stop
