<!DOCTYPE html>
@extends('templates.main')
@section('title', 'Teachers Dashboard')
@section('content')

<div class="container mt-4">

    <!-- Header Section -->
    <header class="mb-4">
        <h1 class="text-center">Teacher's Dashboard</h1>
    </header>

    <!-- Modal -->
    <div class="modal fade" id="groupModal" tabindex="-1" aria-labelledby="groupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="groupModalLabel">Create Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('teacher@createGroup') }}" method="POST" enctype="multipart/form-data" data-ajax="false">
                    @csrf
                    <div class="modal-body">
                        <!-- Group Name -->
                        <div class="mb-3">
                            <label for="groupName" class="form-label">Group Name</label>
                            <input type="text" class="form-control" id="groupName" name="group_name" required>
                        </div>
                
                        <!-- Group Section -->
                        <div class="mb-3">
                            <label for="groupSection" class="form-label">Group Section</label>
                            <input type="text" class="form-control" id="groupSection" name="group_section" required>
                        </div>
                
                        <!-- Group Specialization -->
                        <div class="mb-3">
                            <label for="groupSpecialization" class="form-label">Group Specialization</label>
                            <input type="text" class="form-control" id="groupSpecialization" name="group_specialization" required>
                        </div>
                
                        <!-- Group Adviser -->
                        <div class="mb-3">
                            <label for="groupAdviser" class="form-label">Group Adviser</label>
                            <input type="text" class="form-control" id="groupAdviser" name="group_adviser" required>
                        </div>
                
                        <!-- Group Logo -->
                        <div class="mb-3">
                            <label for="groupLogo" class="form-label">Group Logo</label>
                            <input type="file" class="form-control" id="groupLogo" name="group_logo" accept="image/*" required>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Group</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Section: Group Chats -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Group Chats</h4>
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#groupModal">
                        Create Group
                    </button>
                </div>

                <!-- Group Chat List -->
                <div class="card-body">
                    <ul class="list-group">
                        @if($groupChats && $groupChats->count() > 0)
                            @foreach ($groupChats as $group)
                                <li class="list-group-item d-flex align-items-center 
                                    {{ request()->route('id') == $group->id ? 'active' : '' }}">
                                    @if($group->logo)
                                        <img src="{{ asset('storage/group_logos/' . basename($group->logo)) }}" 
                                             alt="{{ $group->name }} logo" 
                                             class="mr-3" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                    @endif
                                    <a href="{{ route('get.message', ['id' => $group->id]) }}"
                                       class="{{ request()->route('id') == $group->id ? 'text-white' : '' }}">
                                        {{ $group->name }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item">No group chats available.</li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>

        <!-- Middle Section: Submissions -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>{{ isset($groupChat) ? $groupChat->name : 'No group selected' }}</h4>
                </div>

                <div class="card-body chat-body" style="height: 400px; overflow-y: auto;">
                    @if(isset($messages) && count($messages) > 0)
                        @foreach ($messages as $message)
                            <div class="message mb-3 
                                {{ $message->user->role == 'teacher' ? 'text-right' : 'text-left' }}">
                                <div class="message-content 
                                    {{ $message->user->role == 'teacher' ? 'bg-primary text-white' : 'bg-light' }} 
                                    p-2 rounded">
                                    
                                    <!-- User Profile Picture -->
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset( 'storage/profile/'. $message->user->picture) }}" alt="{{ $message->user->first_name .' ' . $message->user->last_name }}" class="rounded-circle" style="width: 40px; height: 40px; margin-right: 10px;">
                                        <strong>{{ $message->user->first_name . ' ' . $message->user->last_name }}</strong>
                                    </div>
                                    
                                    <p>{{ $message->message }}</p>
                                    <small class="text-muted">
                                        {{ $message->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-muted">No messages yet</p>
                    @endif
                </div>
                
                <!-- Message Input -->
                <div class="card-footer">
                    <!-- File name Upload Info -->
                    <span id="file-name" class="ml-2 text-muted"></span>

                    @if(request()->segment(3)) <!-- Check if the third segment (group chat ID) is present -->
                        <form action="{{ route('send.message', request()->segment(3)) }}" method="POST" enctype="multipart/form-data" data-ajax="false">
                            @csrf
                            <input type="hidden" name="group_id" value="{{ request()->segment(3) }}">
                            <div class="input-group">
                                <input type="text" name="content" class="form-control" 
                                    placeholder="Type your message..." required>
                                
                                <!-- Hidden File Upload Input -->
                                <input type="file" name="file" id="file-upload" class="d-none" accept="image/*,application/pdf" onchange="updateFileName()">
                        
                                <!-- Custom File Upload Button -->
                                <label for="file-upload" class="btn btn-secondary" style="margin-left: 10px; cursor: pointer;">
                                    Upload File
                                </label>
                        
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <p>Please select a group chat to send a message.</p> <!-- Message when no group chat is selected -->
                    @endif
                </div>

            </div>
        </div>

        <!-- Right Section: Group Info -->
        <div class="col-md-3">
            <div class="card mb-4">

                <div class="card-header">
                    <h4>Group: {{ isset($groupChat) ? $groupChat->name : 'No group selected' }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('teacher.addMember', $groupChat->id ?? '') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name ="email" class="form-control" placeholder="Add member by email" required>
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </form>

                    <h5>Members:</h5>
                    {{-- <ul class="list-group mb-3">
                        @if(isset($groupChat) && $groupChat->members)
                            @foreach ($groupChat->members as $member)
                                <li class="list-group-item">{{ $member->name }}</li>
                            @endforeach
                        @else
                            <li class="list-group-item">No members found.</li>
                        @endif
                    </ul> --}}

                    <h5>Progress:</h5>
                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: {{ isset($groupChat) ? $groupChat->progress : 0 }}%;" aria-valuenow="{{ isset($groupChat) ? $groupChat->progress : 0 }}" aria-valuemin="0" aria-valuemax="100">
                            {{ isset($groupChat) ? $groupChat->progress : 0 }}%
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script to put file info --}}
<script>
        function updateFileName() {
        const fileInput = document.getElementById('file-upload');
        const fileNameDisplay = document.getElementById('file-name');

        // Check if a file is selected
        if (fileInput.files.length > 0) {
            // Get the name of the selected file
            const fileName = fileInput.files[0].name;
            // Display the file name
            fileNameDisplay.textContent = `File: ${fileName}`;
        } else {
            // Clear the file name display if no file is selected
            fileNameDisplay.textContent = '';
        }
    }

    // Optional: Clear the file input when the label is clicked again
    document.getElementById('file-upload').addEventListener('change', function() {
        if (this.files.length === 0) {
            // If no file is selected, clear the file name display
            document.getElementById('file-name').textContent = '';
        }
    });
</script>

{{-- script to handle sending messages --}}
{{-- <script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                // Append message to chat
                $('.chat-body').append(`
                    <div class="message">
                        <strong>${response.message.user.name}</strong>
                        <p>${response.message.content}</p>
                        <small>${response.message.created_at}</small>
                    </div>
                `);
                
                // Clear input
                $('input[name="content"]').val('');
            },
            error: function(xhr) {
                alert('Failed to send message');
            }
        });
    });
});
</script> --}}

@endsection