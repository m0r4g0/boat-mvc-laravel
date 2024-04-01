<!-- resources/views/boats/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Boat</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('boats.update', $boat->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $boat->name }}">
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category" class="form-control">
                <option value="sailing-yacht" {{ $boat->category === 'sailing-yacht' ? 'selected' : '' }}>Sailing Yacht</option>
                <option value="motor-boat" {{ $boat->category === 'motor-boat' ? 'selected' : '' }}>Motor Boat</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection