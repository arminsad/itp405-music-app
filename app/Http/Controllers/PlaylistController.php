<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = DB::table('playlists')
        ->get([
            'id',
            'name',
        ]);

        return view('playlists.index', [
            'playlists' => $playlists
        ]);
    }
    public function show($id)
    {
        $playlist = DB::table('playlists')
        ->where('id', '=', $id)
        ->first();

        $playlistTracks = DB::table('playlist_track')
            ->where('playlist_id', '=', $id)
            ->join('tracks', 'tracks.id', '=', 'playlist_track.track_id')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->join('genres', 'tracks.genre_id', '=', 'genres.id')
            ->get([
                'tracks.name AS track',
                'albums.title AS album',
                'artists.name AS artist',
                'genres.name AS genre',
            ]);

        return view('playlists.show' , [
            'playlist' => $playlist,
            'playlistTracks' => $playlistTracks,
        ]);
    }

    public function edit($id)
    {
        $playlist= DB::table('playlists')->where('id', '=', $id)->first();
        return view('playlists.edit', [
            'playlist' => $playlist,
        ]);
    }

    public function update($id,Request $request)
    {
        $playlist= DB::table('playlists')->where('id', '=', $id)->first();
        $request->validate([
            'playlist'=> 'required|max:30|unique:playlists,name,' . $id,
        ]);

        DB::table('playlists')->where('id', '=', $id)->update([
            'name' => $request->input('playlist'),
        ]);
        return redirect()
        ->route('playlists.index', [ 'id' => $id])
        ->with('success', "{$playlist->name} was successfully renamed to {$request->input('playlist')}");
    }
}
