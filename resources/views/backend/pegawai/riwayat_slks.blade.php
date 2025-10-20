@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Riwayat Satyalancana Karya Satya
        <button type="button"
        onclick="openTambahModalSlks()"
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">SLKS (Tahun)</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No Kepres</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Kepres</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Status</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($riwayat_slks as $slks)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $slks->slks }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $slks->no_kepres }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">
                                    {{ $slks->tgl_kepres }}
                                </td>
                                <td class="border px-6 py-3 text-sm text-gray-800">
                                    {{ ucfirst($slks->status) }}
                                </td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalSlks(
                                                {{ $slks->id }},
                                                '{{ addslashes(e($slks->slks)) }}',
                                                '{{ addslashes(e($slks->no_kepres)) }}',
                                                '{{ addslashes(e($slks->tgl_kepres)) }}',
                                                '{{ addslashes(e($slks->status)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.slks.destroy', $slks->id) }}" method="POST" class="inline-block"
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
                                <td colspan="6" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada data Riwayat SLKS.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            {{-- MODAL TAMBAH DATA RIWAYAT SLKS --}}
                <div id="tambahModalSlks" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Slks</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormSlks" method="POST" action="/admin/riwayat_slks/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_slks">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_slks" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">SLKS</label>
                                    <input type="text" name="slks" id="tambah_slks" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('slks') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_kepres" class="block text-sm font-medium text-gray-700">No Kepres</label>
                                    <input type="text" name="no_kepres" id="tambah_no_kepres" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('no_kepres') }}">
                                    @error('no_kepres')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_kepres" class="block text-sm font-medium text-gray-700">Tanggal Kepres</label>
                                    <input type="date" name="tgl_kepres" id="tambah_tgl_kepres" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" min="1950" max="{{ date('Y') }}" required value="{{ old('tgl_kepres') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <input type="text" name="status" id="tambah_status" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('status') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                            <button type="button" onclick="closeTambahModalSlks()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormSlks" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT SLKS JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalSlks').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT SLKS --}}
                @if(isset($slks))
                    <div id="editModalSlks" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat SLKS</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormSlks" method="POST" action="{{ route('backend.riwayat_slks.update', $slks) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_slks">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_slks" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">SLKS</label>
                                        <input type="text" name="slks" id="edit_slks" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('slks', $slks->slks) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_kepres" class="block text-sm font-medium text-gray-700">No Kepres</label>
                                        <input type="text" name="no_kepres" id="edit_no_kepres" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('no_kepres', $slks->no_kepres) }}">
                                        @error('no_kepres')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_kepres" class="block text-sm font-medium text-gray-700">Tanggal Kepres</label>
                                        <input type="date" name="tgl_kepres" id="edit_tgl_kepres" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_kepres', $slks->tgl_kepres) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_status" class="block text-sm font-medium text-gray-700">Status</label>
                                        <input type="text" name="status" id="edit_status" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('status', $slks->status) }}">
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                                <button type="button" onclick="closeEditModalSlks()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormSlks" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT SLKS JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalSlks').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT SLKS--}}
    <script>
        console.log(document.getElementById('tambahFormSlks').action);
        function openTambahModalSlks() {
        document.getElementById('tambahModalSlks').classList.remove('hidden');
        }

        function closeTambahModalSlks() {
            document.getElementById('tambahModalSlks').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT SLKS--}}
    <script>
        function openEditModalSlks(id, slks, no_kepres, tgl_kepres, status) {
            document.getElementById('edit_id_slks').value = id;
            document.getElementById('edit_slks').value = slks;
            document.getElementById('edit_no_kepres').value = no_kepres;
            document.getElementById('edit_tgl_kepres').value = tgl_kepres;
            document.getElementById('edit_status').value = status;

            document.getElementById('editFormSlks').action = `/admin/riwayat_slks/${id}`;
            document.getElementById('editModalSlks').classList.remove('hidden');
        }

        function closeEditModalSlks() {
            document.getElementById('editModalSlks').classList.add('hidden');
        }
    </script>
@endsection