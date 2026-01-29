@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Service</h2>

    {{-- ✅ عرض رسائل النجاح أو الأخطاء --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('provider.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ✅ الاسم --}}
        <div class="mb-3">
            <label for="name" class="form-label">Service Name</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="{{ old('name', $service->name) }}"
                required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- ✅ الفئة --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- ✅ السعر --}}
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input
                type="number"
                name="price"
                id="price"
                class="form-control"
                value="{{ old('price', $service->price) }}"
                step="0.01"
                required>
            @error('price')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- ✅ الوصف --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea
                name="description"
                id="description"
                class="form-control"
                rows="3">{{ old('description', $service->description) }}</textarea>
            @error('description')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- ✅ الصورة --}}
        <div class="mb-3">
            <label for="image" class="form-label">Service Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">

            @if($service->image)
                <div class="mt-2">
                    <p class="mb-1">Current Image:</p>
                    <img src="{{ asset('storage/' . $service->image) }}" width="120" class="rounded shadow">
                </div>
            @endif

            @error('image')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <button class="btn btn-success">Update Service</button>
    </form>
</div>
@endsection
