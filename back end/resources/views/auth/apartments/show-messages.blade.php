@extends('layouts.app')
@section('content')
@if ($apartment->user_id == auth()->user()->id)
<div>
    <h2>Messaggi dell'appartamento {{ $apartment->title }}</h2>
    <ul>
        @foreach ($messages as $message)
        <br>
        <li>
            <span>{{ $message->name }}</span>
            <span>{{ $message->surname }}</span>
            <span>{{ $message->email }}</span>
            <span>{{ $message->message }}</span>
        </li>
        <br>
        @endforeach
    </ul>
    <span>Torna a <a href="{{ route('auth.apartments.show') }}">Miei appartamenti</a></span>
</div>
@endif


@endsection