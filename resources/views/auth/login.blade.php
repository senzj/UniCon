@extends('templates.auth')
@section('title', 'Login')
@section('content')

    <!-- Display error messages -->
    @if (@session()->has('error'))
    <div class="alert">
        <div class="alert-container">
            <div class="alert-content alert-danger">
                <div class="alert-header">
                    <span class="alert-message">{{ session()->get('error') }}</span>
                    <span class="btn btn-close"></span>
                </div>
            </div>
        </div>
    </div>
    @elseif (session()->has('success'))
    <div class="alert">
        <div class="alert-container">
            <div class="alert-content alert-success">
                <div class="alert-header">
                    <span class="alert-message">{{ session()->get('success') }}</span>
                    <span class="btn btn-close"></span>
                </div>
            </div>
        </div>
    </div> 
    @endif

    {{-- <div class="mt-5">
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>

        @elseif(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success')}}
            </div>
        @endif
    </div> --}}

    <form action="{{ route('login@post') }}" method="POST">  <!--Use the name of the route to identify-->
        @csrf <!--Cross-Site Request Forgery - a security token feature in Laravel to execute form-->
        <div class="form-container">
            <h1>Login</h1>

            <div class="row">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
                    <label for="floatingInput">Email address</label>
                </div>
            </div>

            <div class="row">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                    <label for="floatingPassword">Password</label>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                
                <button type="submit" class="btn btn-primary" id="loginBtn">Log In</button>
                <p><span>Don't have an account? <a href="/signup">Sign up!</a></span></p>
            </div>
        </div>
    </form>

@endsection