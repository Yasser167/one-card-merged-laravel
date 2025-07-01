@extends('layouts.app')

@section('title_page', 'إعادة تعيين كلمة المرور')

@section('content')


@if (!$userId)
<script>
    window.location.href = "{{ route('login') }}";
</script>
@endif


<section>

    <form dir="rtl" class="form login" style="margin-bottom: 0;" method="POST" action="{{ route('verification.notice') }}" onsubmit="return disableButton(this)">
        @csrf
        <input type="hidden" name="user_id" value="{{ $userId }}">

        <p class="text-center">إعادة إرسال رمز التحقق الخاص بك</p>
        <button type="submit" class="btn w-100">إعادة الإرسال</button>
    </form>

    <form dir="rtl" method="POST" style="margin-top: 0;" action="{{ route('password.update') }}" class="form login" onsubmit="return disableButton(this)">
        @csrf
        <input type="hidden" name="user_id" value="{{ $userId }}">

        <div class="mb-3">
            <label for="otp" class="form-label">رمز التحقق</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="text" name="otp" id="otp" class="form-control" value="{{ old('otp') }}" placeholder="اكتب رمز التحقق" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور الجديدة</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="اكتب كلمة المرور الجديدة" required>
                <span class="input-group-text">
                    <i class="bi bi-eye-fill click_eye eye"></i>
                    <i class="bi bi-eye-slash-fill click_eye eye-off" style="display:none;"></i>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">تأكيد كلمة السر الجديدة</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="اكتب تأكيد كلمة السر الجديدة" required>
                <span class="input-group-text">
                    <i class="bi bi-eye-fill click_eye eye"></i>
                    <i class="bi bi-eye-slash-fill click_eye eye-off" style="display:none;"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn w-100">إعادة تعيين كلمة المرور</button>
    </form>

</section>


@endsection