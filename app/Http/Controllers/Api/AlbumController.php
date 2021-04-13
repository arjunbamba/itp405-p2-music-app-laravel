<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
 
class AlbumController extends Controller
{
    // Look at Laravel docs at resource controller
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Album::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Post hits store method automatically 

        // Before we did: $request->validate();
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'artist_id' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        // $album = new Album();
        // $album->title = $request->input('title');
        // $album->artist_id = $request->input('artist_id');
        return Album::create($request->all());
    }

    /**
     * Display the specified resource.
     * 
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        // Like Laravel doing something like this in web.php:
        // Route::get('/api/albums/{album}', [AlbumController::class, 'show']);
        // Laravel automatically does Album::find($id); because parameter is Album $album - aka route model binding
        return $album;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        // Put hits update method automatically 

        // Before we did: $request->validate();
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'artist_id' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        $album->update($request->all());
        return $album;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        // Making a delete request to /albums/id, it'll call destroy method
        // Laravel wll find album for us via route model binding

        // Only want to delete albumss with no tracks

        $trackCount = DB::table('tracks')->where('album_id', '=', $album->id)->count();

        if ($trackCount > 0) {
            return response()->json([
                'error' => 'Only albums without tracks can be deleted.',
            ], 400);
        }

        $album->delete();
        return response(null, 204);
    }
}
