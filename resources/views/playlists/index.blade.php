@extends('layouts.p_main')

@section('title', 'Playlists')

@section('content')
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($playlists as $playlist)
                <tr>
                    <td>
                        {{$playlist->id}}
                    </td>
                    <td>
                        <a href="{{route('playlists.show', [ 'id' => $playlist->id ])}}">
                            {{$playlist->name}}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection