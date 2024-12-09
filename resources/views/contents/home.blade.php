@extends('templates.main')
@section('title', 'Home')
@section('content')

<div class="container my-5">
    <div class="text-center">
        <h1 class="display-4 fw-bold mb-4 text-primary">Welcome to Capstone Compass!</h1>
        <p class="lead mb-4">
            Capstone Compass is an innovative web application designed to streamline the management of capstone projects,
            enabling students to efficiently submit progress reports while allowing mentors to review and provide valuable feedback.
        </p>
        <p class="mb-5">
            This project is created by the Capstone Compass Team in completion of the subject <span class="fw-semibold">System Integration Architecture.</span>
        </p>
    </div>

    <div class="card mx-auto shadow-sm border-0" style="max-width: 500px;">
        <div class="card-body text-center">
            <h5 class="card-title fw-bold text-primary mb-3">Capstone Compass Team</h5>
            <ul class="list-unstyled">
                <li class="py-2 border-bottom">Valena, Riin</li>
                <li class="py-2 border-bottom">Cheng, Reignald Zachary</li>
                <li class="py-2 border-bottom">Lee, Jesus Jansen</li>
                <li class="py-2 border-bottom">Sandoval, Vince Jerome</li>
                <li class="py-2">Sanguyo, Erica Nerisse</li>
            </ul>
        </div>
    </div>
</div>

@endsection
