@extends('dashboard.layouts.app')

@section('title_page', 'الحساب')

@section('admin_content')


<section>

    <form class="form login" method="POST" action="{{ route('account.update') }}" onsubmit="return disableButton()">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                <input type="text" name="name" id="name" class="form-control" placeholder="اكتب اسم جديد" value="{{ old('name', $user->name) }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">بريد</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
                <input type="text" name="email" id="email" class="form-control" placeholder="اكتب بريد" value="{{ old('email', $user->email) }}">
            </div>
        </div>

        <div class="mb-3">
            <b>التسجيل في: <small>{{ $user->created_at->format('d F Y') }}</small></b>
            <br>
            <small>{{ $user->created_at->diffForHumans(['parts' => 2]) }}</small>
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>

    <hr>

    <form class="form login" method="POST" action="{{ route('account.password.update') }}" onsubmit="return disableButton()">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="current_password" class="form-label">كلمة السر الحالية</label>
            <div class="input-group">
                <i class="bi bi-lock-fill input-group-text"></i>
                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="اكتب كلمة السر الحالية" required>
                <span class="input-group-text click_eye eye"><i class="bi bi-eye-fill"></i></span>
                <span class="input-group-text click_eye eye-off" style="display: none;"><i class="bi bi-eye-slash-fill"></i></span>
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور الجديدة</label>
            <div class="input-group">
                <i class="bi bi-lock-fill input-group-text"></i>
                <input type="password" name="password" id="password" class="form-control" placeholder="اكتب كلمة المرور الجديدة" required>
                <span class="input-group-text click_eye eye"><i class="bi bi-eye-fill"></i></span>
                <span class="input-group-text click_eye eye-off" style="display: none;"><i class="bi bi-eye-slash-fill"></i></span>
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">تأكيد كلمة السر الجديدة</label>
            <div class="input-group">
                <i class="bi bi-lock-fill input-group-text"></i>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="اكتب تأكيد كلمة السر الجديدة" required>
                <span class="input-group-text click_eye eye"><i class="bi bi-eye-fill"></i></span>
                <span class="input-group-text click_eye eye-off" style="display: none;"><i class="bi bi-eye-slash-fill"></i></span>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">تحديث</button>
    </form>

    <hr>

    <div class="container mt-4 form login">
        @foreach ($sessions as $session)
        <div class="card mb-3">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-pc-display-horizontal ms-3"></i>
                <div class="flex-grow-1">
                    <p class="mb-1">{{ $session->user_agent->browser() }} - {{ $session->user_agent->platform() }}</p>

                    @if ($session->id === session()->getId())
                    <p class="mb-0">{{ $session->ip_address }}, <span class="badge bg-primary">هذا الجهاز</span></p>
                    @else
                    <p class="mb-0">{{ $session->ip_address }}, {{ $session->last_activity }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        <form method="POST" action="{{ route('dashboard.sessions.clear') }}" onsubmit="return disableButton()">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">تسجيل الخروج من جلسات المتصفح الأخرى</button>
        </form>
    </div>
</section>

@endsection
