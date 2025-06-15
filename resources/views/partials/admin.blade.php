{{-- Kartu Jumlah Dokumen per Bidang --}}
<div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
    @foreach ($jumlahFilePerBidang as $namaBidang => $jumlah)
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="text-lg font-semibold capitalize">{{ $namaBidang }}</h2>
            <p class="text-sm text-gray-600">Jumlah dokumen: {{ $jumlah }}</p>
            <a href="{{ route('dashboard.bidang', ['bidang' => $namaBidang]) }}"
                class="inline-block mt-2 text-blue-600 hover:underline">
                More Info
            </a>
        </div>
    @endforeach
</div>

{{-- Navigasi Tab Bidang --}}
<div class="mb-4">
    <ul class="flex space-x-4 border-b">
        @foreach ($dataDokumenPerBidang as $namaBidang => $dokumenBidang)
            <li>
                <a href="?tab={{ $namaBidang }}"
                    class="block px-4 py-2 font-medium capitalize border-b-2
                    {{ request('tab', 'sekretariat') === $namaBidang ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-600 hover:text-blue-600' }}">
                    {{ $namaBidang }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

{{-- Tabel Dokumen Bidang Tertentu --}}
@php
    $activeTab = request('tab', 'sekretariat');
    $dokumenBidang = $dataDokumenPerBidang[$activeTab] ?? [];
@endphp

<div class="p-4 bg-white rounded-lg shadow">
    <table class="w-full text-sm text-left table-auto">
        <thead>
            <tr class="text-gray-700 bg-gray-100">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Nama File</th>
                <th class="px-4 py-2">Upload File</th>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Uploaded by</th>
                <th class="px-4 py-2">Jam Upload</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dokumenBidang as $index => $doc)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $doc->name }}</td>
                    <td class="px-4 py-2">{{ $doc->original_name }}</td>
                    <td class="px-4 py-2">{{ $doc->created_at->format('d-m-Y') }}</td>
                    <td class="px-4 py-2">{{ $doc->uploader->name ?? 'Tidak diketahui' }}</td>
                    <td class="px-4 py-2">{{ $doc->created_at->format('H:i:s') }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-2 text-center text-gray-500">Belum ada dokumen.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
