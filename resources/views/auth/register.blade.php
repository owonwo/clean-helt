@extends('auth.base')

@section('content')
	@php 
		$nm = "PATIENT";
		if (request()->query('type'))
			$nm = @request()->query('type') !== 'doctor' ? 'PATIENT' : 'DOCTOR';
	@endphp
  <Register model="{{ $nm }}"/>
@stop
