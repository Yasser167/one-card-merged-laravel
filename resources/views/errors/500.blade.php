@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))
<script>
    window.location.href = window.location.origin;
</script>
