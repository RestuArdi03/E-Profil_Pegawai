@extends('main.layout2')

@section('content')
    <h1 class="text-xl">Riwayat PLH/PLT
        <button type="button"
        onclick="openTambahModalPlhPlt()"
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No Sprint</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Sprint</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Mulai</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Selesai</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jabatan PLH/PLT</th>
                            <th class="border border-gray px-6 py-3 text-sm text-default-100
                            " style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($riwayat_plh_plt as $rpp)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rpp->no_sprint }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rpp->tgl_sprint }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rpp->tgl_mulai }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rpp->tgl_selesai ?? '-' }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $rpp->jabatan_plh_plt ?? '-' }}</td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalPlhPlt(
                                                {{ $rpp->id }},
                                                '{{ addslashes(e($rpp->no_sprint)) }}',
                                                '{{ addslashes(e($rpp->tgl_sprint)) }}',
                                                '{{ addslashes(e($rpp->tgl_mulai)) }}',
                                                '{{ addslashes(e($rpp->tgl_selesai)) }}',
                                                '{{ addslashes(e($rpp->jabatan_plh_plt)) }}',
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.plh_plt.destroy', $rpp->id) }}" method="POST" class="inline-block"
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
                                    Belum ada data Riwayat PLH/PLT.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL TAMBAH DATA RIWAYAT PLH/PLT --}}
                <div id="tambahModalPlhPlt" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Riwayat PLH/PLT</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormPlhPlt" method="POST" action="/admin/riwayat_plh_plt/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_plh_plt">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_no_sprint" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">No Sprint</label>
                                    <input type="text" name="no_sprint" id="tambah_no_sprint" class="w-full border rounded-md text-sm" required value="{{ old('no_sprint') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_sprint" class="block text-sm font-medium text-gray-700">Tanggal Sprint</label>
                                    <input type="date" name="tgl_sprint" id="tambah_tgl_sprint" class="w-full border rounded-md text-sm" required value="{{ old('tgl_sprint') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                    <input type="date" name="tgl_mulai" id="tambah_tgl_mulai" class="w-full border rounded-md text-sm" required value="{{ old('tgl_mulai') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                    <input type="date" name="tgl_selesai" id="tambah_tgl_selesai" class="w-full border rounded-md text-sm" required value="{{ old('tgl_selesai') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_jabatan_plh_plt" class="block text-sm font-medium text-gray-700">Jabatan PLH/PLT</label>
                                    <input type="text" name="jabatan_plh_plt" id="tambah_jabatan_plh_plt" class="w-full border rounded-md text-sm" required value="{{ old('jabatan_plh_plt') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                            <button type="button" onclick="closeTambahModalPlhPlt()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormPlhPlt" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>

                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA RIWAYAT PLH/PLT JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalPltPlt').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA RIWAYAT PLH/PLT --}}
                @if(isset($rpp))
                    <div id="editModalPlhPlt" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Riwayat PlhPlt</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormPlhPlt" method="POST" action="{{ route('backend.riwayat_plh_plt.update', $rpp) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_plh_plt">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_no_sprint" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">No Sprint</label>
                                        <input type="text" name="no_sprint" id="edit_no_sprint" class="w-full border rounded-md text-sm" required value="{{ old('no_sprint', $rpp->no_sprint) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_sprint" class="block text-sm font-medium text-gray-700">Tanggal Sprint</label>
                                        <input type="date" name="tgl_sprint" id="edit_tgl_sprint" class="w-full border rounded-md text-sm" required value="{{ old('tgl_sprint', $rpp->tgl_sprint) }}">

                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                        <input type="date" name="tgl_mulai" id="edit_tgl_mulai" class="w-full border rounded-md text-sm" required value="{{ old('tgl_mulai', $rpp->tgl_mulai) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                        <input type="date" name="tgl_selesai" id="edit_tgl_selesai" class="w-full border rounded-md text-sm" required value="{{ old('tgl_selesai', $rpp->tgl_selesai) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_jabatan_plh_plt" class="block text-sm font-medium text-gray-700">Jabatan plh_plt</label>
                                        <input type="text" name="jabatan_plh_plt" id="edit_jabatan_plh_plt" class="w-full border rounded-md text-sm" required value="{{ old('jabatan_plh_plt', $rpp->jabatan_plh_plt) }}">
                                    </div>
                                </form>
                            </div>
                            <!-- Tombol Aksi / Action Buttons -->
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px;">
                                <button type="button" onclick="closeEditModalPlhPlt()"
                                        class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                                    Batal
                                </button>
                                <button type="submit" form="editFormPlhPlt"
                                        class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA RIWAYAT PLH/PLT JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalPlhPlt').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA RIWAYAT PLH/PLT--}}
    <script>
        console.log(document.getElementById('tambahFormPlhPlt').action);
        function openTambahModalPlhPlt() {
        document.getElementById('tambahModalPlhPlt').classList.remove('hidden');
        }

        function closeTambahModalPlhPlt() {
            document.getElementById('tambahModalPlhPlt').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA RIWAYAT PLH/PLT--}}
    <script>
        function openEditModalPlhPlt(id, no_sprint, tgl_sprint, tgl_mulai, tgl_selesai, jabatan_plh_plt) {
            document.getElementById('edit_id_plh_plt').value = id;
            document.getElementById('edit_tgl_sprint').value = tgl_sprint;
            document.getElementById('edit_tgl_mulai').value = tgl_mulai;
            document.getElementById('edit_tgl_selesai').value = tgl_selesai;
            document.getElementById('edit_tgl_selesai').value = tgl_selesai;
            document.getElementById('edit_jabatan_plh_plt').value = jabatan_plh_plt;

            document.getElementById('editFormPlhPlt').action = `/admin/riwayat_plh_plt/${id}`;
            document.getElementById('editModalPlhPlt').classList.remove('hidden');
        }

        function closeEditModalPlhPlt() {
            document.getElementById('editModalPlhPlt').classList.add('hidden');
        }
    </script>

@endsection