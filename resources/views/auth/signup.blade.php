@extends('templates.auth')
@section('title', 'Signup')
@section('content')

    <!-- Display error messages -->
    <div class="mt-5">
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>

        @elseif(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success')}}
            </div>
        @endif
    </div>

    <form action="{{ route('signup@post') }}" method="POST">
        @csrf <!-- CSRF Protection -->
        <div class="form-container">
            <h1>Sign Up</h1>

            <div class="row mb-3">
                <div class=" form-floating col">
                    <input type="text" class="form-control" id="FName" placeholder="Juan" name="FName">
                    <label for="FName" id="snameinput">First Name</label>
                </div>

                <div class="form-floating col">
                    <input type="text" class="form-control" id="LName" placeholder="Dela Cruz" name="LName">
                    <label idfor="LName" id="snameinput">Last Name</label>
                </div>
            </div>

            <div class="row">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="EMail" placeholder="email@example.com" name="Email">
                    <label for="EMail">Email address</label>
                </div>
            </div>

            <div class="row">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="Password" placeholder="Password" name="Password">
                    <label for="Password">Password</label>
                </div>
            </div>

            <div class="row">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="CPassword" placeholder="Confirm Password" name="CPassword">
                    <label for="CPassword">Confirm Password</label>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
        
                <button type="submit" class="btn btn-primary">Sign In</button>
                <p><span>Already have an account? <a href="/login">Log In!</a></span></p>
            </div>
        </div>
    </form>

    
@endsection