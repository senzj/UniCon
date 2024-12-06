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
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>

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
                    {{-- file input text display--}}
                    <span id="file-name" class="ml-2 text-muted"></span>
                
                    <form action="{{ route('send.Message', $groupChat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="group_id" value="{{ $groupChat->id }}">
                        <input type="text" name="message" class="form-control" placeholder="Type your message here..." required>
                        
                        <div class="d-flex justify-content-end mt-2">
                            <!-- Hidden File Upload Input -->
                            <input type="file" name="file" id="file-upload" class="d-none" accept="image/*,application/pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" onchange="updateFileName()">
                            
                            <!-- Custom File Upload Button -->
                            <label for="file-upload" class="btn btn-secondary mr-2" style="cursor: pointer;">
                                Upload File
                            </label>
                    
                            <!-- Send Button -->
                            <button type="submit" class="btn btn-primary" {{ isset($groupChat) ? '' : 'disabled' }}>Send</button>
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
</div>

<!-- Custom JavaScript -->
<script>
    // Update the file name in the file upload button
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
</script>

@endsection