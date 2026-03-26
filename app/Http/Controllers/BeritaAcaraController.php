<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use Illuminate\Http\Request;

use App\Models\FieldWorkReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class BeritaAcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $bas = BeritaAcara::with('fieldWorkReport.user')->latest()->get();
        } else {
            $bas = BeritaAcara::whereHas('fieldWorkReport', function($q) {
                $q->where('user_id', Auth::id());
            })->with('fieldWorkReport')->latest()->get();
        }

        return view('berita_acara.index', compact('bas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $reportId = $request->get('report_id');
        $report = FieldWorkReport::findOrFail($reportId);

        // Check ownership
        if (!Auth::user()->isAdmin() && $report->user_id != Auth::id()) {
            abort(403);
        }

        // Auto generate BA number
        $year = date('Y');
        $month = date('m');
        $count = BeritaAcara::whereYear('created_at', $year)->count() + 1;
        $ba_number = "BA/NST/{$year}/{$month}/" . str_pad($count, 4, '0', STR_PAD_LEFT);

        return view('berita_acara.create', compact('report', 'ba_number'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ba_number' => 'required|string|unique:berita_acaras',
            'field_work_report_id' => 'required|exists:field_work_reports,id',
            'client_name' => 'required|string|max:255',
            'date' => 'required|date',
            'signature' => 'nullable|string', // Could be base64 if using signature pad
        ]);

        $ba = BeritaAcara::create($request->all());

        return redirect()->route('berita-acara.index')->with('success', 'Berita Acara berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BeritaAcara $beritaAcara)
    {
        $beritaAcara->load('fieldWorkReport.user');
        
        if (!Auth::user()->isAdmin() && $beritaAcara->fieldWorkReport->user_id != Auth::id()) {
            abort(403);
        }

        return view('berita_acara.show', compact('beritaAcara'));
    }

    /**
     * Generate PDF for the specified resource.
     */
    public function downloadPdf(BeritaAcara $beritaAcara)
    {
        $beritaAcara->load('fieldWorkReport.user');
        $pdf = Pdf::loadView('berita_acara.pdf', compact('beritaAcara'));
        
        $filename = str_replace('/', '-', $beritaAcara->ba_number) . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Print/Stream PDF for the specified resource.
     */
    public function printPdf(BeritaAcara $beritaAcara)
    {
        $beritaAcara->load('fieldWorkReport.user');
        $pdf = Pdf::loadView('berita_acara.pdf', compact('beritaAcara'));
        
        $filename = str_replace('/', '-', $beritaAcara->ba_number) . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeritaAcara $beritaAcara)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BeritaAcara $beritaAcara)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeritaAcara $beritaAcara)
    {
        if (!Auth::user()->isAdmin() && $beritaAcara->fieldWorkReport->user_id != Auth::id()) {
            abort(403);
        }

        $beritaAcara->delete();

        return redirect()->route('berita-acara.index')->with('success', 'Berita Acara berhasil dihapus.');
    }
}
