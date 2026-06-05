@extends('layout.app')
@section('content')
    <style>
        @media print {

            .header,
            .sidebar,
            .page-header,
            .report-filter-card,
            .report-print-action,
            .copyright-footer,
            .whirly-loader,
            #global-loader {
                display: none !important;
            }

            .page-wrapper,
            .content {
                margin: 0 !important;
                padding: 0 !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
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
        }
    </style>

    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('report.account_balances_report') }}</h4>
        </div>
        <div class="page-btn report-print-action">
            <a href="{{ route('reports.print', request()->query()) }}" target="_blank" class="btn btn-primary">
                <i class="ti ti-printer me-1"></i>{{ __('report.print_report') }}
            </a>
        </div>
    </div>

    <div class="card report-filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('reports') }}">
                <div class="row align-items-end g-3">
                    <div class="col-lg-3">
                        <div class="form-check form-check-lg mt-4">
                            <input type="checkbox" name="all_areas" value="1" id="all_areas" class="form-check-input"
                                @checked($showAllAreas)>
                            <label for="all_areas" class="form-check-label fw-bold">{{ __('report.all_areas') }}</label>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <label for="area_ids" class="form-label fw-bold">{{ __('report.select_areas') }}</label>
                        <select name="area_ids[]" id="area_ids" class="form-select" multiple @disabled($showAllAreas)>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}" @selected(!$showAllAreas && in_array((string) $area->id, $selectedAreas, true))>
                                    {{ $area->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex gap-2 justify-content-lg-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-filter me-1"></i>{{ __('report.generate_report') }}
                            </button>
                            <a href="{{ route('reports') }}" class="btn btn-secondary">
                                <i class="ti ti-refresh me-1"></i>{{ __('transaction.reset') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <h5 class="mb-0">{{ __('report.account_details') }}</h5>
            <span class="badge bg-light text-dark">
                {{ $showAllAreas ? __('report.all_areas') : __('report.selected_areas') }}:
                {{ $accounts->count() }}
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('account.code') }}</th>
                            <th>{{ __('account.name') }}</th>
                            <th>{{ __('account.area') }}</th>
                            <th class="text-end">{{ __('transaction.credit') }}</th>
                            <th class="text-end">{{ __('transaction.debit') }}</th>
                            <th class="text-end">{{ __('transaction.balance') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td><code>{{ $account->code }}</code></td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->assignedArea?->name ?? ($account->area ?: '-') }}</td>
                                <td class="text-end fw-bold font-monospace text-success">
                                    {{ number_format($account->credit_total, 2, '.', ',') }}
                                </td>
                                <td class="text-end fw-bold font-monospace text-danger">
                                    {{ number_format($account->debit_total, 2, '.', ',') }}
                                </td>
                                <td
                                    class="text-end font-monospace {{ $account->balance >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($account->balance, 2, '.', ',') }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    @if ($accounts->isNotEmpty())
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="3" class="text-end">{{ __('transaction.totals') }}:</td>
                                <td class="text-end font-monospace">
                                    {{ number_format($totals['credit_total'], 2, '.', ',') }}
                                <td class="text-end font-monospace">
                                    {{ number_format($totals['debit_total'], 2, '.', ',') }}
                                <td class="text-end font-monospace">
                                    {{ number_format($totals['balance'], 2, '.', ',') }}
                                </td>

                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allAreas = document.getElementById('all_areas');
            const areaSelect = document.getElementById('area_ids');

            allAreas.addEventListener('change', function() {
                areaSelect.disabled = allAreas.checked;

                if (allAreas.checked) {
                    Array.from(areaSelect.options).forEach(option => option.selected = false);
                }
            });
        });
    </script>
@endsection
