<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ $settings->favicon ? url( Storage::url($settings->favicon)) : url( 'favicon.ico' ) }}" type="image/x-icon">
    <meta property="og:type" content="website" />

    <meta property="og:url" content="@yield('url_site' , url()->current())" />
    <meta property="twitter:url" content="@yield('url_site' , url()->current())" />

    <meta name="keywords" content="@yield('keywords_seo' , $settings->keywords)">

    <meta property="twitter:card" content="summary_large_image" />

    <meta name="description" content="@yield('description_og', app()->getLocale() == 'ar' ? $settings->description_ar : $settings->description_en)">
    <meta property="og:description" content="@yield('description_og' , app()->getLocale() == 'ar' ? $settings->description_ar : $settings->description_en)" />
    <meta property="twitter:description" content="@yield('description_og' , app()->getLocale() == 'ar' ? $settings->description_ar : $settings->description_en)" />

    <meta property="og:site_name" content="@yield('title_seo' , app()->getLocale() == 'ar' ? $settings->title_ar : $settings->title_en)" />
    <meta property="og:title" content="@yield('title_seo' ,  app()->getLocale() == 'ar' ? $settings->title_ar : $settings->title_en)" />
    <meta property="twitter:title" content="@yield('title_seo' , app()->getLocale() == 'ar' ? $settings->title_ar : $settings->title_en)" />

    <meta property="og:image" content="@yield('image_seo' , url( Storage::url($settings->logo_og)) )" />
    <meta property="twitter:image" content="@yield('image_seo' , url( Storage::url($settings->logo_og)) )" />

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url( '/frontend/style/style.css' ) }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title_site' , app()->getLocale() == 'ar' ? $settings->title_ar : $settings->title_en ) - @yield('title_page' , __('messages.the_store'))</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('html')

</head>

<body class="lang_{{app()->getLocale()}}" dir="{{app()->getLocale()}}">

    @include('layouts.loading')

    @if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
        <small>{{ $error }}</small>
        @endforeach

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <small> {{ session('success') }}</small>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <small> {{ session('error') }}</small>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('removeitemsCart'))
    <script>
        localStorage.removeItem("cart");
    </script>
    @endif


    @include('layouts.nav')

    @if (auth()->user() && !auth()->user()->hasVerifiedEmail())
    <div class="hasVerifiedEmail">
        <form dir="rtl" class="form login" style="margin-bottom: 0;" method="POST" action="{{ route('verification.notice') }}" onsubmit="return disableButton(this)">
            @csrf

            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <p class="text-center"> لم يتم التحقق من حسابك بعد. يرجى التحقق من بريدك للحصول على رمز التحقق</p>

            <button type="submit" class="btn w-100">إعادة الإرسال</button>
        </form>

        <form dir="rtl" class="form login" style="margin-top: 0;" method="POST" action="{{ route('verification.verify') }}" onsubmit="return disableButton(this)">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="mb-3">
                <label for="otp" class="form-label">رمز التحقق</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="text" name="otp" id="otp" class="form-control" value="{{ old('otp') }}" placeholder="اكتب رمز التحقق" required>
                </div>
            </div>

            <button type="submit" class="btn w-100">تحقق</button>
        </form>

    </div>

    @else


    @yield('content')

    @endif

    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

    <script src="{{url('/frontend/js/script.js')}}"></script>

</body>

</html>
