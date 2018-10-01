@extends('auth.base')

@section('content')
	@php 
		$nm = @request()->query('type') !== 'doctor' ? 'PATIENT' : 'DOCTOR';
	@endphp
  <Register model="{{ $nm }}"/>
@stop
