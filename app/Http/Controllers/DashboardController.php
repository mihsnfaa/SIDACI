<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard berdasarkan level user
     */
    public function index()
    {
        $user = Auth::user();
        $bidang = $user->bidang;
        $level = $user->level;

        // Jika user adalah admin, tampilkan semua dokumen dan statistik per bidang
        if ($level === 'admin') {
            $bidangs = ['sekretariat', 'progsi', 'yansdk', 'kesmas', 'p2p'];

            $jumlahFilePerBidang = [];
            $dataDokumenPerBidang = [];

            foreach ($bidangs as $b) {
                $jumlahFilePerBidang[$b] = Documents::where('bidang', $b)->count();
                $dataDokumenPerBidang[$b] = Documents::where('bidang', $b)
                    ->with('uploader') // relasi benar
                    ->latest()
                    ->get();
            }

            $documents = Documents::with('uploader')->latest()->get();

            return view('dashboard', compact(
                'user',
                'level',
                'bidang',
                'documents',
                'jumlahFilePerBidang',
                'dataDokumenPerBidang'
            ));
        }

        // Untuk user biasa (non-admin), tampilkan hanya dokumen bidang miliknya
        $documents = Documents::where('bidang', $bidang)
            ->with('uploader') // relasi benar
            ->latest()
            ->get();

        return view('dashboard', compact('user', 'level', 'bidang', 'documents'));
    }

    /**
     * Tampilkan dokumen berdasarkan bidang (khusus admin atau user yang sesuai)
     */
    public function showByBidang($bidang)
    {
        $user = Auth::user();
        $level = $user->level;

        $bidangList = ['sekretariat', 'progsi', 'yansdk', 'kesmas', 'p2p'];
        if (!in_array($bidang, $bidangList)) {
            abort(404, 'Bidang tidak ditemukan');
        }

        // Admin bisa akses semua bidang
        if ($level === 'admin') {
            $documents = Documents::where('bidang', $bidang)
                ->with('uploader') // relasi benar
                ->latest()
                ->get();

            return view('dashboard', [
                'user' => $user,
                'level' => $level,
                'bidang' => $bidang,
                'documents' => $documents,
                'admin_akses_bidang' => true,
            ]);
        }

        // User biasa hanya bisa mengakses bidangnya sendiri
        if ($user->bidang !== $bidang) {
            abort(403, 'Akses ditolak');
        }

        $documents = Documents::where('bidang', $bidang)
            ->with('uploader') // relasi benar
            ->latest()
            ->get();

        return view('dashboard', compact('user', 'level', 'bidang', 'documents'));
    }
}
