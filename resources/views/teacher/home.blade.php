<!DOCTYPE html>
@extends('templates.main')
@section('title', 'Teachers Dashboard')
@section('content')

<div class="container mt-4">

    <!-- Header Section -->
    <header class="mb-4">
        <h1 class="text-center">Teacher's Dashboard</h1>
    </header>

    <!-- Modal for create group chat -->
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
                            <li class="list-group-item d-flex align-items-center list-group-logo
                                        {{ request()->route('id') == $group->id ? 'active' : '' }}"
                                onclick="window.location.href='{{ route('get.message', ['id' => $group->id]) }}'">
                                @if($group->logo)
                                    <img src="{{ asset('storage/group_logos/' . basename($group->logo)) }}" 
                                        alt="{{ $group->name }} logo" 
                                        class="mr-3 group-lists-img">
                                @endif
                                <span class="group-lists {{ request()->route('id') == $group->id ? 'text-white' : '' }}">
                                    {{ $group->name }}
                                </span>
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
                    @if($messages->isEmpty())
                        <p class="text-center text-muted">No messages available.</p>
                    @else
                        @foreach($messages as $message)
                        <div class="flex w-full mb-3 
                            {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="message-content max-w-[40%] 
                                {{ $message->user_id == Auth::id() ? 'bg-primary text-white sender-message' : 'bg-light receiver-message' }} 
                                p-2 rounded">

                                {{-- if message is from the user --}}
                                @if($message->user_id == Auth::id())
                                    <div class="d-flex flex-column align-items-end w-100">
                                        <div class="d-flex align-items-center justify-content-end mb-1 w-100">
                                            <strong class="mr-2" style="margin-right: 0.5rem">{{ $message->user->first_name }} {{ $message->user->last_name }}</strong>
                                            <img src="{{ asset('storage/profile/'. $message->user->picture) }}" 
                                                alt="{{ $message->user->first_name .' ' . $message->user->last_name }}" 
                                                class="rounded-circle message-profile" 
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        </div>
                                        <div class="d-flex justify-content-end w-100 mb-1">
                                            <p class="text-right" style="margin-right: 3.5rem">{{ $message->message }}</p>
                                        </div>
                                    
                                        {{-- if user has attached file --}}
                                        @if($message->file_path)
                                            <div class="d-flex flex-column align-items-end w-100">
                                                
                                                {{-- download file button --}}
                                                <div class="text-right">
                                                    <small class="mb-1" style="font-size: 0.8rem;">File: {{ basename($message->file_path) }}</small>
                                                </div>
                                                <a href="{{ route('file.download', $groupChat->name .'/' . basename($message->file_path)) }}" 
                                                class="btn btn-secondary btn-sm" style="margin-bottom: 1rem;">
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>

                                            </div>
                                        @endif
                                    
                                        <div class="d-flex justify-content-end w-100">
                                            <small class="text-muted">
                                                {{ $message->created_at->format('F d, Y h:i A') }}
                                            </small>
                                        </div>
                                    </div>

                                {{-- if message is from other users --}}
                                @else
                                    <div class="flex flex-col items-start">
                                        <div class="flex items-center mb-1">
                                            <img src="{{ asset('storage/profile/'. $message->user->picture) }}" 
                                                 alt="{{ $message->user->first_name .' ' . $message->user->last_name }}" 
                                                 class="rounded-circle message-profile mr-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <strong>{{ $message->user->first_name }} {{ $message->user->last_name }}</strong>
                                        </div>
                                        <p class="mb-1" style="margin-left: 3.5rem">{{ $message->message }}</p>

                                        {{-- if user has attached file --}}
                                        @if($message->file_path)
                                            <div class="col-12">
                                                <!-- File Path -->
                                                <?php $filepath = $groupChat->name .'/' . basename($message->file_path) ?>

                                                {{-- download file button --}}
                                                <div class="text-right">
                                                    <small class="mb-1" style="font-size: 0.8rem;">File: {{ basename($message->file_path) }}</small>
                                                </div>
                                                <a href="{{ route('file.download', $groupChat->name .'/' . basename($message->file_path)) }}" 
                                                class="btn btn-secondary btn-sm" style="margin-bottom: 1rem;">
                                                    <i class=""></i> Download
                                                </a>
                                            
                                                {{-- grade task button --}}
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" style="margin-bottom: 1rem;">
                                                    <i></i> Grade
                                                </button>
                                            </div>
                                        @endif

                                        <small class="text-muted">
                                            {{ $message->created_at->format('F d, Y h:i A') }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
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
                                <input type="text" name="content" class="form-control" placeholder="Type your message..." required>
                                
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
        @if (request()->segment(3)) <!-- Check if the third segment (group chat ID) is present -->
            <div class="col-md-3">
                <div class="card mb-4">

                    <div class="card-header">
                        <h4>Group: {{ isset($groupChat) ? $groupChat->name : 'No group selected' }}</h4>
                    </div>

                    <div class="card-body">

                        <form id="add-member-form" onsubmit="event.preventDefault(); addMember();">
                            <input type="email" id="email" placeholder="Enter student email" required>
                            <button type="submit">Add</button>
                        </form>

                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        <h5>Progress:</h5>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: {{ isset($groupChat) ? $groupChat->progress : 0 }}%;" aria-valuenow="{{ isset($groupChat) ? $groupChat->progress : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                {{ isset($groupChat) ? $groupChat->progress : 0 }}%
                            </div>
                        </div>

                        <h5>Tasks:</h5>
                        <ul>
                        </ul>

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
                                                <li class="list-group-item d-flex align-items-center list-group-memebers">
                                                    <img 
                                                        src="{{ asset('storage/profile/' . $member->picture) }}" 
                                                        alt="{{ $member->first_name .' ' . $member->last_name }}" 
                                                        class="rounded-circle me-3" 
                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                    >
                                                    <div class="d-flex flex-column align-items-start">
                                                        <h6 class="mb-1">{{ $member->first_name . ' ' . $member->last_name }}</h6>
                                                        {{-- <a href="mailto:{{ $member->email }}"  --}}
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
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Script to put file info --}}
<script>

    // addMember to group chat script
    function addMember() {
        // Get the email from the input field
        const email = document.getElementById('email').value;

        // Dynamically fetch the groupchat ID from the current URL
        const CURRENT_GROUP_ID = window.location.pathname.split('/').pop();

        // Send the POST request to add the member
        fetch(`/groupchats/${CURRENT_GROUP_ID}/add-member`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ email }),
        })
        .then(response => {
            // Log full response for debugging
            // console.log('Full Response:', response);
            // console.log('Response Status:', response.status);
            return response.json();
        })
        // Uses toastr to display a alert messages to the user
        .then(data => {
            // Log parsed data
            // console.log('Parsed Data:', data);

            if (data.status === 'error') {
                toastr.error(data.message, 'Error!');

            } else {
                toastr.success(data.message, 'Success!');
            }
        })
        .catch(error => {
            // console.error('Detailed Error:', error);
            toastr.error('An unexpected error occurred', 'Error!');
        });
    }

    // Function to update the file name display
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

@endsection