@extends('templates.main')
@section('title', 'Teacher Dashboard')
@section('content')

<div class="container-fluid mt-4">
    <!-- Main Content -->
    <div class="row">
        <!-- Left Sidebar: Group Chat Selection -->
        <div class="col-md-3 bg-light p-3" style="height: 100vh; overflow-y: auto;">
            <h5>CHATS</h5>
            <input type="text" class="form-control mb-3" placeholder="Search">
            <div class="list-group">
                <div class="list-group-item">GROUP NAME <br><span class="text-muted">Chat (Parang Messenger)</span></div>
                <div class="list-group-item">GROUP NAME <br><span class="text-muted">Chat (Parang Messenger)</span></div>
                <div class="list-group-item">GROUP NAME <br><span class="text-muted">Chat (Parang Messenger)</span></div>
                <div class="list-group-item">GROUP NAME <br><span class="text-muted">Chat (Parang Messenger)</span></div>
            </div>
        </div>

        <!-- Middle Section: Chatbox and Group Information -->
        <div class="col-md-6 p-3" style="height: 100vh; overflow-y: auto;">
            <div class="border p-3 mb-3" style="background-color: #f9f9f9;">
                <div class="d-flex justify-content-between">
                    <h5>FRONT END - DONE</h5>
                    <span>11/05/24</span>
                </div>
                <p>ETO PO YUNG PROJECT NAMIN GAWA NG AI BLABLABLABLABLABLABLABLAB...</p>
                <div class="d-flex justify-content-start gap-3">
                    <button class="btn btn-outline-primary btn-sm">Add Comment</button>
                    <button class="btn btn-outline-success btn-sm">Add Grade</button>
                </div>
                <div class="d-flex justify-content-end gap-3 mt-2">
                    <button class="btn btn-outline-secondary btn-sm">ZIP</button>
                    <button class="btn btn-outline-secondary btn-sm">Preview</button>
                    <button class="btn btn-outline-secondary btn-sm">Graded <i class="bi bi-check-lg"></i></button>
                </div>
            </div>
        </div>

        <!-- Right Sidebar: Information and Progress -->
        <div class="col-md-3 bg-light p-3" style="height: 100vh; overflow-y: auto;">
            <div class="text-center mb-4">
                <!-- Profile Image Section -->
                <div
                    style="width: 100px; height: 100px; border-radius: 50%; border: 1px solid #000; margin: 0 auto; cursor: pointer;"
                    data-bs-toggle="modal" data-bs-target="#profileImageModal">
                    @if ($profileImage ?? false)
                        <img src="{{ asset('storage/' . $profileImage) }}" alt="Profile Image"
                             style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; border-radius: 50%; background-color: #e9ecef;"></div>
                    @endif
                </div>
                <h5 class="mt-3">Group Name</h5>
            </div>

            <h6>Progress Bar</h6>
            <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h6>Group Members</h6>
            <ul class="list-group mb-4">
                <li class="list-group-item">Member 1</li>
                <li class="list-group-item">Member 2</li>
                <li class="list-group-item">Member 3</li>
                <li class="list-group-item">Member 4</li>
            </ul>
            <h6>Task List</h6>
            <ul class="list-group">
                <li class="list-group-item">Front End - 11/25/24</li>
                <li class="list-group-item">Back End - 12/01/24</li>
                <li class="list-group-item">Lorem Ipsum - 12/10/24</li>
                <li class="list-group-item">Lorem Ipsum - 12/17/24</li>
            </ul>
        </div>
    </div>
</div>

<!-- Profile Image Modal -->
<div class="modal fade" id="profileImageModal" tabindex="-1" aria-labelledby="profileImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileImageModalLabel">Upload Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('teacher.uploadProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="file" name="profile_image" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
