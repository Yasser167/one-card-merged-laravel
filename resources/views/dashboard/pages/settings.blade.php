@extends('dashboard.layouts.app')

@section('admin_content')

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5 mb-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Settings Site</h3>
                </div>
                <div class="card-body">

                    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.update.settings', 1) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="favicon">favicon icon Size 100px × 100px </label>
                            <div class="img_blog">
                                <input type="file" class="form-control-file image-file" id="favicon" name="favicon" accept=".ico">
                                <img class="preview" src="{{ Storage::url($settings->favicon) }}" alt="Image">
                                <i class="bi bi-cloud-upload upload"></i>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="logo_site">logo_site Size 50px × 50px </label>
                            <div class="img_blog" style="width: 50px; height: 50px; border-radius: 5px; background: #111;">
                                <input type="file" class="form-control-file image-file" id="logo_site" name="logo_site" accept="*/images">
                                <img class="preview" src="{{ Storage::url($settings->logo_site) }}" alt="Image">
                                <i class="bi bi-cloud-upload upload"></i>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="logo_og">logo SEO Size 400px × 400px </label>
                            <div class="img_blog" style="width: 200px; height: 200px; border-radius: 5px;">
                                <input type="file" class="form-control-file image-file" id="logo_og" name="logo_og" accept=".png">
                                <img class="preview" src="{{ Storage::url($settings->logo_og) }}" alt="Image">
                                <i class="bi bi-cloud-upload upload"></i>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="title_en">Site Title en</label>
                            <div class="input-group">
                                <input type="text" name="title_en" id="title_en" class="form-control" value="{{ old('title_en',$settings->title_en) }}" placeholder="Site Title en">
                            </div>
                            <label for="title_ar">Site Title ar</label>
                            <div class="input-group">
                                <input type="text" name="title_ar" id="title_ar" class="form-control" value="{{ old('title_ar',$settings->title_ar) }}" placeholder="Site Title ar">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description_en">Site description en </label>
                            <div class="input-group">
                                <textarea name="description_en" id="description_en" class="form-control" placeholder="Site description en">{{ old('description_en',$settings->description_en) }}</textarea>
                            </div>
                            <label for="description_ar">Site description ar </label>
                            <div class="input-group">
                                <textarea name="description_ar" id="description_ar" class="form-control" placeholder="Site description ar">{{ old('description_ar',$settings->description_ar) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="keywords">Keywords separated by commas (,) </label>
                            <div class="input-group">
                                <input type="text" name="keywords" id="keywords" class="form-control" value="{{ old('keywords',$settings->keywords) }}" placeholder="Keywords separated by commas (,) ">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="head">head </label>
                            <div class="input-group">
                                <textarea name="head" id="head" class="form-control" placeholder="head">{{ old('head', $settings->head) }}</textarea>
                            </div>
                        </div>



                        <button type="submit" class="btn btn-primary">save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
