@extends('templates.main')
@section('title', 'Student')

@section('content')
<div class="container-fluid p-4">
    <div class="row g-4">
        <!-- Main Section (Middle) -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">{{ $groupChat ? $groupChat->name : 'No Group Joined' }}</h5>
                    <div class="chat-box" style="height: 300px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                        @if($messages->isEmpty())
                            <p class="text-muted">No messages available.</p>
                        @else
                            @foreach($messages as $message)
                                <div class="mb-2">
                                    <strong>{{ $message->user->first_name }} {{ $message->user->last_name }}:</strong>
                                    <p class="mb-1">{{ $message->message }}</p>
                                    <small class="text-muted">{{ $message->created_at->format('F d, Y h:i A') }}</small>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <form action="{{ route('send.message', ['ID' => $groupChat->id ?? 0]) }}" method="POST">
                        @csrf
                        <input type="text" name="message" class="form-control" placeholder="Type your message here..." required>
                        <div class="d-flex justify-content-end mt-2">
                            <button class="btn btn-primary btn-sm" {{ $groupChat ? '' : 'disabled' }}>Send</button>
                        </div>
                    </form>
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
        </div>
    </div>
</div>
@endsection
