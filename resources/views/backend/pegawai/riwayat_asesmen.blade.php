@extends('main.layout2')

@section('content')
    <h1 class="text-xl">Riwayat Asesmen
        <button type="button"
        onclick="openTambahModalAsesmen()"
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Asesmen</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tujuan Asesmen</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Metode Asesmen</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Gambaran Potensi</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Gambaran Kompetensi</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Saran Pengembangan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($riwayat_asesmen as $asesmen)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $asesmen->tgl_asesmen }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $asesmen->tujuan_asesmen }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $asesmen->metode_asesmen }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $asesmen->gambaran_potensi }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $asesmen->gambaran_kompetensi }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $asesmen->saran_pengembangan }}</td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalAsesmen(
                                                {{ $asesmen->id }},
                                                '{{ addslashes(e($asesmen->tgl_asesmen)) }}',
                                                '{{ addslashes(e($asesmen->tujuan_asesmen)) }}',
                                                '{{ addslashes(e($asesmen->metode_asesmen)) }}',
                                                '{{ addslashes(e($asesmen->gambaran_potensi)) }}',
                                                '{{ addslashes(e($asesmen->gambaran_kompetensi)) }}',
                                                '{{ addslashes(e($asesmen->saran_pengembangan)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.asesmen.destroy', $asesmen->id) }}" method="POST" class="inline-block"
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
                                    Belum ada data Riwayat Asesmen.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            {{-- MODAL TAMBAH DATA RIWAYAT ASESMEN --}}
                <div id="tambahModalAsesmen" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat Asesmen</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormAsesmen" method="POST" action="/admin/riwayat_asesmen/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_asesmen">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_tgl_asesmen" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Tanggal Asesmen</label>
                                    <input type="date" name="tgl_asesmen" id="tambah_tgl_asesmen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_asesmen') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tujuan_asesmen" class="block text-sm font-medium text-gray-700">Tujuan Asesmen</label>
                                    <input type="text" name="tujuan_asesmen" id="tambah_tujuan_asesmen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tujuan_asesmen') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_metode_asesmen" class="block text-sm font-medium text-gray-700">Metode Asesmen</label>
                                    <input type="text" name="metode_asesmen" id="tambah_metode_asesmen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('metode_asesmen') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_gambaran_potensi" class="block text-sm font-medium text-gray-700">Gambaran Potensi</label>
                                    <input type="text" name="gambaran_potensi" id="tambah_gambaran_potensi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('gambaran_potensi') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_gambaran_kompetensi" class="block text-sm font-medium text-gray-700">Gambaran Kompetensi</label>
                                    <input type="text" name="gambaran_kompetensi" id="tambah_gambaran_kompetensi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('gambaran_kompetensi') }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tambah_saran_pengembangan" class="block text-sm font-medium text-gray-700">Saran Pengembangan</label>
                                    <input type="text" name="saran_pengembangan" id="tambah_saran_pengembangan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('saran_pengembangan') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                            <button type="button" onclick="closeTambahModalAsesmen()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormAsesmen" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT ASESMEN JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalAsesmen').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT ASESMEN --}}
                @if(isset($asesmen))
                    <div id="editModalAsesmen" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat Asesmen</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormAsesmen" method="POST" action="{{ route('backend.riwayat_asesmen.update', $asesmen) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_asesmen">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_tgl_asesmen" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Tanggal Asesmen</label>
                                        <input type="date" name="tgl_asesmen" id="edit_tgl_asesmen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_asesmen', $asesmen->tgl_asesmen) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tujuan_asesmen" class="block text-sm font-medium text-gray-700">Tujuan Asesmen</label>
                                        <input type="text" name="tujuan_asesmen" id="edit_tujuan_asesmen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tujuan_asesmen', $asesmen->tujuan_asesmen) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_metode_asesmen" class="block text-sm font-medium text-gray-700">Metode Asesmen</label>
                                        <input type="text" name="metode_asesmen" id="edit_metode_asesmen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('metode_asesmen', $asesmen->metode_asesmen) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_gambaran_potensi" class="block text-sm font-medium text-gray-700">Gambaran Potensi</label>
                                        <input type="text" name="gambaran_potensi" id="edit_gambaran_potensi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('gambaran_potensi', $asesmen->gambaran_potensi) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_gambaran_kompetensi" class="block text-sm font-medium text-gray-700">Gambaran Kompetensi</label>
                                        <input type="text" name="gambaran_kompetensi" id="edit_gambaran_kompetensi" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('gambaran_kompetensi', $asesmen->gambaran_kompetensi) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_saran_pengembangan" class="block text-sm font-medium text-gray-700">Saran Pengembangan</label>
                                        <input type="text" name="saran_pengembangan" id="edit_saran_pengembangan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('saran_pengembangan', $asesmen->saran_pengembangan) }}">
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                                <button type="button" onclick="closeEditModalAsesmen()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormAsesmen" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT ASESMEN JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalAsesmen').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT ASESMEN--}}
    <script>
        console.log(document.getElementById('tambahFormAsesmen').action);
        function openTambahModalAsesmen() {
        document.getElementById('tambahModalAsesmen').classList.remove('hidden');
        }

        function closeTambahModalAsesmen() {
            document.getElementById('tambahModalAsesmen').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT ASESMEN--}}
    <script>
        function openEditModalAsesmen(id, tgl_asesmen, tujuan_asesmen, metode_asesmen, gambaran_potensi, gambaran_kompetensi, saran_pengembangan) {
            document.getElementById('edit_id_asesmen').value = id;
            document.getElementById('edit_tgl_asesmen').value = tgl_asesmen;
            document.getElementById('edit_tujuan_asesmen').value = tujuan_asesmen;
            document.getElementById('edit_metode_asesmen').value = metode_asesmen;
            document.getElementById('edit_gambaran_potensi').value = gambaran_potensi;
            document.getElementById('edit_gambaran_kompetensi').value = gambaran_kompetensi;
            document.getElementById('edit_saran_pengembangan').value = saran_pengembangan;

            document.getElementById('editFormAsesmen').action = `/admin/riwayat_asesmen/${id}`;
            document.getElementById('editModalAsesmen').classList.remove('hidden');
        }

        function closeEditModalAsesmen() {
            document.getElementById('editModalAsesmen').classList.add('hidden');
        }
    </script>
@endsection