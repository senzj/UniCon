@extends('templates.main')
@section('title', 'Home')
@section('content')

<div class="bg-light py-5">
    <div class="container text-center">
        <!-- Hero Section -->
        <div class="hero bg-primary text-white rounded shadow p-5 mb-4">
            <h1 class="display-3 fw-bold text-white">Welcome to Capstone Compass!</h1>
            <p class="lead mt-3 text-white">
                Your innovative solution for managing capstone projects effortlessly. Submit progress reports and receive valuable mentor feedback, all in one place.
            </p>
        </div>

        <!-- About Section -->
        <div class="about-section py-4">
            <p class="fs-5 text-muted">
                Capstone Compass is a project proudly created by the <span class="fw-semibold">Capstone Compass Team</span>
                as part of the subject <span class="text-primary">System Integration Architecture</span>.
            </p>
        </div>

        <!-- Team Section -->
        <div class="team-section mt-4">
            <div class="card mx-auto shadow-lg border-0" style="max-width: 600px;">
                <div class="card-header bg-primary text-white fw-bold text-center">
                    Meet the Team
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center py-3">
                            <i class="bi bi-person-circle text-primary fs-4"></i>
                            <span class="d-block fw-semibold">Valena, Riin</span>
                        </li>
                        <li class="list-group-item text-center py-3">
                            <i class="bi bi-person-circle text-primary fs-4"></i>
                            <span class="d-block fw-semibold">Lee, Jesus Jansen</span>
                        </li>
                        <li class="list-group-item text-center py-3">
                            <i class="bi bi-person-circle text-primary fs-4"></i>
                            <span class="d-block fw-semibold">Sandoval, Vince Jerome</span>
                        </li>
                        <li class="list-group-item text-center py-3">
                            <i class="bi bi-person-circle text-primary fs-4"></i>
                            <span class="d-block fw-semibold">Sanguyo, Erica Nerisse</span>
                        </li>
                        <li class="list-group-item text-center py-3">
                            <i class="bi bi-person-circle text-primary fs-4"></i>
                            <span class="d-block fw-semibold">Cheng, Reignald Zachary</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
