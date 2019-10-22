@extends('layouts.master')
@section('title', '- Welcome')

@section('content')
    <div id="app">
        <router-view></router-view>
    </div>
@endsection

@push('footer_scripts')

@endpush
