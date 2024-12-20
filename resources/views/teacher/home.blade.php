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

                        <!-- Group Project Title -->
                        <div class="mb-3">
                            <label for="groupTitle" class="form-label">Project Title</label>
                            <input type="text" class="form-control" id="groupTtile" name="group_title" required>
                        </div>
                
                        <!-- Group Section -->
                        <div class="mb-3">
                            <label for="groupSection" class="form-label">Section</label>
                            <input type="text" class="form-control" id="groupSection" name="group_section" required>
                        </div>
                
                        <!-- Group Specialization -->
                        <div class="mb-3">
                            <label for="groupSpecialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control" id="groupSpecialization" name="group_specialization" required>
                        </div>
                
                        <!-- Group Adviser -->
                        <div class="mb-3">
                            <label for="groupAdviser" class="form-label">Group Adviser</label>
                            <input type="text" class="form-control" id="groupAdviser" name="group_adviser" required>
                        </div>

                        <!-- Term -->
                        <div class="mb-3">
                            <label for="term" class="form-label">Term</label>
                            <select class="form-select" id="term" name="term" required>
                                <option value="" disabled selected>Select a term</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>

                        <!-- Academic Year -->
                        <div class="mb-3">
                            <label for="academicYear" class="form-label">Academic Year</label>
                            <input type="text" class="form-control" id="academicYear" name="academic_year" required>
                        </div>

                        <!-- Mentoring Day -->
                        <div class="mb-3">
                            <label for="mentoringDay" class="form-label">Mentoring Day</label>
                            <select class="form-select" id="mentoringDay" name="mentoring_day" required>
                                <option value="" disabled selected>Select a day</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>

                        <!-- Mentoring Time -->
                        <div class="mb-3">
                            <label for="mentoringTime" class="form-label">Mentoring Time</label>
                            <input type="time" class="form-control" id="mentoringTime" name="mentoring_time" required>
                        </div>
                
                        <!-- Group Logo -->
                        <div class="mb-3">
                            <label for="groupLogo" class="form-label">Group Logo</label>
                            <input type="file" class="form-control" id="groupLogo" name="group_logo" accept="image/*" required>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Group</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <!-- Modal for viewing progress report form -->
    <div class="modal fade" id="progressreportModal" tabindex="-1" aria-labelledby="gradingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="progressReportLabel">Progress Report: Week #</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">

                        <!-- Progress Report Table -->
                        <table class="table table-bordered">
                            <thead>
                                {{-- hidden task id --}}
                                
                                <tr>
                                    <th colspan="2">PART A: TO BE COMPLETED BY THE GROUP</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- This will be populated dynamically -->
                            </tbody>
                        </table>

                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th colspan="3">PART B: LIST OF ACTIVITIES DONE</th>
                                </tr>

                                <tr>
                                    <th>Date</th>
                                    <th>Activity</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- This will be populated dynamically -->
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="completeButton" onclick="completePReport()">Mark as Complete</button>
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
                    <h4>Group: {{ isset($groupChat) ? $groupChat->name : 'No group selected' }}</h4>
                    <small>Title: {{ isset($groupChat) ? $groupChat->title : '' }}</small>
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

                                {{-- if message is sent from the current user --}}
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

                                        {{-- Check if there is a task associated with this message --}}
                                        @if($tasks->where('message_id', $message->id)->isNotEmpty())
                                            @php
                                                $task = $tasks->where('message_id', $message->id)->first(); // Get the first task associated with the message
                                            @endphp
                                            <button type="button" class="btn btn-success btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#progressreportModal" 
                                                    data-task-id="{{ $task->id }}" 
                                                    data-term="{{ $groupChat->term }}"
                                                    data-members="{{ $members }}"
                                                    data-academic-year="{{ $groupChat->academic_year }}"
                                                    data-project-title="{{ $task->project_title }}" 
                                                    data-group-name="{{ $groupChat->name }}"
                                                    data-specialization="{{ $groupChat->specialization }}"
                                                    data-reporting-week="{{ $task->reporting_week }}"
                                                    data-mentoring-day = "{{ $groupChat->mentoring_day }}"
                                                    data-mentoring-time = "{{ $groupChat->mentoring_time }}"
                                                    data-tasklist = "{{ $tasks }}"
                                                    style="margin-bottom:1rem">
                                                View Progress Report
                                            </button>
                                        @endif
                                    
                                        <div class="d-flex justify-content-end w-100">
                                            <small class="text-white">
                                                {{ $message->created_at->format('F d, Y h:i A') }}
                                            </small>
                                        </div>
                                    </div>



                                {{-- if message is sent from other users --}}
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

                                            </div>
                                        @endif

                                        {{-- Check if there is a task associated with this message --}}
                                        @if($tasks->where('message_id', $message->id)->isNotEmpty())
                                            @php
                                                $task = $tasks->where('message_id', $message->id)->first(); // Get the first task associated with the message
                                            @endphp

                                            @if ($task->complete == 1)
                                                <button type="button" class="btn btn-success btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#progressreportModal" 
                                                        data-task-id="{{ $task->id }}" 
                                                        data-term="{{ $groupChat->term }}"
                                                        data-members="{{ $members }}"
                                                        data-academic-year="{{ $groupChat->academic_year }}"
                                                        data-project-title="{{ $task->project_title }}" 
                                                        data-group-name="{{ $groupChat->name }}"
                                                        data-specialization="{{ $groupChat->specialization }}"
                                                        data-reporting-week="{{ $task->reporting_week }}"
                                                        data-mentoring-day = "{{ $groupChat->mentoring_day }}"
                                                        data-mentoring-time = "{{ $groupChat->mentoring_time }}"
                                                        data-tasklist = "{{ $tasks }}"
                                                        style="margin-bottom:1rem">
                                                    View Progress Report
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-success btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#progressreportModal" 
                                                        data-task-id="{{ $task->id }}" 
                                                        data-term="{{ $groupChat->term }}"
                                                        data-members="{{ $members }}"
                                                        data-academic-year="{{ $groupChat->academic_year }}"
                                                        data-project-title="{{ $task->project_title }}" 
                                                        data-group-name="{{ $groupChat->name }}"
                                                        data-specialization="{{ $groupChat->specialization }}"
                                                        data-reporting-week="{{ $task->reporting_week }}"
                                                        data-mentoring-day = "{{ $groupChat->mentoring_day }}"
                                                        data-mentoring-time = "{{ $groupChat->mentoring_time }}"
                                                        data-tasklist = "{{ $tasks }}"
                                                        style="margin-bottom:1rem">
                                                    Check Progress Report
                                                </button>
                                            @endif
                                        @endif

                                        <div class="w-100">
                                            <small class="text-muted">
                                                {{ $message->created_at->format('F d, Y h:i A') }}
                                            </small>
                                        </div>
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
                                <input type="text" name="content" class="form-control" placeholder="Type your message...">
                                
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
                <!-- Group Chat header -->
                <div class="card mb-4">
                    <div class="card-header" id="groupChatDetailsHeading" role="button" data-bs-toggle="collapse" data-bs-target="#groupChatDetails" aria-expanded="false" aria-controls="groupChatDetails" style="cursor: pointer;">
                        <h4>{{ isset($groupChat) ? $groupChat->name : 'No group selected' }}</h4>
                    </div>
                
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
                    @if(isset($groupChat))
                    
                        <div id="groupChatDetails" class="collapse" aria-labelledby="groupChatDetailsHeading">
                            <div class="card-body">
                                <p class="mb-1"><strong>Section:</strong> {{ $groupChat->section }}</p>
                                <p class="mb-1"><strong>Specialization:</strong> {{ $groupChat->specialization }}</p>
                                <p class="mb-1"><strong>Adviser:</strong> {{ $groupChat->adviser }}</p>
                                <p class="mb-1"><strong>Term:</strong> {{ $groupChat->term }}</p>
                                <p class="mb-1"><strong>Academic Year:</strong> {{ $groupChat->academic_year }}</p>
                                <p class="mb-1"><strong>Mentoring Day:</strong> {{ $groupChat->mentoring_day }}</p>
                                <p class="mb-1"><strong>Mentoring Time:</strong> {{ $groupChat->mentoring_time }}</p>
                            </div>
                        </div>
                    @endif
                
                </div>

                <div class="card-body">

                    <!-- Report Progress -->
                    <div class="card">
                        <div class="card-header" id="chaptersHeading" role="button" data-bs-toggle="collapse" data-bs-target="#chaptersAccordion" aria-expanded="false" aria-controls="chaptersAccordion" style="cursor: pointer;">
                            <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                Report Progress
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            </h5>
                        </div>

                        <!-- Over all Progress Bar -->
                        <center>
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
                        </center>

                        <!-- chapter progress -->
                        <div id="chaptersAccordion" class="collapse" aria-labelledby="chaptersHeading">
                            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                @for ($i = 1; $i <= 15; $i++)
                                    <div class="mb-4">
                                        <h5>Week {{ $i }}</h5>
                                        <div class="progress">
                                            <div 
                                                class="progress-bar" 
                                                id="progressBar{{ $i }}" 
                                                role="progressbar" 
                                                style="width: {{ $progress['tasks'.$i] ?? 0 }}%;" 
                                                aria-valuenow="{{ $progress['tasks'.$i] ?? 0 }}" 
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
    
                    <!-- Members section -->
                    <div class="card mb-4" style="margin-top: 1rem;">
                        <!-- Members Header -->
                        <div class="card-header" id="membersHeading" role="button" data-bs-toggle="collapse" data-bs-target="#membersList" aria-expanded="false" aria-controls="membersList" style="cursor: pointer;">
                            <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                Members: ({{ isset($members) ? $members->count() : 0 }})
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            </h5>
                        </div>

                        <!-- Add member -->
                        <div class="card-body">
                            <form id="add-member-form" onsubmit="event.preventDefault(); addMember();">
                                <div class="input-group mb-3">
                                    <input type="email" id="email" class="form-control" placeholder="Enter student email" required>
                                    <button type="submit" class="btn btn-success">Add</button>
                                </div>
                            </form>
                        </div>

                        <!-- Members List -->
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
                // reloads page
                location.reload();
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


    // Function that makes the PReport complete
    function completePReport() {
        // Check if task exists and has an ID
        const taskId = "{{ $task->id ?? '' }}";
        
        // If no task ID, show an error
        if (!taskId) {
            toastr.error('No task found for this message', 'Error!');
            return;
        }

        console.log('Task ID:', taskId);
        
        fetch(`/teacher/complete/${taskId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            toastr.success('Progress Report Marked as Complete', 'Success!');
            
            const progressReportModal = bootstrap.Modal.getInstance(document.getElementById('progressreportModal'));
            if (progressReportModal) {
                progressReportModal.hide();
            }
            
            setTimeout(() => {
                location.reload();
            }, 5000); // 5000 milliseconds = 5 seconds
        })
        .catch((error) => {
            toastr.error('An error occurred while marking the task complete', 'Error!');
            console.error('Error:', error);
        });
    }


    // set the tasks to a global variable
    window.tasks = <?php echo json_encode($tasks ?? []); ?>;
    // console.log('Tasks:', window.tasks);

    // Function to update the overall progress bar
    function updateProgressBar() {
        // Directly use the tasks from the existing data
        const tasks = window.tasks; // Assuming you've passed tasks to a global variable
        // console.log('Tasks:', tasks);

        // Create an object to track completed tasks for each week
        const weekCompletion = {};

        // Iterate through tasks and mark week completion
        tasks.forEach(task => {
            const week = task.reporting_week;
            const complete = task.complete;
            
            // console.log('Week:', week, 'Complete:', complete);
            
            // If the task is complete, mark the week as complete
            if (complete === 1) {
                weekCompletion[week] = 100;
            } else if (!weekCompletion[week]) {
                // If not complete and not already set, set to 0
                weekCompletion[week] = 0;
            }
        });

        // Update progress bars for each week
        for (let i = 1; i <= 15; i++) {
            const progressBar = document.getElementById(`progressBar${i}`);

            if (progressBar) {
                // Get the completion status for this week
                const weekProgress = weekCompletion[i] || 0;

                // Update progress bar
                progressBar.style.width = `${weekProgress}%`;
                progressBar.setAttribute('aria-valuenow', weekProgress);
                progressBar.textContent = `${weekProgress}%`;
            }
        }

        // Calculate and update overall progress
        const completedWeeks = Object.values(weekCompletion).filter(progress => progress === 100).length;
        const overallProgress = Math.round((completedWeeks / 15) * 100);
        const overallProgressBar = document.getElementById('overallProgressBar');

        if (overallProgressBar) {
            overallProgressBar.style.width = `${overallProgress}%`;
            overallProgressBar.setAttribute('aria-valuenow', overallProgress);
            overallProgressBar.textContent = `${overallProgress}%`;
        }
    }

    // Call the function when the page loads
    document.addEventListener('DOMContentLoaded', updateProgressBar);
    

    // Optional: Clear the file input when the label is clicked again
    document.getElementById('file-upload').addEventListener('change', function() {
        if (this.files.length === 0) {
            // If no file is selected, clear the file name display
            document.getElementById('file-name').textContent = '';
        }
    });

    // JavaScript to handle the progress report modal display
    document.addEventListener('DOMContentLoaded', function () {

        // Get the modal element
        var progressReportModal = document.getElementById('progressreportModal');

        // Add event listener for when the modal is shown
        progressReportModal.addEventListener('show.bs.modal', function (event) {
            // Get the button that triggered the modal
            var button = event.relatedTarget;

            // Extract the data attributes from the button
            var taskId = button.getAttribute('data-task-id');
            var projectTitle = button.getAttribute('data-project-title');
            var groupName = button.getAttribute('data-group-name');
            var specialization = button.getAttribute('data-specialization');
            var reportingWeek = button.getAttribute('data-reporting-week');
            var mentoringDay = button.getAttribute('data-mentoring-day');
            var mentoringTime = button.getAttribute('data-mentoring-time');
            var term = button.getAttribute('data-term');
            var academicYear = button.getAttribute('data-academic-year');
            var members = button.getAttribute('data-members'); // JSON string
            var tasks = button.getAttribute('data-tasklist'); // JSON string

            // Update the modal's title
            var modalTitle = progressReportModal.querySelector('.modal-title');
            modalTitle.textContent = 'Progress Report: Week ' + reportingWeek;

            // Populate Part A
            var modalBody = progressReportModal.querySelector('.table-responsive tbody');
            modalBody.innerHTML = ''; // Clear previous content

            modalBody.innerHTML += `
                <!-- Group Information -->
                <tr>
                    <td style="font-weight: bold;">Group Name:</td>
                    <td>${groupName}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Program:</td>
                    <td>${specialization}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Term:</td>
                    <td>${term}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Academic Year:</td>
                    <td>${academicYear}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Reporting Week:</td>
                    <td>${reportingWeek}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Member's Name:</td>
                    <td colspan="5">
                        <ol id="student-list">
                            <!-- Student names will be populated here -->
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Mentoring Day:</td>
                    <td>${mentoringDay}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Mentoring Time:</td>
                    <td>${mentoringTime}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Title of the Project:</td>
                    <td>${projectTitle}</td>
                </tr>
            `;

            // Parse the members JSON string
            var membersArray = JSON.parse(members);

            // Filter for students
            var students = membersArray.filter(member => member.role === 'student');

            // Get the student list element
            var studentList = document.getElementById('student-list');

            // Populate the student list
            students.forEach(student => {
                var listItem = document.createElement('li');
                listItem.textContent = `${student.first_name} ${student.last_name}`;
                studentList.appendChild(listItem);
            });

                // Populate Part B: Activities
            // Parse the tasks JSON string into an array
            var tasksArray = JSON.parse(tasks);

            // Find the task data by taskId
            var taskData = tasksArray.find(task => task.id === parseInt(taskId, 10));

            // Clear previous activities
            var activitiesTableBody = progressReportModal.querySelectorAll('.table-bordered')[1].querySelector('tbody');
            activitiesTableBody.innerHTML = ''; // Clear previous content

            if (taskData) {
                // Loop through day(number)_date and day(number)_activities
                for (let i = 1; i <= 6; i++) {
                    let date = taskData[`day${i}_date`];
                    let activity = taskData[`day${i}_activities`];

                    // Only add rows for non-null or valid entries
                    if (date && activity) {
                        activitiesTableBody.innerHTML += `
                            <tr>
                                <td>Day: ${i} <br> Date: ${date}</td>
                                <td>${activity}</td>
                            </tr>
                        `;
                    }
                }
            } else {
                // Handle case where no task data is found
                activitiesTableBody.innerHTML = `
                    <tr>
                        <td colspan="2">No activities found for this task.</td>
                    </tr>
                `;
            }

            // Check if the selected week is complete
            const isWeekComplete = taskData && taskData.complete === 1; // Assuming 'complete' is a property in taskData
            console.log(taskData);

            // Get the complete button
            const completeButton = document.getElementById('completeButton');

            // Hide or show the button based on the completion status
            if (isWeekComplete) {
                completeButton.style.display = 'none'; // Hide the button
            } else {
                completeButton.style.display = 'block'; // Show the button
            }
        });
   });

</script>

@endsection