@extends('layouts.app')

@section('title_page', __('messages.the_store'))

@section('content')

<section>

    @if($sliderStores->isNotEmpty())
    <div class="container">
        <b>@lang('messages.best_seller')</b>
        <div class="slider_home">

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
        </div>
    </div>
    @endif


    <div class="container">
        <div class="row">
            @if($products->isNotEmpty())

            @foreach ($products as $product)
            @php
            $randomNumber=rand(111, 999);
            @endphp
            <div class="col-12 col-md-4 col-lg-3 mb-4">
                <a class="card_product" href="{{ route('store.show',  app()->getLocale() == 'ar' ? $product->link_ar : $product->link_en ) }}">
                    <div class="card mt-4 border-0 rounded-0 shadow">
                        <div class="card_product_img">
                            <img src="{{ url(Storage::url($product->images[0]->img)) }}" class="card-img-top rounded-0" alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}" />
                        </div>

                        <div class="card-body mt-3 mb-3">
                            <div class="row">
                                <div class="col-10">
                                    <h4 class="card-title">{{ Str::limit(app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en, 10) }}</h4>
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
                                <h5 class="btn btn-danger m-0">{{ $product->price }} @lang('messages.currency')</h5>
                            </div>
                            <div class="col-2">
                                <i class="bi bi-bag-plus-fill"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            @else
            <div class="d-flex justify-content-center align-items-center">
                <p class="text-center text-danger">@lang('messages.no_products_to_display')</p>
            </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-center">
        {{$products->links('pagination::bootstrap-4')}}
    </div>

</section>

@endsection
