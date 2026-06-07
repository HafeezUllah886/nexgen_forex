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
                        <tr>
                            <th>ID</th>
                            <th>{{ __('account.code') }}</th>
                            <th>{{ __('account.name') }}</th>
                            <th>{{ __('account.area') }}</th>
                            <th>{{ __('account.contact') }}</th>
                            <th>{{ __('transaction.balance') }}</th>
                            <th>{{ __('account.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>{{ $account->code }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->assignedArea?->name ?? $account->area }}</td>
                                <td>{{ $account->contact }}</td>
                                <td>{{ number_format($account->getBalance(), 2, '.', ',') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="btn-action" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical fs-18"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('accounts.show', $account->id) }}">
                                                    <i class="ti ti-eye me-1 text-info"></i> {{ __('messages.view') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('accounts.edit', $account->id) }}">
                                                    <i class="ti ti-edit me-1 text-primary"></i> {{ __('messages.edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item view-statement-btn" href="javascript:void(0);"
                                                    data-id="{{ $account->id }}" data-name="{{ $account->name }}">
                                                    <i class="ti ti-file-text me-1 text-warning"></i>
                                                    {{ __('account.statement') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item delete-account-btn" href="javascript:void(0);"
                                                    data-id="{{ $account->id }}" data-name="{{ $account->name }}">
                                                    <i class="ti ti-trash me-1 text-danger"></i>
                                                    {{ __('account.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Date Range Modal for Account Statement -->
    <div class="modal fade" id="statementModal" tabindex="-1" aria-labelledby="statementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statementModalLabel">
                        <i class="ti ti-file-text me-1 text-warning"></i>{{ __('account.account_statement') }}
                    </h5>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close"
                        style="border: none; background: transparent; font-size: 1.25rem; color: #6c757d; transition: color 0.2s; outline: none; box-shadow: none;"
                        onmouseover="this.style.color='#dc3545'" onmouseout="this.style.color='#6c757d'">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form id="statementForm" method="GET" action="" target="_blank">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('account.name') }}</label>
                            <input type="text" id="statement_account_name" class="form-control bg-light" readonly>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="statement_start_date"
                                    class="form-label fw-bold">{{ __('transaction.date_from') }}</label>
                                <input type="date" name="start_date" id="statement_start_date"
                                    value="{{ firstDateofCurrentMonth() }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="statement_end_date"
                                    class="form-label fw-bold">{{ __('transaction.date_to') }}</label>
                                <input type="date" name="end_date" value="{{ date('Y-m-d') }}" id="statement_end_date"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-2" style="border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary me-2"
                            data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-warning fw-bold text-dark m-0">
                            <i class="ti ti-eye me-1"></i>{{ __('account.generate_statement') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="deleteAccountModalLabel">
                        <i class="ti ti-alert-triangle me-2 text-danger"></i>{{ __('messages.confirm_delete') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-1">{{ __('account.delete_confirm_message') }} <strong id="delete_account_name" class="text-danger"></strong>?</p>
                    <p class="text-muted small mb-0"><i class="ti ti-info-circle me-1"></i>{{ __('account.delete_transactions_warning') }}</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <form id="deleteAccountForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i>{{ __('account.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script trigger -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('click', '.view-statement-btn', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                // Set form action dynamically
                $('#statementForm').attr('action', `/accounts/${id}/statement`);

                // Set account name
                $('#statement_account_name').val(name);

                // Open modal
                $('#statementModal').modal('show');
            });

            // Delete account confirmation
            $(document).on('click', '.delete-account-btn', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                // Set account name in modal
                $('#delete_account_name').text(name);

                // Set form action dynamically
                $('#deleteAccountForm').attr('action', `/accounts/${id}`);

                // Open modal
                $('#deleteAccountModal').modal('show');
            });
        });
    </script>
@endsection
