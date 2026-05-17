@extends('layout.app')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>User Details</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username</label>
                        <p class="form-control-static">{{ $user->username }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Default Language</label>
                        <p class="form-control-static">
                            <span class="badge bg-primary">{{ strtoupper($user->lang) }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Created At</label>
                        <p class="form-control-static">{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Updated</label>
                        <p class="form-control-static">{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
