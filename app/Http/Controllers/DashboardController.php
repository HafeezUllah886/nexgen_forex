<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\Area;
use App\Models\Transactions;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $monthStart = $today->copy()->startOfMonth();

        $totalAccounts = accounts::count();
        $totalAreas = Area::count();
        $todayTransactions = Transactions::whereDate('date', $today)->count();
        $monthlyTransactions = Transactions::whereBetween('date', [$monthStart, $today])->count();

        $ledger = [
            'credit' => Transactions::sum('credit'),
            'debit' => Transactions::sum('debit'),
            'balance' => Transactions::sum('credit') - Transactions::sum('debit'),
            'rupees' => Transactions::sum('rupees_credit') - Transactions::sum('rupees_debit'),
            'dollar' => Transactions::sum('dollar_credit') - Transactions::sum('dollar_debit'),
            'afghani' => Transactions::sum('afghani_credit') - Transactions::sum('afghani_debit'),
        ];

        $monthlyCurrency = [
            'rupees' => Transactions::whereBetween('date', [$monthStart, $today])->sum('rupees_credit')
                - Transactions::whereBetween('date', [$monthStart, $today])->sum('rupees_debit'),
            'dollar' => Transactions::whereBetween('date', [$monthStart, $today])->sum('dollar_credit')
                - Transactions::whereBetween('date', [$monthStart, $today])->sum('dollar_debit'),
            'afghani' => Transactions::whereBetween('date', [$monthStart, $today])->sum('afghani_credit')
                - Transactions::whereBetween('date', [$monthStart, $today])->sum('afghani_debit'),
        ];

        $recentTransactions = Transactions::with('account')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $topAccounts = accounts::query()
            ->with('assignedArea')
            ->withSum('transactions as credit_total', 'credit')
            ->withSum('transactions as debit_total', 'debit')
            ->get()
            ->map(function ($account) {
                $account->balance = ($account->credit_total ?? 0) - ($account->debit_total ?? 0);

                return $account;
            })
            ->sortByDesc(fn ($account) => abs($account->balance))
            ->take(5)
            ->values();

        $areaSummary = Area::withCount('accounts')
            ->orderByDesc('accounts_count')
            ->limit(5)
            ->get();

        $chartLabels = [];
        $chartCredit = [];
        $chartDebit = [];

        for ($day = $monthStart->copy(); $day->lte($today); $day->addDay()) {
            $chartLabels[] = $day->format('M d');
            $chartCredit[] = (float) Transactions::whereDate('date', $day)->sum('credit');
            $chartDebit[] = (float) Transactions::whereDate('date', $day)->sum('debit');
        }

        return view('dashboard.index', compact(
            'totalAccounts',
            'totalAreas',
            'todayTransactions',
            'monthlyTransactions',
            'ledger',
            'monthlyCurrency',
            'recentTransactions',
            'topAccounts',
            'areaSummary',
            'chartLabels',
            'chartCredit',
            'chartDebit'
        ));
    }
}
