@extends('layout.app')

@section('content')
    <style>
        @media print {

            /* Hide UI controls and sidebar */
            .header,
            .sidebar,
            .page-header,
            .btn-print-action,
            .copyright-footer,
            .whirly-loader,
            #global-loader {
                display: none !important;
            }

            /* Adjust page wrapper margins */
            .page-wrapper {
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
            }

            .content {
                padding: 0 !important;
                margin: 0 !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Ensure background and font colors are print-friendly */
            body {
                background-color: #fff !important;
                color: #000 !important;
                font-size: 12px !important;
            }

            .table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            .table th,
            .table td {
                border: 1px solid #ccc !important;
                padding: 6px !important;
            }

            .table-light {
                background-color: #f8f9fa !important;
            }
        }
    </style>

    <!-- Page navigation and action buttons -->
    <div class="d-flex align-items-center justify-content-between mb-4 btn-print-action">
        <div>
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i>{{ __('messages.back') ?? 'Back' }}
            </a>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="ti ti-printer me-1"></i>{{ __('account.print_statement') }}
            </button>

        </div>
    </div>

    <!-- Account Statement Document Card -->
    <div class="card border shadow-sm">
        <div class="card-body">
            <!-- Branding & Header Info -->
            <div class="row border-bottom pb-4 mb-4 align-items-center">
                <div class="col-md-6">
                    <h3 class="fw-bold text-primary m-0">NEXGEN FOREX</h3>
                    <p class="text-muted m-0 fs-13">Premium Currency Exchange & Ledger Solutions</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <h4 class="fw-bold text-dark m-0">{{ __('account.account_statement') }}</h4>
                    <p class="text-muted m-0 fs-13">
                        <strong>{{ __('transaction.filter') }}:</strong>
                        @if ($startDate && $endDate)
                            {{ $startDate }} {{ __('transaction.date_to') }} {{ $endDate }}
                        @elseif($startDate)
                            {{ __('transaction.date_from') }}: {{ $startDate }}
                        @elseif($endDate)
                            {{ __('transaction.date_to') }}: {{ $endDate }}
                        @else
                            All-Time
                        @endif
                    </p>
                </div>
            </div>

            <!-- Client Info & Summarized Balances -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="fw-bold text-secondary mb-2">{{ __('account.account_info') }}</h6>
                    <table class="table table-sm table-borderless m-0 fs-14">
                        <tr>
                            <td class="fw-bold text-dark p-0 pb-1" style="width: 120px;">{{ __('account.name') }}:</td>
                            <td class="p-0 pb-1">{{ $account->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark p-0 pb-1">{{ __('account.code') }}:</td>
                            <td class="p-0 pb-1"><code>{{ $account->code }}</code></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark p-0 pb-1">{{ __('account.contact') }}:</td>
                            <td class="p-0 pb-1">{{ $account->contact ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark p-0 pb-1">{{ __('account.area') }}:</td>
                            <td class="p-0 pb-1">{{ $account->assignedArea?->name ?? ($account->area ?? '-') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <h6 class="fw-bold text-secondary mb-2">Ledger Balances Summary</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="border rounded p-2 text-center bg-light">
                                <span class="fs-12 text-muted d-block">{{ __('account.opening_balance') }}</span>
                                <span class="fs-15 fw-bold text-dark">{{ number_format($openingBalance, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2 text-center bg-light">
                                <span class="fs-12 text-muted d-block">{{ __('transaction.balance') }}</span>
                                @php
                                    $finalBalance =
                                        $openingBalance + ($transactions->sum('credit') - $transactions->sum('debit'));
                                @endphp
                                <span class="fs-15 fw-bold {{ $finalBalance >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($finalBalance, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ledger Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle m-0 fs-13">
                    <thead class="table-light">
                        <tr class="text-center align-middle">
                            <th rowspan="2" style="width: 60px;">ID</th>
                            <th rowspan="2" style="width: 100px;">{{ __('transaction.date') }}</th>
                            <th rowspan="2">{{ __('transaction.location') }} / {{ __('transaction.number') }}</th>
                            <th colspan="3" class="text-dark bg-opacity-10 bg-secondary">Base Currency</th>
                            <th colspan="2" class="text-success bg-opacity-10 bg-success">Rupees (PKR)</th>
                            <th colspan="2" class="text-primary bg-opacity-10 bg-primary">Dollar (USD)</th>
                            <th colspan="2" class="text-danger bg-opacity-10 bg-danger">Afghani (AFN)</th>
                        </tr>
                        <tr class="text-center">
                            <!-- Base -->
                            <th class="text-success">Credit</th>
                            <th class="text-danger">Debit</th>
                            <th>Balance</th>
                            <!-- Rupees -->
                            <th class="text-success">Cr</th>
                            <th class="text-danger">Dr</th>
                            <!-- Dollar -->
                            <th class="text-success">Cr</th>
                            <th class="text-danger">Dr</th>
                            <!-- Afghani -->
                            <th class="text-success">Cr</th>
                            <th class="text-danger">Dr</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Opening Balance Row -->
                        <tr class="table-secondary fw-bold text-dark">
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td>{{ __('account.opening_balance') }}</td>
                            <td class="text-end text-success">-</td>
                            <td class="text-end text-danger">-</td>
                            <td class="text-end font-monospace">{{ number_format($openingBalance, 2) }}</td>
                            <td class="text-center font-monospace" colspan="2">
                                Bal: {{ number_format($openingRupees, 2) }}
                            </td>
                            <td class="text-center font-monospace" colspan="2">
                                Bal: {{ number_format($openingDollar, 2) }}
                            </td>
                            <td class="text-center font-monospace" colspan="2">
                                Bal: {{ number_format($openingAfghani, 2) }}
                            </td>
                        </tr>

                        <!-- Transaction Rows -->
                        @php
                            $runningBalance = $openingBalance;
                            $runningRupees = $openingRupees;
                            $runningDollar = $openingDollar;
                            $runningAfghani = $openingAfghani;

                            $totalCredit = 0;
                            $totalDebit = 0;
                            $totalRupeesCr = 0;
                            $totalRupeesDr = 0;
                            $totalDollarCr = 0;
                            $totalDollarDr = 0;
                            $totalAfghaniCr = 0;
                            $totalAfghaniDr = 0;
                        @endphp
                        @forelse($transactions as $transaction)
                            @php
                                $runningBalance += $transaction->credit - $transaction->debit;
                                $runningRupees += $transaction->rupees_credit - $transaction->rupees_debit;
                                $runningDollar += $transaction->dollar_credit - $transaction->dollar_debit;
                                $runningAfghani += $transaction->afghani_credit - $transaction->afghani_debit;

                                $totalCredit += $transaction->credit;
                                $totalDebit += $transaction->debit;
                                $totalRupeesCr += $transaction->rupees_credit;
                                $totalRupeesDr += $transaction->rupees_debit;
                                $totalDollarCr += $transaction->dollar_credit;
                                $totalDollarDr += $transaction->dollar_debit;
                                $totalAfghaniCr += $transaction->afghani_credit;
                                $totalAfghaniDr += $transaction->afghani_debit;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $transaction->id }}</td>
                                <td class="text-center">{{ $transaction->date }}</td>
                                <td>
                                    @if ($transaction->location || $transaction->number)
                                        {{ $transaction->location ?? '-' }} / {{ $transaction->number ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <!-- Base -->
                                <td class="text-end text-success font-monospace">
                                    {{ number_format($transaction->credit, 2) }}</td>
                                <td class="text-end text-danger font-monospace">{{ number_format($transaction->debit, 2) }}
                                </td>
                                <td class="text-end fw-bold font-monospace">{{ number_format($runningBalance, 2) }}</td>
                                <!-- Rupees -->
                                <td class="text-end text-success font-monospace">
                                    {{ number_format($transaction->rupees_credit, 2) }}</td>
                                <td class="text-end text-danger font-monospace">
                                    {{ number_format($transaction->rupees_debit, 2) }}</td>
                                <!-- Dollar -->
                                <td class="text-end text-success font-monospace">
                                    {{ number_format($transaction->dollar_credit, 2) }}</td>
                                <td class="text-end text-danger font-monospace">
                                    {{ number_format($transaction->dollar_debit, 2) }}</td>
                                <!-- Afghani -->
                                <td class="text-end text-success font-monospace">
                                    {{ number_format($transaction->afghani_credit, 2) }}</td>
                                <td class="text-end text-danger font-monospace">
                                    {{ number_format($transaction->afghani_debit, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted py-4">No transactions found for the
                                    specified period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($transactions->isNotEmpty())
                        <tfoot class="table-light fw-bold text-dark border-top-2">
                            <tr>
                                <td colspan="3" class="text-end text-uppercase">{{ __('transaction.totals') }}:</td>
                                <td class="text-end text-success font-monospace">{{ number_format($totalCredit, 2) }}</td>
                                <td class="text-end text-danger font-monospace">{{ number_format($totalDebit, 2) }}</td>
                                <td class="text-end font-monospace">{{ number_format($runningBalance, 2) }}</td>
                                <!-- Rupees -->
                                <td class="text-end text-success font-monospace">{{ number_format($totalRupeesCr, 2) }}
                                </td>
                                <td class="text-end text-danger font-monospace">{{ number_format($totalRupeesDr, 2) }}</td>
                                <!-- Dollar -->
                                <td class="text-end text-success font-monospace">{{ number_format($totalDollarCr, 2) }}
                                </td>
                                <td class="text-end text-danger font-monospace">{{ number_format($totalDollarDr, 2) }}
                                </td>
                                <!-- Afghani -->
                                <td class="text-end text-success font-monospace">{{ number_format($totalAfghaniCr, 2) }}
                                </td>
                                <td class="text-end text-danger font-monospace">{{ number_format($totalAfghaniDr, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <!-- Statement Sign-off signatures -->
            <div class="row mt-5 pt-5 border-top text-center fs-12 text-muted signature-block">
                <div class="col-6">
                    <div style="border-bottom: 1px solid #ccc; width: 200px; margin: 0 auto 10px auto; height: 40px;">
                    </div>
                    Prepared By
                </div>
                <div class="col-6">
                    <div style="border-bottom: 1px solid #ccc; width: 200px; margin: 0 auto 10px auto; height: 40px;">
                    </div>
                    Customer Verification / Signature
                </div>
            </div>

        </div>
    </div>
@endsection
