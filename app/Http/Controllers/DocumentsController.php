<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DocumentsController extends Controller
{
    protected $bidangs = ['sekretariat', 'progsi', 'yan-SDK', 'kesmas', 'p2p'];

    // Dashboard untuk admin
    public function adminDashboard()
    {
        if (Auth::user()->level !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $jumlahFilePerBidang = [];
        $dataDokumenPerBidang = [];

        foreach ($this->bidangs as $bidang) {
            $jumlahFilePerBidang[$bidang] = Documents::where('bidang', $bidang)->count();
            $dataDokumenPerBidang[$bidang] = Documents::with('uploader')->where('bidang', $bidang)->latest()->get();
        }

        return view('partials.admin', compact('jumlahFilePerBidang', 'dataDokumenPerBidang'));
    }

    // Halaman per bidang
    private function loadBidangView($bidang, $view)
    {
        $user = Auth::user();
        if ($user->level !== 'admin' && $user->bidang !== $bidang) {
            abort(403, 'Akses ditolak.');
        }

        $documents = Documents::with('uploader')->where('bidang', $bidang)->latest()->get();
        return view($view, compact('documents'));
    }

    public function kesmas() { return $this->loadBidangView('kesmas', 'partials.kesmas'); }
    public function progsi() { return $this->loadBidangView('progsi', 'partials.progsi'); }
    public function sekretariat() { return $this->loadBidangView('sekretariat', 'partials.sekretariat'); }
    public function yansdk() { return $this->loadBidangView('yan-SDK', 'partials.yansdk'); }
    public function p2p() { return $this->loadBidangView('p2p', 'partials.p2p'); }

    // Upload dokumen
    public function upload(Request $request)
    {
        $request->validate([
            'nama_file' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
            'bidang' => 'required|string|in:' . implode(',', $this->bidangs),
        ]);

        $user = Auth::user();
        if ($user->level !== 'admin' && $user->bidang !== $request->bidang) {
            abort(403, 'Kamu tidak diizinkan mengunggah dokumen ke bidang ini.');
        }

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $cleanName = preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $originalName);
        $fileName = Str::uuid() . '-' . $cleanName;
        $filePath = $file->storeAs('dokumen', $fileName, 'public');

        Documents::create([
            'name'          => $request->nama_file,
            'original_name' => $originalName,
            'file_path'     => $filePath,
            'file_type'     => $file->getClientMimeType(),
            'uploaded_at'   => now(),
            'uploaded_by'   => $user->id,
            'bidang'        => $request->bidang,
        ]);

        return back()->with('success', 'File berhasil diupload!');
    }

    // Download dokumen
    public function download($id)
    {
        $document = Documents::findOrFail($id);
        $user = Auth::user();

        if ($user->level !== 'admin' && $user->bidang !== $document->bidang) {
            abort(403, 'Kamu tidak berhak mengunduh dokumen ini.');
        }

        return response()->download(storage_path('app/public/' . $document->file_path));
    }

    // Lihat detail dokumen
    public function detail($id)
    {
        $document = Documents::with('uploader', 'updater')->findOrFail($id);
        $user = Auth::user();

        if ($user->level !== 'admin' && $user->bidang !== $document->bidang) {
            abort(403, 'Kamu tidak berhak melihat detail dokumen ini.');
        }

        return view('details', compact('document'));
    }

    // Update dokumen
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_file' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
        ]);

        $document = Documents::findOrFail($id);
        $user = Auth::user();

        if ($user->level !== 'admin' && $user->id !== $document->uploaded_by) {
            abort(403, 'Kamu tidak berhak mengedit dokumen ini.');
        }

        $document->name = $request->nama_file;
        $document->updated_by = $user->id;

        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $cleanName = preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $originalName);
            $fileName = Str::uuid() . '-' . $cleanName;
            $filePath = $file->storeAs('dokumen', $fileName, 'public');

            $document->original_name = $originalName;
            $document->file_path = $filePath;
            $document->file_type = $file->getClientMimeType();
        }

        $document->updated_at = now();
        $document->save();

        return redirect()->route('dashboard')->with('success', 'Dokumen berhasil diperbarui.');
    }

    // Hapus dokumen
    public function destroy($id)
    {
        $document = Documents::findOrFail($id);
        $user = Auth::user();

        if ($user->level !== 'admin' && $user->id !== $document->uploaded_by) {
            abort(403, 'Kamu tidak berhak menghapus dokumen ini.');
        }

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
