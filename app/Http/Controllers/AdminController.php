<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Statistik Utama
        $totalEmployees = User::where('role', 'employee')->count();
        $attendedToday = Attendance::whereDate('created_at', $today)
            ->where('tipe_absen', 'masuk')
            ->distinct('user_id')
            ->count();
        
        $absentToday = $totalEmployees - $attendedToday;

        // Statistik Departemen
        $deptStats = User::selectRaw('department, count(*) as count')
            ->groupBy('department')
            ->get();
        
        // Pengajuan Izin Menunggu
        $pendingLeaves = \App\Models\LeaveRequest::where('status', 'pending')->count();

        // Data terbaru
        $attendances = Attendance::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.dashboard', compact(
            'totalEmployees', 
            'attendedToday', 
            'absentToday', 
            'attendances',
            'deptStats',
            'pendingLeaves'
        ));
    }

    public function export()
    {
        $attendances = Attendance::with('user')->orderBy('created_at', 'desc')->get();
        
        $filename = "laporan_absensi_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Waktu', 'Nama Karyawan', 'NIK', 'Departemen', 'Tipe', 'Status', 'Latitude', 'Longitude'];

        $callback = function() use($attendances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($attendances as $row) {
                fputcsv($file, [
                    $row->created_at->format('Y-m-d H:i:s'),
                    $row->user->name,
                    $row->user->nik,
                    $row->user->department,
                    strtoupper($row->tipe_absen),
                    strtoupper($row->status_lokasi),
                    $row->latitude,
                    $row->longitude,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
