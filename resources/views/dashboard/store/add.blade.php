@if(auth()->check() && auth()->user()->is_admin)
@extends('dashboard.layouts.app')

@section('title_page', 'Add product')

@section('html')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css'>
@endsection


@section('admin_content')

<section>
    <div class="container mt-5">
        <h2>Add Product</h2>

        <form class="form login" method="POST" action="{{ route('admin.store.store') }}" enctype="multipart/form-data" onsubmit="return disableButton()" style="max-width:100%;margin:20px auto;">
            @csrf
            <div class="form-group mb-3">
                <input type="file" name="img[]" class="form-control-file multiple_images" id="multiple_images" multiple required>

                <div class="image-preview mt-2">
                    <label for="multiple_images">
                        <img src="{{ url( 'frontend/images/img_upload.webp' ) }}" alt="img_upload" style="width:100px;object-fit:cover;">
                    </label>
                </div>
            </div>

            <div class="form-group mb-3">
                <b>name en & ar</b>
                <div class="input-group mb-3">
                    <input type="text" name="name_en" class="form-control me-2" placeholder="name en" value="{{ old('name_en') }}" required>

                    <input type="text" name="name_ar" class="form-control" placeholder="name ar" value="{{ old('name_ar') }}" required>

                </div>

                <b>link en & ar</b>
                <div class="input-group mb-3">
                    <input type="text" name="link_en" class="form-control link_seo me-2" placeholder="link en" value="{{ old('link_en') }}" required>

                    <input type="text" name="link_ar" class="form-control link_seo" placeholder="link ar" value="{{ old('link_ar') }}" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <b>description en</b>
                <div class="input-group mb-3">
                    <textarea name="description_en" class="form-control description_en" required>{{ old('description_en') }}</textarea>
                </div>

                <b>description ar</b>
                <div class="input-group mb-3">
                    <textarea name="description_ar" class="form-control description_ar" required>{{ old('description_ar') }}</textarea>
                </div>
            </div>

            <div class="form-group mb-3">
                <b>price</b>
                <div class="input-group mb-3" style="max-width: 200px;">
                    <input type="floor" name="price" class="form-control  me-2" placeholder="price" value="{{ old('price') }}" required>
                    <b class="mt-2">SAR</b>
                </div>

            </div>



            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</section>

@endsection

@else
<div class="alert alert-danger">🚫 هذه الصفحة مخصصة للمسؤول فقط.</div>
@endif