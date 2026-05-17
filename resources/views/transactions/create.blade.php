@extends('layout.window')
@section('content')
    <style>
        /* Disable spinners/spin buttons for number inputs */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Mobile Responsive Stacked Table */
        @media (max-width: 991.98px) {
            /* Hide the standard table header */
            .transaction-create-table thead {
                display: none !important;
            }

            /* Make table layout block-based */
            .transaction-create-table,
            .transaction-create-table tbody,
            .transaction-create-table tr,
            .transaction-create-table td {
                display: block !important;
                width: 100% !important;
            }

            /* Display each row (tr) as a distinct card with proper spacing */
            .transaction-create-table tbody tr {
                background: #fdfdfd !important;
                border: 2px solid #e9ecef !important;
                border-radius: 12px !important;
                padding: 16px !important;
                margin-bottom: 24px !important;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02) !important;
                position: relative !important;
                transition: all 0.3s ease;
            }

            .transaction-create-table tbody tr:hover {
                border-color: #ff9f43 !important;
                box-shadow: 0 6px 12px rgba(255, 159, 67, 0.08) !important;
            }

            /* Format each td inside the row */
            .transaction-create-table td {
                padding: 8px 0 !important;
                border: none !important;
            }

            /* Prepend standard descriptive label using data-label attribute */
            .transaction-create-table td::before {
                content: attr(data-label);
                display: block;
                font-weight: 700;
                font-size: 13px;
                color: #495057;
                margin-bottom: 6px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Style multi-currency double inputs in mobile */
            .transaction-create-table td input[type=number] + input[type=number] {
                margin-top: 8px !important;
            }

            /* Align action button td inside card to absolute top-right or just as standard stacked */
            .transaction-create-table td:last-child {
                border-top: 1px solid #dee2e6 !important;
                padding-top: 12px !important;
                margin-top: 8px !important;
                display: flex !important;
                justify-content: flex-end !important;
            }
        }
    </style>
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('transaction.transaction_management') }}</h4>
        </div>
        <div class="page-btn">
            <button type="button" class="btn btn-added" onclick="add_row()">
                <i class="ti ti-plus fs-16 me-1"></i>{{ __('transaction.add_row') }}
            </button>
        </div>
    </div>

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

    <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped transaction-create-table">
                        <thead>
                            <tr>
                                <th>{{ __('transaction.date') }}</th>
                                <th style="width: 150px !important;">{{ __('transaction.account') }}</th>
                                <th>{{ __('transaction.balance') }}</th>
                                <th>{{ __('transaction.location') }}</th>
                                <th>{{ __('transaction.number') }}</th>
                                <th style="width: 200px !important;">{{ __('transaction.description') }}</th>
                                <th class="text-success">{{ __('transaction.credit') }}</th>
                                <th class="text-danger">{{ __('transaction.debit') }}</th>
                                <th>{{ __('transaction.rupees') }}</th>
                                <th>{{ __('transaction.dollar') }}</th>
                                <th>{{ __('transaction.afghani') }}</th>
                                <th style="width: 10px !important;"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <tr id="trRow_0">
                                <td class="p-1" data-label="{{ __('transaction.date') }}"><input type="date" name="date[]" value="{{ date('Y-m-d') }}"
                                        id="date_0" class="form-control p-1 h-100"></td>
                                <td class="p-1" data-label="{{ __('transaction.account') }}"><select name="account[]" id="account_0"
                                        class="form-select p-1 h-100 account-select">
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
                                </td>
                                <td class="p-1" data-label="{{ __('transaction.balance') }}"><input type="number" readonly id="balance_0"
                                        class="form-control p-1 m-0 h-100 text-center"></td>
                                <td class="p-1" data-label="{{ __('transaction.location') }}"><input type="text" name="location[]" id="location_0"
                                        class="form-control p-1 m-0 h-100" placeholder="{{ __('transaction.location') }}"></td>
                                <td class="p-1" data-label="{{ __('transaction.number') }}"><input type="text" name="number[]" id="number_0"
                                        class="form-control p-1 m-0 h-100 text-center" placeholder="{{ __('transaction.number') }}"></td>
                                <td class="p-1" data-label="{{ __('transaction.description') }}"><input type="text" name="description[]" id="description_0"
                                        class="form-control p-1 m-0 h-100" placeholder="{{ __('transaction.description') }}"></td>
                                <td class="p-1" data-label="{{ __('transaction.credit') }}"><input type="number" step="0.01" name="credit[]" id="credit_0"
                                        class="form-control p-1 m-0 h-100 text-center" placeholder="{{ __('transaction.credit') }}"></td>
                                <td class="p-1" data-label="{{ __('transaction.debit') }}"><input type="number" step="0.01" name="debit[]" id="debit_0"
                                        class="form-control p-1 m-0 h-100 text-center" placeholder="{{ __('transaction.debit') }}"></td>
                                <td class="p-1" data-label="{{ __('transaction.rupees') }}"><input type="number" step="0.01" name="rupees_credit[]"
                                        id="rupees_credit_0" class="form-control p-1 m-0 h-100 text-center" placeholder="{{ __('transaction.rupees_credit') }}"><input
                                        type="number" step="0.01" name="rupees_debit[]" id="rupees_debit_0"
                                        class="form-control p-1 m-0 h-100 text-center" placeholder="{{ __('transaction.rupees_debit') }}">
                                </td>
                                <td class="p-1" data-label="{{ __('transaction.dollar') }}"><input type="number" step="0.01" name="dollar_credit[]"
                                        id="dollar_credit_0" class="form-control p-1 m-0 h-100 text-center" placeholder="{{ __('transaction.dollar_credit') }}"><input
                                        type="number" step="0.01" name="dollar_debit[]" id="dollar_debit_0"
                                        class="form-control p-1 m-0 h-100 text-center" placeholder="{{ __('transaction.dollar_debit') }}"></td>
                                <td class="p-1" data-label="{{ __('transaction.afghani') }}"><input type="number" step="0.01" name="afghani_credit[]"
                                        id="afghani_credit_0" class="form-control p-1 m-0 h-100 text-center" placeholder="{{ __('transaction.afghani_credit') }}"><input
                                        type="number" step="0.01" name="afghani_debit[]" id="afghani_debit_0"
                                        class="form-control p-1 m-0 h-100 text-center" placeholder="{{ __('transaction.afghani_debit') }}"></td>
                                <td class="p-1 m-0"><a href="javascript:void(0);" class="btn btn-success btn-sm"
                                        onclick="add_row()"><i class="ti ti-plus"></i></a>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="ti ti-device-floppy fs-16 me-1"></i>{{ __('messages.save') }}
                </button>
                <a href="{{ route('transactions.history') }}" class="btn btn-secondary">
                    <i class="ti ti-x fs-16 me-1"></i>{{ __('messages.cancel') }}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        let rowIndex = 1;

        $(document).ready(function() {
            $('.account-select').select2({
                width: '100%'
            });
            // Trigger dynamic balance load on start
            $('.account-select').trigger('change');
        });

        // AJAX event listener for account balance fetching
        $(document).on('change', '.account-select', function() {
            let select = $(this);
            let id = select.attr('id');
            let index = id.split('_')[1];
            let accountId = select.val();

            if (!accountId) {
                $('#balance_' + index).val('0.00');
                return;
            }

            $.ajax({
                url: `/accounts/${accountId}/balance`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#balance_' + index).val(data.balance);
                },
                error: function() {
                    $('#balance_' + index).val('Error');
                }
            });
        });

        function add_row() {
            let tbody = document.getElementById('tbody');
            let tr = document.createElement('tr');
            tr.id = 'trRow_' + rowIndex;
            tr.innerHTML = `
                            <td class="p-1" data-label="{{ __('transaction.date') }}"><input type="date" name="date[]" value="{{ date('Y-m-d') }}"
                                    id="date_${rowIndex}" class="form-control p-1 h-100"></td>
                            <td class="p-1" data-label="{{ __('transaction.account') }}"><select name="account[]" id="account_${rowIndex}" class="form-select p-1 h-100 account-select">
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
                                            $displayText = $translatedName !== $account->name ? "{$account->name} - {$translatedName}" : $account->name;
                                        @endphp
                                        <option value="{{ $account->id }}">{{ $displayText }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-1" data-label="{{ __('transaction.balance') }}"><input type="number" readonly id="balance_${rowIndex}"
                                    class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1" data-label="{{ __('transaction.location') }}"><input type="text" name="location[]" id="location_${rowIndex}"
                                    class="form-control p-1 h-100" placeholder="{{ __('transaction.location') }}"></td>
                            <td class="p-1" data-label="{{ __('transaction.number') }}"><input type="text" name="number[]" id="number_${rowIndex}"
                                    class="form-control p-1 h-100 text-center" placeholder="{{ __('transaction.number') }}"></td>
                            <td class="p-1" data-label="{{ __('transaction.description') }}"><input type="text" name="description[]" id="description_${rowIndex}"
                                    class="form-control p-1 h-100" placeholder="{{ __('transaction.description') }}"></td>
                            <td class="p-1" data-label="{{ __('transaction.credit') }}"><input type="number" step="0.01" name="credit[]" id="credit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center" placeholder="{{ __('transaction.credit') }}"></td>
                            <td class="p-1" data-label="{{ __('transaction.debit') }}"><input type="number" step="0.01" name="debit[]" id="debit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center" placeholder="{{ __('transaction.debit') }}"></td>
                            <td class="p-1" data-label="{{ __('transaction.rupees') }}"><input type="number" step="0.01" name="rupees_credit[]"
                                    id="rupees_credit_${rowIndex}" class="form-control p-1 h-100 text-center" placeholder="{{ __('transaction.rupees_credit') }}"><input type="number" step="0.01" name="rupees_debit[]" id="rupees_debit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center" placeholder="{{ __('transaction.rupees_debit') }}">
                            </td>
                            <td class="p-1" data-label="{{ __('transaction.dollar') }}"><input type="number" step="0.01" name="dollar_credit[]"
                                    id="dollar_credit_${rowIndex}" class="form-control p-1 h-100 text-center" placeholder="{{ __('transaction.dollar_credit') }}"><input type="number" step="0.01" name="dollar_debit[]"
                                    id="dollar_debit_${rowIndex}" class="form-control p-1 h-100 text-center" placeholder="{{ __('transaction.dollar_debit') }}"></td>
                            <td class="p-1" data-label="{{ __('transaction.afghani') }}"><input type="number" step="0.01" name="afghani_credit[]" id="afghani_credit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center" placeholder="{{ __('transaction.afghani_credit') }}"><input type="number" step="0.01" name="afghani_debit[]" id="afghani_debit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center" placeholder="{{ __('transaction.afghani_debit') }}">
                            </td>
                            <td class="p-1"><a href="javascript:void(0);" class="btn btn-danger btn-sm removeBtn" data-index="${rowIndex}"><i
                                        class="ti ti-trash"></i></a>
                            </td>
            `;
            tbody.appendChild(tr);

            // Initialize Select2 on the new select element
            $('#account_' + rowIndex).select2({
                width: '100%'
            });
            // Trigger dynamic balance load
            $('#account_' + rowIndex).trigger('change');

            rowIndex++;
        }

        $(document).on('click', '.removeBtn', function() {
            var index = $(this).data('index');
            $('#trRow_' + index).remove();
        });
    </script>
@endsection
