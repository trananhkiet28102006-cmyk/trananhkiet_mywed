{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Xin chào')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
    <h1>My Dashboard</h1>
@endsection
