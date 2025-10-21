@extends('main.layout2')@section('content')
    <h1 class="text-xl font-semibold mb-4">Daftar Folder
        <button type="button"
        onclick="openTambahModalFolder()"
        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow-sm">
            <span class="material-icons" style="margin-right: 5px; margin-left: -5px;font-size: 16px;">add</span>
            Tambah Data
        </button>
    </h1>

    {{-- FITUR SORT BY --}}
    @php
        // Tentukan URL dasar untuk memudahkan pembuatan link filter
        $currentRoute = route('backend.daftar_folder');
        $currentSortBy = $sortBy ?? 'created_at';
        $currentDirection = $sortDirection ?? 'desc';
    @endphp

    <div class="mb-4 flex justify-end items-center gap-2">
        <label for="sort_filter" class="text-sm font-medium text-gray-700">Urutkan Berdasarkan:</label>
        
        <select id="sort_filter" onchange="window.location.href = this.value"
                class="mt-1 block border border-gray-300 rounded-md text-sm py-2 px-3" style="width: 200px;">
            
            <option value="{{ $currentRoute }}?sort_by=created_at&direction=desc" 
                {{ $currentSortBy == 'created_at' && $currentDirection == 'desc' ? 'selected' : '' }}>
                Terbaru
            </option>
            
            <option value="{{ $currentRoute }}?sort_by=created_at&direction=asc" 
                {{ $currentSortBy == 'created_at' && $currentDirection == 'asc' ? 'selected' : '' }}>
                Terlama
            </option>

            <option value="{{ $currentRoute }}?sort_by=nm_folder&direction=asc" 
                {{ $currentSortBy == 'nm_folder' && $currentDirection == 'asc' ? 'selected' : '' }}>
                Nama folder (A-Z)
            </option>
            
            <option value="{{ $currentRoute }}?sort_by=nm_folder&direction=desc" 
                {{ $currentSortBy == 'nm_folder' && $currentDirection == 'desc' ? 'selected' : '' }}>
                Nama folder (Z-A)
            </option>
            
            <option value="{{ $currentRoute }}?sort_by=updated_at&direction=desc" 
                {{ $currentSortBy == 'updated_at' && $currentDirection == 'desc' ? 'selected' : '' }}>
                Terakhir Diedit
            </option>

        </select>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600">
                            <tr>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 50px;">No</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Folder</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 250px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($folder as $f)
                                <tr>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $folder->firstItem() + $loop->iteration - 1 }}</td>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $f->nm_folder }}</td>
                                    <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                        <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                            {{-- Tombol Edit --}}
                                            <button type="button"
                                                onclick="openEditModalFolder(
                                                    {{ $f->id }},
                                                    '{{ addslashes(e($f->nm_folder)) }}'
                                                )"
                                                class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                                <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                                Edit
                                            </button>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('backend.folder.destroy', $f->id) }}" method="POST" class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex flex-nowrap items-center gap-2 overflow-auto px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                                    <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">delete</span>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                        Belum ada data Folder.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- MODAL TAMBAH DATA DAFTAR FOLDER --}}
                    <div id="tambahModalFolder" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Tambah Daftar Folder</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="tambahFormFolder" method="POST" action="{{ route('backend.folder.store') }}">
                                    @csrf

                                    <input type="hidden" name="id" id="tambah_id_folder">
                                    <input type="hidden" name="mode" value="tambah">

                                    <div class="mb-3">
                                        <label for="tambah_nm_folder" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Folder</label>
                                        <input type="text" name="nm_folder" id="tambah_nm_folder" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_folder') }}">
                                    </div>

                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                <button type="button" onclick="closeTambahModalFolder()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="tambahFormFolder" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                    {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA DAFTAR FOLDER JIKA ADA ERROR--}}
                    @if ($errors->any() && old('mode') === 'tambah')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('tambahModalFolder').classList.remove('hidden');
                            });
                        </script>
                    @endif

                    {{-- MODUL EDIT DATA DAFTAR FOLDER --}}
                    @if(isset($f))
                        <div id="editModalFolder" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                            style="max-width: 800px; max-height: 800px;">
                                <div class="p-6">
                                    <h2 class="text-base font-semibold">Edit Daftar Folder</h2>
                                </div>

                                <div class="form_edit p-6 overflow-y-auto">
                                    <form id="editFormFolder" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="id" id="edit_id_folder">
                                        <input type="hidden" name="mode" value="edit">

                                        <div class="mb-3">
                                            <label for="edit_nm_folder" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Folder</label>
                                            <input type="text" name="nm_folder" id="edit_nm_folder" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_folder', $f->nm_folder) }}">
                                        </div>

                                    </form>
                                </div>
                                <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                    <button type="button" onclick="closeEditModalFolder()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                    <button type="submit" form="editFormFolder" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                                </div>
                            </div>
                        </div>

                        {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA DAFTAR FOLDER JIKA ADA ERROR --}}
                        @if ($errors->any() && old('mode') === 'edit')
                            <script>
                                window.addEventListener('DOMContentLoaded', () => {
                                    document.getElementById('editModalFolder').classList.remove('hidden');
                                });
                            </script>
                        @endif
                    @endif

                </div>
                {{-- TAMBAHKAN NAVIGASI PAGINATION DI SINI --}}
                <div class="mt-4 flex justify-end p-4">
                    {{ $folder->links('pagination::tailwind') }}
                </div>

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA DAFTAR FOLDER--}}
    <script>
        console.log(document.getElementById('tambahFormFolder').action);
        function openTambahModalFolder() {
        document.getElementById('tambahModalFolder').classList.remove('hidden');
        }

        function closeTambahModalFolder() {
            document.getElementById('tambahModalFolder').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA DAFTAR FOLDER--}}
    <script>
        function openEditModalFolder(id, nm_folder) {
            document.getElementById('edit_id_folder').value = id;
            document.getElementById('edit_nm_folder').value = nm_folder;
            
            // 1. Ambil URL rute Laravel yang benar menggunakan helper route()
            const updateUrl = "{{ route('backend.folder.update', ':id') }}";
            
            // 2. Ganti placeholder ':id' dengan ID yang dikirim
            document.getElementById('editFormFolder').action = updateUrl.replace(':id', id);
            
            document.getElementById('editModalFolder').classList.remove('hidden');
        }

        function closeEditModalFolder() {
            document.getElementById('editModalFolder').classList.add('hidden');
        }
    </script>

@endsection