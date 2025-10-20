@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Riwayat Diklat
        <button type="button"
        onclick="openTambahModalDiklat()"
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Diklat</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">JPL</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Mulai</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Selesai</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No Sertifikat</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Sertifikat</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Penyelenggara</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($riwayat_diklat as $rd)
                                <tr>
                                    <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">
                                        {{ $rd->nm_diklat }}
                                    </td>
                                    <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">
                                        {{ $rd->jpl }}
                                    </td>
                                    <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">
                                        {{ $rd->tgl_mulai }}
                                    </td>
                                    <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">
                                        {{ $rd->tgl_selesai }}
                                    </td>
                                    <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">
                                        {{ $rd->no_sertifikat }}
                                    </td>
                                    <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">
                                        {{ $rd->tgl_sertifikat }}
                                    </td>
                                    <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">
                                        {{ $rd->penyelenggara }}
                                    </td>
                                    <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">    
                                        <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                            {{-- Tombol Edit --}}
                                            <button type="button"
                                                onclick="openEditModalDiklat(
                                                    {{ $rd->id }},
                                                    '{{ addslashes(e($rd->nm_diklat)) }}',
                                                    '{{ addslashes(e($rd->jpl)) }}',
                                                    '{{ addslashes(e($rd->tgl_mulai)) }}',
                                                    '{{ addslashes(e($rd->tgl_selesai)) }}',
                                                    '{{ addslashes(e($rd->no_sertifikat)) }}',
                                                    '{{ addslashes(e($rd->tgl_sertifikat)) }}',
                                                    '{{ addslashes(e($rd->penyelenggara)) }}'
                                                )"
                                                class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                                <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                                Edit
                                            </button>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('backend.diklat.destroy', $rd->id) }}" method="POST" class="inline-block"
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
                                    Belum ada data Riwayat Diklat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                                {{-- MODAL TAMBAH DATA RIWAYAT DIKLAT --}}
                <div id="tambahModalDiklat" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Diklat</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormDiklat" method="POST" action="/admin/riwayat_diklat/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_diklat">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_nm_diklat" class="block text-sm font-medium  text-gray-700" style="margin-top: -25px;">Nama Diklat</label>
                                    <input type="text" name="nm_diklat" id="tambah_nm_diklat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_diklat') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_jpl" class="block text-sm font-medium text-gray-700">JPL</label>
                                    <input type="number" name="jpl" id="tambah_jpl" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jpl') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                    <input type="date" name="tgl_mulai" id="tambah_tgl_mulai" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_mulai') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_selesai" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                    <input type="date" name="tgl_selesai" id="tambah_tgl_selesai" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" min="1950" max="{{ date('Y') }}" required value="{{ old('tgl_selesai') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_sertifikat" class="block text-sm font-medium text-gray-700">No Sertifikat</label>
                                    <input type="text" name="no_sertifikat" id="tambah_no_sertifikat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sertifikat') }}">
                                    @error('no_sertifikat')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_sertifikat" class="block text-sm font-medium text-gray-700">Tanggal Sertifikat</label>
                                    <input type="date" name="tgl_sertifikat" id="tambah_tgl_sertifikat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sertifikat') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_penyelenggara" class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                                    <input type="text" name="penyelenggara" id="tambah_penyelenggara" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('penyelenggara') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6">
                            <button type="button" onclick="closeTambahModalDiklat()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormDiklat" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT DIKLAT JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalDiklat').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT DIKLAT --}}
                @if(isset($rd))
                    <div id="editModalDiklat" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat Diklat</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormDiklat" method="POST" action="{{ route('backend.riwayat_diklat.update', $rd) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_diklat">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_nm_diklat" class="block text-sm font-medium  text-gray-700" style="margin-top: -25px;">Nama Diklat</label>
                                        <input type="text" name="nm_diklat" id="edit_nm_diklat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_diklat', $rd->nm_diklat) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_jpl" class="block text-sm font-medium text-gray-700">JPL</label>
                                        <input type="number" name="jpl" id="edit_jpl" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jpl', $rd->jpl) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                        <input type="date" name="tgl_mulai" id="edit_tgl_mulai" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_mulai', $rd->tgl_mulai) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                        <input type="date" name="tgl_selesai" id="edit_tgl_selesai" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_selesai', $rd->tgl_selesai) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_sertifikat" class="block text-sm font-medium text-gray-700">No Sertifikat</label>
                                        <input type="text" name="no_sertifikat" id="edit_no_sertifikat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sertifikat', $rd->no_sertifikat) }}">
                                        @error('no_sertifikat')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_sertifikat" class="block text-sm font-medium text-gray-700">Tanggal Sertifikat</label>
                                        <input type="date" name="tgl_sertifikat" id="edit_tgl_sertifikat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sertifikat', $rd->tgl_sertifikat) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_penyelenggara" class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                                        <input type="text" name="penyelenggara" id="edit_penyelenggara" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('penyelenggara', $rd->penyelenggara) }}">
                                    </div>
                                    
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6">
                                <button type="button" onclick="closeEditModalDiklat()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormDiklat" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT DIKLAT JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalDiklat').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT DIKLAT--}}
    <script>
        console.log(document.getElementById('tambahFormDiklat').action);
        function openTambahModalDiklat() {
        document.getElementById('tambahModalDiklat').classList.remove('hidden');
        }

        function closeTambahModalDiklat() {
            document.getElementById('tambahModalDiklat').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT DIKLAT--}}
    <script>
        function openEditModalDiklat(id, nm_diklat, jpl, tgl_mulai, tgl_selesai, no_sertifikat, tgl_sertifikat, penyelenggara) {
            document.getElementById('edit_id_diklat').value = id;
            document.getElementById('edit_nm_diklat').value = nm_diklat;
            document.getElementById('edit_jpl').value = jpl;
            document.getElementById('edit_tgl_mulai').value = tgl_mulai;
            document.getElementById('edit_tgl_selesai').value = tgl_selesai;
            document.getElementById('edit_no_sertifikat').value = no_sertifikat;
            document.getElementById('edit_tgl_sertifikat').value = tgl_sertifikat;
            document.getElementById('edit_penyelenggara').value = penyelenggara;

            document.getElementById('editFormDiklat').action = `/admin/riwayat_diklat/${id}`;
            document.getElementById('editModalDiklat').classList.remove('hidden');
        }

        function closeEditModalDiklat() {
            document.getElementById('editModalDiklat').classList.add('hidden');
        }
    </script>

@endsection