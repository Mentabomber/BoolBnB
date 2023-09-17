@extends('layouts.app')
@section('content')
    <h1 style="text-align: center">
        {{ $message}}
    </h1>

    <a href="{{ route('auth.apartments.show') }}">Torna indietro</a>
@endsection
