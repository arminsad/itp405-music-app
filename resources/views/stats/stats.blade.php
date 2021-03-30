@extends('layouts.email')

@section('content')
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            Stats
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Total number of artists: {{$artist_num}}</li>
            <li class="list-group-item">Total number of albums: {{$album_num}}</li>
            <li class="list-group-item">Total tracks length: {{$milliseconds}}</li>
        </ul>
  </div>
@endsection