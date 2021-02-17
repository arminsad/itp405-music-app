@extends('layouts.main')

@section('title', 'Tracks')

@section('content')
    <div class="text-end mb-3">
        <a href="{{route('track.create')}}">New Track</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Track</th>
                <th>Album</th>
                <th>Artist</th>
                <th>Media Type</th>
                <th>Genre</th>
                <th>Unit Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tracks as $track)
                <tr>
                    <td>
                        {{$track->tracks}}
                    </td>
                    <td>
                        {{$track->albums}}
                    </td>
                    <td>
                        {{$track->artist}}
                    </td>
                    <td>
                        {{$track->media_types}}
                    </td>
                    <td>
                        {{$track->genres}}
                    </td>
                    <td>
                        {{$track->unit_price}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection