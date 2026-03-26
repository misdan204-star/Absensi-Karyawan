<?php

namespace App\Http\Controllers;

use App\Models\FieldWorkReport;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FieldWorkReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $reports = FieldWorkReport::with('user')->orderBy('date', 'desc')->get();
        } else {
            $reports = FieldWorkReport::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        }

        return view('field_work.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('field_work.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'work_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'photo_before' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_after' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['photo_before', 'photo_after']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('photo_before')) {
            $data['photo_before'] = $request->file('photo_before')->store('field_work_photos', 'public');
        }

        if ($request->hasFile('photo_after')) {
            $data['photo_after'] = $request->file('photo_after')->store('field_work_photos', 'public');
        }

        FieldWorkReport::create($data);

        return redirect()->route('field-work.index')->with('success', 'Laporan pekerjaan lapangan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FieldWorkReport $fieldWorkReport)
    {
        if (Auth::user()->role !== 'admin' && $fieldWorkReport->user_id !== Auth::id()) {
            abort(403);
        }

        return view('field_work.show', ['report' => $fieldWorkReport]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FieldWorkReport $fieldWorkReport)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FieldWorkReport $fieldWorkReport)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FieldWorkReport $fieldWorkReport)
    {
        if (Auth::user()->role !== 'admin' && $fieldWorkReport->user_id !== Auth::id()) {
            abort(403);
        }

        if ($fieldWorkReport->photo_before) {
            Storage::disk('public')->delete($fieldWorkReport->photo_before);
        }
        if ($fieldWorkReport->photo_after) {
            Storage::disk('public')->delete($fieldWorkReport->photo_after);
        }

        $fieldWorkReport->delete();

        return redirect()->route('field-work.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
