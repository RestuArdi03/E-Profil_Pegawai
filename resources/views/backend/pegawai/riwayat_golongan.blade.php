<?php use Carbon\Carbon;
?>

@extends('main.layout2')

@section('content')
    <h1 class="text-xl">Riwayat Golongan
        <button type="button"
        onclick="openTambahModalGolongan()"
        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow-sm">
            <span class="material-icons" style="margin-right: 5px; margin-left: -5px;font-size: 16px;">add</span>
            Tambah Data
        </button>
    </h1>
    <!-- Profil Pegawai -->
    <div class="mb-6">
        @php
            $jabatanTerbaru = $pegawai->riwayatJabatan?->sortByDesc('created_at')->first()?->jabatan;

            $fotoPath = 'foto_pegawai/' . ($pegawai->foto ?? '');
            $fotoUrl = file_exists(public_path($fotoPath)) && $pegawai->foto
                ? asset($fotoPath)
                : asset('assets/images/users/default.png');
        @endphp

        <div class="bg-white shadow rounded-xl p-6 mb-6">
            <div class="flex items-center gap-6">
                <img src="{{ $fotoUrl }}"
                    alt="Foto Pegawai"
                    class="w-24 h-24 object-cover rounded-full border border-gray-300 shadow-sm"
                    style="aspect-ratio: 1 / 1; max-width: 100px;">

                <div>
                    <p class="text-gray-800 font-medium text-lg">
                        {{ $pegawai->nama ?? 'Nama Pegawai' }}
                    </p>
                    <p class="text-gray-600 text-sm">
                        NIP: {{ $pegawai->nip ?? '-' }}
                    </p>
                    <p class="text-gray-600 text-sm">
                        Jabatan: {{ $jabatanTerbaru ?? '-' }}
                    </p>
                </div>
            </div>
        </div>        
    </div>

    {{-- FITUR SORT BY --}}
    @php
        // Ambil ID Pegawai dari objek $pegawai yang sudah dimuat di controller
        $pegawaiId = $pegawai->id; 
         
        $currentRoute = route('backend.golongan.show', $pegawaiId); 

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
            
            <option value="{{ $currentRoute }}?sort_by=updated_at&direction=desc" 
                {{ $currentSortBy == 'updated_at' && $currentDirection == 'desc' ? 'selected' : '' }}>
                Terakhir Diedit
            </option>

        </select>
    </div>

    <!-- Flash Notification / Pemberitahuan -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-4 right-4 z-[999] bg-red-500 text-white px-4 py-2 rounded shadow text-sm">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 50px;">No</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Golru</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">TMT Golongan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Masa Kerja</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pejabat Penetap</th>
                            <th class="border border-gray px-6 py-3 text-sm text-default-100
                            " style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($riwayat_golongan as $gol)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $riwayat_golongan->firstItem() + $loop->iteration - 1 }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $gol->golongan->golru ?? '-' }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $gol->tmt_golongan }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $gol->no_sk }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $gol->tgl_sk }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $gol->masa_kerja }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $gol->pejabat }}</td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalGolongan(
                                                {{ $gol->id }},
                                                '{{ addslashes(e($gol->golongan_id)) }}',
                                                '{{ addslashes(e($gol->tmt_golongan)) }}',
                                                '{{ addslashes(e($gol->no_sk)) }}',
                                                '{{ addslashes(e($gol->tgl_sk)) }}',
                                                '{{ addslashes(e($gol->pejabat)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.golongan.destroy', $gol->id) }}" method="POST" class="inline-block"
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
                                <td colspan="8" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada data Riwayat Golongan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL TAMBAH DATA RIWAYAT GOLONGAN --}}
                <div id="tambahModalGolongan" class="fixed inset-0 z-50 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Golongan</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormGolongan" method="POST" action="/admin/riwayat_golongan/store" novalidate>
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_golongan">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label class="block text-sm font-medium" style="margin-top: -25px;">Golru</label>
                                    <select name="golongan_id" id="golongan_id" class="select2 mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                        <option value="">-- Pilih golru --</option>
                                        @foreach ($golongan as $g)
                                            <option value="{{ $g->id }}" {{ old('golongan_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->golru }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="golongan_id_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Pilih Golru dalam daftar.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tmt_golongan" class="block text-sm font-medium text-gray-700">TMT Golongan</label>
                                    <input type="date" name="tmt_golongan" id="tambah_tmt_golongan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmt_golongan') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="tmt_golongan_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        TMT Golongan wajib diisi.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                    <input type="text" name="no_sk" id="tambah_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk') }}">
                                    <div id="no_sk_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Nomor SK wajib diisi.
                                    </div>
                                    @error('no_sk')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                    <input type="date" name="tgl_sk" id="tambah_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk') }}">
                                    <div id="tgl_sk_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Tanggal SK wajib diisi.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_pejabat" class="block text-sm font-medium text-gray-700">Pejabat</label>
                                    <input type="text" name="pejabat" id="tambah_pejabat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat') }}">
                                    <div id="pejabat_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Nama Pejabat wajib diisi.
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6">
                            <button type="button" onclick="closeTambahModalGolongan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormGolongan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>

                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT GOLONGAN JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalGolongan').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT GOLONGAN --}}
                @if(isset($gol))
                    <div id="editModalGolongan" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat Golongan</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormGolongan" method="POST" action="{{ route('backend.riwayat_golongan.update', $gol->id) }}" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_riwayat_golongan">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium" style="margin-top: -25px;">Golru</label>
                                        <select name="golongan_id" id="edit_golongan_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                            <option value="">-- Pilih golru --</option>
                                            @foreach ($golongan as $g)
                                                <option value="{{ $g->id }}" {{ old('golongan_id') == $g->id ? 'selected' : '' }}>
                                                {{ $g->golru }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div id="edit_golongan_id_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Pilih Golru dalam daftar.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tmt_golongan" class="block text-sm font-medium text-gray-700">TMT Golongan</label>
                                        <input type="date" name="tmt_golongan" id="edit_tmt_golongan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmt_golongan', $gol->tmt_golongan) }}">
                                        <div id="edit_tmt_golongan_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            TMT Golongan wajib diisi.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                        <input type="text" name="no_sk" id="edit_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk', $gol->no_sk) }}">
                                        <div id="edit_no_sk_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Nomor SK wajib diisi.
                                        </div>
                                        @error('no_sk')
                                            <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                        <input type="date" name="tgl_sk" id="edit_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk', $gol->tgl_sk) }}">
                                        <div id="edit_tgl_sk_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Tanggal SK wajib diisi.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pejabat" class="block text-sm font-medium text-gray-700">Pejabat</label>
                                        <input type="text" name="pejabat" id="edit_pejabat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat', $gol->pejabat) }}">
                                        <div id="edit_pejabat_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Nama Pejabat wajib diisi.
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                                <button type="button" onclick="closeEditModalGolongan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormGolongan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT GOLONGAN JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalGolongan').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
            {{-- TAMBAHKAN NAVIGASI PAGINATION DI SINI --}}
            <div class="mt-4 flex justify-end p-4">
                {{ $riwayat_golongan->links('pagination::tailwind') }}
            </div>

        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT GOLONGAN--}}
    <script>
        // Fungsi inisialisasi yang lebih aman
        function initSelect2(modalId, selectId) {
            // Cek apakah Select2 sudah diinisialisasi
            if ($(selectId).hasClass('select2-hidden-accessible')) {
                return;
            }

            $(selectId).select2({ 
                dropdownParent: $(modalId), 
                placeholder: "-- Pilih golru --",
                allowClear: false,
                theme: 'default' 
            });
            
            // --- TAMBAHKAN KELAS TAILWIND KE CONTAINER SELECT2 ---
            // Menargetkan container yang baru dibuat oleh Select2
            var container = $(selectId).next('.select2-container');
            
            // Tambahkan w-full dan styling lainnya ke container utama
            container.addClass('w-full custom-select-full'); // <-- MEMBUAT LEBAR 100%

            // Tambahkan styling border ke elemen seleksi di dalamnya
            container.find('.select2-selection--single')
                    .addClass('mt-1 block w-full order border-gray-300 rounded-md text-sm py-1'); 
            
            container.find('.select2-selection__rendered')
                    .css('padding-left', '10px');
        }
        function openTambahModalGolongan() {
            // Panggil inisialisasi
            initSelect2('#tambahModalGolongan', '#golongan_id');
            document.getElementById('tambahModalGolongan').classList.remove('hidden');
        }
        
        // --- LOGIKA VALIDASI KUSTOM DI SISI KLIEN ---
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('tambahFormGolongan');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    
                    let isValid = true;
                    
                    // --- Definisikan semua elemen Input/Error ---
                    const fields = [
                        { id: 'golongan_id', errorId: 'golongan_id_error', type: 'select2' },
                        { id: 'tambah_tmt_golongan', errorId: 'tmt_golongan_error', type: 'input' },
                        { id: 'tambah_no_sk', errorId: 'no_sk_error', type: 'input' },
                        { id: 'tambah_tgl_sk', errorId: 'tgl_sk_error', type: 'input' },
                        { id: 'tambah_pejabat', errorId: 'pejabat_error', type: 'input' },
                    ];

                    // --- Loop dan Validasi ---
                    fields.forEach(field => {
                        const inputElement = document.getElementById(field.id);
                        const errorDiv = document.getElementById(field.errorId);
                        let valueToCheck = inputElement.value;
                        let isFieldValid = true;

                        // Khusus untuk Select2, pastikan value tidak kosong
                        if (field.type === 'select2') {
                            // Jika Select2, nilai yang dicek adalah value
                            if (!valueToCheck) {
                                isFieldValid = false;
                            }
                        } else { 
                            // Input standar (text/date)
                            if (!valueToCheck || valueToCheck.trim() === '') {
                                isFieldValid = false;
                            }
                        }

                        if (!isFieldValid) {
                            // Tampilkan error
                            errorDiv.style.display = 'block';
                            
                            // Tambahkan class error pada input/container
                            if (field.type === 'select2') {
                                $(inputElement).next('.select2-container').find('.select2-selection--single').addClass('border-red-500');
                            } else {
                                inputElement.classList.add('border-red-500');
                            }
                            isValid = false;
                        } else {
                            // Hapus error
                            errorDiv.style.display = 'none';
                            if (field.type === 'select2') {
                                $(inputElement).next('.select2-container').find('.select2-selection--single').removeClass('border-red-500');
                            } else {
                                inputElement.classList.remove('border-red-500');
                            }
                        }
                    });

                    // --- Mencegah Submit Jika Tidak Valid ---
                    if (!isValid) {
                        e.preventDefault(); 
                    }
                });
            }
        });

        function closeTambahModalGolongan() {
            document.getElementById('tambahModalGolongan').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT GOLONGAN--}}
    <script>
        function openEditModalGolongan(id, golongan_id, tmt_golongan, no_sk, tgl_sk, pejabat) {
            document.getElementById('edit_id_riwayat_golongan').value = id;
            document.getElementById('edit_golongan_id').value = golongan_id;
            document.getElementById('edit_tmt_golongan').value = tmt_golongan;
            document.getElementById('edit_no_sk').value = no_sk;
            document.getElementById('edit_tgl_sk').value = tgl_sk;
            document.getElementById('edit_pejabat').value = pejabat;

            initSelect2('#editModalGolongan', '#edit_golongan_id');
            $('#editModalGolongan #edit_golongan_id').val(golongan_id).trigger('change');

            document.getElementById('editFormGolongan').action = `/admin/riwayat_golongan/${id}`;
            document.getElementById('editModalGolongan').classList.remove('hidden');
        }

        function closeEditModalGolongan() {
            document.getElementById('editModalGolongan').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK VALIDASI EDIT MODAL EDIT --}}
    <script>
        // Ambil form secara langsung setelah form di-render oleh Blade
        const formEdit = document.getElementById('editFormGolongan');

        if (formEdit) {
            formEdit.addEventListener('submit', function(e) {
                
                let isValid = true;
                
                // --- Definisikan semua elemen Input/Error di Modal Edit ---
                const fields = [
                    // PASTIKAN ID ERROR INI ADA DI BLADE EDIT MODAL!
                    { id: 'edit_golongan_id', errorId: 'edit_golongan_id_error', type: 'select2' },
                    { id: 'edit_tmt_golongan', errorId: 'edit_tmt_golongan_error', type: 'input' },
                    { id: 'edit_no_sk', errorId: 'edit_no_sk_error', type: 'input' },
                    { id: 'edit_tgl_sk', errorId: 'edit_tgl_sk_error', type: 'input' },
                    { id: 'edit_pejabat', errorId: 'edit_pejabat_error', type: 'input' },
                ];

                // --- Logika Validasi Tetap Sama ---
                fields.forEach(field => {
                    const inputElement = document.getElementById(field.id);
                    // PASTIKAN errorDiv DITEMUKAN: Tambahkan pengecekan null
                    const errorDiv = document.getElementById(field.errorId);
                    
                    // Tambahkan pengecekan di sini
                    if (!inputElement) {
                        console.error("Input Element not found:", field.id);
                        return;
                    }
                    if (!errorDiv) {
                        console.error("Error Div not found:", field.errorId);
                    }

                    // ... (Sisa Logika Validasi Tetap Sama) ...
                    
                    let valueToCheck = inputElement.value;
                    let isFieldValid = true;

                    if (field.type === 'select2') {
                        if (!valueToCheck) {
                            isFieldValid = false;
                        }
                    } else { 
                        if (!valueToCheck || valueToCheck.trim() === '') {
                            isFieldValid = false;
                        }
                    }

                    if (!isFieldValid) {
                        if(errorDiv) errorDiv.style.display = 'block'; 
                        
                        const selector = field.type === 'select2' ? $(inputElement).next('.select2-container').find('.select2-selection--single') : $(inputElement);
                        selector.addClass('border-red-500');
                        
                        isValid = false;
                    } else {
                        if(errorDiv) errorDiv.style.display = 'none';
                        const selector = field.type === 'select2' ? $(inputElement).next('.select2-container').find('.select2-selection--single') : $(inputElement);
                        selector.removeClass('border-red-500');
                    }
                });

                // --- Mencegah Submit Jika Tidak Valid ---
                if (!isValid) {
                    e.preventDefault(); 
                }
            });
        }
    </script>

@endsection