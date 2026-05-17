<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\Area;
use App\Models\Transactions;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = accounts::with('assignedArea')->orderBy('created_at', 'desc')->paginate(10);

        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::orderBy('name')->get();

        return view('accounts.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:accounts',
            'name' => 'required|string|max:255',
            'area_id' => 'nullable|exists:areas,id',
            'address' => 'nullable|string',
            'contact' => 'nullable|string|max:255',
        ]);

        $area = Area::find($request->area_id);

        accounts::create([
            'code' => $request->code,
            'name' => $request->name,
            'area_id' => $area?->id,
            'area' => $area?->name ?? '',
            'address' => $request->address ?? '',
            'contact' => $request->contact ?? '',
        ]);

        return redirect()->route('accounts.index')->with('success', __('account.account_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(accounts $account)
    {
        $account->load('assignedArea');

        return view('accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(accounts $account)
    {
        $areas = Area::orderBy('name')->get();

        return view('accounts.edit', compact('account', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, accounts $account)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:accounts,code,'.$account->id,
            'name' => 'required|string|max:255',
            'area_id' => 'nullable|exists:areas,id',
            'address' => 'nullable|string',
            'contact' => 'nullable|string|max:255',
        ]);

        $area = Area::find($request->area_id);

        $account->update([
            'code' => $request->code,
            'name' => $request->name,
            'area_id' => $area?->id,
            'area' => $area?->name ?? '',
            'address' => $request->address ?? '',
            'contact' => $request->contact ?? '',
        ]);

        return redirect()->route('accounts.index')->with('success', __('account.account_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(accounts $account)
    {
        $account->delete();

        return redirect()->route('accounts.index')->with('success', __('account.account_deleted'));
    }

    /**
     * Get the balance of the specified account.
     */
    public function getBalance(accounts $account)
    {
        $creditSum = Transactions::where('account_id', $account->id)->sum('credit');
        $debitSum = Transactions::where('account_id', $account->id)->sum('debit');
        $balance = $creditSum - $debitSum;

        return response()->json([
            'balance' => number_format($balance, 2, '.', ''),
        ]);
    }

    /**
     * View detailed account statement with date range filtering.
     */
    public function statement(Request $request, accounts $account)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Calculate opening balances (all transactions before start_date)
        $openingBalance = 0;
        $openingRupees = 0;
        $openingDollar = 0;
        $openingAfghani = 0;

        if ($startDate) {
            $prevCredit = Transactions::where('account_id', $account->id)->where('date', '<', $startDate)->sum('credit');
            $prevDebit = Transactions::where('account_id', $account->id)->where('date', '<', $startDate)->sum('debit');
            $openingBalance = $prevCredit - $prevDebit;

            $prevRupeesCredit = Transactions::where('account_id', $account->id)->where('date', '<', $startDate)->sum('rupees_credit');
            $prevRupeesDebit = Transactions::where('account_id', $account->id)->where('date', '<', $startDate)->sum('rupees_debit');
            $openingRupees = $prevRupeesCredit - $prevRupeesDebit;

            $prevDollarCredit = Transactions::where('account_id', $account->id)->where('date', '<', $startDate)->sum('dollar_credit');
            $prevDollarDebit = Transactions::where('account_id', $account->id)->where('date', '<', $startDate)->sum('dollar_debit');
            $openingDollar = $prevDollarCredit - $prevDollarDebit;

            $prevAfghaniCredit = Transactions::where('account_id', $account->id)->where('date', '<', $startDate)->sum('afghani_credit');
            $prevAfghaniDebit = Transactions::where('account_id', $account->id)->where('date', '<', $startDate)->sum('afghani_debit');
            $openingAfghani = $prevAfghaniCredit - $prevAfghaniDebit;
        }

        // Fetch filtered transactions chronologically
        $query = Transactions::where('account_id', $account->id);

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        $transactions = $query->orderBy('date')->orderBy('id')->get();

        return view('accounts.statement', compact(
            'account',
            'transactions',
            'startDate',
            'endDate',
            'openingBalance',
            'openingRupees',
            'openingDollar',
            'openingAfghani'
        ));
    }
}
