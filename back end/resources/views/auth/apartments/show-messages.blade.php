@extends('layouts.app')
@section('content')

@if ($apartment->user_id == auth()->user()->id)

    <div class="container">
        <h2><span>Messaggi</span> {{ $apartment->title }}</h2>

        <div class="accordion" id="accordionPanelsStayOpenExample">
            @foreach($messages as $id => $message)
                <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ $id === 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-collapse{{ $id }}" aria-expanded="{{ $id === 0 ? 'true' : 'false' }}" aria-controls="accordion-collapse{{ $id }}">
                    <span class="name-nick-email">{{ $message->name }} | {{ $message->surname }} | {{ $message->email }}</span>
                    </button>
                </h2>
                <div id="accordion-collapse{{ $id }}" class="accordion-collapse collapse {{ $id === 0 ? 'show' : '' }}">
                    <div class="accordion-body">
                    {{ $message->message }}
                    </div>
                </div>
                </div>
            @endforeach
        </div>
    </div>

@endif

<style>
body {
    background-color: #dfdedf;
}

.container  {

    padding: 1rem 2rem;
}

h2 {
    font-weight: bold;
    padding: 0rem 0rem;
    margin-bottom: 2rem;
}

h2 > span {
    color: #15ba8f;
}

.name-nick-email {
    font-weight: bold;
}

.accordion-item {
    border: 1px solid #15ba8f;
}

.accordion-body {
    border-top: 1px solid #15ba8f;
    padding: 1rem 2rem;
}

.accordion-button:not(.collapsed) {
    background-color: #00000000;
    color: black;
}

</style>

@endsection
