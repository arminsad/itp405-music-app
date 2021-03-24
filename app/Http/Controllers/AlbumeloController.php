<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AlbumeloController extends Controller
{
    public function index()
    {
        $albums = Album::with(['artist', 'user'])->orderBy('title')->get();
        // $albums = Album::select('albums.*')
        //     ->with(['artist', 'user'])
        //     ->join('artists', 'albums.artist_id', '=', 'artists.id')
        //     ->join('users', 'albums.user_id', '=', 'users.id')
        //     ->when(!Auth::user()->isAdmin(), function($query){
        //         return $query->where('albums.user_id', '=', Auth::user()->id);
        //     })
        //     ->orderBy('title')
        //     ->get();

        return view('albumelo.index', [
            'albums' => $albums,
        ]);  
    }

    public function create()
    {
        $artists = Artist::orderBy('name')->get();
        return view('albumelo.create', [
            'artists' => $artists,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'=> 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = new Album();
        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->user_id = Auth::user()->id;
        $album->save();

        return redirect()
        ->route('albumelo.index')
        ->with('success', "Successfully created {$request->input('title')}");
    }
    
    public function edit($id)
    {
        $artists = Artist::orderBy('name')->get();
        $album = Album::where('id', '=', $id)->first();

        if (Auth::user()->cannot('edit', $album)){
            abort(403);
        }

        return view('albumelo.edit', [
            'artists' => $artists,
            'album' => $album,
        ]);
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = Album::where('id', '=', $id)->update([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist'),
        ]);

        if (Auth::user()->cannot('edit', $album)){
            abort(403);
        }

        return redirect()
        ->route('albumelo.edit', [ 'id' => $id])
        ->with('success', "Successfully updated  {$request->input('title')}");
    }
}
