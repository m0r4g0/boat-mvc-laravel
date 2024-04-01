@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $boat->name }}</h1>
        <p><strong>Category:</strong> {{ $boat->category }}</p>
        <p><strong>Slug:</strong> {{ $boat->slug }}</p>
        <p><strong>ID:</strong> {{ $boat->id }}</p>
        <p><strong>Created at:</strong> {{ $boat->created_at }}</p>
        <p><strong>Updated at:</strong> {{ $boat->updated_at }}</p>

        <a href="{{ route('boats.index') }}" class="btn btn-secondary">Back to Boats</a>
    </div>
@endsection