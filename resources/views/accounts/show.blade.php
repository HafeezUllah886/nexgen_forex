@extends('layout.app')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('account.account_details') }}</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-primary">{{ __('messages.edit') }}</a>
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary">{{ __('messages.back') }}</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-bold">{{ __('account.code') }}</label>
                        <p>{{ $account->code }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-bold">{{ __('account.name') }}</label>
                        <p>{{ $account->name }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-bold">{{ __('account.area') }}</label>
                        <p>{{ $account->area ?? '-' }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-bold">{{ __('account.contact') }}</label>
                        <p>{{ $account->contact ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="fw-bold">{{ __('account.address') }}</label>
                <p>{{ $account->address ?? '-' }}</p>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-bold">Created At</label>
                        <p>{{ $account->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="fw-bold">Updated At</label>
                        <p>{{ $account->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection