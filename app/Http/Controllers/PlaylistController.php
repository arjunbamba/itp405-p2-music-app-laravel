<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PlaylistController extends Controller
{
    public function index() 
    {
        $all_playlists = DB::table('playlists')
            ->get([
                'playlists.id',
                'playlists.name',
            ]); // Model Layer; 

            //SELECT id, name
            //FROM playlists

        return view('playlist.index', [
            'all_playlists' => $all_playlists
        ]);
    }

    public function show($id) 
    {
        // dd($id);
        $playlist = DB::table('playlists')
            ->where('id', '=', $id)
            ->first();

        // dd($playlist);

        $all_tracks = DB::table('playlist_track')
            ->where('playlist_id', '=', $id)
            ->join('tracks', 'playlist_track.track_id', '=', 'tracks.id')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->join('genres', 'tracks.genre_id', '=', 'genres.id')
            ->get([
                'tracks.name AS track',
                'albums.title AS album',
                'artists.name AS artist',
                'genres.name AS genre',
            ]);

        return view('playlist.show', [
            'playlist' => $playlist,
            'all_tracks' => $all_tracks,
        ]);
    }
}
