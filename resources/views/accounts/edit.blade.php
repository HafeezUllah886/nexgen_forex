@extends('layout.app')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('account.edit_account') }}</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('accounts.update', $account->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('account.code') }} <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" value="{{ $account->code }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('account.name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $account->name }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('account.area') }}</label>
                            <select name="area_id" class="form-select">
                                <option value="">{{ __('account.select_area') }}</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('area_id', $account->area_id) == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('account.contact') }}</label>
                            <input type="text" name="contact" class="form-control" value="{{ $account->contact }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('account.address') }}</label>
                    <textarea name="address" class="form-control" rows="3">{{ $account->address }}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
                    <a href="{{ route('accounts.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
