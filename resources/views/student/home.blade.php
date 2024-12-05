@extends('templates.main')
@section('title', 'Student')

@section('content')
<div class="container-fluid p-4">

    <div class="row g-4">
        <!-- Main Section (Middle) -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Front-End Development - Completed</h5>
                        <small class="text-muted">Completion Date: 11/05/2024</small>
                    </div>
                    <p class="mt-3 text-secondary">
                        This is the front-end implementation of our project, showcasing the design and user interface functionalities.
                    </p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm">Download ZIP</button>
                        <button class="btn btn-outline-primary btn-sm">Preview</button>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success">Status</span>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <div class="chat-input">
                        <input type="text" class="form-control" placeholder="Type your message here...">
                        <div class="d-flex justify-content-end mt-2">
                            <button class="btn btn-primary btn-sm">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <div class="avatar bg-secondary rounded-circle mx-auto mb-3" style="width: 100px; height: 100px;"></div>
                    <h6>Overall Progress</h6>
                    <div class="progress position-relative mb-3">
                        <div class="progress-bar bg-primary" style="width: 60%;"></div>
                        <small class="position-absolute top-50 start-50 translate-middle text-white">60%</small>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="text-primary">Group Name</h6>
                    <ul class="list-unstyled mb-4">
                        <li>Riin Valena</li>
                        <li>Reignald Cheng</li>
                        <li>Vince Sandoval</li>
                        <li>Erica Sanguyo</li>
                        <li>Jansen Lee</li>
                    </ul>
                    <h6 class="text-primary">Task List</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="text-success">✔</span> Lorem Ipsum - Completed (11/05/2024)
                        </li>
                        <li class="mb-2">
                            <span class="text-warning">⚠</span> Back-End Development - Due (12/01/2024)
                        </li>
                        <li class="mb-2">
                            <span class="text-warning">⚠</span> API Integration - Due (12/10/2024)
                        </li>
                        <li class="mb-2">
                            <span class="text-warning">⚠</span> Testing & Debugging - Due (12/17/2024)
                        </li>
                        <li class="mb-2">
                            <span class="text-warning">⚠</span> Final Presentation - Due (12/25/2024)
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
