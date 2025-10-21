@extends('main.layout2')@section('content')
    <h1 class="text-xl font-semibold mb-4">Daftar Satuan Kerja
        <span class="text-xl font-semibold">({{ $unitKerja->nm_unit_kerja ?? 'Semua' }})</span>
        <button type="button"
        onclick="openTambahModalSatuanKerja()"
        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow-sm">
            <span class="material-icons" style="margin-right: 5px; margin-left: -5px;font-size: 16px;">add</span>
            Tambah Data
        </button>
    </h1>

    {{-- FITUR SORT BY --}}
    @php
        // Ambil ID Unit Kerja dari variabel $unitKerja yang dikirim oleh controller
        // Menggunakan Safe Operator (?->) dan null coalescing (??) untuk keamanan
        $unitKerjaId = $unitKerja->id ?? 0;
        
        // Gunakan rute SATUAN KERJA, memasukkan ID Unit Kerja saat ini
        $currentRoute = route('backend.satuan_kerja.by_unit_kerja', ['unit_kerja_id' => $unitKerjaId]);
        
        // Sesuaikan nilai default pengurutan untuk Satuan Kerja
        $currentSortBy = $sortBy ?? 'created_at';
        $currentDirection = $sortDirection ?? 'desc';
    @endphp

    <div class="mb-4 flex justify-end items-center gap-2">
        <label for="sort_filter" class="text-sm font-medium text-gray-700">Urutkan Berdasarkan:</label>
        
        <select id="sort_filter" onchange="window.location.href = this.value"
                class="mt-1 block border border-gray-300 rounded-md text-sm py-2 px-3" style="width: 250px;">
            
            <option value="{{ $currentRoute }}?sort_by=created_at&direction=desc" 
                {{ $currentSortBy == 'created_at' && $currentDirection == 'desc' ? 'selected' : '' }}>
                Terbaru
            </option>
            
            <option value="{{ $currentRoute }}?sort_by=created_at&direction=asc" 
                {{ $currentSortBy == 'created_at' && $currentDirection == 'asc' ? 'selected' : '' }}>
                Terlama
            </option>

            <option value="{{ $currentRoute }}?sort_by=nm_satuan_kerja&direction=asc" 
                {{ $currentSortBy == 'nm_satuan_kerja' && $currentDirection == 'asc' ? 'selected' : '' }}>
                Nama Satuan Kerja(A-Z)
            </option>
            
            <option value="{{ $currentRoute }}?sort_by=nm_satuan_kerja&direction=desc" 
                {{ $currentSortBy == 'nm_satuan_kerja' && $currentDirection == 'desc' ? 'selected' : '' }}>
                Nama Satuan Kerja (Z-A)
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
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Satuan Kerja</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 250px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($satuanKerja as $sk)
                                <tr>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $satuanKerja->firstItem() + $loop->iteration - 1 }}</td>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $sk->nm_satuan_kerja }}</td>
                                    <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                        <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                            {{-- Tombol Edit --}}
                                            <button type="button"
                                                onclick="openEditModalSatuanKerja(
                                                    {{ $sk->id }},
                                                    '{{ addslashes(e($sk->nm_satuan_kerja)) }}'
                                                )"
                                                class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                                <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                                Edit
                                            </button>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('backend.satuanKerja.destroy', $sk->id) }}" method="POST" class="inline-block"
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
                                        Belum ada data Satuan Kerja.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- MODAL TAMBAH DATA DAFTAR SATUAN KERJA --}}
                    <div id="tambahModalSatuanKerja" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Tambah Daftar Satuan Kerja</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="tambahFormSatuanKerja" method="POST" action="{{ route('backend.satuanKerja.store') }}">
                                    @csrf

                                    <input type="hidden" name="id" id="tambah_id_satuan_kerja">
                                    <input type="hidden" name="unit_kerja_id" id="tambah_unit_kerja_id" value="{{ old('unit_kerja_id', $unitKerja->id) }}">
                                    <input type="hidden" name="mode" value="tambah">

                                    <div class="mb-3">
                                        <label for="tambah_nm_satuan_kerja" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Satuan Kerja</label>
                                        <input type="text" name="nm_satuan_kerja" id="tambah_nm_satuan_kerja" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_satuan_kerja') }}">
                                        @error('nm_satuan_kerja')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                <button type="button" onclick="closeTambahModalSatuanKerja()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="tambahFormSatuanKerja" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                    {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA DAFTAR SATUAN KERJA JIKA ADA ERROR--}}
                    @if ($errors->any() && old('mode') === 'tambah')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('tambahModalSatuanKerja').classList.remove('hidden');
                            });
                        </script>
                    @endif

                    {{-- MODUL EDIT DATA DAFTAR SATUAN KERJA --}}
                    @if(isset($sk))
                        <div id="editModalSatuanKerja" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                            style="max-width: 800px; max-height: 800px;">
                                <div class="p-6">
                                    <h2 class="text-base font-semibold">Edit Daftar Satuan Kerja</h2>
                                </div>

                                <div class="form_edit p-6 overflow-y-auto">
                                    <form id="editFormSatuanKerja" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="id" id="edit_id_satuan_kerja">
                                        <input type="hidden" name="unit_kerja_id" id="edit_unit_kerja_id" value="{{ old('unit_kerja_id', $unitKerja->id ?? '') }}">
                                        <input type="hidden" name="mode" value="edit">

                                        <div class="mb-3">
                                            <label for="edit_nm_satuan_kerja" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Satuan Kerja</label>
                                            <input type="text" name="nm_satuan_kerja" id="edit_nm_satuan_kerja" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_satuan_kerja', $sk->nm_satuan_kerja) }}">
                                            @error('nm_satuan_kerja')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </form>
                                </div>
                                <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                    <button type="button" onclick="closeEditModalSatuanKerja()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                    <button type="submit" form="editFormSatuanKerja" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                                </div>
                            </div>
                        </div>

                        {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA DAFTAR Satuan KERJA JIKA ADA ERROR --}}
                        @if ($errors->any() && old('mode') === 'edit')
                            <script>
                                window.addEventListener('DOMContentLoaded', () => {
                                    document.getElementById('editModalSatuanKerja').classList.remove('hidden');
                                });
                            </script>
                        @endif
                    @endif

                </div>
                {{-- TAMBAHKAN NAVIGASI PAGINATION DI SINI --}}
                <div class="mt-4 flex justify-end p-4">
                    {{ $satuanKerja->links('pagination::tailwind') }}
                </div>

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA DAFTAR SATUAN KERJA--}}
    <script>
        console.log(document.getElementById('tambahFormSatuanKerja').action);
        function openTambahModalSatuanKerja() {
        document.getElementById('tambahModalSatuanKerja').classList.remove('hidden');
        }

        function closeTambahModalSatuanKerja() {
            document.getElementById('tambahModalSatuanKerja').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA DAFTAR SATUAN KERJA--}}
    <script>
        function openEditModalSatuanKerja(id, nm_satuan_kerja) {
            document.getElementById('edit_id_satuan_kerja').value = id;
            document.getElementById('edit_nm_satuan_kerja').value = nm_satuan_kerja;
            
            // 1. Ambil URL rute Laravel yang benar menggunakan helper route()
            const updateUrl = "{{ route('backend.satuanKerja.update', ':id') }}";
            
            // 2. Ganti placeholder ':id' dengan ID yang dikirim
            document.getElementById('editFormSatuanKerja').action = updateUrl.replace(':id', id);
            
            document.getElementById('editModalSatuanKerja').classList.remove('hidden');
        }

        function closeEditModalSatuanKerja() {
            document.getElementById('editModalSatuanKerja').classList.add('hidden');
        }
    </script>

@endsection