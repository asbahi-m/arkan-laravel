@extends('site.layout')

@section('title', __('site.Clients'))

@section('content')

@include('site.include.heading', [
'title' => __('site.Clients'),
'image' => null,
'route' => route('site.clients'),
'parent_title' => null,
'parent_route' => null,
])

@include('site.templates.clients', $clients)

@endsection
