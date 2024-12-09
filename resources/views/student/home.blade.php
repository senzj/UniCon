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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReportModalLabel">Create Progress Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Basic Report Information -->
                        <div class="row">
                            <!-- invisible form for project title -->
                            <input type="hidden" name="project_title" value="{{ $groupChat->title ?? '' }}">

                            <!-- invisible form for group name -->
                            <input type="hidden" name="group_name" value="{{ $groupChat->name ?? '' }}">
                            
                            <div class="col-md-6 mb-3">
                                <label for="reportingDate" class="form-label">Reporting Date</label>
                                <input type="date" class="form-control" id="reportingDate" name="reporting_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="reportingWeek" class="form-label">Reporting Week</label>
                                <select class="form-select" id="reportingWeek" name="reporting_week" required>
                                    <option value="">Select Week</option>
                                    @for ($week = 1; $week <= 15; $week++)
                                        <option value="{{ $week }}">Week {{ $week }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Chapters and Activities -->
                        <h5 class="mt-4 mb-3">Chapter Activities</h5>
                        @for ($i = 1; $i <= 6; $i++)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6>Day {{ $i }} Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="chapter{{ $i }}Date" class="form-label">Date</label>
                                            <input type="date" 
                                                class="form-control" 
                                                id="chapter{{ $i }}Date" 
                                                name="chapter_{{ $i }}_date">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="chapter{{ $i }}Activity" class="form-label">Activities</label>
                                            <textarea 
                                                class="form-control" 
                                                id="chapter{{ $i }}Activity" 
                                                name="chapter_{{ $i }}_activities" 
                                                rows="3" 
                                                placeholder="Describe activities for Day {{ $i }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Progress Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- view Progress report modal form -->
    <div class="modal fade" id="progressreportModal" tabindex="-1" aria-labelledby="progressReportLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                </div>

            </div>
        </div>
    </div>
  

    <div class="row">
        <!-- Middle Section: Messages -->
        <div class="col-md-9"> <!-- Changed to col-md-9 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>{{ isset($groupChat) ? $groupChat->name : 'No Group Selected' }}</h4>
                    <small>Title: {{ isset($groupChat) ? $groupChat->title : '' }}</small>
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
                                                <div class="text-right">
                                                    <small class="mb-1" style="font-size: 0.8rem;">File: {{ basename($message->file_path) }}</small>
                                                </div>
                                                <a href="{{ route('file.download', $groupChat->name .'/' . basename($message->file_path)) }}" 
                                                class="btn btn-secondary btn-sm" style="margin-bottom: 1rem;">
                                                    Download
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
                                        <div class="col-12">
                
                                            {{-- if user has attached file --}}
                                            @if($message->file_path)
                                                <div class="text-right">
                                                    <small class="mb-1" style="font-size: 0.8rem;">File: {{ basename($message->file_path) }}</small>
                                                </div>
                                                <a href="{{ route('file.download', $groupChat->name .'/' . basename($message->file_path)) }}" 
                                                    class="btn btn-secondary btn-sm" style="margin-bottom: 1rem;">
                                                     Download
                                                 </a>
                                             @endif
                 
                                             {{-- Check if there is a task associated with this message --}}
                                            @if($tasks->where('message_id', $message->id)->isNotEmpty() && isset($groupChat))
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
                 
                                             <small class="text-muted" style="margin-left: 3.5rem;">
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
                    {{-- file input text display--}}
                    <span id="file-name" class="ml-2 text-muted"></span>
                
                    @if ($groupChat)
                        <form action="{{ route('send.Message', $groupChat->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="group_chat_id" value="{{ $groupChat->id }}">
                            <div class="input-group">
                                <input type="text" name="message" class="form-control" placeholder="Type your message here...">
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

    // Javascript to handle the progress report modal display
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
            var members = button.getAttribute('data-members'); // Split into an array
            var tasks = button.getAttribute('data-tasklist');

            //logging variables
            // console.log(taskId);
            // console.log(projectTitle);
            // console.log(groupName);
            // console.log(specialization);
            // console.log(reportingWeek);
            // console.log(mentoringDay);
            // console.log(mentoringTime);
            // console.log(term);
            // console.log(academicYear);
            // console.log(members);
            // console.log(tasks);
            
            // Update the modal's title
            var modalTitle = progressReportModal.querySelector('.modal-title');
            modalTitle.textContent = 'Progress Report: Week ' + reportingWeek;

            // Populate Part A
            var modalBody = progressReportModal.querySelector('.table-responsive tbody');
            modalBody.innerHTML = ''; // Clear previous content

            modalBody.innerHTML += `
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

            // Populate Part B (You can replace this with actual data)

            // Parse the tasks JSON string into an array
            var tasksArray = JSON.parse(tasks);
            // console.log("array", tasksArray);

            // Find the task data by taskId
            var taskData = tasksArray.find(task => task.id === parseInt(taskId, 10));
            console.log("data", taskData);

            // Clear previous activities
            var activitiesTableBody = progressReportModal.querySelectorAll('.table-bordered')[1].querySelector('tbody');
            activitiesTableBody.innerHTML = ''; // Clear previous content

            if (taskData) {
                // Loop through day(number)_date and day(number)_activities
                for (let i = 1; i <= 6; i++) {
                    let date = taskData[`day${i}_date`];
                    let activity = taskData[`day${i}_activities`];

                    console.log(`Day ${i} - Date: ${date}, Activity: ${activity}`);

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

        });
    });


     // set the tasks to a global variable
     window.tasks = <?php echo json_encode($tasks); ?>;
    console.log('Tasks:', window.tasks);

    // Function to mark the progress report as complete
    // Function to update the progress bar
    function updateProgressBar() {
        // Directly use the tasks from the existing data
        const tasks = window.tasks; // Assuming you've passed tasks to a global variable
        console.log('Tasks:', tasks);

        // Create an object to track completed tasks for each week
        const weekCompletion = {};

        // Iterate through tasks and mark week completion
        tasks.forEach(task => {
            const week = task.reporting_week;
            const complete = task.complete;
            
            console.log('Week:', week, 'Complete:', complete);
            
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

    // Function to update the progress bar
    function updateProgressBar() {
        // Directly use the tasks from the existing data
        const task = window.tasks; // Assuming you've passed tasks to a global variable

        // Create an object to track completed tasks for each week
        const weekCompletion = {};

        // Iterate through tasks and mark week completion
        task.forEach(task => {
            const week = task.reporting_week;
            console.log('Task:', task, 'Week:', week);
            
            // If the task is complete, mark the week as complete
            if (task.complete === 1) {
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
                       
</script>

@endsection