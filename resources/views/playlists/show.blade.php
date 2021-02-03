@extends('layouts.p_main')

@section('title')
    Playlist: {{$playlist->name}}
@endsection

@section('content')
    <a href="{{route('playlists.index')}}" class="d-block mb-3">Back to Playlists</a>
    <p>Tracks Total: {{$playlistTracks->count()}}</p>
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
            @foreach($playlistTracks as $playlistTrack)
                <tr>
                    <td>{{$playlistTrack->track}}</td>
                    <td>{{$playlistTrack->album}}</td>
                    <td>{{$playlistTrack->artist}}</td>
                    <td>${{$playlistTrack->genre}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection