@extends('templates.main')
@section('title', 'Publications')
@section('content')

@auth
    <h1>Welcome to the publication Page!</h1>
    <p>This is the body content of your page.</p>
@else
    redirect(route('/events'));
@endauth
    
@endsection