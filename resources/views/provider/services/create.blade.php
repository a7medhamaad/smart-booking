@extends('layouts.provcust')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Add New Service</h2>

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

    <form action="{{ route('provider.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ✅ اسم الخدمة --}}
        <div class="mb-3">
            <label for="name" class="form-label">Service Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                placeholder="Enter service name" required>
            @error('name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- ✅ الفئة (Category) --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- ✅ السعر --}}
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}"
                placeholder="Enter service price" step="0.01" required>
            @error('price')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- ✅ الوصف --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"
                placeholder="Describe your service...">{{ old('description') }}</textarea>
            @error('description')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- ✅ الصورة --}}
        <div class="mb-3">
            <label for="image" class="form-label">Service Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            @error('image')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- ✅ زر الحفظ --}}
        <button type="submit" class="btn btn-success">Save Service</button>
    </form>
</div>
@endsection
