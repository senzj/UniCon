@extends('templates.main')
@section('title', 'Student Dashboard')

@section('content')
<div class="container mt-4">

    <!-- Header Section -->
    <header class="mb-4">
        <h1 class="text-center">Student Dashboard</h1>
    </header>

    <!-- Progress report modal form -->
    <div class="modal fade" id="createReportModal" tabindex="-1" aria-labelledby="createReportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReportModalLabel">Create Progress Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data" data-ajax="false">
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
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

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
                
                    @if ($groupChat)
                        <form action="{{ route('send.Message', $groupChat->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="group_chat_id" value="{{ $groupChat->id }}">
                            <div class="input-group">
                                <input type="text" name="message" class="form-control" placeholder="Type your message here..." required>
                                <input type="file" name="file" id="file-upload" class="form-control" style="display: none;" onchange="updateFileName()">
                                
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createReportModal">
                                    Create Report
                                </button>

                                <button type="button" class="btn btn-secondary" onclick="document.getElementById('file-upload').click()">
                                    Upload File
                                </button>

                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                        
                        
                    @endif
                </div>

            </div>
        </div>

        <!-- Right Section: User Info and Progress -->
        <div class="col-md-3"> <!-- Right section remains col-md-3 -->
            <div class="card mb-4 text-center">

                <div class="card-body">
                    {{-- group picture --}}
                    <div class="avatar bg-secondary rounded-circle mx-auto mb-3" style="width: 100px; height: 100px;">
                        @if ($groupChat && $groupChat->group_logo)

                            <img src="{{ asset('storage/group_logos/' . basename($groupChat->group_logo)) }}" 
                                alt="{{ $groupChat->name }}" 
                                class="w-100 h-100 rounded-circle" 
                                style="object-fit: cover;">
                        @else

                            <img src="{{ asset('storage/group_logos/default_logo.png') }}" 
                                alt="{{ $groupChat->name ?? 'Default Group Name' }}" 
                                class="w-100 h-100 rounded-circle" 
                                style="object-fit: cover;">

                        @endif
                    </div>
                    @if ($groupChat && $groupChat->name)
                        <small>{{ $groupChat->name }}</small>
                    @else
                        <small>No Group Selected</small>
                    @endif

                    {{-- group progress --}}
                    <!-- Group Chat Details -->
                    <div class="card-body">
                        @if(isset($groupChat))
                            <p class="mb-1"><strong>Section:</strong> {{ $groupChat->section }}</p>
                            <p class="mb-1"><strong>Specialization:</strong> {{ $groupChat->specialization }}</p>
                            <p class="mb-1"><strong>Adviser:</strong> {{ $groupChat->adviser }}</p>
                            <p class="mb-1"><strong>Term:</strong> {{ $groupChat->term }}</p>
                            <p class="mb-1"><strong>Academic Year:</strong> {{ $groupChat->academic_year }}</p>
                            <p class="mb-1"><strong>Mentoring Day:</strong> {{ $groupChat->mentoring_day }}</p>
                            <p class="mb-1"><strong>Mentoring Time:</strong> {{ $groupChat->mentoring_time }}</p>
                        @else
                            <p>No Group Selected</p>
                        @endif
                    </div>
                    <h5>Overall Progress:</h5>
                    <div class="progress mb-3">
                        <div 
                            class="progress-bar bg-success" 
                            id="overallProgressBar" 
                            role="progressbar" 
                            style="width: {{ 
                                number_format(
                                    (($progress['chapter1'] ?? 0) + 
                                    ($progress['chapter2'] ?? 0) + 
                                    ($progress['chapter3'] ?? 0) + 
                                    ($progress['chapter4'] ?? 0) + 
                                    ($progress['chapter5'] ?? 0) + 
                                    ($progress['chapter6'] ?? 0)) / 6, 
                                    0
                                ) 
                            }}%;" 
                            aria-valuenow="{{ 
                                number_format(
                                    (($progress['chapter1'] ?? 0) + 
                                    ($progress['chapter2'] ?? 0) + 
                                    ($progress['chapter3'] ?? 0) + 
                                    ($progress['chapter4'] ?? 0) + 
                                    ($progress['chapter5'] ?? 0) + 
                                    ($progress['chapter6'] ?? 0)) / 6, 
                                    0
                                ) 
                            }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                            {{ 
                                number_format(
                                    (($progress['chapter1'] ?? 0) + 
                                    ($progress['chapter2'] ?? 0) + 
                                    ($progress['chapter3'] ?? 0) + 
                                    ($progress['chapter4'] ?? 0) + 
                                    ($progress['chapter5'] ?? 0) + 
                                    ($progress['chapter6'] ?? 0)) / 6, 
                                    0
                                ) 
                            }}%
                        </div>
                    </div>

                    <!-- Chapters Accordion -->
                    <div class="card">
                        <div class="card-header" id="chaptersHeading" role="button" data-bs-toggle="collapse" data-bs-target="#chaptersAccordion" aria-expanded="false" aria-controls="chaptersAccordion" style="cursor: pointer;">
                            <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                Weekly Progress
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            </h5>
                        </div>

                        {{-- chapter progress --}}
                        <div id="chaptersAccordion" class="collapse" aria-labelledby="chaptersHeading">
                            <div class="card-body">
                                @for ($i = 1; $i <= 6; $i++)
                                    <div class="mb-4">
                                        <h5>Week {{ $i }}</h5>
                                        <div class="progress">
                                            <div 
                                                class="progress-bar" 
                                                id="progressBar{{ $i }}" 
                                                role="progressbar" 
                                                style="width: {{ $progress['chapter'.$i] ?? 0 }}%;" 
                                                aria-valuenow="{{ $progress['chapter'.$i] ?? 0 }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                {{ $progress['chapter'.$i] ?? 0 }}%
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
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

    // script to add progress to progress bar
    document.addEventListener('DOMContentLoaded', function() {
        function updateOverallProgress() {
            const progressBars = document.querySelectorAll('[id^="progressBar"]');
            let total = 0;

            progressBars.forEach(bar => {
                total += parseInt(bar.getAttribute('aria-valuenow'), 10);
            });

            const average = total / progressBars.length;
            const overallProgressBar = document.getElementById('overallProgressBar');

            if (overallProgressBar) {
                overallProgressBar.style.width = `${average}%`;
                overallProgressBar.setAttribute('aria-valuenow', average);
                overallProgressBar.textContent = `${Math.round(average)}%`;
            }
        }

        // You can keep both methods if you want
        updateOverallProgress();
    });

    // Optional: If you need a separate method for server-side updates
    function updateOverallProgressFromServer() {
        const chapterCount = 6;
        let total = 0;

        for (let i = 1; i <= chapterCount; i++) {
            const progressBar = document.getElementById(`progressBar${i}`);
            if (progressBar) {
                const progressValue = parseInt(progressBar.getAttribute('aria-valuenow'), 10);
                total += progressValue;
            }
        }

        const average = total / chapterCount;
        const overallProgressBar = document.getElementById('overallProgressBar');

        if (overallProgressBar) {
            overallProgressBar.style.width = `${average}%`;
            overallProgressBar.setAttribute('aria-valuenow', average);
            overallProgressBar.textContent = `${Math.round(average)}%`;
        }
    }

</script>

@endsection