@extends('layouts.app')

@section('title_page', 'نسيت كلمة المرور')

@section('content')

<section>

    <form dir="rtl" class="form login" method="POST" action="{{ route('password.email') }}" onsubmit="return disableButton(this)">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">بريد</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
                <input type="email" class="form-control" name="email" id="email" placeholder="اكتب بريد" required>
            </div>
        </div>

        <button type="submit" class="btn w-100">ارسال</button>

        <p class="text-center mt-3">هل لديك حساب؟
            <a href="{{route('login')}}" class="text-decoration-none">تسجيل دخول</a>
        </p>
    </form>

</section>

@endsection