@extends('templates.main')
@section('title', 'Admin Dashboard')
@section('content')

<h1>Welcome, Admin!</h1>

<div class="container mt-4">
    <h2>User Overview</h2>

    <!-- Search Form -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control me-2" 
                    placeholder="Search by first name, last name, or email" 
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Filter users by search term and exclude admins
                $filteredUsers = $users->filter(function ($user) {
                    $search = request('search');
                    // Exclude admins
                    if ($user->role === 'admin') {
                        return false;
                    }
                    // Match by first name, last name, or email
                    if (!$search) {
                        return true;
                    }
                    $search = strtolower($search);
                    return str_contains(strtolower($user->first_name), $search) || 
                           str_contains(strtolower($user->last_name), $search) || 
                           str_contains(strtolower($user->email), $search);
                });
            @endphp

            @forelse ($filteredUsers as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <form action="{{ route('updateRole', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>
                            <select name="role" class="form-select" value="{{ $user->role }}">
                                <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                                <option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Teacher</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary mt-2">Update Role</button>
                        </td>
                    </form>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
