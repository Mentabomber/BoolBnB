@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    <a href="{{ route('auth.apartments.create') }}"> Crea Nuovo Appartamento </a>
                    <br>
                    <a href="{{ route('auth.apartments.show') }}"> I miei appartamenti </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
