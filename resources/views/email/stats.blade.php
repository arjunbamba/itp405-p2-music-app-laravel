@extends('layouts.email')

@section('content')
    <br>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Usage Stats</h5>
            <h6 class="card-subtitle mb-2 text-muted">View stats below.</h6>
            <p class="card-text">Total number of artists: {{ $artist }} artists.</p>
            <p class="card-text">Total number of playlists: {{ $playlist }} playlists.</p>
            <p class="card-text">Total minutes of tracks: {{ floor($track / 60000) }} minutes.</p>
        </div>
    </div>
@endsection