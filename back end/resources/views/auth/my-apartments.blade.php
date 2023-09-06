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
                            <a href="{{ route('guest.show-apartment', $apartment->id) }}">{{ $apartment->title }}</a>
                            <a href=""> Edit</a>
                        </li>
                    @endif
                @endforeach
            </ul>

        </div>
    </div>
@endsection
