<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LeaveController extends Controller
{
    // List pengajuan untuk Karyawan
    public function index()
    {
        $requests = LeaveRequest::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('leave.index', compact('requests'));
    }

    // Form Pengajuan
    public function create()
    {
        return view('leave.create');
    }

    // Simpan Pengajuan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:izin,cuti,sakit,dinas,dispensasi',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
            'evidence' => 'nullable|image|max:2048', // 2MB max
        ]);

        // 1. Validasi: Tanggal mulai tidak boleh di masa lalu (kecuali sakit/izin mendesak)
        if (in_array($validated['type'], ['cuti', 'dinas']) && 
            now()->startOfDay()->greaterThan(Carbon::parse($validated['start_date']))) {
            return back()->withErrors(['start_date' => 'Untuk cuti/dinas, tanggal mulai tidak boleh di masa lalu.'])->withInput();
        }

        // 2. Validasi: Cegah pengajuan tumpang tindih (Overlap)
        $overlap = LeaveRequest::where('user_id', auth()->id())
            ->where('status', '!=', 'rejected')
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhere(function($q) use ($validated) {
                          $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                      });
            })->exists();

        if ($overlap) {
            return back()->withErrors(['start_date' => 'Anda sudah memiliki pengajuan izin/cuti pada rentang tanggal tersebut.'])->withInput();
        }

        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('evidence', 'public');
        }

        LeaveRequest::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'],
            'evidence_path' => $evidencePath,
            'status' => 'pending'
        ]);

        return redirect()->route('leave.index')->with('success', 'Pengajuan berhasil dikirim!');
    }

    // List pengajuan untuk Admin
    public function adminIndex()
    {
        $requests = LeaveRequest::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.leave.index', compact('requests'));
    }

    // Update Status (Approve/Reject)
    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $leaveRequest->update([
            'status' => $validated['status']
        ]);

        return back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }
}
