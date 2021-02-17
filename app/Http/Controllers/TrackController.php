<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    public function index()
    {
    $tracks = DB::table('tracks')
    ->join('albums', 'tracks.album_id', '=', 'albums.id')
    ->join('artists', 'albums.artist_id', '=', 'artists.id')
    ->join('genres', 'tracks.genre_id', '=', 'genres.id')
    ->join('media_types', 'tracks.media_type_id', '=', 'media_types.id')
    ->orderBy('tracks.name')
    ->get([
        'tracks.id',
        'tracks.name AS tracks',
        'albums.title AS albums',
        'artists.name AS artist',
        'media_types.name AS media_types',
        'genres.name AS genres',
        'tracks.unit_price',
    ]);
    return view('track.index', [
        'tracks' => $tracks,
    ]);  
    }
    
    public function create()
    {
        $albums = DB::table('albums')->orderBy('title')->get();
        $media_types = DB::table('media_types')->orderBy('name')->get();
        $genres = DB::table('genres')->orderBy('name')->get();
        return view('track.create', [
            'albums' => $albums,
            'media_types' => $media_types,
            'genres' => $genres,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tracks' => 'required|max:50',
            'album' => 'required|exists:albums,id',
            'media_type' => 'required|exists:media_types,id',
            'genre' => 'required|exists:genres,id',
            'unit_price' => 'required|numeric',
        ]);

        DB::table('tracks')->insert([
            'name' => $request->input('tracks'),
            'album_id' => $request->input('album'),
            'genre_id' => $request->input('genre'),
            'media_type_id' => $request->input('media_type'),
            'unit_price' => $request->input('unit_price'),
        ]);

        return redirect()
        ->route('track.index')
        ->with('success', "Successfully created {$request->input('tracks')}");
    }
}
