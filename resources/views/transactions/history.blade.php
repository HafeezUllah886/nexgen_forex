@extends('layout.app')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('messages.transaction_history') }}</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('transactions.create') }}" class="btn btn-added" target="nexgen_create_transaction"
                onclick="window.open(this.href, 'nexgen_create_transaction', 'width=1600,height=900,noopener,noreferrer,scrollbars=yes,resizable=yes'); return false;">
                <i class="ti ti-plus fs-16 me-1"></i>{{ __('messages.create_transaction') }}
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <div class="search-set">
                    <div class="search-input">
                        <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary d-flex align-items-center gap-1" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false"
                        aria-controls="filterCollapse">
                        <i class="ti ti-filter fs-16"></i>{{ __('transaction.filter') }}
                    </button>
                </div>
            </div>

            <!-- Collapsible Filters -->
            <div class="collapse mt-3 {{ request()->anyFilled(['start_date', 'end_date', 'account_id', 'location']) ? 'show' : '' }}"
                id="filterCollapse">
                <div class="p-3 border rounded bg-light">
                    <form action="{{ route('transactions.history') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">{{ __('transaction.date_from') }}</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">{{ __('transaction.date_to') }}</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">{{ __('transaction.account') }}</label>
                            <select name="account_id" class="form-select select2-filter">
                                <option value="">-- {{ __('transaction.all_accounts') }} --</option>
                                @foreach ($accounts as $account)
                                    @php
                                        $words = explode(' ', $account->name);
                                        $translatedWords = [];
                                        foreach ($words as $word) {
                                            $lowerWord = strtolower(trim($word));
                                            $lowerWord = preg_replace('/[^\w\s]/u', '', $lowerWord);
                                            if (Lang::has('accounts.' . $lowerWord)) {
                                                $translatedWords[] = __('accounts.' . $lowerWord);
                                            } else {
                                                $translatedWords[] = $word;
                                            }
                                        }
                                        $translatedName = implode(' ', $translatedWords);
                                        $displayText =
                                            $translatedName !== $account->name
                                                ? "{$account->name} - {$translatedName}"
                                                : $account->name;
                                    @endphp
                                    <option value="{{ $account->id }}"
                                        {{ request('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $displayText }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">{{ __('transaction.location') }}</label>
                            <input type="text" name="location" class="form-control" value="{{ request('location') }}"
                                placeholder="{{ __('transaction.location') }}...">
                        </div>
                        <div class="col-12 text-end mt-2">
                            <a href="{{ route('transactions.history') }}" class="btn btn-light btn-sm me-2">
                                <i class="ti ti-refresh me-1"></i>{{ __('transaction.reset') }}
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ti ti-search me-1"></i>{{ __('transaction.apply_filters') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table datatable table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>{{ __('transaction.date') }}</th>
                            <th>{{ __('transaction.account') }}</th>
                            <th>{{ __('transaction.location') }}</th>
                            <th>{{ __('transaction.number') }}</th>
                            <th class="text-success">{{ __('transaction.credit') }}</th>
                            <th class="text-danger">{{ __('transaction.debit') }}</th>
                            <th>{{ __('transaction.rupees') }}</th>
                            <th>{{ __('transaction.dollar') }}</th>
                            <th>{{ __('transaction.afghani') }}</th>
                            <th>{{ __('transaction.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            @php
                                $accountName = $transaction->account?->name ?? '-';
                                $words = explode(' ', $accountName);
                                $translatedWords = [];
                                foreach ($words as $word) {
                                    $lowerWord = strtolower(trim($word));
                                    $lowerWord = preg_replace('/[^\w\s]/u', '', $lowerWord);
                                    if (Lang::has('accounts.' . $lowerWord)) {
                                        $translatedWords[] = __('accounts.' . $lowerWord);
                                    } else {
                                        $translatedWords[] = $word;
                                    }
                                }
                                $translatedName = implode(' ', $translatedWords);
                                $displayText =
                                    $translatedName !== $accountName
                                        ? "{$accountName} - {$translatedName}"
                                        : $accountName;
                            @endphp
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td class="fw-bold">{{ $displayText }}</td>
                                <td>{{ $transaction->location ?? '-' }}</td>
                                <td>{{ $transaction->number ?? '-' }}</td>
                                <td class="text-success fw-bold">{{ number_format($transaction->credit, 2) }}</td>
                                <td class="text-danger fw-bold">{{ number_format($transaction->debit, 2) }}</td>
                                <td>
                                    <span class="text-success">{{ number_format($transaction->rupees_credit, 2) }}</span>
                                    /
                                    <span class="text-danger">{{ number_format($transaction->rupees_debit, 2) }}</span>
                                </td>
                                <td>
                                    <span class="text-success">{{ number_format($transaction->dollar_credit, 2) }}</span>
                                    /
                                    <span class="text-danger">{{ number_format($transaction->dollar_debit, 2) }}</span>
                                </td>
                                <td>
                                    <span class="text-success">{{ number_format($transaction->afghani_credit, 2) }}</span>
                                    /
                                    <span class="text-danger">{{ number_format($transaction->afghani_debit, 2) }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="btn-action" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical fs-18"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item edit-transaction-btn" href="javascript:void(0);"
                                                    data-id="{{ $transaction->id }}"
                                                    data-date="{{ $transaction->date }}"
                                                    data-account_id="{{ $transaction->account_id }}"
                                                    data-location="{{ $transaction->location }}"
                                                    data-number="{{ $transaction->number }}"
                                                    data-credit="{{ $transaction->credit }}"
                                                    data-debit="{{ $transaction->debit }}"
                                                    data-rupees_credit="{{ $transaction->rupees_credit }}"
                                                    data-rupees_debit="{{ $transaction->rupees_debit }}"
                                                    data-dollar_credit="{{ $transaction->dollar_credit }}"
                                                    data-dollar_debit="{{ $transaction->dollar_debit }}"
                                                    data-afghani_credit="{{ $transaction->afghani_credit }}"
                                                    data-afghani_debit="{{ $transaction->afghani_debit }}">
                                                    <i class="ti ti-edit me-1 text-primary"></i> {{ __('messages.edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item delete-transaction-btn"
                                                    href="javascript:void(0);" data-id="{{ $transaction->id }}">
                                                    <i class="ti ti-trash me-1 text-danger"></i> {{ __('messages.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @if ($transactions->isNotEmpty())
                        @php
                            $totalCredit = $transactions->sum('credit');
                            $totalDebit = $transactions->sum('debit');
                            $totalRupeesCredit = $transactions->sum('rupees_credit');
                            $totalRupeesDebit = $transactions->sum('rupees_debit');
                            $totalDollarCredit = $transactions->sum('dollar_credit');
                            $totalDollarDebit = $transactions->sum('dollar_debit');
                            $totalAfghaniCredit = $transactions->sum('afghani_credit');
                            $totalAfghaniDebit = $transactions->sum('afghani_debit');
                        @endphp
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-end">{{ __('transaction.totals') }}:</td>
                                <td class="text-success">{{ number_format($totalCredit, 2) }}</td>
                                <td class="text-danger">{{ number_format($totalDebit, 2) }}</td>
                                <td>
                                    <span class="text-success">{{ number_format($totalRupeesCredit, 2) }}</span> /
                                    <span class="text-danger">{{ number_format($totalRupeesDebit, 2) }}</span>
                                </td>
                                <td>
                                    <span class="text-success">{{ number_format($totalDollarCredit, 2) }}</span> /
                                    <span class="text-danger">{{ number_format($totalDollarDebit, 2) }}</span>
                                </td>
                                <td>
                                    <span class="text-success">{{ number_format($totalAfghaniCredit, 2) }}</span> /
                                    <span class="text-danger">{{ number_format($totalAfghaniDebit, 2) }}</span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Transaction Modal -->
    <div class="modal fade" id="editTransactionModal" tabindex="-1" aria-labelledby="editTransactionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTransactionModalLabel">{{ __('transaction.edit_transaction') }}</h5>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: transparent; font-size: 1.25rem; color: #6c757d; transition: color 0.2s; outline: none; box-shadow: none;" onmouseover="this.style.color='#dc3545'" onmouseout="this.style.color='#6c757d'">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form id="editTransactionForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_date" class="form-label fw-bold">{{ __('transaction.date') }}</label>
                                <input type="date" name="date" id="edit_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_account_id" class="form-label fw-bold">{{ __('transaction.account') }}</label>
                                <select name="account_id" id="edit_account_id" class="form-select edit-account-select">
                                    @foreach ($accounts as $account)
                                        @php
                                            $words = explode(' ', $account->name);
                                            $translatedWords = [];
                                            foreach ($words as $word) {
                                                $lowerWord = strtolower(trim($word));
                                                $lowerWord = preg_replace('/[^\w\s]/u', '', $lowerWord);
                                                if (Lang::has('accounts.' . $lowerWord)) {
                                                    $translatedWords[] = __('accounts.' . $lowerWord);
                                                } else {
                                                    $translatedWords[] = $word;
                                                }
                                            }
                                            $translatedName = implode(' ', $translatedWords);
                                            $displayText =
                                                $translatedName !== $account->name
                                                    ? "{$account->name} - {$translatedName}"
                                                    : $account->name;
                                        @endphp
                                        <option value="{{ $account->id }}">{{ $displayText }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_location" class="form-label fw-bold">{{ __('transaction.location') }}</label>
                                <input type="text" name="location" id="edit_location" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_number" class="form-label fw-bold">{{ __('transaction.number') }}</label>
                                <input type="text" name="number" id="edit_number" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_credit"
                                    class="form-label fw-bold text-success">{{ __('transaction.credit') }}</label>
                                <input type="number" step="0.01" name="credit" id="edit_credit" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_debit"
                                    class="form-label fw-bold text-danger">{{ __('transaction.debit') }}</label>
                                <input type="number" step="0.01" name="debit" id="edit_debit" class="form-control">
                            </div>

                            <div class="col-12 border-top pt-3 mt-3">
                                <h6 class="fw-bold mb-3">Multi-Currency (Rupees, Dollar, Afghani) Credits & Debits</h6>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_rupees_credit" class="form-label text-success">{{ __('transaction.rupees') }} (Cr)</label>
                                <input type="number" step="0.01" name="rupees_credit" id="edit_rupees_credit"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_rupees_debit" class="form-label text-danger">{{ __('transaction.rupees') }} (Dr)</label>
                                <input type="number" step="0.01" name="rupees_debit" id="edit_rupees_debit"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_dollar_credit" class="form-label text-success">{{ __('transaction.dollar') }} (Cr)</label>
                                <input type="number" step="0.01" name="dollar_credit" id="edit_dollar_credit"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_dollar_debit" class="form-label text-danger">{{ __('transaction.dollar') }} (Dr)</label>
                                <input type="number" step="0.01" name="dollar_debit" id="edit_dollar_debit"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_afghani_credit" class="form-label text-success">{{ __('transaction.afghani') }} (Cr)</label>
                                <input type="number" step="0.01" name="afghani_credit" id="edit_afghani_credit"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_afghani_debit" class="form-label text-danger">{{ __('transaction.afghani') }} (Dr)</label>
                                <input type="number" step="0.01" name="afghani_debit" id="edit_afghani_debit"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-2" style="border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary m-0">{{ __('transaction.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Transaction Password Modal -->
    <div class="modal fade" id="deleteTransactionModal" tabindex="-1" aria-labelledby="deleteTransactionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteTransactionModalLabel">
                        <i class="ti ti-alert-triangle me-1"></i>{{ __('transaction.confirm_deletion') }}
                    </h5>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: transparent; font-size: 1.25rem; color: #6c757d; transition: color 0.2s; outline: none; box-shadow: none;" onmouseover="this.style.color='#dc3545'" onmouseout="this.style.color='#6c757d'">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form id="deleteTransactionForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center">
                        <p class="mb-4 text-dark">{{ __('transaction.delete_confirmation_text') }}</p>
                        <div class="mb-3 text-start">
                            <label for="delete_password" class="form-label fw-bold text-dark">{{ __('transaction.enter_password_to_confirm') }}</label>
                            <input type="password" name="password" id="delete_password" class="form-control" required
                                placeholder="{{ __('transaction.enter_password') }}">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-2" style="border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-danger m-0">{{ __('transaction.confirm_delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script triggers -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize select2 on collapsible filter select
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2-filter').select2({
                    width: '100%'
                });
                // Initialize select2 for Modal dropdown, setting modal wrapper as parent to enable correct focus behavior
                $('.edit-account-select').select2({
                    dropdownParent: $('#editTransactionModal'),
                    width: '100%'
                });
            }

            // Edit button click event
            $(document).on('click', '.edit-transaction-btn', function() {
                const id = $(this).data('id');
                const date = $(this).data('date');
                const accountId = $(this).data('account_id');
                const location = $(this).data('location');
                const number = $(this).data('number');
                const credit = $(this).data('credit');
                const debit = $(this).data('debit');
                const rupeesCredit = $(this).data('rupees_credit');
                const rupeesDebit = $(this).data('rupees_debit');
                const dollarCredit = $(this).data('dollar_credit');
                const dollarDebit = $(this).data('dollar_debit');
                const afghaniCredit = $(this).data('afghani_credit');
                const afghaniDebit = $(this).data('afghani_debit');

                // Set Form action
                $('#editTransactionForm').attr('action', `/transactions/${id}`);

                // Pre-populate input values
                $('#edit_date').val(date);
                $('#edit_account_id').val(accountId).trigger('change');
                $('#edit_location').val(location);
                $('#edit_number').val(number);
                $('#edit_credit').val(credit);
                $('#edit_debit').val(debit);
                $('#edit_rupees_credit').val(rupeesCredit);
                $('#edit_rupees_debit').val(rupeesDebit);
                $('#edit_dollar_credit').val(dollarCredit);
                $('#edit_dollar_debit').val(dollarDebit);
                $('#edit_afghani_credit').val(afghaniCredit);
                $('#edit_afghani_debit').val(afghaniDebit);

                // Open Modal
                $('#editTransactionModal').modal('show');
            });

            // Delete button click event
            $(document).on('click', '.delete-transaction-btn', function() {
                const id = $(this).data('id');

                // Set Form action URL
                $('#deleteTransactionForm').attr('action', `/transactions/${id}`);

                // Clear previous password entry
                $('#delete_password').val('');

                // Open Modal
                $('#deleteTransactionModal').modal('show');
            });
        });
    </script>
@endsection
