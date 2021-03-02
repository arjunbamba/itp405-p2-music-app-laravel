<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;

class EloquentAlbumController extends Controller
{
    public function index() {

        $albums = Album::with('artist')
            ->join('artists', 'artists.id', '=', 'albums.artist_id')
            ->orderBy('artists.name')
            ->orderBy('title')
            ->get([
                'albums.*',
                'artists.id AS artist_id', 
            ]);

        return view('eloquent_album.index', [
            'albums' => $albums,
        ]);
    }

    public function create() {

        $artists = Artist::orderBy('name')->get();

        return view('eloquent_album.create', [
            'artists' => $artists,
        ]);
    }

    public function store(Request $request) {

        // If you want to add more rules, can separate with pipe. "max" is max characters rule.
        // exists rule means it must exist in artist table in id column
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $artist = Artist::find($request->input('artist'));

        $album = new Album();
        $album->title = $request->input('title');
        $album->artist()->associate($artist);
        $album->save();

        return redirect()
            ->route('eloquent_album.index')
            ->with('success', "Successfully created: {$request->input('title')} by {$artist->name}");
    }

    public function edit($id) {
        $artists = Artist::orderBy('name')->get();
        $album = Album::find($id);

        return view('eloquent_album.edit', [
            'artists' => $artists,
            'album' => $album,
        ]);
    }

    public function update($id, Request $request) {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $artist = Artist::find($request->input('artist'));

        $album = Album::find($id);
        $album->title = $request->input('title');
        $album->artist()->associate($artist);
        $album->save();

        return redirect()
            ->route('album.edit', [ 'id' => $id ])
            ->with('success', "Successfully updated: {$request->input('title')} by {$artist->name}");
    
    }
}
