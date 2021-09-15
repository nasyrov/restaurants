@extends('layouts.base', [
    'title' => __('Home'),
])

@section('body')
    <livewire:restaurants />
@endsection
