@extends('templates.main')
@section('title', 'Teachers Dashboard')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- Modal for grade task -->
    {{-- <div class="modal fade" id="gradingModal" tabindex="-1" aria-labelledby="gradingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradingModalLabel">Grade Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="gradingForm">
                        <div class="mb-3">
                            <label for="chapter1" class="form-label">Chapter 1: Introduction</label>
                            <span id="chapter1Score" style="margin-left: 1rem; font-weight:bold;">0%</span>
                            <input type="range" class="form-range" id="chapter1" min="0" max="100" value="0" oninput="updateScore('chapter1Score', this.value, '1')">
                        </div>
                        <div class="mb-3">
                            <label for="chapter2" class="form-label">Chapter 2: Review of Related Literature</label>
                            <span id="chapter2Score" style="margin-left: 1rem; font-weight:bold;">0%</span>
                            <input type="range" class="form-range" id="chapter2" min="0" max="100" value="0" oninput="updateScore('chapter2Score', this.value, '2')">
                        </div>
                        <div class="mb-3">
                            <label for="chapter3" class="form-label">Chapter 3: Methodology</label>
                            <span id="chapter3Score" style="margin-left: 1rem; font-weight:bold;">0%</span>
                            <input type="range" class="form-range" id="chapter3" min="0" max="100" value="0" oninput="updateScore('chapter3Score', this.value, '3')">
                        </div>
                        <div class="mb-3">
                            <label for="chapter4" class="form-label">Chapter 4: Results and Discussion</label>
                            <span id="chapter4Score" style="margin-left: 1rem; font-weight:bold;">0%</span>
                            <input type="range" class="form-range" id="chapter4" min="0" max="100" value="0" oninput="updateScore('chapter4Score', this.value, '4')">
                        </div>
                        <div class="mb-3">
                            <label for="chapter5" class="form-label">Chapter 5: Conclusion</label>
                            <span id="chapter5Score" style="margin-left: 1rem; font-weight:bold;">0%</span>
                            <input type="range" class="form-range" id="chapter5" min="0" max="100" value="0" oninput="updateScore('chapter5Score', this.value, '5')">
                        </div>
                        <div class="mb-3">
                            <label for="chapter6" class="form-label">Chapter 6: Recommendation</label>
                            <span id="chapter6Score" style="margin-left: 1rem; font-weight:bold;">0%</span>
                            <input type="range" class="form-range" id="chapter6" min="0" max="100" value="0" oninput="updateScore('chapter6Score', this.value, '6')">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitGrades()">Submit Progress</button>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Modal for progress report -->
    <div class="modal fade" id="progressreportModal" tabindex="-1" aria-labelledby="gradingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradingModalLabel">Progress report: Week #</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ProgressReportTable">
                        table here na same lng progressreport na paper
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitGrades()">Mark as Complete</button>
                </div>
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
                    
                    @if(!isset($groupChat) || !$groupChat)
                        <p class="text-center text-muted">Please select a group chat to view messages.</p>
                    @elseif(!isset($messages) || $messages->isEmpty())
                        <p class="text-center text-muted">No messages in this group chat yet. Start the conversation!</p>
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
                                                {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#gradingModal" style="margin-bottom:1rem">
                                                    Grade
                                                </button> --}}

                                                {{-- check progress report --}}
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#progressreportModal" style="margin-bottom:1rem">
                                                    View Progress Report
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
    
                    <h5>Overall Progress:</h5>
                    <div class="progress mb-3">
                        <div 
                            class="progress-bar bg-success" 
                            id="overallProgressBar" 
                            role="progressbar" 
                            style="width: 0%;" 
                            aria-valuenow="0" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                            0%
                        </div>
                    </div>
    
                    <!-- Chapters Accordion -->
                    <div class="card">
                        <div class="card-header" id="chaptersHeading" role="button" data-bs-toggle="collapse" data-bs-target="#chaptersAccordion" aria-expanded="false" aria-controls="chaptersAccordion" style="cursor: pointer;">
                            <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                Chapter Progress
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            </h5>
                        </div>
    
                        {{-- chapter progress --}}
                        <div id="chaptersAccordion" class="collapse" aria-labelledby="chaptersHeading">
                            <div class="card-body">
                                @for ($i = 1; $i <= 6; $i++)
                                    <div class="mb-4">
                                        <h5>Chapter {{ $i }}</h5>
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
    





{{-- Script to put file info --}}
<script>

    // addMember to group chat script
    function addMember() {
        // Get the email from the input field
        const email = document.getElementById('email').value;

        // Send the POST request to add the member
        fetch('/addgroupmember', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ 
                email: email,
                group_id: window.location.pathname.split('/').pop() // Assuming group ID is the last segment
            }),
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.status === 'error') {
                toastr.error(data.message, 'Error!');
            } else {
                toastr.success(data.message, 'Success!');
            }
        })
        .catch(error => {
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


    // Function to update the score display
    function updateScore(scoreId, value, chapterNumber) {
        document.getElementById(scoreId).innerText = value + '%';
        updateChapterProgress(value, chapterNumber); // Update the progress bar
        console.log(chapterNumber);
    }

    // Function to submit the grades
    function submitGrades() {
        // Create an object to hold the chapter values
        const chapterValues = {};
        
        // Collect only the numeric values for each chapter
        for (let i = 1; i <= 6; i++) {
            chapterValues[`chapter${i}`] = parseInt(document.getElementById(`chapter${i}`).value, 10);
        }

        console.log('Chapter Values:', chapterValues); // Log the chapter values

        const groupId = window.location.pathname.split('/').pop();
        console.log('Group ID:', groupId); // Log the group ID

        fetch(`/teacher/grade/${groupId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(chapterValues), // Directly send the chapter values
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data:', data); // Log the data received from the server
            
            // Optional: Show success message
            toastr.success('Grades submitted successfully', 'Success!');
        })
        .catch((error) => {
            toastr.error('An unexpected error occurred', 'Error!');
            console.error('Error:', error);
        });

        // Close the modal after submitting the grades
        const gradingModal = new bootstrap.Modal(document.getElementById('gradingModal'));
        gradingModal.hide();

        // reload the page
        location.reload();
        
    }

    // Function to update the score display
    function updateChapterProgress(value, chapterNumber) {
        const progressBar = document.getElementById(`progressBar${chapterNumber}`);
        progressBar.style.width = value + '%';
        progressBar.setAttribute('aria-valuenow', value);
        progressBar.textContent = value + '%';

        updateOverallProgressFromServer(); // Update overall progress whenever a chapter slider changes
    }

    // Script for updating the initial progress
    document.addEventListener('DOMContentLoaded', function() {
        @for ($i = 1; $i <= 6; $i++)
            document.getElementById('chapter{{ $i }}').value = {{ $progress['chapter'.$i] ?? 0 }};
            document.getElementById('chapter{{ $i }}Score').innerText = '{{ $progress['chapter'.$i] ?? 0 }}%';
            
            // Also update the progress bars initially
            const progressBar{{ $i }} = document.getElementById('progressBar{{ $i }}');
            progressBar{{ $i }}.style.width = '{{ $progress['chapter'.$i] ?? 0 }}%';
            progressBar{{ $i }}.setAttribute('aria-valuenow', '{{ $progress['chapter'.$i] ?? 0 }}');
            progressBar{{ $i }}.textContent = '{{ $progress['chapter'.$i] ?? 0 }}%';
        @endfor

        // Update overall progress
        updateOverallProgressFromServer();
    });

    // Function to calculate and update overall progress
    function updateOverallProgressFromServer() {
        let total = 0;
        for (let i = 1; i <= 6; i++) {
            const progressValue = parseInt(document.getElementById(`progressBar${i}`).getAttribute('aria-valuenow'), 10);
            total += progressValue;
        }
        const average = total / 6;

        const overallProgressBar = document.getElementById('overallProgressBar');
        overallProgressBar.style.width = average + '%';
        overallProgressBar.setAttribute('aria-valuenow', average);
        overallProgressBar.textContent = average.toFixed(0) + '%';
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