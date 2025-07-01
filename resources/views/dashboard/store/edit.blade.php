@if(auth()->check() && auth()->user()->is_admin)
@extends('dashboard.layouts.app')

@section('title_page', 'Edit product')

@section('html')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css'>
@endsection

@section('admin_content')

<section>
    <div class="container mt-5">
        <h2>Edit Product</h2>

        <form class="form login" method="POST" action="{{ route('admin.store.update', $store->id) }}" enctype="multipart/form-data" onsubmit="return disableButton()" style="max-width:100%;margin:20px auto;">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <input type="file" name="img[]" class="form-control-file multiple_images_edit" id="multiple_images" multiple>

                <div class="image-preview_edit mt-5">
                    @foreach ($store->images as $image)
                    <div class="existing-image">
                        <img src="{{ url( Storage::url($image->img)) }}" alt="Product Image" style="width:100px;object-fit:cover;">

                        <label for="delete_images_{{$image->id}}">
                            <i class="bi bi-trash text-danger"></i>
                            <input type="checkbox" name="delete_images[]" id="delete_images_{{$image->id}}" value="{{ $image->id }}" class="opacity-0">
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group mb-3">
                <b>name en & ar</b>
                <div class="input-group mb-3">
                    <input type="text" name="name_en" class="form-control me-2" placeholder="name en" value="{{ old('name_en', $store->name_en) }}" required>

                    <input type="text" name="name_ar" class="form-control" placeholder="name ar" value="{{ old('name_ar', $store->name_ar) }}" required>
                </div>

                <b>link en & ar</b>
                <div class="input-group mb-3">
                    <input type="text" name="link_en" class="form-control link_seo me-2" placeholder="link en" value="{{ old('link_en', $store->link_en) }}" required>

                    <input type="text" name="link_ar" class="form-control link_seo" placeholder="link ar" value="{{ old('link_ar', $store->link_ar) }}" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <b>description en</b>
                <div class="input-group mb-3">
                    <textarea name="description_en" class="form-control description_en" required>{{ old('description_en', $store->description_en) }}</textarea>
                </div>

                <b>description ar</b>
                <div class="input-group mb-3">
                    <textarea name="description_ar" class="form-control description_ar" required>{{ old('description_ar', $store->description_ar) }}</textarea>
                </div>
            </div>

            <div class="form-group mb-3">
                <b>price</b>
                <div class="input-group mb-3" style="max-width: 200px;">
                    <input type="floor" name="price" class="form-control me-2" placeholder="price" value="{{ old('price', $store->price) }}" required>
                    <b class="mt-2">SAR</b>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</section>

@endsection

@else
<div class="alert alert-danger">🚫 هذه الصفحة مخصصة للمسؤول فقط.</div>
@endif