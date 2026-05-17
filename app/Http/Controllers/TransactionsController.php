<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transactions::with('account')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('transactions.history', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = accounts::all();

        return view('transactions.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|array',
            'date.*' => 'required|date',
            'account' => 'required|array',
            'account.*' => 'required|exists:accounts,id',
            'location' => 'nullable|array',
            'location.*' => 'nullable|string|max:255',
            'number' => 'nullable|array',
            'number.*' => 'nullable|string|max:255',
            'credit' => 'nullable|array',
            'credit.*' => 'nullable|numeric',
            'debit' => 'nullable|array',
            'debit.*' => 'nullable|numeric',
            'rupees_credit' => 'nullable|array',
            'rupees_credit.*' => 'nullable|numeric',
            'rupees_debit' => 'nullable|array',
            'rupees_debit.*' => 'nullable|numeric',
            'dollar_credit' => 'nullable|array',
            'dollar_credit.*' => 'nullable|numeric',
            'dollar_debit' => 'nullable|array',
            'dollar_debit.*' => 'nullable|numeric',
            'afghani_credit' => 'nullable|array',
            'afghani_credit.*' => 'nullable|numeric',
            'afghani_debit' => 'nullable|array',
            'afghani_debit.*' => 'nullable|numeric',
        ]);

        $dates = $request->input('date');
        $accounts = $request->input('account');
        $locations = $request->input('location');
        $numbers = $request->input('number');
        $credits = $request->input('credit');
        $debits = $request->input('debit');
        $rupeesCredits = $request->input('rupees_credit');
        $rupeesDebits = $request->input('rupees_debit');
        $dollarCredits = $request->input('dollar_credit');
        $dollarDebits = $request->input('dollar_debit');
        $afghaniCredits = $request->input('afghani_credit');
        $afghaniDebits = $request->input('afghani_debit');

        \DB::transaction(function () use (
            $dates, $accounts, $locations, $numbers, $credits, $debits,
            $rupeesCredits, $rupeesDebits, $dollarCredits, $dollarDebits,
            $afghaniCredits, $afghaniDebits
        ) {
            foreach ($accounts as $index => $accountId) {
                Transactions::create([
                    'account_id' => $accountId,
                    'user_id' => auth()->id(),
                    'date' => $dates[$index],
                    'location' => $locations[$index] ?? null,
                    'number' => $numbers[$index] ?? null,
                    'credit' => $credits[$index] ?? 0,
                    'debit' => $debits[$index] ?? 0,
                    'rupees_credit' => $rupeesCredits[$index] ?? 0,
                    'rupees_debit' => $rupeesDebits[$index] ?? 0,
                    'dollar_credit' => $dollarCredits[$index] ?? 0,
                    'dollar_debit' => $dollarDebits[$index] ?? 0,
                    'afghani_credit' => $afghaniCredits[$index] ?? 0,
                    'afghani_debit' => $afghaniDebits[$index] ?? 0,
                ]);
            }
        });

        return redirect()->route('transactions.create')->with('success', __('transaction.transactions_stored'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transactions $transactions)
    {
        //
    }
}
