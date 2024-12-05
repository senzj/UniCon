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

                <form action="{{ route('teacher@createGroup') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="groupLogo" class="form-label">Group Logo Picture</label>
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
                <div class="card-body">
                    <ul class="list-group">
                        @if(isset($Groupchats) && count($Groupchats) > 0)
                            @foreach ($Groupchats as $group)
                                <li class="list-group-item">
                                    <a href="{{ route('teacher@groupchat', $group->id) }}">{{ $group->name }}</a>
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
                    <h4>Submissions for: {{ isset($Groupchat) ? $Groupchat->name : 'No group selected' }}</h4>
                </div>

                <div class="card-body">
                    @if(isset($submissions) && count($submissions) > 0)
                        @foreach ($submissions as $submission)
                            <div class="submission mb-3 border p-3 rounded">
                                <p><strong>Student:</strong> {{ $submission->student_name }}</p>
                                <p>{{ $submission->content }}</p>
                                <p><strong>Grade:</strong> {{ $submission->grade ?? 'Not graded yet' }}</p>
                                <form action="{{ route('teacher.gradeSubmission', $submission->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group mb-2">
                                        <input type="number" name="grade" class="form-control" placeholder="Grade" required>
                                        <input type="text" name="comment" class="form-control" placeholder="Comment">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    @else
                        <p>No submissions available.</p>
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
                    <ul class="list-group mb-3">
                        @if(isset($groupChat) && $groupChat->members)
                            @foreach ($groupChat->members as $member)
                                <li class="list-group-item">{{ $member->name }}</li>
                            @endforeach
                        @else
                            <li class="list-group-item">No members found.</li>
                        @endif
                    </ul>

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

@endsection