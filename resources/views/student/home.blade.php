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
    
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Basic Report Information -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reportingWeek" class="form-label">Reporting Week</label>
                                <select class="form-select" id="reportingWeek" name="reporting_week" required>
                                    <option value="">Select Week</option>
                                    <option value="1">Week 1</option>
                                    <option value="2">Week 2</option>
                                    <option value="3">Week 3</option>
                                    <option value="4">Week 4</option>
                                    <option value="5">Week 5</option>
                                    <option value="6">Week 6</option>
                                    <option value="7">Week 7</option>
                                    <option value="8">Week 8</option>
                                    <option value="8">Week 9</option>
                                    <option value="8">Week 10</option>
                                    <option value="8">Week 11</option>
                                    <option value="8">Week 12</option>
                                    <option value="8">Week 13</option>
                                    <option value="8">Week 14</option>
                                    <option value="8">Week 15</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="reportingDate" class="form-label">Reporting Date</label>
                                <input type="date" class="form-control" id="reportingDate" name="reporting_date" required>
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
                    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

                </form>
            </div>
        </div>
    </div>

    <div class="row">
        @section('content')
<div class="container">
    <h2>Student Dashboard</h2>

    <!-- Progress Report Section -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>Progress Report</h5>
        </div>
        <div class="card-body">
            @if($tasks->isNotEmpty())
                <p class="text-success">A progress report has been sent.</p>
                
                <!-- Display all tasks -->
                <ul class="list-group">
                    @foreach($tasks as $task)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>
                                    <strong>Group Name:</strong> {{ $task->group_name }}<br>
                                    <strong>Reporting Date:</strong> {{ $task->reporting_date }}<br>
                                    <strong>Project Title:</strong> {{ $task->project_title }}
                                </span>
                                
                                <!-- View Details Button -->
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}">
                                    View Details
                                </button>
                            </div>
                        </li>

                        <!-- Task Details Modal -->
                        <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">Progress Report Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Group Name:</strong> {{ $task->group_name }}</p>
                                        <p><strong>Reporting Date:</strong> {{ $task->reporting_date }}</p>
                                        <p><strong>Reporting Week:</strong> {{ $task->reporting_week }}</p>
                                        <p><strong>Project Title:</strong> {{ $task->project_title }}</p>
                                        
                                        <!-- Daily Activities -->
                                        @for ($i = 1; $i <= 6; $i++)
                                            <div class="mt-3">
                                                <h6>Day {{ $i }}</h6>
                                                <p><strong>Date:</strong> {{ $task->{'day'.$i.'_date'} ?? 'N/A' }}</p>
                                                <p><strong>Activities:</strong> {{ $task->{'day'.$i.'_activities'} ?? 'N/A' }}</p>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            @else
                <p class="text-danger">No progress report has been sent yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection

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
    document.querySelector('form').addEventListener('submit', function(e) {
        // Example validation
        const groupName = document.getElementById('groupName').value;
        const reportingDate = document.getElementById('reportingDate').value;
        
        if (!groupName || !reportingDate) {
            e.preventDefault();
            alert('Please fill in all required fields');
        }
    });

</script>

@endsection