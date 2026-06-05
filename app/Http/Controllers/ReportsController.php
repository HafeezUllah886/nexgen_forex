<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\Area;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.index', $this->reportData($request));
    }

    public function print(Request $request)
    {
        return view('reports.print', $this->reportData($request));
    }

    private function reportData(Request $request): array
    {
        $areas = Area::orderBy('name')->get();
        $selectedAreas = collect($request->input('area_ids', []))
            ->filter(fn ($areaId) => $areaId !== null && $areaId !== '')
            ->values()
            ->all();

        $hasAreaFilter = $request->has('all_areas') || $request->has('area_ids');
        $showAllAreas = ! $hasAreaFilter || $request->boolean('all_areas') || empty($selectedAreas);

        $accountsQuery = accounts::query()
            ->with('assignedArea')
            ->withSum('transactions as credit_total', 'credit')
            ->withSum('transactions as debit_total', 'debit')
            ->withSum('transactions as rupees_credit_total', 'rupees_credit')
            ->withSum('transactions as rupees_debit_total', 'rupees_debit')
            ->withSum('transactions as dollar_credit_total', 'dollar_credit')
            ->withSum('transactions as dollar_debit_total', 'dollar_debit')
            ->withSum('transactions as afghani_credit_total', 'afghani_credit')
            ->withSum('transactions as afghani_debit_total', 'afghani_debit')
            ->orderBy('code');

        if (! $showAllAreas) {
            $accountsQuery->whereIn('area_id', $selectedAreas);
        }

        $accounts = $accountsQuery->get()->map(function ($account) {
            $account->balance = ($account->credit_total ?? 0) - ($account->debit_total ?? 0);
            $account->rupees_balance = ($account->rupees_credit_total ?? 0) - ($account->rupees_debit_total ?? 0);
            $account->dollar_balance = ($account->dollar_credit_total ?? 0) - ($account->dollar_debit_total ?? 0);
            $account->afghani_balance = ($account->afghani_credit_total ?? 0) - ($account->afghani_debit_total ?? 0);

            return $account;
        });

        $totals = [
            'balance' => $accounts->sum('balance'),
            'credit_total' => $accounts->sum('credit_total'),
            'debit_total' => $accounts->sum('debit_total'),
            'rupees_balance' => $accounts->sum('rupees_balance'),
            'dollar_balance' => $accounts->sum('dollar_balance'),
            'afghani_balance' => $accounts->sum('afghani_balance'),
        ];

        $selectedAreaNames = $showAllAreas
            ? collect()
            : $areas->whereIn('id', array_map('intval', $selectedAreas))->pluck('name')->values();

        return compact('areas', 'selectedAreas', 'showAllAreas', 'accounts', 'totals', 'selectedAreaNames');
    }
}
