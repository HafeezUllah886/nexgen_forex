@extends('layout.app')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Users Management</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('users.create') }}" class="btn btn-added">
                <i class="ti ti-plus fs-16 me-1"></i>Add New User
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Language</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    @if ($user->lang == 'en')
                                        <span class="badge bg-light">English</span>
                                    @elseif($user->lang == 'ur')
                                        <span class="badge bg-light">اردو</span>
                                    @elseif($user->lang == 'fa')
                                        <span class="badge bg-light">فارسی</span>
                                    @else
                                        <span class="badge bg-light">{{ strtoupper($user->lang) }}</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
