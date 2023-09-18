@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="text-center d-flex justify-content-center">
            <h2>Le mie statistiche</h2>
        </div>
        <ul>
            
            @foreach($visits as $visit)
    
            <li>{{ $visit }}</li>
    
            @endforeach

        </ul>
           
            <a href="{{ route('dashboard') }}">Torna alla Dashboard</a>
        </div>
    </div>
@endsection
