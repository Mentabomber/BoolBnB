@extends('layouts.app')
@section('content')

<h1 class="display-5 fw-bold">
    Ricerca Avanzata
</h1>
<br>
<label for=""></label>
<input type="text" id="" name="">
<br>
<label for=""></label>
<input type="text" id="" name="">
<br>
<label for=""></label>
<input type="text" id="" name="">
<br>
<label for=""></label>
<input type="text" id="" name="">
<div>

    @foreach($apartments as $apartment)
        <div>
            <a href="{{ route('guest.apartments.show', $apartment->id) }}">{{ $apartment->title }}</a>
            <br>
            <img src="{{ asset('storage/uploads/' . $apartment->image) }}" alt="">
        </div>
    @endforeach
</div>

<div class="content">
    <div class="container">
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempora temporibus, dicta nemo aliquam totam nisi deserunt soluta quas voluptatum ab beatae praesentium necessitatibus minus, facilis illum rerum officiis accusamus dolores!</p>
    </div>
</div>
<script type="text/javascript" src="{{ asset('assets/js/search-bar.js') }}"></script>
@endsection
