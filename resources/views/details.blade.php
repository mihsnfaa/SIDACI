@extends('layouts.app')

@section('content')
    <div class="min-h-screen p-6 bg-gray-200">
        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold">Detail Data</h2>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
            </div>

            {{-- Edit & Keterangan --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Edit Form --}}
                <div class="p-4 bg-white rounded shadow">
                    <h3 class="mb-4 text-lg font-semibold">Edit File</h3>
                    <form action="{{ route('documents.update', $document->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <div>
                            <label for="nama_file" class="block text-sm font-medium">Nama File</label>
                            <input type="text" name="nama_file" id="nama_file" value="{{ $document->name }}"
                                class="w-full px-3 py-2 mt-1 border rounded" required>
                        </div>

                        <div>
                            <label for="file" class="block text-sm font-medium">Ubah File</label>
                            <input type="file" name="file" id="file"
                                class="w-full px-3 py-2 mt-1 border rounded">
                        </div>

                        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                            Simpan
                        </button>
                    </form>

                </div>

                {{-- File Info --}}
                {{-- File Info --}}
                <div class="p-4 bg-white rounded shadow">
                    <h3 class="mb-4 text-lg font-semibold">Keterangan File</h3>
                    <ul class="space-y-2 text-sm">
                        <li><span class="font-medium">Nama File:</span>
                            <a href="#" class="text-blue-600 hover:underline">{{ $document->name }}</a>
                        </li>
                        <li><span class="font-medium">Nama File Upload:</span> {{ $document->original_name }}</li>
                        <li><span class="font-medium">Tgl. Upload - Jam Upload:</span>
                            {{ \Carbon\Carbon::parse($document->created_at)->format('d-m-Y - H:i:s') }}
                        </li>
                        <li><span class="font-medium">Tgl. Edit - Jam Edit:</span>
                            {{ \Carbon\Carbon::parse($document->updated_at)->format('d-m-Y - H:i:s') }}
                        </li>
                        <li><span class="font-medium">Uploaded by:</span>
                            {{ $document->uploader->name ?? 'Tidak diketahui' }}
                        </li>
                        <li><span class="font-medium">Updated by:</span>
                            {{ $document->updater->name ?? '-' }}
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Preview Data --}}
            <div class="p-6 bg-white rounded shadow">
                <h3 class="mb-4 text-lg font-semibold">Preview Data</h3>
                <div class="w-full h-[500px] overflow-hidden border rounded bg-gray-100">
                    @if (Str::endsWith($document->original_name, ['.pdf']))
                        <iframe src="{{ asset('storage/' . $document->file_path) }}" class="w-full h-full"></iframe>
                    @elseif (Str::endsWith($document->original_name, ['.doc', '.docx', '.ppt', '.pptx', '.xls', '.xlsx']))
                        <p class="p-4 text-gray-500">Preview tidak tersedia untuk format dokumen ini.</p>
                    @elseif (Str::endsWith($document->original_name, ['.jpg', '.jpeg', '.png']))
                        <img src="{{ asset('storage/' . $document->file_path) }}" class="object-contain w-full h-full"
                            alt="Preview">
                    @else
                        <p class="p-4 text-gray-500">Format file tidak dikenali untuk preview.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
