@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name ?? old('name') }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($category) ? 'Update' : 'Add' }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
