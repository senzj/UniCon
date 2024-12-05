<!DOCTYPE html>
@extends('templates.main')
@section('title', 'Admin Dashboard')
@section('content')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mt-4">
        <!-- Header Section -->
        <header class="mb-4">
            <h1 class="text-center">Teacher's Dashboard</h1>
        </header>

        <!-- Create Group Chat Section -->
        <div class="mb-4">
            <h4>Create a New Group Chat</h4>
            <form action="{{ route('teacher.createGroupChat') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="group_name" class="form-control" placeholder="Enter group chat name" required>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>

        <div class="row">
            <!-- Left Section: Group Chats -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Group Chats</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @if(isset($Groupchats) && count($Groupchats) > 0)
                                @foreach ($Groupchats as $group)
                                    <li class="list-group-item">
                                        <a href="{{ route('teacher.group_Chat', $group->id) }}">{{ $group->name }}</a>
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
                        <form action="{{ route('teacher.addMember', $groupChat->id ?? '') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="email" name ="email" class="form-control" placeholder="Add member by email" required>
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>
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
</body>
</html>