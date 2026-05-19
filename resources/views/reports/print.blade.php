<!DOCTYPE html>
<html lang="{{ $currentLang ?? 'en' }}" dir="{{ $direction ?? 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('report.account_balances_report') }}</title>

    @if (($direction ?? 'ltr') === 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    @endif

    <style>
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body {
            background: #f4f6f9;
            color: #111827;
            font-size: 12px;
        }

        .print-toolbar {
            max-width: 1120px;
            margin: 16px auto;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .report-sheet {
            max-width: 1120px;
            margin: 0 auto 24px;
            background: #fff;
            border: 1px solid #d9dee7;
            padding: 24px;
        }

        .brand-title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: .4px;
            color: #0f172a;
            margin: 0;
        }

        .report-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .meta-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .meta-label {
            width: 120px;
            font-weight: 700;
            color: #374151;
        }

        .table-report {
            border: 1px solid #9ca3af;
            margin-bottom: 0;
        }

        .table-report th,
        .table-report td {
            border: 1px solid #9ca3af !important;
            padding: 7px 8px;
            vertical-align: middle;
        }

        .table-report thead th {
            background: #eef2f7 !important;
            color: #111827;
            font-weight: 700;
        }

        .table-report tfoot td {
            background: #f8fafc !important;
            font-weight: 800;
        }

        .amount {
            font-family: Consolas, Monaco, monospace;
            white-space: nowrap;
        }

        .signature-line {
            border-top: 1px solid #9ca3af;
            padding-top: 8px;
            min-width: 220px;
            display: inline-block;
        }

        @media print {
            body {
                background: #fff !important;
            }

            .print-toolbar {
                display: none !important;
            }

            .report-sheet {
                max-width: none;
                margin: 0;
                border: none;
                padding: 0;
            }

            .table-report th,
            .table-report td {
                padding: 5px 6px;
            }
        }
    </style>
</head>

<body>
    <div class="print-toolbar">
        <a href="{{ route('reports', request()->query()) }}" class="btn btn-secondary">
            {{ __('messages.back') }}
        </a>
        <button type="button" onclick="window.print()" class="btn btn-primary">
            {{ __('report.print_report') }}
        </button>
    </div>

    <main class="report-sheet">
        <header class="border-bottom pb-3 mb-3">
            <div class="row align-items-start">
                <div class="col-6">
                    <h1 class="brand-title">NEXGEN FOREX</h1>
                    <div class="text-muted">{{ __('account.premium_solutions') }}</div>
                </div>
                <div class="col-6 text-end">
                    <h2 class="report-title">{{ __('report.account_balances_report') }}</h2>
                    <table class="meta-table ms-auto mt-2">
                        <tr>
                            <td class="meta-label text-start">{{ __('account.generated_on') }}:</td>
                            <td class="text-start">{{ now()->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <td class="meta-label text-start">{{ __('account.area') }}:</td>
                            <td class="text-start">
                                {{ $showAllAreas ? __('report.all_areas') : $selectedAreaNames->implode(', ') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="meta-label text-start">{{ __('report.total_accounts') }}:</td>
                            <td class="text-start">{{ $accounts->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </header>

        <section class="mb-3">
            <div class="row g-2">
                <div class="col-3">
                    <div class="border p-2">
                        <div class="text-muted">{{ __('transaction.balance') }}</div>
                        <strong class="amount">{{ number_format($totals['balance'], 2, '.', ',') }}</strong>
                    </div>
                </div>
                <div class="col-3">
                    <div class="border p-2">
                        <div class="text-muted">{{ __('report.rupees_balance') }}</div>
                        <strong class="amount">{{ number_format($totals['rupees_balance'], 2, '.', ',') }}</strong>
                    </div>
                </div>
                <div class="col-3">
                    <div class="border p-2">
                        <div class="text-muted">{{ __('report.dollar_balance') }}</div>
                        <strong class="amount">{{ number_format($totals['dollar_balance'], 2, '.', ',') }}</strong>
                    </div>
                </div>
                <div class="col-3">
                    <div class="border p-2">
                        <div class="text-muted">{{ __('report.afghani_balance') }}</div>
                        <strong class="amount">{{ number_format($totals['afghani_balance'], 2, '.', ',') }}</strong>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <table class="table table-report">
                <thead>
                    <tr>
                        <th style="width: 12%;">{{ __('account.code') }}</th>
                        <th style="width: 22%;">{{ __('account.name') }}</th>
                        <th style="width: 18%;">{{ __('account.area') }}</th>
                        <th class="text-end">{{ __('transaction.balance') }}</th>
                        <th class="text-end">{{ __('report.rupees_balance') }}</th>
                        <th class="text-end">{{ __('report.dollar_balance') }}</th>
                        <th class="text-end">{{ __('report.afghani_balance') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($accounts as $account)
                        <tr>
                            <td>{{ $account->code }}</td>
                            <td>{{ $account->name }}</td>
                            <td>{{ $account->assignedArea?->name ?? ($account->area ?: '-') }}</td>
                            <td class="text-end amount">{{ number_format($account->balance, 2, '.', ',') }}</td>
                            <td class="text-end amount">{{ number_format($account->rupees_balance, 2, '.', ',') }}</td>
                            <td class="text-end amount">{{ number_format($account->dollar_balance, 2, '.', ',') }}</td>
                            <td class="text-end amount">{{ number_format($account->afghani_balance, 2, '.', ',') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">{{ __('report.no_accounts_found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($accounts->isNotEmpty())
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end">{{ __('transaction.totals') }}:</td>
                            <td class="text-end amount">{{ number_format($totals['balance'], 2, '.', ',') }}</td>
                            <td class="text-end amount">{{ number_format($totals['rupees_balance'], 2, '.', ',') }}
                            </td>
                            <td class="text-end amount">{{ number_format($totals['dollar_balance'], 2, '.', ',') }}
                            </td>
                            <td class="text-end amount">{{ number_format($totals['afghani_balance'], 2, '.', ',') }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </section>

        <footer class="row mt-5 pt-4 text-center">
            <div class="col-6">
                <span class="signature-line">{{ __('account.prepared_by') }}</span>
            </div>
            <div class="col-6">
                <span class="signature-line">{{ __('account.customer_signature') }}</span>
            </div>
        </footer>
    </main>
</body>

</html>
