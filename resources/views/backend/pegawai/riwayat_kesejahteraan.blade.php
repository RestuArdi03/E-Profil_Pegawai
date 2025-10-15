@extends('main.layout2')

@section('content')
    <h1 class="text-xl">Riwayat Kesejahteraan
        <button type="button"
        onclick="openTambahModalKesejahteraan()"
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">NPWP</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No BPJS</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No Taspen</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Kepemilikan Rumah</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Kartu Pegawai Elektronik</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($kesejahteraan as $data)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $data->npwp }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $data->no_bpjs }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $data->no_taspen }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $data->kepemilikan_rumah }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $data->kartu_pegawai_elektronik }}</td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalKesejahteraan(
                                                {{ $data->id }},
                                                '{{ addslashes(e($data->npwp)) }}',
                                                '{{ addslashes(e($data->no_bpjs)) }}',
                                                '{{ addslashes(e($data->no_taspen)) }}',
                                                '{{ addslashes(e($data->kepemilikan_rumah)) }}',
                                                '{{ addslashes(e($data->kartu_pegawai_elektronik)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.kesejahteraan.destroy', $data->id) }}" method="POST" class="inline-block"
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
                                    Belum ada data Riwayat Kesejahteraan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
           {{-- MODAL TAMBAH DATA RIWAYAT KESEJAHTERAAN --}}
                <div id="tambahModalKesejahteraan" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Kesejahteraan</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormKesejahteraan" method="POST" action="/admin/riwayat_kesejahteraan/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_kesejahteraan">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_npwp" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">NPWP</label>
                                    <input type="text" name="npwp" id="tambah_npwp" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('npwp') }}">
                                    @error('npwp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_bpjs" class="block text-sm font-medium text-gray-700">No BPJS</label>
                                    <input type="text" name="no_bpjs" id="tambah_no_bpjs" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_bpjs') }}">
                                    @error('no_bpjs')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_taspen" class="block text-sm font-medium text-gray-700">No Taspen</label>
                                    <input type="text" name="no_taspen" id="tambah_no_taspen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_taspen') }}">
                                    @error('no_taspen')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_kepemilikan_rumah" class="block text-sm font-medium text-gray-700">Kepemilikan Rumah</label>
                                    <input type="text" name="kepemilikan_rumah" id="tambah_kepemilikan_rumah" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('kepemilikan_rumah') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_kartu_pegawai_elektronik" class="block text-sm font-medium text-gray-700">Kartu Pegawai Elektronik</label>
                                    <input type="text" name="kartu_pegawai_elektronik" id="tambah_kartu_pegawai_elektronik" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('kartu_pegawai_elektronik') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                            <button type="button" onclick="closeTambahModalKesejahteraan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormKesejahteraan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT KESEJAHTERAAN JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalKesejahteraan').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT KESEJAHTERAAN --}}
                @if(isset($data))
                    <div id="editModalKesejahteraan" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat Kesejahteraan</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormKesejahteraan" method="POST" action="{{ route('backend.riwayat_kesejahteraan.update', $data) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_kesejahteraan">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_npwp" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">NPWP</label>
                                        <input type="text" name="npwp" id="edit_npwp" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('npwp', $data->npwp) }}">
                                        @error('npwp')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_bpjs" class="block text-sm font-medium text-gray-700">No BPJS</label>
                                        <input type="text" name="no_bpjs" id="edit_no_bpjs" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_bpjs', $data->no_bpjs) }}">
                                        @error('no_bpjs')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_taspen" class="block text-sm font-medium text-gray-700">No Taspen</label>
                                        <input type="text" name="no_taspen" id="edit_no_taspen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_taspen', $data->no_taspen) }}">
                                        @error('no_taspen')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_kepemilikan_rumah" class="block text-sm font-medium text-gray-700">kepemilikan_rumah</label>
                                        <input type="text" name="kepemilikan_rumah" id="edit_kepemilikan_rumah" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('kepemilikan_rumah', $data->kepemilikan_rumah) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_kartu_pegawai_elektronik" class="block text-sm font-medium text-gray-700">Kartu Pegawai Elektronik</label>
                                        <input type="text" name="kartu_pegawai_elektronik" id="edit_kartu_pegawai_elektronik" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('kartu_pegawai_elektronik', $data->kartu_pegawai_elektronik) }}">
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                                <button type="button" onclick="closeEditModalKesejahteraan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormKesejahteraan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT KESEJAHTERAAN JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalKesejahteraan').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT KESEJAHTERAAN--}}
    <script>
        console.log(document.getElementById('tambahFormKesejahteraan').action);
        function openTambahModalKesejahteraan() {
        document.getElementById('tambahModalKesejahteraan').classList.remove('hidden');
        }

        function closeTambahModalKesejahteraan() {
            document.getElementById('tambahModalKesejahteraan').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT KESEJAHTERAAN--}}
    <script>
        function openEditModalKesejahteraan(id, npwp, no_bpjs, no_taspen, kepemilikan_rumah, kartu_pegawai_elektronik) {
            document.getElementById('edit_id_kesejahteraan').value = id;
            document.getElementById('edit_npwp').value = npwp;
            document.getElementById('edit_no_bpjs').value = no_bpjs;
            document.getElementById('edit_no_taspen').value = no_taspen;
            document.getElementById('edit_kepemilikan_rumah').value = kepemilikan_rumah;
            document.getElementById('edit_kartu_pegawai_elektronik').value = kartu_pegawai_elektronik;

            document.getElementById('editFormKesejahteraan').action = `/admin/riwayat_kesejahteraan/${id}`;
            document.getElementById('editModalKesejahteraan').classList.remove('hidden');
        }

        function closeEditModalKesejahteraan() {
            document.getElementById('editModalKesejahteraan').classList.add('hidden');
        }
    </script>
@endsection