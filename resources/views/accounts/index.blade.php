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
                        <th>{{ __('transaction.balance') }}</th>
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
                                                    data-id="{{ $account->id }}"
                                                    data-name="{{ $account->name }}">
                                                    <i class="ti ti-file-text me-1 text-warning"></i> {{ __('account.statement') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('account.no_accounts') }}</td>
                            </tr>
                        @endforelse

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
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: transparent; font-size: 1.25rem; color: #6c757d; transition: color 0.2s; outline: none; box-shadow: none;" onmouseover="this.style.color='#dc3545'" onmouseout="this.style.color='#6c757d'">
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
                                <label for="statement_start_date" class="form-label fw-bold">{{ __('transaction.date_from') }}</label>
                                <input type="date" name="start_date" id="statement_start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="statement_end_date" class="form-label fw-bold">{{ __('transaction.date_to') }}</label>
                                <input type="date" name="end_date" id="statement_end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-2" style="border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-warning fw-bold text-dark m-0">
                            <i class="ti ti-eye me-1"></i>{{ __('account.generate_statement') }}
                        </button>
                    </div>
                </form>
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

                // Clear previous dates
                $('#statement_start_date').val('');
                $('#statement_end_date').val('');

                // Open modal
                $('#statementModal').modal('show');
            });
        });
    </script>
@endsection
