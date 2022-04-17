@extends('admin.layout')

@section('content')
    <div>All Views: <strong>{{ App\Models\View::count() }}</strong></div>
    <div>Services: <strong>{{ App\Models\View::has('service')->count() }}</strong></div>
    <div>Products: <strong>{{ App\Models\View::has('product')->count() }}</strong></div>
    <div>Projects: <strong>{{ App\Models\View::has('project')->count() }}</strong></div>
    <div>Featrues: <strong>{{ App\Models\View::has('feature')->count() }}</strong></div>
    <div>Clients: <strong>{{ App\Models\View::has('client')->count() }}</strong></div>
    <div>Pages: <strong>{{ App\Models\View::has('page')->count() }}</strong></div>
@endsection
