@extends('layouts.main')

 @section('title', 'Admin')

 @section('content')
    <form method="post" action="{{ route('toggle') }}">
        @csrf
        <div class="form-check">
            <input type="checkbox" name="maintenance-mode" id="maintenance-mode" value="1" {{ $configs->first()->value == TRUE ? 'checked' : ''}}>
            <label class="form-check-label" for="maintenance-mode">Maintenance Mode</label> 
        </div>
        <button type="submit" class="btn btn-primary">
            Save Changes
        </button>
    </form>
    <form method="post" action="{{ route('stats') }}">
        @csrf
        <button type="submit" class="btn btn-primary">
            Email Stats to Users
        </button>
    </form>
 @endsection