@extends('layouts.app')

@section('title_page', 'تسجيل الدخول')

@section('content')

<section>

    <form dir="rtl" class="form login" method="POST" action="{{ route('user.login') }}" onsubmit="return disableButton(this)">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">بريد</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
                <input type="text" class="form-control text-end" name="email" id="email" value="{{ old('email') }}" placeholder="اكتب بريد" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" class="form-control text-end" name="password" id="password" placeholder="اكتب كلمة المرور" required>
                <span class="input-group-text">
                    <i class="bi bi-eye-fill click_eye eye"></i>
                    <i class="bi bi-eye-slash-fill click_eye eye-off" style="display:none;"></i>
                </span>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">تذكرني</label>
            </div>
            <a href="{{route('forgot')}}" class="text-decoration-none">هل نسيت كلمة المرور؟</a>
        </div>

        <button type="submit" class="btn w-100">تسجيل الدخول</button>

    </form>

</section>

@endsection
