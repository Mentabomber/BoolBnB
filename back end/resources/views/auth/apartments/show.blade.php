@extends('layouts.app')
@section('content')

<div class="container">
    <h2>Miei <span>Appartamenti</span></h2>

    <ul class="list-unstyled d-flex justify-content-center align-items-center flex-wrap">
        @foreach ($apartments as $apartment)
            @if ($apartment->user_id == auth()->user()->id)
                <li class="card d-flex justify-content-between align-items-center flex-row">
                    <div class="img">
                        <img src="{{ asset('storage/uploads/' . $apartment->image) }}" alt="">
                    </div>

                    <div class="info">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="max-width: 215px">
                                <a class="titolo" href="{{ route('guest.apartments.show', $apartment->id) }}">
                                    <span>{{ $apartment->title }}</span><br>
                                    <i class="fa-solid fa-location-dot"></i> {{ $apartment->address->address }}
                                </a>
                            </div>
                            <div>
                                @if (!in_array($apartment->id, $apartmentsWithValidSponsorship))
                                    <a class="sponsor" href="{{ route('sponsor_plans', $apartment->id) }}">Sponsorizza</a>
                                @else
                                    @foreach ($endDate as $date)
                                        @if ($apartment->id == $date->apartment_id)
                                            <div class="data_sponsor">Sponsorizzato <br>
                                                fino al: <span class="data_fine">{{ $date->end_date }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <a class="bottone btn-dark" href="{{ route('auth.apartments.show-messages', $apartment->id) }}">Messaggi</a>
                             <a class="bottone btn-dark" href="#">Statistiche</a> {{-- aggiungere reindirizzamento a statistiche --}}
                            <a class="bottone btn-dark" href="{{ route('auth.apartments.edit', $apartment->id) }}"> Modifica</a>

                            <form class="d-inline" method="POST"
                                action="{{ route('auth.apartments.delete', $apartment->id) }}">

                                @csrf
                                @method('DELETE')

                                <input class="bottone btn-dark" type="submit" value="Elimina" style="border: none"
                                    onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')"
                                >
                            </form>
                        </div>
                    </div>
                </li>
            @endif
        @endforeach
    </ul>

    <a href="{{ route('dashboard') }}">Torna alla Dashboard</a>
</div>

<style>
.bottone {
    min-width: 150px;
    border-radius: 8px;
    background-color: #0d233d;
    color: white;
    text-align: center;
    padding: 0.5rem 2.5rem;
    margin: 1rem 0;
}
a {
    text-decoration: none;
    color: black;
}

.btn {
    --bs-btn-padding-x: 2.50rem;
}

.bottone:hover {
    color: #e1e6e4;
}

.container {
    background-color: #dfdedf;
    text-align: center;
}
h2 {
    font-weight: bold;
    font-size: 3rem;
    margin-bottom: 3rem;
    padding-top: 2rem;
}
h2 > span {
    color: #15ba8f;
}

.card {
    width: 80%;
    background-color: white;
    border: 1.2px solid #15ba8f;
    text-align: left;
    height: 280px;
    margin-bottom: 3rem;
}

.img {
    width: 45%;
    height: 100%;
}

img {
    width: 100%;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    height: 100%;
    object-fit: cover;
}

.info {
    width: 55%;
    padding: 2.5rem;
}

.titolo > span {
    font-weight: bold;
    font-size: 1.2rem;
}

.titolo {
    font-weight: bold;
    font-size: .8rem;
}

.sponsor {
    color: #15ba8f;
    font-weight: bold;
    text-shadow: 2px 2px #e6e9e6;
    font-size: 1.2rem;
    position: relative;
    bottom: 10px;
}

.data_sponsor {
    font-weight: bold;
    font-style: italic;
    text-align: right;
}

.data_fine {
    color: #15ba8f;
}
</style>

@endsection
