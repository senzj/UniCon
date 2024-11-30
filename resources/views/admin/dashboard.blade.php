@extends('templates.main')
@section('title', 'Admin Dashboard')
@section('content')

<h1>Welcome to the Admin Dashboard Page!</h1>

<div class="container mt-4">
    {{-- @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}

    <h2>User Overview</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Change Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                {{-- <td>{{ $user->role }}</td> --}}
                <form action="{{ route('updateRole', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <td>
                        <select name="role" class="form-select" value="{{ $user->role }}">
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Teacher</option>
                            @if (Auth::user()->role == 'admin')
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            @endif
                        </select>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary mt-2">Update Role</button>
                    </td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
