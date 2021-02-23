<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function index() 
    {
        $albums = DB::table('albums')
            ->join('artists', 'artists.id', '=', 'albums.artist_id')
            ->orderBy('artist')
            ->orderBy('title')
            ->get([
                'albums.id',
                //realiasing
                'albums.title',
                'artists.name AS artist',
            ]);

        //corresponds to folder in views folder ie path in views folder
        return view('album.index', [
            //pass in data for when you render view
            'albums' => $albums,
        ]);
    }

    public function create()
    {
        $artists = DB::table('artists')->orderBy('name')->get();

        return view('album.create', [
            'artists' => $artists,
        ]);
    }
    public function store(Request $request)
    {
        // If you want to add more rules, can separate with pipe. "max" is max characters rule.
        // exists rule means it must exist in artist table in id column
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        //input method allows us to collect info so like collect data typed into select menu for artist
        // dd($request->input('artist')); //PHP equivalent: $_POST('artist')

        //insert into table
        DB::table('albums')->insert([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist'),
        ]);

        //time 1:49:00 for artist

        return redirect()
            ->route('album.index')
            ->with('success', "Successfully created {$request->input('title')}");
    }

    public function edit($id)
    {
        $artists = DB::table('artists')->orderBy('name')->get();
        $album = DB::table('albums')->where('id', '=', $id)->first();

        return view('album.edit', [
            'artists' => $artists,
            'album' => $album,
        ]);
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        DB::table('albums')->where('id', '=', $id)->update([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist'),
        ]);

        return redirect()
            ->route('album.edit', [ 'id' => $id ])
            ->with('success', "Successfully updated {$request->input('title')}");
    }
}
