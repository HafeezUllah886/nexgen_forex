@extends('layout.app')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('account.account_management') }}</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('accounts.create') }}" class="btn btn-added">
                <i class="ti ti-plus fs-16 me-1"></i>{{ __('account.add_new_account') }}
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <div class="search-set">
                <div class="search-input">
                    <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                </div>
            </div>

        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead class="thead-light">
                        <th>ID</th>
                        <th>{{ __('account.code') }}</th>
                        <th>{{ __('account.name') }}</th>
                        <th>{{ __('account.area') }}</th>
                        <th>{{ __('account.contact') }}</th>
                        <th>{{ __('account.actions') }}</th>
                    </thead>
                    <tbody>
                        @forelse($accounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>{{ $account->code }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->assignedArea?->name ?? $account->area }}</td>
                                <td>{{ $account->contact }}</td>
                                <td>
                                    <a href="{{ route('accounts.show', $account->id) }}"
                                        class="btn btn-sm btn-info">{{ __('messages.view') }}</a>
                                    <a href="{{ route('accounts.edit', $account->id) }}"
                                        class="btn btn-sm btn-primary">{{ __('messages.edit') }}</a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('account.no_accounts') }}</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
