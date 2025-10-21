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
                            <form id="tambahFormJabatan" method="POST" action="/admin/riwayat_jabatan/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_jabatan">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3" style="margin-top: -25px;">
                                    <label for="tambah_jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                    <input type="text" name="jabatan" id="tambah_jabatan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jabatan') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Eselon</label>
                                    <select name="eselon_id" id="eselon_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                        <option value="">-- Pilih eselon --</option>
                                        @foreach ($eselon as $sln)
                                            <option value="{{ $sln->id }}"
                                                {{ old('eselon_id') == $sln->id ? 'selected' : '' }}>
                                                {{ $sln->nm_eselon }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Jenis Jabatan</label>
                                    <select name="jenis_jabatan_id" id="jenis_jabatan_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                        <option value="">-- Pilih jenis jabatan --</option>
                                        @foreach ($jenis_jabatan as $jbtn)
                                            <option value="{{ $jbtn->id }}"
                                                {{ old('jenis_jabatan_id') == $jbtn->id ? 'selected' : '' }}>
                                                {{ $jbtn->jenis_jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tmt" class="block text-sm font-medium text-gray-700">TMT</label>
                                    <input type="date" name="tmt" id="tambah_tmt" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmt') }}">
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

                                <div class="mb-3">
                                    <label for="tambah_jenis_mutasi" class="block text-sm font-medium text-gray-700">Jenis Mutasi</label>
                                    <input type="text" name="jenis_mutasi" id="tambah_jenis_mutasi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jenis_mutasi') }}">
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
                                <form id="editFormJabatan" method="POST" action="{{ route('backend.riwayat_jabatan.update', $rj) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_jabatan">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3" style="margin-top: -25px;">
                                        <label for="edit_jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                        <input type="text" name="jabatan" id="edit_jabatan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jabatan', $rj->jabatan) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium">Eselon</label>
                                        <select name="eselon_id" id="edit_eselon_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                            <option value="">-- Pilih eselon --</option>
                                            @foreach ($eselon as $sln)
                                                <option value="{{ $sln->id }}"
                                                    {{ old('eselon_id') == $sln->id ? 'selected' : '' }}>
                                                    {{ $sln->nm_eselon }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium">Jenis Jabatan</label>
                                        <select name="jenis_jabatan_id" id="edit_jenis_jabatan_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                            <option value="">-- Pilih jenis jabatan --</option>
                                            @foreach ($jenis_jabatan as $jbtn)
                                                <option value="{{ $jbtn->id }}"
                                                    {{ old('jenis_jabatan_id') == $jbtn->id ? 'selected' : '' }}>
                                                    {{ $jbtn->jenis_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tmt" class="block text-sm font-medium text-gray-700">TMT</label>
                                        <input type="date" name="tmt" id="edit_tmt" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmt', $rj->tmt) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                        <input type="text" name="no_sk" id="edit_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk', $rj->no_sk) }}">
                                        @error('no_sk')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                        <input type="date" name="tgl_sk" id="edit_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk', $rj->tgl_sk) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pejabat_penetap" class="block text-sm font-medium text-gray-700">Pejabat Penetap</label>
                                        <input type="text" name="pejabat_penetap" id="edit_pejabat_penetap" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penetap', $rj->pejabat_penetap) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_jenis_mutasi" class="block text-sm font-medium text-gray-700">Jenis Mutasi</label>
                                        <input type="text" name="jenis_mutasi" id="edit_jenis_mutasi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jenis_mutasi', $rj->jenis_mutasi) }}">
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
        console.log(document.getElementById('tambahFormJabatan').action);
        function openTambahModalJabatan() {
        document.getElementById('tambahModalJabatan').classList.remove('hidden');
        }

        function closeTambahModalJabatan() {
            document.getElementById('tambahModalJabatan').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT JABATAN --}}
    <script>
        function openEditModalJabatan(id, jabatan, eselon_id, jenis_jabatan_id, tmt, no_sk, tgl_sk, pejabat_penetap, jenis_mutasi) {

            console.log({
                id, jabatan, eselon_id, jenis_jabatan_id,
                tmt, no_sk, tgl_sk, pejabat_penetap, jenis_mutasi
            });

            const modal = document.getElementById('editModalJabatan');
            modal.classList.remove('hidden');

            document.getElementById('edit_id_jabatan').value = id;
            document.getElementById('edit_jabatan').value = jabatan;
            document.getElementById('edit_eselon_id').value = eselon_id;
            document.getElementById('edit_jenis_jabatan_id').value = jenis_jabatan_id;
            document.getElementById('edit_tmt').value = tmt;
            document.getElementById('edit_no_sk').value = no_sk;
            document.getElementById('edit_tgl_sk').value = tgl_sk;
            document.getElementById('edit_pejabat_penetap').value = pejabat_penetap;
            document.getElementById('edit_jenis_mutasi').value = jenis_mutasi;

            document.getElementById('editFormJabatan').action = `/admin/riwayat_jabatan/${id}`;
            document.getElementById('editModalJabatan').classList.remove('hidden');
        }

        function closeEditModalJabatan() {
            document.getElementById('editModalJabatan').classList.add('hidden');
        }
    </script>

@endsection
