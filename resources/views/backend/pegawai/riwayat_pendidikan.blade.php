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
                        Jabatan: {{ $jabatanTerbaru ?? 'Staff' }}
                    </p>
                </div>
            </div>
        </div>        
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
                                <td class="border border-gray px-6 py-3 text-sm text-default-800">{{ $loop->iteration }}</td>
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
                            <form id="tambahFormPendidikan" method="POST" action="/admin/riwayat_pendidikan/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_pendidikan">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label class="block text-sm font-medium" style="margin-top: -25px;">Strata dan Jurusan</label>
                                    <select name="strata_id" id="strata_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                        <option value="">-- Pilih strata dan jurusan --</option>
                                        @foreach ($strata as $s)
                                            <option value="{{ $s->id }}" {{ old('strata_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nm_strata }} - {{ $s->jurusan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_nm_sekolah_pt" class="block text-sm font-medium text-gray-700">Nama Sekolah/PT</label>
                                    <input type="text" name="nm_sekolah_pt" id="tambah_nm_sekolah_pt" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_sekolah_pt') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_ijazah" class="block text-sm font-medium text-gray-700">No Ijazah</label>
                                    <input type="text" name="no_ijazah" id="tambah_no_ijazah" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_ijazah') }}">
                                    @error('no_ijazah')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_thn_lulus" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                    <input type="number" name="thn_lulus" id="tambah_thn_lulus" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" min="1950" max="{{ date('Y') }}" required value="{{ old('thn_lulus') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_pimpinan" class="block text-sm font-medium text-gray-700">Pimpinan</label>
                                    <input type="text" name="pimpinan" id="tambah_pimpinan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pimpinan') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_kode_pendidikan" class="block text-sm font-medium text-gray-700">Kode Pendidikan</label>
                                    <input type="text" name="kode_pendidikan" id="tambah_kode_pendidikan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('kode_pendidikan') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
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
                                <form id="editFormPendidikan" method="POST" action="{{ route('backend.riwayat_pendidikan.update', $rp) }}">
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
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_nm_sekolah_pt" class="block text-sm font-medium text-gray-700">Nama Sekolah/PT</label>
                                        <input type="text" name="nm_sekolah_pt" id="edit_nm_sekolah_pt" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_sekolah_pt', $rp->nm_sekolah_pt) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_ijazah" class="block text-sm font-medium text-gray-700">No Ijazah</label>
                                        <input type="text" name="no_ijazah" id="edit_no_ijazah" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_ijazah', $rp->no_ijazah) }}">
                                        @error('no_ijazah')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_thn_lulus" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                        <input type="number" name="thn_lulus" id="edit_thn_lulus" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('thn_lulus', $rp->thn_lulus) }}" min="1950" max="{{ date('Y') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pimpinan" class="block text-sm font-medium text-gray-700">Pimpinan</label>
                                        <input type="text" name="pimpinan" id="edit_pimpinan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pimpinan', $rp->pimpinan) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_kode_pendidikan" class="block text-sm font-medium text-gray-700">Kode Pendidikan</label>
                                        <input type="text" name="kode_pendidikan" id="edit_kode_pendidikan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('kode_pendidikan', $rp->kode_pendidikan) }}">
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
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT PENDIDIKAN--}}
    <script>
        console.log(document.getElementById('tambahFormPendidikan').action);
        function openTambahModalPendidikan() {
        document.getElementById('tambahModalPendidikan').classList.remove('hidden');
        }

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

            document.getElementById('editFormPendidikan').action = `/admin/riwayat_pendidikan/${id}`;
            document.getElementById('editModalPendidikan').classList.remove('hidden');
        }

        function closeEditModalPendidikan() {
            document.getElementById('editModalPendidikan').classList.add('hidden');
        }
    </script>

@endsection