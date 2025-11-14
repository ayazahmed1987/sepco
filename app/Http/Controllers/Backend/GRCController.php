<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\GRCRequest;
use App\Models\Grc;
use Exception;

class GRCController extends Controller
{
    public function index()
    {
        try {
            $grcs = Grc::all();
            return view('backend.tenders.grc.index', compact('grcs'));
        } catch (Exception $e) {
            return back()->with('error','Failed to fetch GRCs');
        }
    }

    public function create()
    {
        try {
            return view('backend.tenders.grc.create');
        } catch (Exception $e) {
            return back()->with('error','Failed to open GRC page!');
        }
    }

    public function store(GRCRequest $request)
    {
        try {
            Grc::create($request->validated());
            return redirect()->back()->with('success', 'GRC created successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to create GRC: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $grc = Grc::findOrFail($id);
            return view('backend.tenders.grc.edit', compact('grc'));
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to find GRC: ' . $e->getMessage()]);
        }
    }

    public function update(GRCRequest $request, $id)
    {
        try {
            $grc = Grc::findOrFail($id);
            $grc->update($request->validated());
            return redirect()->route('manager.grcs.index')->with('success', 'GRC updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update GRC');
        }
    }

    public function destroy($id)
    {
        try {
            $grc = Grc::findOrFail($id);
            $grc->delete();
            return redirect()->back()->with('success', 'GRC deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete GRC');
        }
    }
}
