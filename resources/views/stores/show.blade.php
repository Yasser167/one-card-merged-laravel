@extends('layouts.app')

@section('title_page', __('messages.the_store'))

@section('content')

<section>
    @php
    $randomNumber=rand(111, 999);
    @endphp

    <input type="hidden" value="{{$product->id}}" class="add_to_cart_product_id">

    <div class="container my-5">
        <div class="row justify-content-between all_product">
            <div class="col-md-5" dir="ltr">
                <div class="main-slider">
                    @foreach ($product->images as $image)
                    <div>
                        <img src="{{ url( Storage::url($image->img)) }}" class="img-fluid" alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}">
                    </div>
                    @endforeach
                </div>

                <div class="thumbnail-slider mt-3">
                    @foreach ($product->images as $image)
                    <div>
                        <img src="{{ url( Storage::url($image->img)) }}" class="img-fluid" alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-5">
                <h2 class="product-title mb-1">{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h2>
                <div class="mb-3">
                    <span class="text-warning">★ ★ ★ ★ ★</span>
                    <span>({{$randomNumber}} @lang('messages.evaluation'))</span>
                </div>



                <p class="product-description mb-3">{{ app()->getLocale() == 'ar' ? $product->info_ar : $product->info_en }}</p>


                <h4 class="text-danger mb-3"><span>{{ $product->price }}</span> @lang('messages.currency')</h4>

                <div class="input-group mb-3" style="width: 120px;" dir="ltr">
                    <button class="btn btn-outline-secondary btn-decrease update_decrease" type="button" id="">-</button>
                    <input type="text" class="form-control text-center product-quantity" value="1" min="1" readonly>
                    <button class="btn btn-outline-secondary btn-increase update_increase" type="button">+</button>
                </div>

                <button class="btn btn-primary btn-lg w-100 add_to_cart_show" id="add-to-cart" onclick="addToCart(this, '{{$product->id}}')">
                    <i class="bi bi-cart"></i> @lang('messages.add_to_cart')
                </button>
            </div>
        </div>

        <div class="long-description mt-3">
            <h3 class="btn btn-info">@lang('messages.product_description')</h3>

            {!! app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en !!}
        </div>

    </div>


    <div class="container">
        <b>@lang('messages.best_seller')</b>
        <div class="slider_home">

            @if($sliderStores->isNotEmpty())
            @foreach ($sliderStores as $sliderStore)
            @php
            $randomNumber=rand(111, 999);
            @endphp

            <a class="card_product" href="{{ route('store.show',  app()->getLocale() == 'ar' ? $sliderStore->link_ar : $sliderStore->link_en ) }}">
                <div class="card border-0 rounded-0 shadow">
                    <div class="card_product_img">
                        <img src="{{ url(Storage::url($sliderStore->images[0]->img)) }}" class="card-img-top rounded-0" alt="{{ app()->getLocale() == 'ar' ? $sliderStore->name_ar : $sliderStore->name_en }}" />
                    </div>

                    <div class="card-body mt-3 mb-3">
                        <div class="row">
                            <div class="col-10">
                                <h4 class="card-title">{{ Str::limit(app()->getLocale() == 'ar' ? $sliderStore->name_ar : $sliderStore->name_en, 10) }}</h4>
                                <p class="card-text">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    ({{$randomNumber}})
                                </p>
                            </div>
                            <div class="col-2">
                                <i class="bi bi-bookmark-plus fs-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center text-center g-0">
                        <div class="col-10">
                            <h5 class="btn btn-danger m-0">{{ $sliderStore->price }} @lang('messages.currency')</h5>
                        </div>
                        <div class="col-2">
                            <i class="bi bi-bag-plus-fill"></i>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            @endif
        </div>
    </div>


</section>

@endsection
