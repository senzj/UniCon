@extends('templates.main')
@section('title', 'Student Dashboard')

@section('content')
<div class="container mt-4">

    <!-- Header Section -->
    <header class="mb-4">
        <h1 class="text-center">Student Dashboard</h1>
    </header>

    <div class="row">
        <!-- Middle Section: Messages -->
        <div class="col-md-9"> <!-- Middle section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>{{ isset($groupChat) ? $groupChat->name : 'No Group Selected' }}</h4>
                </div>

                <div class="card-body chat-body" style="height: 400px; overflow-y: auto;">
                    @if($messages->isEmpty())
                        <p class="text-center text-muted">No messages available.</p>
                    @else
                        @foreach($messages as $message)
                            <div class="message mb-3 
                                {{ $message->user->role == 'student' ? 'text-left' : 'text-right' }}">
                                <div class="message-content 
                                    {{ $message->user->role == 'student' ? 'bg-light' : 'bg-primary text-white' }} 
                                    p-2 rounded">
                                    <strong>{{ $message->user->first_name }} {{ $message->user->last_name }}:</strong>
                                    <p class="mb-1">{{ $message->message }}</p>
                                    <small class="text-muted">{{ $message->created_at->format('F d, Y h:i A') }}</small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Message Input -->
                <div class="card-footer">
                    <form action="{{ route('student.sendMessage') }}" method="POST">
                        @csrf
                        <input type="text" name="message" class="form-control" placeholder="Type your message here..." required>
                        <div class="d-flex justify-content-end mt-2">
                            <button class="btn btn-primary btn-sm" {{ isset($groupChat) ? '' : 'disabled' }}>Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Section: Members -->
        <div class="col-md-3"> <!-- Right section -->
            <h5>Members:</h5>
            <div class="card">
                <div class="card-header" id="membersHeading" role="button" data-bs-toggle="collapse" data-bs-target="#membersList" aria-expanded="false" aria-controls="membersList" style="cursor: pointer;">
                    <h5 class="mb-0 d-flex justify-content-between align-items-center">
                        Members ({{ isset($members) ? $members->count() : 0 }})
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </h5>
                </div>
            
                <div id="membersList" class="collapse" aria-labelledby="membersHeading">
                    <div class="card-body">
                        @if(isset($members) && $members->count() > 0)
                            <ul class="list-group">
                                @foreach ($members as $member)
                                    <li class="list-group-item d-flex align-items-center list-group-members">
                                        <img 
                                            src="{{ asset('storage/profile/' . $member->picture) }}" 
                                            alt="{{ $member->first_name .' ' . $member->last_name }}" 
                                            class="rounded-circle me-3" 
                                            style="width: 50px; height: 50px; object-fit: cover;"
                                        >
                                        <div class="d-flex flex-column align-items-start">
                                            <h6 class="mb-1">{{ $member->first_name . ' ' . $member->last_name }}</h6>
                                            <a href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to={{ $member->email }}" 
                                               class="text-muted small text-decoration-none" 
                                               title="Send email to {{ $member->first_name }}"
                                               target="_blank">
                                                {{ $member->email }}
                                                <i class="fas fa-envelope ms-2 text-primary" style="font-size: 0.8rem;"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-info">No members found.</div>
                        @endif
                        </div>
                        @endsection
                