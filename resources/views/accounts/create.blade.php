@extends('layout.app')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('account.create_account') }}</h4>
        </div>
        <div class="page-btn">
            <button type="button" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#manageAreasModal">
                <i class="ti ti-map-pin fs-16 me-1"></i>{{ __('account.manage_areas') }}
            </button>
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

            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('account.code') }} <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('account.name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('account.area') }}</label>
                            <div class="input-group">
                                <select name="area_id" class="form-select">
                                    <option value="">{{ __('account.select_area') }}</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id }}"
                                            {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                            {{ $area->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#createAreaModal" title="{{ __('account.create_area') }}">
                                    <i class="ti ti-plus fs-16"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('account.contact') }}</label>
                            <input type="text" name="contact" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('account.address') }}</label>
                    <textarea name="address" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('messages.create') }}</button>
                    <a href="{{ route('accounts.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="manageAreasModal" tabindex="-1" aria-labelledby="manageAreasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageAreasModalLabel">{{ __('account.manage_areas') }}</h5>
                    <button type="button" class="btn btn-primary btn-sm ms-auto me-2" data-bs-toggle="modal"
                        data-bs-target="#createAreaModal">
                        <i class="ti ti-plus fs-16 me-1"></i>{{ __('account.create_area') }}
                    </button>

                </div>
                <div class="modal-body">
                    @forelse ($areas as $area)
                        <form action="{{ route('areas.update', $area->id) }}" method="POST"
                            class="area-edit-row d-flex align-items-center gap-2 mb-3">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" class="form-control" value="{{ $area->name }}" required>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-edit fs-16 me-1"></i>{{ __('messages.edit') }}
                            </button>
                        </form>
                    @empty
                        <p class="mb-0 text-muted">{{ __('account.no_areas') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createAreaModal" tabindex="-1" aria-labelledby="createAreaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('areas.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAreaModalLabel">{{ __('account.create_new_area') }}</h5>

                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label>{{ __('account.area_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('account.create_area') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
