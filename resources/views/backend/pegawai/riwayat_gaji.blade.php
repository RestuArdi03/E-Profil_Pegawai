@extends('main.layout2')

@section('content')
    <h1 class="text-xl">Riwayat Gaji
        <button type="button"
        onclick="openTambahModalGaji()"
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pejabat Penetap</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jumlah Gaji</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Keterangan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($riwayat_gaji as $gaji)
                            <tr>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $gaji->pejabat_penetap }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $gaji->no_sk }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $gaji->tgl_sk }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">Rp {{ number_format($gaji->jml_gaji, 2, ',', '.') }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $gaji->ket ?? '-' }}</td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalGaji(
                                                {{ $gaji->id }},
                                                '{{ addslashes(e($gaji->pejabat_penetap)) }}',
                                                '{{ addslashes(e($gaji->no_sk)) }}',
                                                '{{ addslashes(e($gaji->tgl_sk)) }}',
                                                '{{ addslashes(e($gaji->jml_gaji)) }}',
                                                '{{ addslashes(e($gaji->ket)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.gaji.destroy', $gaji->id) }}" method="POST" class="inline-block"
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
                                <td colspan="7" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada data Riwayat Gaji.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL TAMBAH DATA RIWAYAT GAJI --}}
                <div id="tambahModalGaji" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Gaji</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormGaji" method="POST" action="/admin/riwayat_gaji/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_gaji">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_pejabat_penetap" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Pejabat Penetap</label>
                                    <input type="text" name="pejabat_penetap" id="tambah_pejabat_penetap" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penetap') }}">
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
                                    <label for="tambah_jml_gaji" class="block text-sm font-medium text-gray-700">Jumlahaji</label>
                                    <input type="text" name="jml_gaji" id="tambah_jml_gaji" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jml_gaji') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_ket" class="block text-sm font-medium text-gray-700">Keterangan</label>
                                    <input type="text" name="ket" id="tambah_ket" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('ket') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                            <button type="button" onclick="closeTambahModalGaji()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormGaji" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT GAJI JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalGaji').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT GAJI --}}
                @if(isset($gaji))
                    <div id="editModalGaji" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat Gaji</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormGaji" method="POST" action="{{ route('backend.riwayat_gaji.update', $gaji) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_gaji">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_pejabat_penetap" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Pejabat Penetap</label>
                                        <input type="text" name="pejabat_penetap" id="edit_pejabat_penetap" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penetap', $gaji->pejabat_penetap) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                        <input type="text" name="no_sk" id="edit_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk', $gaji->no_sk) }}">
                                        @error('no_sk')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                        <input type="date" name="tgl_sk" id="edit_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk', $gaji->tgl_sk) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_jml_gaji" class="block text-sm font-medium text-gray-700">Jumlah Gaji</label>
                                        <input type="text" name="jml_gaji" id="edit_jml_gaji" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jml_gaji', $gaji->jml_gaji) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_ket" class="block text-sm font-medium text-gray-700">Keterangan</label>
                                        <input type="text" name="ket" id="edit_ket" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('ket', $gaji->ket) }}">
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                                <button type="button" onclick="closeEditModalGaji()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormGaji" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT GAJI JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalGaji').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT GAJI--}}
    <script>
        console.log(document.getElementById('tambahFormGaji').action);
        function openTambahModalGaji() {
        document.getElementById('tambahModalGaji').classList.remove('hidden');
        }

        function closeTambahModalGaji() {
            document.getElementById('tambahModalGaji').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT GAJI--}}
    <script>
        function openEditModalGaji(id, pejabat_penetap, no_sk, tgl_sk, jml_gaji, ket) {
            document.getElementById('edit_id_gaji').value = id;
            document.getElementById('edit_pejabat_penetap').value = pejabat_penetap;
            document.getElementById('edit_no_sk').value = no_sk;
            document.getElementById('edit_tgl_sk').value = tgl_sk;
            document.getElementById('edit_jml_gaji').value = jml_gaji;
            document.getElementById('edit_ket').value = ket;

            document.getElementById('editFormGaji').action = `/admin/riwayat_gaji/${id}`;
            document.getElementById('editModalGaji').classList.remove('hidden');
        }

        function closeEditModalGaji() {
            document.getElementById('editModalGaji').classList.add('hidden');
        }
    </script>

@endsection