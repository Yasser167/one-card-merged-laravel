@php
$pageTitle = trim($__env->yieldContent('title'));
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ $settings->favicon ? url( Storage::url($settings->favicon)) : url( 'favicon.ico' ) }}" type="image/x-icon">

    <title>{{ $pageTitle }}</title>
</head>

<body>

    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        body {
            padding: 0;
            margin: 0
        }

        #notfound {
            position: relative;
            height: 100vh;
            background: #111;

            .notfound {
                position: absolute;
                left: 50%;
                top: 50%;
                -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
                max-width: 767px;
                width: 100%;
                line-height: 1.4;
                text-align: center;

                .notfound-404 {
                    position: relative;
                    height: 180px;
                    margin-bottom: 20px;
                    z-index: -1;

                    h1 {
                        font-family: montserrat, sans-serif;
                        position: absolute;
                        left: 50%;
                        top: 50%;
                        -webkit-transform: translate(-50%, -50%);
                        -ms-transform: translate(-50%, -50%);
                        transform: translate(-50%, -50%);
                        font-size: 224px;
                        font-weight: 900;
                        margin-top: 0;
                        margin-bottom: 0;
                        margin-left: -12px;
                        color: #030005;
                        text-transform: uppercase;
                        text-shadow: -1px -1px 0 #8400ff, 1px 1px 0 #ff005a;
                        letter-spacing: -20px;

                        @media (max-width:480px) {
                            font-size: 182px;
                        }


                    }

                    h2 {
                        font-family: montserrat, sans-serif;
                        position: absolute;
                        left: 0;
                        right: 0;
                        top: 110px;
                        font-size: 42px;
                        font-weight: 700;
                        color: #fff;
                        text-transform: uppercase;
                        text-shadow: 0 2px 0 #8400ff;
                        margin: 0;

                        @media (max-width:767px) {
                            font-size: 24px;
                        }

                    }
                }

                a {
                    font-family: montserrat, sans-serif;
                    display: inline-block;
                    text-transform: uppercase;
                    color: #ff005a;
                    text-decoration: none;
                    border: 2px solid;
                    background: 0 0;
                    padding: 10px 40px;
                    font-size: 14px;
                    font-weight: 700;
                    -webkit-transition: .2s all;
                    transition: .2s all;

                    &:hover {
                        color: #8400ff;
                    }
                }
            }
        }
    </style>
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>@yield('code')</h1>
                <h2>@yield('message')</h2>
            </div>
            <a href="{{ route('index.store') }}">@lang('messages.home')</a>
        </div>
    </div>
</body>

</html>