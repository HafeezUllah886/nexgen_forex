<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\Area;
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
            'code' => 'required|string|max:255|unique:accounts,code,' . $account->id,
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
}
