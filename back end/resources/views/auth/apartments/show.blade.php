@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="text-center d-flex justify-content-center">
            <h2>Miei Appartamenti</h2>
        </div>

        <div class="text-center">
            <ul class="list-unstyled">
                @foreach ($apartments as $apartment)
                    @if ($apartment->user_id == auth()->user()->id)
                        <li>
                            <a href="http://localhost:5174/apartment/{{ $apartment->id }}">{{ $apartment->title }}</a>
                            <a href="{{ route('auth.apartments.edit', $apartment->id) }}"> Modifica</a>
                            <a href="{{ route('auth.apartments.show-messages', $apartment->id) }}">Lista Messaggi
                                Appartamento</a>
                            <a href="{{ route('stats', $apartment->id) }}">Statistiche</a>

                            @if (!in_array($apartment->id, $apartmentsWithValidSponsorship))
                                <a href="{{ route('sponsor_plans', $apartment->id) }}">Crea sponsorizzazione</a>
                            @else
                                @foreach ($endDate as $date)
                                    @if ($apartment->id == $date->apartment_id)
                                        <span>Appartamento gia sponsorizzato fino al: {{ $date->end_date }}</span>
                                    @endif
                                @endforeach
                            @endif

                            <form class="d-inline" method="POST"
                                action="{{ route('auth.apartments.delete', $apartment->id) }}">

                                @csrf
                                @method('DELETE')

                                <input class="btn btn-primary" type="submit" value="Elimina"
                                    onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')">
                            </form>

                        </li>
                    @endif
                @endforeach
            </ul>
            <a href="{{ route('dashboard') }}">Torna alla Dashboard</a>
        </div>
    </div>
@endsection
