@extends('layouts.main') 

@section('title')
Playlists: {{$playlist->name}}
@endsection

@section('content')
    <a href="{{route('playlist.index')}}" class="d-block mb-3">Back to Playlists</a>
    <p>Total tracks: {{$all_tracks->count()}}</p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Track</th>
                <th>Album</th>
                <th>Artist</th>
                <th>Genre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($all_tracks as $single_track)
                <tr>
                    <td>{{$single_track->track}}</td>
                    <td>{{$single_track->album}}</td>
                    <td>{{$single_track->artist}}</td>
                    <td>{{$single_track->genre}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection