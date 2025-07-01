@extends('layouts.app')

@section('title_page', 'تسجيل حساب')

@section('content')

<section>

    <form dir="rtl" class="form login" method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data" onsubmit="return disableButton(this)">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                <input type="text" class="form-control" name="name" id="name" placeholder="اكتب الاسم" value="{{ old('name') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">بريد</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
                <input type="text" class="form-control" name="email" id="email" placeholder="اكتب بريد" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" class="form-control" name="password" id="password" placeholder="اكتب كلمة المرور" required>
                <span class="input-group-text">
                    <i class="bi bi-eye-fill click_eye eye"></i>
                    <i class="bi bi-eye-slash-fill click_eye eye-off" style="display:none;"></i>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="اكتب تأكيد كلمة المرور" required>
                <span class="input-group-text">
                    <i class="bi bi-eye-fill click_eye eye"></i>
                    <i class="bi bi-eye-slash-fill click_eye eye-off" style="display:none;"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn w-100">تسجيل حساب</button>

        <p class="text-center mt-3">هل لديك حساب؟
            <a href="{{ route('login') }}" class="text-decoration-none">تسجيل الدخول</a>
        </p>
    </form>


</section>

@endsection