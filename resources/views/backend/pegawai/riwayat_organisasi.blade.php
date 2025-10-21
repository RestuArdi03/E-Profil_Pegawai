@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Riwayat Organisasi
        <button type="button"
        onclick="openTambahModalOrganisasi()"
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
         
        $currentRoute = route('backend.organisasi.show', $pegawaiId); 

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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Organisasi</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jabatan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Masa Jabatan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pejabat Penetap</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($riwayat_organisasi as $org)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $riwayat_organisasi->firstItem() + $loop->iteration - 1 }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $org->organisasi }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $org->jabatan }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $org->masa_jabatan }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $org->no_sk }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $org->tgl_sk }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $org->pejabat_penetap }}</td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalOrganisasi(
                                                {{ $org->id }},
                                                '{{ addslashes(e($org->organisasi)) }}',
                                                '{{ addslashes(e($org->jabatan)) }}',
                                                '{{ addslashes(e($org->masa_jabatan)) }}',
                                                '{{ addslashes(e($org->no_sk)) }}',
                                                '{{ addslashes(e($org->tgl_sk)) }}',
                                                '{{ addslashes(e($org->pejabat_penetap)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.organisasi.destroy', $org->id) }}" method="POST" class="inline-block"
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
                                    Belum ada data Riwayat Organisasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            {{-- MODAL TAMBAH DATA RIWAYAT ORGANSIASI --}}
                <div id="tambahModalOrganisasi" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Organisasi</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormOrganisasi" method="POST" action="/admin/riwayat_organisasi/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_organisasi">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_organisasi" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Organisasi</label>
                                    <input type="text" name="organisasi" id="tambah_organisasi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('organisasi') }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tambah_jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                    <input type="text" name="jabatan" id="tambah_jabatan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jabatan') }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tambah_masa_jabatan" class="block text-sm font-medium text-gray-700">Masa Jabatan</label>
                                    <input type="text" name="masa_jabatan" id="tambah_masa_jabatan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('masa_jabatan') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                    <input type="text" name="no_sk" id="tambah_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk') }}">
                                    @error('no_sk')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                    <input type="date" name="tgl_sk" id="tambah_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_pejabat_penetap" class="block text-sm font-medium text-gray-700">Pejabat Penetap</label>
                                    <input type="text" name="pejabat_penetap" id="tambah_pejabat_penetap" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penetap') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                            <button type="button" onclick="closeTambahModalOrganisasi()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormOrganisasi" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT ORGANISASI JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalOrganisasi').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT ORGANISASI --}}
                @if(isset($org))
                    <div id="editModalOrganisasi" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat Organisasi</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormOrganisasi" method="POST" action="{{ route('backend.riwayat_organisasi.update', $org) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_organisasi">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_organisasi" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Organisasi</label>
                                        <input type="text" name="organisasi" id="edit_organisasi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('organisasi') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                        <input type="text" name="jabatan" id="edit_jabatan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jabatan', $org->jabatan) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_masa_jabatan" class="block text-sm font-medium text-gray-700">Masa Jabatan</label>
                                        <input type="text" name="masa_jabatan" id="edit_masa_jabatan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('masa_jabatan', $org->masa_jabatan) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                        <input type="text" name="no_sk" id="edit_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk', $org->no_sk) }}">
                                        @error('no_sk')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                        <input type="date" name="tgl_sk" id="edit_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk', $org->tgl_sk) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pejabat_penetap" class="block text-sm font-medium text-gray-700">Pejabat Penetap</label>
                                        <input type="text" name="pejabat_penetap" id="edit_pejabat_penetap" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penetap', $org->pejabat_penetap) }}">
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                                <button type="button" onclick="closeEditModalOrganisasi()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormOrganisasi" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT ORGANISASI JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalOrganisasi').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
            {{-- TAMBAHKAN NAVIGASI PAGINATION DI SINI --}}
            <div class="mt-4 flex justify-end p-4">
                {{ $riwayat_organisasi->links('pagination::tailwind') }}
            </div>

        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT ORGANISASI--}}
    <script>
        console.log(document.getElementById('tambahFormOrganisasi').action);
        function openTambahModalOrganisasi() {
        document.getElementById('tambahModalOrganisasi').classList.remove('hidden');
        }

        function closeTambahModalOrganisasi() {
            document.getElementById('tambahModalOrganisasi').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT ORGANISASI--}}
    <script>
        function openEditModalOrganisasi(id, organisasi, jabatan,masa_jabatan, no_sk, tgl_sk, pejabat_penetap) {
            document.getElementById('edit_id_organisasi').value = id;
            document.getElementById('edit_organisasi').value = organisasi;
            document.getElementById('edit_jabatan').value = jabatan;
            document.getElementById('edit_masa_jabatan').value = masa_jabatan;
            document.getElementById('edit_no_sk').value = no_sk;
            document.getElementById('edit_tgl_sk').value = tgl_sk;
            document.getElementById('edit_pejabat_penetap').value = pejabat_penetap;

            document.getElementById('editFormOrganisasi').action = `/admin/riwayat_organisasi/${id}`;
            document.getElementById('editModalOrganisasi').classList.remove('hidden');
        }

        function closeEditModalOrganisasi() {
            document.getElementById('editModalOrganisasi').classList.add('hidden');
        }
    </script>
@endsection