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
                        @forelse($pegawai->riwayatGolongan as $gol)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
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
                            <form id="tambahFormGolongan" method="POST" action="/admin/riwayat_golongan/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_golongan">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label class="block text-sm font-medium" style="margin-top: -25px;">Golru</label>
                                    <select name="golongan_id" id="golongan_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value>
                                        <option value="">-- Pilih golru --</option>
                                        @foreach ($golongan as $g)
                                            <option value="{{ $g->id }}" {{ old('golongan_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->golru }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tmt_golongan" class="block text-sm font-medium text-gray-700">TMT Golongan</label>
                                    <input type="date" name="tmt_golongan" id="tambah_tmt_golongan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmt_golongan') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                    <input type="text" name="no_sk" id="tambah_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk') }}">
                                </div>
                                @error('no_sk')
                                    <p class="text-red-500 text-sm" style="margin-top: -10px; margin-bottom: 10px;">{{ $message }}</p>
                                @enderror

                                <div class="mb-3">
                                    <label for="tambah_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                    <input type="date" name="tgl_sk" id="tambah_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_pejabat" class="block text-sm font-medium text-gray-700">Pejabat</label>
                                    <input type="text" name="pejabat" id="tambah_pejabat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
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
                                <form id="editFormGolongan" method="POST" action="{{ route('backend.riwayat_golongan.update', $gol->id) }}">
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
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tmt_golongan" class="block text-sm font-medium text-gray-700">TMT Golongan</label>
                                        <input type="date" name="tmt_golongan" id="edit_tmt_golongan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmt_golongan', $gol->tmt_golongan) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_sk" class="block text-sm font-medium text-gray-700">No SK</label>
                                        <input type="text" name="no_sk" id="edit_no_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sk', $gol->no_sk) }}">
                                        @error('no_sk')
                                            <p class="text-red-500 text-sm" style="margin-top: -10px; margin-bottom: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_sk" class="block text-sm font-medium text-gray-700">Tanggal SK</label>
                                        <input type="date" name="tgl_sk" id="edit_tgl_sk" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sk', $gol->tgl_sk) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pejabat" class="block text-sm font-medium text-gray-700">Pejabat</label>
                                        <input type="text" name="pejabat" id="edit_pejabat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat', $gol->pejabat) }}">
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
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT GOLONGAN--}}
    <script>
        console.log(document.getElementById('tambahFormGolongan').action);
        function openTambahModalGolongan() {
        document.getElementById('tambahModalGolongan').classList.remove('hidden');
        }

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

            document.getElementById('editFormGolongan').action = `/admin/riwayat_golongan/${id}`;
            document.getElementById('editModalGolongan').classList.remove('hidden');
        }

        function closeEditModalGolongan() {
            document.getElementById('editModalGolongan').classList.add('hidden');
        }
    </script>

@endsection