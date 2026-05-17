<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = accounts::orderBy('created_at', 'desc')->paginate(10);
        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:accounts',
            'name' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'contact' => 'nullable|string|max:255',
        ]);

        accounts::create($request->all());

        return redirect()->route('accounts.index')->with('success', __('account.account_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(accounts $account)
    {
        return view('accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(accounts $account)
    {
        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, accounts $account)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:accounts,code,' . $account->id,
            'name' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'contact' => 'nullable|string|max:255',
        ]);

        $account->update($request->all());

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
}