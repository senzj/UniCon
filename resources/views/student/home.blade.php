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
        <div class="col-md-9"> <!-- Changed to col-md-9 -->
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

        <!-- Right Section: User Info and Progress -->
        <div class="col-md-3"> <!-- Right section remains col-md-3 -->
            <div class="card mb-4 text-center">
                <div class="card-body">
                    <div class="avatar bg-secondary rounded-circle mx-auto mb-3" style="width: 100px; height: 100px;"></div>
                    <h6>Overall Progress</h6>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: {{ isset($progress) ? $progress : 0 }}%;" aria-valuenow="{{ isset($progress) ? $progress : 0 }}" aria-valuemin="0" aria-valuemax="100">
                            {{ isset($progress) ? $progress : 0 }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection