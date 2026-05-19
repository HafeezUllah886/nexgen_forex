<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $query = Transactions::with('account');

        // Apply filters
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->input('end_date'));
        }
        if ($request->filled('account_id')) {
            $query->where('account_id', $request->input('account_id'));
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->input('location').'%');
        }

        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $accounts = accounts::all();

        return view('transactions.history', compact('transactions', 'accounts'));
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
        $descriptions = $request->input('description');

        \DB::transaction(function () use (
            $dates, $accounts, $locations, $numbers, $credits, $debits,
            $rupeesCredits, $rupeesDebits, $dollarCredits, $dollarDebits,
            $afghaniCredits, $afghaniDebits, $descriptions
        ) {
            foreach ($accounts as $index => $accountId) {
                Transactions::create([
                    'account_id' => $accountId,
                    'user_id' => auth()->id(),
                    'date' => $dates[$index],
                    'location' => $locations[$index] ?? null,
                    'number' => $numbers[$index] ?? null,
                    'description' => $descriptions[$index] ?? null,
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
    public function update(Request $request, Transactions $transaction)
    {
        $request->validate([
            'date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'location' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:255',
            'credit' => 'nullable|numeric',
            'debit' => 'nullable|numeric',
            'rupees_credit' => 'nullable|numeric',
            'rupees_debit' => 'nullable|numeric',
            'dollar_credit' => 'nullable|numeric',
            'dollar_debit' => 'nullable|numeric',
            'afghani_credit' => 'nullable|numeric',
            'afghani_debit' => 'nullable|numeric',
        ]);

        $transaction->update([
            'date' => $request->input('date'),
            'account_id' => $request->input('account_id'),
            'location' => $request->input('location'),
            'number' => $request->input('number'),
            'credit' => $request->input('credit') ?? 0,
            'debit' => $request->input('debit') ?? 0,
            'rupees_credit' => $request->input('rupees_credit') ?? 0,
            'rupees_debit' => $request->input('rupees_debit') ?? 0,
            'dollar_credit' => $request->input('dollar_credit') ?? 0,
            'dollar_debit' => $request->input('dollar_debit') ?? 0,
            'afghani_credit' => $request->input('afghani_credit') ?? 0,
            'afghani_debit' => $request->input('afghani_debit') ?? 0,
            'description' => $request->input('description') ?? null,
        ]);

        return redirect()->route('transactions.history')->with('success', __('transaction.transaction_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transactions $transaction)
    {
        $request = request();
        $request->validate([
            'password' => 'required|string',
        ]);

        if (! \Hash::check($request->input('password'), auth()->user()->password)) {
            return back()->withErrors(['password' => __('transaction.incorrect_password')]);
        }

        $transaction->delete();

        return redirect()->route('transactions.history')->with('success', __('transaction.transaction_deleted'));
    }
}
