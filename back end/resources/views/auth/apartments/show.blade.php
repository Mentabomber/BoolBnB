@extends('layouts.app')
@section('content')

@php
    $today = date('Y-m-d');
@endphp

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="text-center d-flex justify-content-center">
            <h2>Miei Appartamenti</h2>
        </div>

        <div class="text-center">
            <ul class="list-unstyled">
                @foreach ($apartments as $apartment)
                    @if ($apartment->user_id == auth()->user()->id)
                        <li>
                            <a href="{{ route('guest.apartments.show', $apartment->id) }}">{{ $apartment->title }}</a>
                            <a href="{{ route('auth.apartments.edit', $apartment->id) }}"> Modifica</a>
                            <a href="{{ route('auth.apartments.show-messages', $apartment->id) }}">Lista Messaggi Appartamento</a>

                            {{-- @if ($apartment->sponsorships->isEmpty())
                                <a href="{{ route('sponsor_plans', $apartment->id) }}">Crea sponsorizzazione</a>
                            @else
                                @foreach ($apartment->sponsorships as $sponsorship)
                                    <li>{{ $sponsorship->type }}</li>
                                @endforeach
                            @endif --}}

                            @if ($apartment->sponsorships->isEmpty() || $apartment->sponsorships->last()->pivot->'end_date' < $today)
                                <a href="{{ route('sponsor_plans', $apartment->id) }}">Crea sponsorizzazione</a>
                            @else
                                @foreach ($apartment->sponsorships as $sponsorship)
                                    <li>{{ $sponsorship->type }}</li>
                                @endforeach
                            @endif



                            <form
                            class="d-inline"
                            method="POST"
                            action="{{ route('auth.apartments.delete', $apartment -> id) }}"
                            >

                                @csrf
                                @method("DELETE")

                                <input class="btn btn-primary" type="submit" value="Elimina" onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')">
                            </form>

                        </li>
                    @endif
                @endforeach
            </ul>
            <a href="{{ route('dashboard') }}">Torna alla Dashboard</a>
        </div>
    </div>

@endsection
