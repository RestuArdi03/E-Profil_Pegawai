@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Riwayat Pendidikan
        <button type="button"
        onclick="openTambahModalPendidikan()"
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
        
        $currentRoute = route('backend.pendidikan.show', $pegawaiId); 

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
                            <th class="border border-gray px-6 py-3 text-sm text-default-100">Strata</th>
                            <th class="border border-gray px-6 py-3 text-sm text-default-100
                            ">Jurusan</th>
                            <th class="border border-gray px-6 py-3 text-sm text-default-100
                            ">Nama Sekolah/PT</th>
                            <th class="border border-gray px-6 py-3 text-sm text-default-100
                            ">No Ijazah</th>
                            <th class="border border-gray px-6 py-3 text-sm text-default-100
                            ">Tahun Lulus</th>
                            <th class="border border-gray px-6 py-3 text-sm text-default-100
                            ">Pimpinan</th>
                            <th class="border border-gray px-6 py-3 text-sm text-default-100
                            ">Kode Pendidikan</th>
                            <th class="border border-gray px-6 py-3 text-sm text-default-100
                            " style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($riwayat_pendidikan as $rp)
                            <tr class="odd:bg-white">
                                <td class="border border-gray px-6 py-3 text-sm text-default-800">{{ $riwayat_pendidikan->firstItem() + $loop->iteration - 1 }}</td>
                                <td class="border border-gray px-6 py-3 text-sm text-default-800">
                                    {{ $rp->strata->nm_strata ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-default-800">
                                    {{ $rp->strata->jurusan ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-default-800">
                                    {{ $rp->nm_sekolah_pt ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-default-800">
                                    {{ $rp->no_ijazah ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-default-800">
                                    {{ $rp->thn_lulus ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-default-800">
                                    {{ $rp->pimpinan ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-default-800">
                                    {{ $rp->kode_pendidikan ?? '-' }}
                                </td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalPendidikan(
                                                {{ $rp->id }},
                                                '{{ addslashes(e($rp->strata->id)) }}',
                                                '{{ addslashes(e($rp->nm_sekolah_pt)) }}',
                                                '{{ addslashes(e($rp->no_ijazah)) }}',
                                                '{{ addslashes(e($rp->thn_lulus)) }}',
                                                '{{ addslashes(e($rp->pimpinan)) }}',
                                                '{{ addslashes(e($rp->kode_pendidikan)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.pendidikan.destroy', $rp->id) }}" method="POST" class="inline-block"
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
                                <td colspan="9" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada data Riwayat Pendidikan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL TAMBAH DATA RIWAYAT PENDIDIKAN --}}
                <div id="tambahModalPendidikan" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Pendidikan</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormPendidikan" method="POST" action="/admin/riwayat_pendidikan/store" novalidate>
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_pendidikan">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label class="block text-sm font-medium" style="margin-top: -25px;">Strata dan Jurusan</label>
                                    <select name="strata_id" id="tambah_strata_id" class="select2 mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                        <option value="">-- Pilih strata dan jurusan --</option>
                                        @foreach ($strata as $s)
                                            <option value="{{ $s->id }}" {{ old('strata_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nm_strata }} - {{ $s->jurusan }}
                                        </option>
                                        @endforeach
                                    </select>
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="strata_id_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Pilih Strata dalam daftar.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_nm_sekolah_pt" class="block text-sm font-medium text-gray-700">Nama Sekolah/PT</label>
                                    <input type="text" name="nm_sekolah_pt" id="tambah_nm_sekolah_pt" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_sekolah_pt') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="nm_sekolah_pt_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Nama Sekolah/PT wajib diisi.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_ijazah" class="block text-sm font-medium text-gray-700">No Ijazah</label>
                                    <input type="text" name="no_ijazah" id="tambah_no_ijazah" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_ijazah') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="no_ijazah_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        No Ijazah wajib diisi.
                                    </div>
                                    @error('no_ijazah')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_thn_lulus" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                    <input type="number" name="thn_lulus" id="tambah_thn_lulus" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" min="1950" max="{{ date('Y') }}" required value="{{ old('thn_lulus') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="thn_lulus_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Tahun Lulus wajib diisi.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_pimpinan" class="block text-sm font-medium text-gray-700">Pimpinan</label>
                                    <input type="text" name="pimpinan" id="tambah_pimpinan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pimpinan') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="pimpinan_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Nama Pimpinan wajib diisi.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_kode_pendidikan" class="block text-sm font-medium text-gray-700">Kode Pendidikan</label>
                                    <input type="text" name="kode_pendidikan" id="tambah_kode_pendidikan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('kode_pendidikan') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="kode_pendidikan_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Kode Pendidikan wajib diisi.
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6">
                            <button type="button" onclick="closeTambahModalPendidikan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormPendidikan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT PENDIDIKAN JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalPendidikan').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT PENDIDIKAN --}}
                @if(isset($rp))
                    <div id="editModalPendidikan" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat Pendidikan</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormPendidikan" method="POST" action="{{ route('backend.riwayat_pendidikan.update', $rp) }}" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_pendidikan">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium" style="margin-top: -25px;">Strata dan Jurusan</label>
                                        <select name="strata_id" id="edit_strata_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                            <option value="">-- Pilih strata dan jurusan --</option>
                                            @foreach ($strata as $s)
                                                <option value="{{ $s->id }}"
                                                    {{ old('strata_id', $rp->strata_id) == $s->id ? 'selected' : '' }}>
                                                    {{ $s->nm_strata }} - {{ $s->jurusan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_strata_id_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Pilih Strata dalam daftar.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_nm_sekolah_pt" class="block text-sm font-medium text-gray-700">Nama Sekolah/PT</label>
                                        <input type="text" name="nm_sekolah_pt" id="edit_nm_sekolah_pt" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_sekolah_pt', $rp->nm_sekolah_pt) }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_nm_sekolah_pt_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Nama Sekolah/PT wajib diisi.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_ijazah" class="block text-sm font-medium text-gray-700">No Ijazah</label>
                                        <input type="text" name="no_ijazah" id="edit_no_ijazah" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_ijazah', $rp->no_ijazah) }}">
                                        <div id="edit_no_ijazah_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            No Ijazah wajib diisi.
                                        </div>
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        @error('no_ijazah')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_thn_lulus" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                        <input type="number" name="thn_lulus" id="edit_thn_lulus" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('thn_lulus', $rp->thn_lulus) }}" min="1950" max="{{ date('Y') }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_thn_lulus_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Tahun Lulus wajib diisi.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pimpinan" class="block text-sm font-medium text-gray-700">Pimpinan</label>
                                        <input type="text" name="pimpinan" id="edit_pimpinan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pimpinan', $rp->pimpinan) }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_pimpinan_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Nama Pimpinan wajib diisi.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_kode_pendidikan" class="block text-sm font-medium text-gray-700">Kode Pendidikan</label>
                                        <input type="text" name="kode_pendidikan" id="edit_kode_pendidikan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('kode_pendidikan', $rp->kode_pendidikan) }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_kode_pendidikan_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Kode Pendidikan wajib diisi.
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                <button type="button" onclick="closeEditModalPendidikan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormPendidikan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT PENDIDIKAN JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalPendidikan').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
            {{-- TAMBAHKAN NAVIGASI PAGINATION DI SINI --}}
            <div class="mt-4 flex justify-end p-4">
                {{ $riwayat_pendidikan->links('pagination::tailwind') }}
            </div>
            
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT PENDIDIKAN--}}
    <script>
        // Fungsi inisialisasi yang lebih aman
        function initSelect2(modalId, selectId) {
            // Cek apakah Select2 sudah diinisialisasi
            if ($(selectId).hasClass('select2-hidden-accessible')) {
                return;
            }

            $(selectId).select2({ 
                dropdownParent: $(modalId), 
                placeholder: "-- Pilih strata dan jurusan --",
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

        // Fungsi khusus untuk membuka Modal Tambah
        function openTambahModalPendidikan() {
            // 1. Inisialisasi Select2 untuk dropdown Strata
            initSelect2('#tambahModalPendidikan', '#tambah_strata_id');
            
            // 2. Tampilkan Modal
            document.getElementById('tambahModalPendidikan').classList.remove('hidden');
        }
        
        // --- LOGIKA VALIDASI KUSTOM DI SISI KLIEN ---
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('tambahFormPendidikan');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    
                    let isValid = true;
                    
                    // --- Definisikan Field Wajib ---
                    const fields = [
                        // Sesuaikan ID dengan input di Modal Tambah Pendidikan Anda
                        { id: 'tambah_strata_id', errorId: 'strata_id_error', type: 'select2' },
                        { id: 'tambah_nm_sekolah_pt', errorId: 'nm_sekolah_pt_error', type: 'input' },
                        { id: 'tambah_no_ijazah', errorId: 'no_ijazah_error', type: 'input' },
                        { id: 'tambah_thn_lulus', errorId: 'thn_lulus_error', type: 'input' },
                        { id: 'tambah_pimpinan', errorId: 'pimpinan_error', type: 'input' },
                        { id: 'tambah_kode_pendidikan', errorId: 'kode_pendidikan_error', type: 'input' },
                    ];

                    // --- Loop dan Validasi (Menggunakan logika yang sama) ---
                    fields.forEach(field => {
                        const inputElement = document.getElementById(field.id);
                        const errorDiv = document.getElementById(field.errorId);
                        let valueToCheck = inputElement.value;
                        let isFieldValid = true;

                        // Logika pengecekan value (Select2 atau Input)
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
                            errorDiv.style.display = 'block';
                            // Tambahkan class error pada input/container
                            if (field.type === 'select2') {
                                $(inputElement).next('.select2-container').find('.select2-selection--single').addClass('border-red-500');
                            } else {
                                inputElement.classList.add('border-red-500');
                            }
                            isValid = false;
                        } else {
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

        function closeTambahModalPendidikan() {
            document.getElementById('tambahModalPendidikan').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT PENDIDIKAN--}}
    <script>
        function openEditModalPendidikan(id, strata_id, nm_sekolah_pt, no_ijazah, thn_lulus, pimpinan, kode_pendidikan) {
            document.getElementById('edit_id_pendidikan').value = id;
            document.getElementById('edit_strata_id').value = strata_id;
            document.getElementById('edit_nm_sekolah_pt').value = nm_sekolah_pt;
            document.getElementById('edit_no_ijazah').value = no_ijazah;
            document.getElementById('edit_thn_lulus').value = thn_lulus;
            document.getElementById('edit_pimpinan').value = pimpinan;
            document.getElementById('edit_kode_pendidikan').value = kode_pendidikan;

            initSelect2('#editModalPendidikan', '#edit_strata_id');
            $('#editModalPendidikan #edit_strata_id').val(strata_id).trigger('change');

            document.getElementById('editFormPendidikan').action = `/admin/riwayat_pendidikan/${id}`;
            document.getElementById('editModalPendidikan').classList.remove('hidden');
        }

        function closeEditModalPendidikan() {
            document.getElementById('editModalPendidikan').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK VALIDASI EDIT MODAL EDIT --}}
    <script>
        // Ambil form secara langsung setelah form di-render oleh Blade
        const formEdit = document.getElementById('editFormPendidikan');

        if (formEdit) {
            formEdit.addEventListener('submit', function(e) {
                
                let isValid = true;
                
                // --- Definisikan semua elemen Input/Error di Modal Edit ---
                const fields = [
                    // PASTIKAN ID ERROR INI ADA DI BLADE EDIT MODAL!
                    { id: 'edit_strata_id', errorId: 'edit_strata_id_error', type: 'select2' },
                    { id: 'edit_nm_sekolah_pt', errorId: 'edit_nm_sekolah_pt_error', type: 'input' },
                    { id: 'edit_no_ijazah', errorId: 'edit_no_ijazah_error', type: 'input' },
                    { id: 'edit_thn_lulus', errorId: 'edit_thn_lulus_error', type: 'input' },
                    { id: 'edit_pimpinan', errorId: 'edit_pimpinan_error', type: 'input' },
                    { id: 'edit_kode_pendidikan', errorId: 'edit_kode_pendidikan_error', type: 'input' },
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