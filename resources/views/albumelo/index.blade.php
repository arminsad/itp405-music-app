@extends('layouts.main')

@section('title', 'Albums')

@section('content')
    @can('create')
    <div class="text-end mb-3">
        <a href="{{route('albumelo.create')}}">New Album</a>
    </div>
    @endcan
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Album</th>
                <th>Artist</th>
                <th>Creator</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>
                        {{$album->title}}
                    </td>
                    <td>
                        {{$album->artist->name}}
                    </td>
                    <td>
                        {{$album->user->name}}
                    </td>
                    @can('edit', $album)
                    <td>
                        <a href="{{route('albumelo.edit', ['id' => $album->id])}}">
                            Edit
                        </a>
                    </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection