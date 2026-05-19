@extends('layout.app')

@section('content')
    <style>
        .dashboard-hero {
            background: linear-gradient(135deg, #10233f 0%, #1d5145 52%, #7a4d16 100%);
            color: #fff;
            border-radius: 8px;
            padding: 22px;
            margin-bottom: 20px;
        }

        .dashboard-hero h4,
        .dashboard-hero p {
            color: #fff;
        }

        .metric-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
            padding: 16px;
            height: 100%;
        }

        .metric-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            flex: 0 0 42px;
        }

        .metric-value {
            font-size: 22px;
            font-weight: 800;
            color: #111827;
            line-height: 1.2;
        }

        .metric-label {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .dashboard-panel {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
        }

        .dashboard-panel .panel-header {
            padding: 16px 18px;
            border-bottom: 1px solid #eef0f4;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .dashboard-panel .panel-body {
            padding: 18px;
        }

        .currency-tile {
            border: 1px solid #edf0f4;
            border-radius: 8px;
            padding: 14px;
            min-height: 94px;
        }

        .progress-thin {
            height: 6px;
        }

        .quick-action {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #111827;
            background: #fff;
        }

        .quick-action:hover {
            border-color: #2563eb;
            color: #2563eb;
        }

        .amount {
            font-family: Consolas, Monaco, monospace;
            white-space: nowrap;
        }
    </style>

    <div class="dashboard-hero">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <h4 class="mb-1">{{ __('dashboard.welcome_title') }}</h4>
                <p class="mb-0">{{ __('dashboard.welcome_subtitle') }}</p>
            </div>
            <div class="col-lg-4">
                <div class="d-flex gap-2 justify-content-lg-end">
                    <a href="{{ route('transactions.create') }}" class="btn btn-light"
                        target="nexgen_create_transaction"
                        onclick="window.open(this.href, 'nexgen_create_transaction', 'width=1600,height=900,noopener,noreferrer,scrollbars=yes,resizable=yes'); return false;">
                        <i class="ti ti-plus me-1"></i>{{ __('messages.create_transaction') }}
                    </a>
                    <a href="{{ route('reports') }}" class="btn btn-outline-light">
                        <i class="ti ti-chart-bar me-1"></i>{{ __('messages.reports') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <div class="metric-label">{{ __('dashboard.total_accounts') }}</div>
                        <div class="metric-value">{{ number_format($totalAccounts) }}</div>
                    </div>
                    <span class="metric-icon" style="background:#2563eb;"><i class="ti ti-wallet"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <div class="metric-label">{{ __('dashboard.ledger_balance') }}</div>
                        <div class="metric-value amount">{{ number_format($ledger['balance'], 2, '.', ',') }}</div>
                    </div>
                    <span class="metric-icon" style="background:#059669;"><i class="ti ti-scale"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <div class="metric-label">{{ __('dashboard.today_transactions') }}</div>
                        <div class="metric-value">{{ number_format($todayTransactions) }}</div>
                    </div>
                    <span class="metric-icon" style="background:#b45309;"><i class="ti ti-calendar-stats"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <div class="metric-label">{{ __('dashboard.total_areas') }}</div>
                        <div class="metric-value">{{ number_format($totalAreas) }}</div>
                    </div>
                    <span class="metric-icon" style="background:#7c3aed;"><i class="ti ti-map-pin"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-xl-8">
            <div class="dashboard-panel h-100">
                <div class="panel-header">
                    <div>
                        <h5 class="mb-1">{{ __('dashboard.monthly_activity') }}</h5>
                        <span class="text-muted fs-13">{{ __('dashboard.monthly_activity_subtitle') }}</span>
                    </div>
                    <span class="badge bg-light text-dark">{{ number_format($monthlyTransactions) }}
                        {{ __('messages.transactions') }}</span>
                </div>
                <div class="panel-body">
                    <div id="monthlyActivityChart" style="min-height: 310px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="dashboard-panel h-100">
                <div class="panel-header">
                    <h5 class="mb-0">{{ __('dashboard.currency_position') }}</h5>
                </div>
                <div class="panel-body">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="currency-tile">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted">{{ __('report.rupees_balance') }}</span>
                                    <i class="ti ti-currency-rupee text-success fs-20"></i>
                                </div>
                                <div class="fw-bold fs-18 amount mt-2">{{ number_format($ledger['rupees'], 2, '.', ',') }}</div>
                                <div class="text-muted fs-12">{{ __('dashboard.this_month') }}:
                                    {{ number_format($monthlyCurrency['rupees'], 2, '.', ',') }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="currency-tile">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted">{{ __('report.dollar_balance') }}</span>
                                    <i class="ti ti-currency-dollar text-primary fs-20"></i>
                                </div>
                                <div class="fw-bold fs-18 amount mt-2">{{ number_format($ledger['dollar'], 2, '.', ',') }}</div>
                                <div class="text-muted fs-12">{{ __('dashboard.this_month') }}:
                                    {{ number_format($monthlyCurrency['dollar'], 2, '.', ',') }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="currency-tile">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted">{{ __('report.afghani_balance') }}</span>
                                    <i class="ti ti-cash text-danger fs-20"></i>
                                </div>
                                <div class="fw-bold fs-18 amount mt-2">{{ number_format($ledger['afghani'], 2, '.', ',') }}</div>
                                <div class="text-muted fs-12">{{ __('dashboard.this_month') }}:
                                    {{ number_format($monthlyCurrency['afghani'], 2, '.', ',') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-xl-7">
            <div class="dashboard-panel h-100">
                <div class="panel-header">
                    <h5 class="mb-0">{{ __('dashboard.recent_transactions') }}</h5>
                    <a href="{{ route('transactions.history') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('messages.view') }}
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('transaction.date') }}</th>
                                <th>{{ __('transaction.account') }}</th>
                                <th>{{ __('transaction.description') }}</th>
                                <th class="text-end">{{ __('transaction.credit') }}</th>
                                <th class="text-end">{{ __('transaction.debit') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->account?->name ?? '-' }}</td>
                                    <td>{{ $transaction->description ?: '-' }}</td>
                                    <td class="text-end text-success amount">{{ number_format($transaction->credit, 2, '.', ',') }}</td>
                                    <td class="text-end text-danger amount">{{ number_format($transaction->debit, 2, '.', ',') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">{{ __('dashboard.no_recent_transactions') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="dashboard-panel h-100">
                <div class="panel-header">
                    <h5 class="mb-0">{{ __('dashboard.top_accounts') }}</h5>
                </div>
                <div class="panel-body">
                    @forelse ($topAccounts as $account)
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                            <div>
                                <div class="fw-bold">{{ $account->name }}</div>
                                <div class="text-muted fs-12">{{ $account->code }} · {{ $account->assignedArea?->name ?? ($account->area ?: '-') }}</div>
                            </div>
                            <div class="fw-bold amount {{ $account->balance >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($account->balance, 2, '.', ',') }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">{{ __('account.no_accounts') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="dashboard-panel h-100">
                <div class="panel-header">
                    <h5 class="mb-0">{{ __('dashboard.area_overview') }}</h5>
                </div>
                <div class="panel-body">
                    @forelse ($areaSummary as $area)
                        @php
                            $percentage = $totalAccounts > 0 ? round(($area->accounts_count / $totalAccounts) * 100) : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold">{{ $area->name }}</span>
                                <span class="text-muted">{{ $area->accounts_count }} {{ __('messages.accounts') }}</span>
                            </div>
                            <div class="progress progress-thin">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentage }}%;"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">{{ __('account.no_areas') }}</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="dashboard-panel h-100">
                <div class="panel-header">
                    <h5 class="mb-0">{{ __('dashboard.quick_actions') }}</h5>
                </div>
                <div class="panel-body d-grid gap-2">
                    <a href="{{ route('accounts.create') }}" class="quick-action">
                        <i class="ti ti-user-plus fs-20 text-primary"></i>
                        <span>{{ __('account.add_new_account') }}</span>
                    </a>
                    <a href="{{ route('transactions.history') }}" class="quick-action">
                        <i class="ti ti-history fs-20 text-warning"></i>
                        <span>{{ __('messages.transaction_history') }}</span>
                    </a>
                    <a href="{{ route('reports.print') }}" target="_blank" class="quick-action">
                        <i class="ti ti-printer fs-20 text-success"></i>
                        <span>{{ __('report.print_report') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartElement = document.querySelector('#monthlyActivityChart');

            if (!chartElement || typeof ApexCharts === 'undefined') {
                return;
            }

            const chart = new ApexCharts(chartElement, {
                chart: {
                    type: 'area',
                    height: 310,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                series: [{
                    name: @json(__('transaction.credit')),
                    data: @json($chartCredit)
                }, {
                    name: @json(__('transaction.debit')),
                    data: @json($chartDebit)
                }],
                xaxis: {
                    categories: @json($chartLabels),
                    labels: {
                        rotate: -45
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                colors: ['#059669', '#dc2626'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.22,
                        opacityTo: 0.03,
                        stops: [0, 90, 100]
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return Number(value).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                }
            });

            chart.render();
        });
    </script>
@endsection
