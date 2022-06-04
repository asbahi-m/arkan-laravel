@extends('site.layout')

@section('title', __('site.Projects'))

@section('content')

@include('site.include.heading', [
'title' => 'Projects',
'image' => null,
'route' => route('site.projects'),
'parent_title' => null,
'parent_route' => null,
])

@include('site.templates.projects', $projects)

@endsection
