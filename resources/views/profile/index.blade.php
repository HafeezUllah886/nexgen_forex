@extends('layout.app')
@section('content')
<div class="page-header">
    <div class="page-title">
        <h4>{{ __('messages.profile') }}</h4>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.language') }}</label>
                        <select name="lang" class="form-select" required>
                            <option value="en" {{ $user->lang == 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
                            <option value="ur" {{ $user->lang == 'ur' ? 'selected' : '' }}>{{ __('messages.urdu') }}</option>
                            <option value="fa" {{ $user->lang == 'fa' ? 'selected' : '' }}>{{ __('messages.farsi') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('auth.username') }}</label>
                        <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
            </div>
        </form>

        <hr class="my-4">

        <h5>Change Password</h5>
        <form action="{{ route('profile.password') }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </div>
</div>
@endsection