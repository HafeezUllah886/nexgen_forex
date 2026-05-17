@extends('layout.app')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('account.account_management') }}</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('accounts.create') }}" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">{{ __('account.add_new_account') }}
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
                            <th>{{ __('account.code') }}</th>
                            <th>{{ __('account.name') }}</th>
                            <th>{{ __('account.area') }}</th>
                            <th>{{ __('account.contact') }}</th>
                            <th>{{ __('account.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>{{ $account->code }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->area }}</td>
                                <td>{{ $account->contact }}</td>
                                <td>
                                    <a href="{{ route('accounts.show', $account->id) }}" class="btn btn-sm btn-info">{{ __('messages.view') }}</a>
                                    <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-sm btn-primary">{{ __('messages.edit') }}</a>
                                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('account.confirm_delete') }}')">{{ __('messages.delete') }}</button>
                                    </form>
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

            <div class="mt-3">
                {{ $accounts->links() }}
            </div>
        </div>
    </div>
@endsection