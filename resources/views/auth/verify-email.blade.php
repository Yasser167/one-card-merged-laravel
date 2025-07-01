@extends('layouts.app')

@section('title_page', 'إعادة ارسال رمز التحقق الخاص بك')

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

        <p>إعادة ارسال رمز التحقق الخاص بك</p>

        <button type="submit" class="btn w-100">إعادة الإرسال</button>
    </form>

    <form dir="rtl" class="form login" style="margin-top: 0;" method="POST" action="{{ route('verification.verify') }}" onsubmit="return disableButton(this)">
        @csrf
        <input type="hidden" name="user_id" value="{{ $userId }}">

        <div class="mb-3">
            <label for="otp" class="form-label">اكتب رمز التحقق</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="text" class="form-control" name="otp" id="otp" value="{{ old('otp') }}" placeholder="اكتب رمز التحقق" required>
            </div>
        </div>

        <button type="submit" class="btn w-100">تحقق</button>
    </form>
</section>
@endsection