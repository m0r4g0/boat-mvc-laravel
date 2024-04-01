<!-- resources/views/boats/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Boats</h1>
    
    <a href="{{ route('boats.create') }}" class="btn btn-primary">Create Boat</a>

    @if ($boats->isEmpty())
        <p>No boats found.</p>
    @else
        <ul>
            @foreach ($boats as $boat)
                <li>{{ $boat->name }} - {{ $boat->category }}
                    <a href="{{ route('boats.edit', $boat->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('boats.destroy', $boat->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
@endsection