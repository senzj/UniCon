@extends('layout.main')
@section('title', 'Home')
@section('content')

@auth
    <h1>Welcome to the Home Page!</h1>
    <p>This is the body content of your page.</p>
@else
    redirect(route('/welcome'));
@endauth
    
@endsection