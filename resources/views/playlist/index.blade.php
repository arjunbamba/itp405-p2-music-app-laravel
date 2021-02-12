@extends('layouts.main') 

@section('title', 'Playlists')

@section('content')
<table>
    <thead>
        <tr>
            <th style="border-left: 1px solid #000; padding: 0px 10px;">Playlist ID</th>
            <th style="border-left: 1px solid #000; border-right: 1px solid #000; text-align: center;">Playlist Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach($all_playlists as $playlist)
            <tr>
                <td style="border-left: 1px solid #000; text-align: center;">
                    {{$playlist->id}}
                </td>
                <td style="border-left: 1px solid #000; text-align: center; padding: 0px 10px;">
                    {{$playlist->name}}
                </td>
                <td style="border-left: 1px solid #000">
                    {{-- /playlists/{{$playlist->id}} --}}
                    <a href="{{ route('playlist.show', ['id' => $playlist->id]) }}">
                        Details
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection