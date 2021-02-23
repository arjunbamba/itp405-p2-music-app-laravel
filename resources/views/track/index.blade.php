@extends('layouts.main') 

@section('title', 'Tracks')

@section('content')

<div class="text-end mb-3">
    <a href="{{ route('track.new') }}">New Track</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Album Title</th>
            <th>Artist Name</th>
            <th>Media Type Name</th>
            <th>Genre Name</th>
            <th>Unit Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tracks as $track)
            <tr>
                <td>
                    {{ $track->name }}
                </td>
                <td>
                    {{ $track->album }}
                </td>
                <td>
                    {{ $track->artist }}
                </td>
                <td>
                    {{ $track->media_type }}
                </td>
                <td>
                    {{ $track->genre }}
                </td>
                <td>
                    {{ $track->unit_price }}
                </td>
                {{-- 
                <td>
                    <a href="{{ route('album.edit', [ 'id' => $album->id ]) }}">
                        Edit
                    </a>
                </td>
                --}}
            </tr>
        @endforeach
    </tbody>
</table>
@endsection