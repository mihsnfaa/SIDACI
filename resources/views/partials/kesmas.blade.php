@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 rounded-lg shadow">
    <h2 class="mb-4 text-2xl font-semibold">Kesmas</h2>

    {{-- Upload Form: hanya tampil untuk admin dan user bidang kesmas --}}
    @if (auth()->user()->level === 'admin' || auth()->user()->bidang === 'kesmas')
        <form action="{{ route('dokumen.upload') }}" method="POST" enctype="multipart/form-data" class="p-4 mb-6 space-y-4 bg-white rounded shadow">
            @csrf
            <input type="hidden" name="bidang" value="kesmas">

            <div>
                <label for="nama_file" class="block mb-1 font-medium">Nama File</label>
                <input type="text" name="nama_file" id="nama_file" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div>
                <label for="file" class="block mb-1 font-medium">Upload File</label>
                <input type="file" name="file" id="file" class="w-full px-3 py-2 border rounded" required>
            </div>

            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                Upload File
            </button>
        </form>
    @endif

    {{-- Tabel Dokumen --}}
    <div class="p-4 overflow-x-auto bg-white rounded shadow">
        <table id="dokumenTable" class="min-w-full text-sm border divide-y divide-gray-200">
            <thead class="text-gray-700 bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">Nama File</th>
                    <th class="px-4 py-2 text-left">Upload File</th>
                    <th class="px-4 py-2 text-left">Tgl. Upload</th>
                    <th class="px-4 py-2 text-left">Uploaded by</th>
                    <th class="px-4 py-2 text-left">Download</th>
                    <th class="px-4 py-2 text-left">Detail</th>
                    <th class="px-4 py-2 text-left">Hapus</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($documents as $index => $doc)
                    <tr>
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $doc->name }}</td>
                        <td class="px-4 py-2">{{ $doc->original_name }}</td>
                        <td class="px-4 py-2">{{ $doc->created_at->format('d F Y') }}</td>
                        <td class="px-4 py-2">{{ $doc->uploader->name ?? 'Tidak diketahui' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('dokumen.download', $doc->id) }}"
                               class="inline-block px-3 py-1 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                                Download
                            </a>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('dokumen.detail', $doc->id) }}"
                               class="inline-block px-3 py-1 text-sm text-white rounded bg-sky-500 hover:bg-sky-600">
                                Detail
                            </a>
                        </td>
                        <td class="px-4 py-2">
                            @if (auth()->user()->level === 'admin' || auth()->user()->bidang === 'kesmas')
                                <form action="{{ route('dokumen.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-block px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-sm text-gray-400">Tidak diizinkan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-3 text-center text-gray-500">
                            Belum ada dokumen.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
