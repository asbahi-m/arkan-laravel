@extends('site.layout')

@section('title', __('site.Products'))

@section('content')

@include('site.include.heading', [
'title' => __('site.Products'),
'image' => null,
'route' => route('site.products'),
'parent_title' => null,
'parent_route' => null,
])

@include('site.templates.products', $products)

@endsection
