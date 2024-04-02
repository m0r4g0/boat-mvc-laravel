<!-- resources/views/boats/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Boats</h1>
    
    <a href="{{ route('boats.create') }}" class="btn btn-primary">Create Boat</a>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if ($boats->isEmpty())
        <p>No boats found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Slug</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($boats as $boat)
                    <tr>
                        <td><a href="{{ route('boats.showId', $boat->id) }}">{{ $boat->id }}</a></td>
                        <td>{{ $boat->slug }}</td>
                        <td>{{ $boat->name }}</td>
                        <td>{{ $boat->category }}</td>
                        <td>
                            <a href="{{ route('boats.edit', $boat->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('boats.destroy', $boat->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
