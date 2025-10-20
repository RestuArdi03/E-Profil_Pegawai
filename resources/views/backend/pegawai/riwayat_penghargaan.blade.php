@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Riwayat Penghargaan
        <button type="button"
        onclick="openTambahModalPenghargaan()"
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Penghargaan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No Urut</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No ST/Sertifikat</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Sertifikat</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pejabat Penetap</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Link</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($riwayat_penghargaan as $rph)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rph->nm_penghargaan }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rph->no_urut }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rph->no_sertifikat }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rph->tgl_sertifikat }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rph->pejabat_penetap }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800 underline">
                                    <a href="{{ $rph->link }}" target="_blank">Lihat Sertifikat</a>
                                </td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalPenghargaan(
                                                {{ $rph->id }},
                                                '{{ addslashes(e($rph->nm_penghargaan)) }}',
                                                '{{ addslashes(e($rph->no_urut)) }}',
                                                '{{ addslashes(e($rph->no_sertifikat)) }}',
                                                '{{ addslashes(e($rph->tgl_sertifikat)) }}',
                                                '{{ addslashes(e($rph->pejabat_penetap)) }}',
                                                '{{ addslashes(e($rph->link)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.penghargaan.destroy', $rph->id) }}" method="POST" class="inline-block"
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
                                    Belum ada data Riwayat Penghargaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            {{-- MODAL TAMBAH DATA RIWAYAT PENGHARGAAN --}}
                <div id="tambahModalPenghargaan" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Penghargaan</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormPenghargaan" method="POST" action="/admin/riwayat_penghargaan/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_penghargaan">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_nm_penghargaan" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Penghargaan</label>
                                    <input type="text" name="nm_penghargaan" id="tambah_nm_penghargaan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_penghargaan') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_no_urut" class="block text-sm font-medium text-gray-700">No Urut</label>
                                    <input type="text" name="no_urut" id="tambah_no_urut" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_urut') }}">
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
                                    <label for="tambah_pejabat_penetap" class="block text-sm font-medium text-gray-700">Pejabat Penetap</label>
                                    <input type="text" name="pejabat_penetap" id="tambah_pejabat_penetap" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penetap') }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tambah_link" class="block text-sm font-medium text-gray-700">Link</label>
                                    <input type="text" name="link" id="tambah_link" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('link') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                            <button type="button" onclick="closeTambahModalPenghargaan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormPenghargaan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT PENGHARGAAN JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalPenghargaan').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT PENGHARGAAN --}}
                @if(isset($rph))
                    <div id="editModalPenghargaan" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat Penghargaan</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormPenghargaan" method="POST" action="{{ route('backend.riwayat_penghargaan.update', $rph) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_penghargaan">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_nm_penghargaan" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Penghargaan</label>
                                        <input type="text" name="nm_penghargaan" id="edit_nm_penghargaan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_penghargaan', $rph->nm_penghargaan) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_urut" class="block text-sm font-medium text-gray-700">No Urut</label>
                                        <input type="text" name="no_urut" id="edit_no_urut" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_urut', $rph->no_urut) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_no_sertifikat" class="block text-sm font-medium text-gray-700">No Sertifikat</label>
                                        <input type="text" name="no_sertifikat" id="edit_no_sertifikat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('no_sertifikat', $rph->no_sertifikat) }}">
                                        @error('no_sertifikat')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_sertifikat" class="block text-sm font-medium text-gray-700">tgl_sertifikat</label>
                                        <input type="date" name="tgl_sertifikat" id="edit_tgl_sertifikat" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_sertifikat', $rph->tgl_sertifikat) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pejabat_penetap" class="block text-sm font-medium text-gray-700">Pejabat Penetap</label>
                                        <input type="text" name="pejabat_penetap" id="edit_pejabat_penetap" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penetap', $rph->pejabat_penetap) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_link" class="block text-sm font-medium text-gray-700">Link</label>
                                        <input type="text" name="link" id="edit_link" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('link', $rph->link) }}">
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                                <button type="button" onclick="closeEditModalPenghargaan()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormPenghargaan" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT PENGHARGAAN JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalPenghargaan').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT PENGHARGAAN--}}
    <script>
        console.log(document.getElementById('tambahFormPenghargaan').action);
        function openTambahModalPenghargaan() {
        document.getElementById('tambahModalPenghargaan').classList.remove('hidden');
        }

        function closeTambahModalPenghargaan() {
            document.getElementById('tambahModalPenghargaan').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT PENGHARGAAN--}}
    <script>
        function openEditModalPenghargaan(id, nm_penghargaan, no_urut, no_sertifikat, tgl_sertifikat, pejabat_penetap, link) {
            document.getElementById('edit_id_penghargaan').value = id;
            document.getElementById('edit_nm_penghargaan').value = nm_penghargaan;
            document.getElementById('edit_no_urut').value = no_urut;
            document.getElementById('edit_no_sertifikat').value = no_sertifikat;
            document.getElementById('edit_tgl_sertifikat').value = tgl_sertifikat;
            document.getElementById('edit_pejabat_penetap').value = pejabat_penetap;
            document.getElementById('edit_link').value = link;

            document.getElementById('editFormPenghargaan').action = `/admin/riwayat_penghargaan/${id}`;
            document.getElementById('editModalPenghargaan').classList.remove('hidden');
        }

        function closeEditModalPenghargaan() {
            document.getElementById('editModalPenghargaan').classList.add('hidden');
        }
    </script>
@endsection