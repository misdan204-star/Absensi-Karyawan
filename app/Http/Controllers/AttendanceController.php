<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        // Mengambil riwayat absen milik user yang sedang login saja
        $history = Attendance::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        // Cek apakah hari ini sedang izin/cuti yang sudah disetujui
        $today = Carbon::today();
        $isOnLeave = \App\Models\LeaveRequest::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();
            
        return response()->json([
            'history' => $history,
            'leave' => $isOnLeave
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tipe_absen' => 'required|in:masuk,pulang',
            'status_lokasi' => 'required|string',
            'image' => 'required|string' // Base64 string
        ]);

        // Cek apakah user sudah absen hari ini untuk tipe yang sama
        $today = Carbon::today();
        $exists = Attendance::where('user_id', auth()->id())
            ->where('tipe_absen', $validated['tipe_absen'])
            ->whereDate('created_at', $today)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen ' . $validated['tipe_absen'] . ' hari ini.'
            ], 422);
        }

        // --- ATURAN 8 JAM (Khusus Absen Pulang) ---
        if ($validated['tipe_absen'] === 'pulang') {
            $absensiMasuk = Attendance::where('user_id', auth()->id())
                ->where('tipe_absen', 'masuk')
                ->whereDate('created_at', $today)
                ->first();

            if (!$absensiMasuk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus melakukan Absen Masuk terlebih dahulu!'
                ], 422);
            }

            $waktuMasuk = $absensiMasuk->created_at;
            $waktuPulangMinimal = $waktuMasuk->copy()->addHours(8); // Aturan 8 jam

            if (now()->lessThan($waktuPulangMinimal)) {
                $sisaMenit = now()->diffInMinutes($waktuPulangMinimal);
                $jam = floor($sisaMenit / 60);
                $menit = $sisaMenit % 60;
                
                return response()->json([
                    'success' => false,
                    'message' => "Belum cukup 8 jam kerja. Anda baru bisa pulang dalam {$jam} jam {$menit} menit lagi (Pukul {$waktuPulangMinimal->format('H:i')})."
                ], 422);
            }
        }

        // Proses Simpan Gambar
        $image = $validated['image'];
        
        // Handle data URI scheme (data:image/xxx;base64,xxxx)
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);
            $extension = strtolower($type[1]); // jpg, png, etc.
            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                return response()->json(['success' => false, 'message' => 'Format gambar tidak didukung.'], 422);
            }
        } else {
            $extension = 'jpg'; // Default
        }

        $image = str_replace(' ', '+', $image);
        $decodedImage = base64_decode($image);
        
        // Validasi ukuran (max 2MB)
        if (strlen($decodedImage) > 2 * 1024 * 1024) {
            return response()->json(['success' => false, 'message' => 'Ukuran gambar terlalu besar (Maks 2MB).'], 422);
        }

        $imageName = 'attendance_' . auth()->id() . '_' . time() . '.' . $extension;
        Storage::disk('public')->put('attendances/' . $imageName, $decodedImage);
        $imagePath = 'attendances/' . $imageName;

        $absen = Attendance::create([
            'user_id' => auth()->id(),
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'tipe_absen' => $validated['tipe_absen'],
            'status_lokasi' => $validated['status_lokasi'],
            'image_path' => $imagePath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil absen ' . $validated['tipe_absen'],
            'data' => $absen
        ]);
    }
}
