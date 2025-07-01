
@extends('layouts.app')

@section('content')
@if(auth()->check() && auth()->user()->is_admin)
<div class="container">
    <h2>🎨 إعدادات الألوان (خاصة بالإدمن)</h2>
    <form method="POST" action="{{ url('/admin/save-colors') }}">
        @csrf
        <div class="mb-3">
            <label for="primary_color" class="form-label">لون الزر الأساسي:</label>
            <input type="color" id="primary_color" name="primary_color" value="#007bff" class="form-control form-control-color">
        </div>
        <div class="mb-3">
            <label for="background_color" class="form-label">لون الخلفية:</label>
            <input type="color" id="background_color" name="background_color" value="#ffffff" class="form-control form-control-color">
        </div>
        <div class="mb-3">
            <label for="text_color" class="form-label">لون العناوين:</label>
            <input type="color" id="text_color" name="text_color" value="#000000" class="form-control form-control-color">
        </div>
        <button type="submit" class="btn btn-primary">حفظ الإعدادات</button>
    </form>
</div>
@else
<div class="container">
    <div class="alert alert-danger">🚫 هذه الصفحة مخصصة للمسؤول فقط.</div>
</div>
@endif
@endsection
