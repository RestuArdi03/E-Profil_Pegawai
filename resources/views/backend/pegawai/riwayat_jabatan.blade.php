@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Riwayat Jabatan
        <button type="button"
        onclick="openTambahModalJabatan()"
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
         
        $currentRoute = route('backend.jabatan.show', $pegawaiId); 

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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jabatan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Eselon</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jenis Jabatan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">TMT</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pejabat Penetap</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jenis Mutasi</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat_jabatan as $rj)
                            <tr class="odd:bg-white">
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $riwayat_jabatan->firstItem() + $loop->iteration - 1 }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->jabatan ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->eselon->nm_eselon ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->jenis_jabatan->jenis_jabatan ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->tmt ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->no_sk ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ \Carbon\Carbon::parse($rj->tgl_sk)->format('d-m-Y') ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->pejabat_penetap ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->jenis_mutasi ?? '-' }}
                                </td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalJabatan(
                                                {{ $rj->id }},
                                                '{{ addslashes(e($rj->jabatan)) }}',
                                                '{{ addslashes(e($rj->eselon->id)) }}',
                                                '{{ addslashes(e($rj->jenis_jabatan->id)) }}',
                                                '{{ addslashes(e($rj->tmt)) }}',
                                                '{{ addslashes(e($rj->no_sk)) }}',
                                                '{{ addslashes(e($rj->tgl_sk)) }}',
                                                '{{ addslashes(e($rj->pejabat_penetap)) }}',
                                                '{{ addslashes(e($rj->jenis_mutasi)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.jabatan.destroy', $rj->id) }}" method="POST" class="inline-block"
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
                                <td colspan="10" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada data Riwayat Jabatan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL TAMBAH DATA RIWAYAT JABATAN --}}
                <div id="tambahModalJabatan" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Jabatan</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormJabatan" method="POST" action="/admin/riwayat_jabatan/store" novalidate>
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_jabatan">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3" style="margin-top: -25px;">
                                    <label for="tambah_jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                    <input type="text" name="jabatan" id="tambah_jabatan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jabatan') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="jabatan_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Nama Jabatan wajib diisi.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Eselon</label>
                                    <select name="eselon_id" id="eselon_id" class="select2 mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                        <option value="">-- Pilih eselon --</option>
                                        @foreach ($eselon as $sln)
                                            <option value="{{ $sln->id }}"
                                                {{ old('eselon_id') == $sln->id ? 'selected' : '' }}>
                                                {{ $sln->nm_eselon }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="eselon_id_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Pilih Eselon dalam daftar.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Jenis Jabatan</label>
                                    <select name="jenis_jabatan_id" id="jenis_jabatan_id" class="select2 mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                        <option value="">-- Pilih jenis jabatan --</option>
                                        @foreach ($jenis_jabatan as $jbtn)
                                            <option value="{{ $jbtn->id }}"
                                                {{ old('jenis_jabatan_id') == $jbtn->id ? 'selected' : '' }}>
                                                {{ $jbtn->jenis_jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="jenis_jabatan_id_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Pilih Jenis Jabatan dalam daftar.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tmt" class="block text-sm font-medium text-gray-700">TMT</label>
                                    <input type="date" name="tmt" id="tambah_tmt" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmt') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="tmt_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        TMT wajib diisi.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                    <input type="text" name="no_sk" id="tambah_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="no_sk_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        No SK wajib diisi.
                                    </div>
                                    @error('no_sk')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                    <input type="date" name="tgl_sk" id="tambah_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="tgl_sk_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Tanggal SK wajib diisi.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_pejabat_penetap" class="block text-sm font-medium text-gray-700">Pejabat Penetap</label>
                                    <input type="text" name="pejabat_penetap" id="tambah_pejabat_penetap" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penetap') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="pejabat_penetap_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Nama Pejabat Penetap wajib diisi.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_jenis_mutasi" class="block text-sm font-medium text-gray-700">Jenis Mutasi</label>
                                    <input type="text" name="jenis_mutasi" id="tambah_jenis_mutasi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jenis_mutasi') }}">
                                    {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                    <div id="jenis_mutasi_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                        Jenis Mutasi wajib diisi.
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6">
                            <button type="button" onclick="closeTambahModalJabatan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormJabatan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT JABATAN JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalJabatan').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODAL EDIT DATA RIWAYAT JABATAN --}}
                @if(isset($rj))
                    <div id="editModalJabatan" class="form_ edit fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat Jabatan</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormJabatan" method="POST" action="{{ route('backend.riwayat_jabatan.update', $rj) }}" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_jabatan">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3" style="margin-top: -25px;">
                                        <label for="edit_jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                        <input type="text" name="jabatan" id="edit_jabatan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jabatan', $rj->jabatan) }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_jabatan_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Nama Jabatan wajib diisi.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium">Eselon</label>
                                        <select name="eselon_id" id="edit_eselon_id" class=" select2 mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                            <option value="">-- Pilih eselon --</option>
                                            @foreach ($eselon as $sln)
                                                <option value="{{ $sln->id }}"
                                                    {{ old('eselon_id') == $sln->id ? 'selected' : '' }}>
                                                    {{ $sln->nm_eselon }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_eselon_id_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Pilih Eselon dalam daftar.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium">Jenis Jabatan</label>
                                        <select name="jenis_jabatan_id" id="edit_jenis_jabatan_id" class="select2 mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                            <option value="">-- Pilih jenis jabatan --</option>
                                            @foreach ($jenis_jabatan as $jbtn)
                                                <option value="{{ $jbtn->id }}"
                                                    {{ old('jenis_jabatan_id') == $jbtn->id ? 'selected' : '' }}>
                                                    {{ $jbtn->jenis_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_jenis_jabatan_id_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Pilih Jenis Jabatan dalam daftar.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tmt" class="block text-sm font-medium text-gray-700">TMT</label>
                                        <input type="date" name="tmt" id="edit_tmt" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmt', $rj->tmt) }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_tmt_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            TMT wajib diisi.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                        <input type="text" name="no_sk" id="edit_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk', $rj->no_sk) }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_no_sk_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            No SK wajib diisi.
                                        </div>
                                        @error('no_sk')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                        <input type="date" name="tgl_sk" id="edit_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk', $rj->tgl_sk) }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_tgl_sk_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Tanggal SK wajib diisi.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pejabat_penetap" class="block text-sm font-medium text-gray-700">Pejabat Penetap</label>
                                        <input type="text" name="pejabat_penetap" id="edit_pejabat_penetap" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penetap', $rj->pejabat_penetap) }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_pejabat_penetap_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Nama Pejabat Penetap wajib diisi.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_jenis_mutasi" class="block text-sm font-medium text-gray-700">Jenis Mutasi</label>
                                        <input type="text" name="jenis_mutasi" id="edit_jenis_mutasi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jenis_mutasi', $rj->jenis_mutasi) }}">
                                        {{-- WADAH PESAN ERROR KHUSUS CLIENT-SIDE --}}
                                        <div id="edit_jenis_mutasi_error" class="text-red-500 text-sm mt-1" style="display: none;">
                                            Jenis Mutasi wajib diisi.
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6">
                                <button type="button" onclick="closeEditModalJabatan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormJabatan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT JABATAN JIKA ADA ERROR--}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalJabatan').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
            {{-- TAMBAHKAN NAVIGASI PAGINATION DI SINI --}}
            <div class="mt-4 flex justify-end p-4">
                {{ $riwayat_jabatan->links('pagination::tailwind') }}
            </div>

        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT JABATAN --}}
    <script>
        // Fungsi inisialisasi yang lebih aman
        function initSelect2(modalId, selectId, placeholderText) {
            // Cek apakah Select2 sudah diinisialisasi
            if ($(selectId).hasClass('select2-hidden-accessible')) {
                return;
            }

            $(selectId).select2({ 
                dropdownParent: $(modalId), 
                placeholder: placeholderText,
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
        function openTambahModalJabatan() {
            const modalId = '#tambahModalJabatan'; 

            // 1. PANGGILAN 1: ESELON
            initSelect2(modalId, '#eselon_id', '-- Pilih Eselon --');
            
            // 2. PANGGILAN 2: JENIS JABATAN
            initSelect2(modalId, '#jenis_jabatan_id', '-- Pilih Jenis Jabatan --'); 

            // 3. APLIKASIKAN STYLING FULL WIDTH (Hanya dilakukan setelah Select2 aktif)
            
            // Targetkan kedua container Select2 yang baru dibuat
            // Asumsi: #eselon_id dan #jenis_jabatan_id adalah ID asli SELECT
            ['#eselon_id', '#jenis_jabatan_id'].forEach(selectId => {
                const container = $(selectId).next('.select2-container');
                
                // Terapkan batas tinggi dan styling Tailwind untuk lebar/border
                container.addClass('w-full custom-select-full'); 
                container.find('.select2-selection--single')
                        .addClass('mt-1 border border-gray-300 rounded-md text-sm py-2'); 
                
                // Jika Anda masih memiliki masalah tinggi/panah:
                container.find('.select2-selection__arrow').css('top', '50%').css('transform', 'translateY(-50%)');
            });
            
            // 2. Tampilkan Modal
            document.getElementById('tambahModalJabatan').classList.remove('hidden');
        }
        
        // --- LOGIKA VALIDASI KUSTOM DI SISI KLIEN ---
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('tambahFormJabatan');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    
                    let isValid = true;
                    
                    // --- Definisikan Field Wajib ---
                    const fields = [
                        // Sesuaikan ID dengan input di Modal Tambah
                        { id: 'tambah_jabatan', errorId: 'jabatan_error', type: 'input' },
                        { id: 'eselon_id', errorId: 'eselon_id_error', type: 'select2' },
                        { id: 'jenis_jabatan_id', errorId: 'jenis_jabatan_id_error', type: 'select2' },
                        { id: 'tambah_tmt', errorId: 'tmt_error', type: 'input' },
                        { id: 'tambah_no_sk', errorId: 'no_sk_error', type: 'input' },
                        { id: 'tambah_tgl_sk', errorId: 'tgl_sk_error', type: 'input' },
                        { id: 'tambah_pejabat_penetap', errorId: 'pejabat_penetap_error', type: 'input' },
                        { id: 'tambah_jenis_mutasi', errorId: 'jenis_mutasi_error', type: 'input' }
                    ];

                    // --- Loop dan Validasi (Menggunakan logika yang sama) ---
                    fields.forEach(field => {
                        const inputElement = document.getElementById(field.id);
                        const errorDiv = document.getElementById(field.errorId);

                        // KODE DEBUGGING: JIKA ELEMEN TIDAK DITEMUKAN, LOG DI KONSEL DAN GAGALKAN VALIDASI
                        if (!inputElement || !errorDiv) {
                            console.error("VALIDATION ERROR: Element or Error Div not found for ID:", field.id, field.errorId);
                            isValid = false; // Gagal secara eksplisit jika elemen hilang
                            return; // PENTING: hentikan iterasi saat ini
                        }
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

        function closeTambahModalJabatan() {
            document.getElementById('tambahModalJabatan').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT JABATAN --}}
    <script>
        // Asumsi: initSelect2() didefinisikan di atas file ini dan sudah benar.
        
        function openEditModalJabatan(id, jabatan, eselon_id, jenis_jabatan_id, tmt, no_sk, tgl_sk, pejabat_penetap, jenis_mutasi) {
            
            const modal = document.getElementById('editModalJabatan');

            // 1. Inisialisasi Select2 (Harus dilakukan sebelum prefill)
            initSelect2('#editModalJabatan', '#edit_eselon_id', '-- Pilih Eselon --');
            initSelect2('#editModalJabatan', '#edit_jenis_jabatan_id', '-- Pilih Jenis Jabatan --');
            
            // 2. Mengisi field input standar
            document.getElementById('edit_id_jabatan').value = id;
            document.getElementById('edit_jabatan').value = jabatan;
            document.getElementById('edit_tmt').value = tmt;
            document.getElementById('edit_no_sk').value = no_sk;
            document.getElementById('edit_tgl_sk').value = tgl_sk;
            document.getElementById('edit_pejabat_penetap').value = pejabat_penetap;
            document.getElementById('edit_jenis_mutasi').value = jenis_mutasi;

            // 3. PREFILL SELECT2 (Wajib trigger 'change')
            $('#editModalJabatan #edit_eselon_id').val(eselon_id).trigger('change');
            $('#editModalJabatan #edit_jenis_jabatan_id').val(jenis_jabatan_id).trigger('change');

            // 4. Set Action dan Tampilkan Modal
            document.getElementById('editFormJabatan').action = `/admin/riwayat_jabatan/${id}`;
            modal.classList.remove('hidden');
        }

        function closeEditModalJabatan() {
            document.getElementById('editModalJabatan').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK VALIDASI EDIT MODAL EDIT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Tambahkan Validasi untuk Modal Edit Jabatan ---
            const formEditJabatan = document.getElementById('editFormJabatan');
            
            if (formEditJabatan) {
                formEditJabatan.addEventListener('submit', function(e) {
                    
                    let isValid = true;
                    
                    // --- Definisikan Field Wajib Modal Edit ---
                    const fieldsEdit = [
                        // Pastikan ID ini cocok dengan Modal Edit Anda
                        { id: 'edit_jabatan', errorId: 'edit_jabatan_error', type: 'input' },
                        { id: 'edit_eselon_id', errorId: 'edit_eselon_id_error', type: 'select2' },
                        { id: 'edit_jenis_jabatan_id', errorId: 'edit_jenis_jabatan_id_error', type: 'select2' },
                        { id: 'edit_tmt', errorId: 'edit_tmt_error', type: 'input' },
                        { id: 'edit_no_sk', errorId: 'edit_no_sk_error', type: 'input' },
                        { id: 'edit_tgl_sk', errorId: 'edit_tgl_sk_error', type: 'input' },
                        { id: 'edit_pejabat_penetap', errorId: 'edit_pejabat_penetap_error', type: 'input' },
                        { id: 'edit_jenis_mutasi', errorId: 'edit_jenis_mutasi_error', type: 'input' }
                    ];

                    // --- Loop dan Validasi (Gunakan logika yang sama seperti di Modal Tambah) ---
                    fieldsEdit.forEach(field => {
                        // ... (ulangi logika validasi dari Modal Tambah, menggunakan fieldsEdit) ...
                        const inputElement = document.getElementById(field.id);
                        const errorDiv = document.getElementById(field.errorId);
                        
                        if (!inputElement || !errorDiv) return; // Fail safe
                        
                        let valueToCheck = inputElement.value;
                        let isFieldValid = true;

                        if (field.type === 'select2' ? !valueToCheck : !valueToCheck || valueToCheck.trim() === '') {
                            isFieldValid = false;
                        }

                        if (!isFieldValid) {
                            errorDiv.style.display = 'block';
                            const selector = field.type === 'select2' ? $(inputElement).next('.select2-container').find('.select2-selection--single') : inputElement;
                            $(selector).addClass('border-red-500');
                            isValid = false;
                        } else {
                            errorDiv.style.display = 'none';
                            const selector = field.type === 'select2' ? $(inputElement).next('.select2-container').find('.select2-selection--single') : inputElement;
                            $(selector).removeClass('border-red-500');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault(); 
                    }
                });
            }
            
        });
    </script>

@endsection
