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
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-striped">
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
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
                                    <span class="text-success">{{ number_format($transaction->rupees_credit, 2) }}</span> /
                                    <span class="text-danger">{{ number_format($transaction->rupees_debit, 2) }}</span>
                                </td>
                                <td>
                                    <span class="text-success">{{ number_format($transaction->dollar_credit, 2) }}</span> /
                                    <span class="text-danger">{{ number_format($transaction->dollar_debit, 2) }}</span>
                                </td>
                                <td>
                                    <span class="text-success">{{ number_format($transaction->afghani_credit, 2) }}</span>
                                    /
                                    <span class="text-danger">{{ number_format($transaction->afghani_debit, 2) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    {{ __('messages.no_data') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection
