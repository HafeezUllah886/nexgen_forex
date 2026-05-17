<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\accounts;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:areas,name',
        ]);

        Area::create($request->only('name'));

        return back()->with('success', 'Area created successfully.');
    }

    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:areas,name,' . $area->id,
        ]);

        $area->update($request->only('name'));
        accounts::where('area_id', $area->id)->update(['area' => $area->name]);

        return back()->with('success', 'Area updated successfully.');
    }
}
