@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Category Details</h1>

    <div class="card mb-3">
        <div class="card-header">{{ $category->name }}</div>
        <div class="card-body">
            <p>ID: {{ $category->id }}</p>
            <p>Created At: {{ $category->created_at->format('d-m-Y') }}</p>
            <p>Updated At: {{ $category->updated_at->format('d-m-Y') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
