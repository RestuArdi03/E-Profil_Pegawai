@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Data keluarga
        <button type="button"
        onclick="openTambahModalKeluarga()"
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
         
        $currentRoute = route('backend.data_keluarga.show', $pegawaiId); 

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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">NIK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tempat Lahir</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Lahir</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jenis Kelamin</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Status Keluarga</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pendidikan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pekerjaan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">NIP</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($data_keluarga as $keluarga)
                            <tr>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $data_keluarga->firstItem() + $loop->iteration - 1 }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $keluarga->nama }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $keluarga->nik }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $keluarga->tmpt_lahir }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $keluarga->tgl_lahir }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $keluarga->jenis_kelamin }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $keluarga->status_keluarga }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ $keluarga->pendidikan }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ empty($keluarga->pekerjaan) ? '-' :$keluarga->pekerjaan }}</td>
                                <td class="border border-gray-200 px-6 py-3 text-sm text-gray-800">{{ empty($keluarga->nip) ? '-' :$keluarga->nip }}</td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalKeluarga(
                                                {{ $keluarga->id }},
                                                '{{ addslashes(e($keluarga->nama)) }}',
                                                '{{ addslashes(e($keluarga->nik)) }}',
                                                '{{ addslashes(e($keluarga->tmpt_lahir)) }}',
                                                '{{ addslashes(e($keluarga->tgl_lahir)) }}',
                                                '{{ addslashes(e($keluarga->jenis_kelamin)) }}',
                                                '{{ addslashes(e($keluarga->status_keluarga)) }}',
                                                '{{ addslashes(e($keluarga->pendidikan)) }}',
                                                '{{ addslashes(e($keluarga->pekerjaan)) }}',
                                                '{{ addslashes(e($keluarga->nip)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.keluarga.destroy', $keluarga->id) }}" method="POST" class="inline-block"
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
                                <td colspan="11" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada Data Keluarga.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- MODAL TAMBAH DATA KELUARGA --}}
                <div id="tambahModalKeluarga" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Data Keluarga</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormKeluarga" method="POST" action="/admin/data_keluarga/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_keluarga">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_nama" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama</label>
                                    <input type="text" name="nama" id="tambah_nama" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nama') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                    <input type="text" name="nik" id="tambah_nik" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nik') }}">
                                    @error('nik')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tmpt_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                    <input type="text" name="tmpt_lahir" id="tambah_tmpt_lahir" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmpt_lahir') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" id="tambah_tgl_lahir" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_lahir') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="tambah_jenis_kelamin" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_status_keluarga" class="block text-sm font-medium text-gray-700">Status Keluarga</label>
                                    <select name="status_keluarga" id="tambah_status_keluarga" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                                        <option value="">Pilih Status</option>
                                        <option value="Suami/istri" {{ old('status_keluarga') == 'Suami/istri' ? 'selected' : '' }}>Suami/istri</option>
                                        <option value="Anak Kandung" {{ old('status_keluarga') == 'Anak Kandung' ? 'selected' : '' }}>Anak Kandung</option>
                                        <option value="Anak Angkat/tiri" {{ old('status_keluarga') == 'Anak Angkat/tiri' ? 'selected' : '' }}>Anak Angkat/tiri</option>
                                        <option value="Orang Tua" {{ old('status_keluarga') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                        <option value="Mertua" {{ old('status_keluarga') == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                                        <option value="Saudara" {{ old('status_keluarga') == 'Saudara' ? 'selected' : '' }}>Saudara</option>
                                        <option value="Keponakan" {{ old('status_keluarga') == 'Keponakan' ? 'selected' : '' }}>Keponakan</option>
                                        <option value="Cucu" {{ old('status_keluarga') == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_pendidikan" class="block text-sm font-medium text-gray-700">Pendidikan</label>
                                    <select name="pendidikan" id="tambah_pendidikan" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="Belum Sekolah" {{ old('pendidikan') == 'Belum Sekolah' ? 'selected' : '' }}>Belum Sekolah</option>
                                        <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA/K" {{ old('pendidikan') == 'SMA/K' ? 'selected' : '' }}>SMA/K</option>
                                        <option value="Diploma" {{ old('pendidikan') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                        <option value="Sarjana" {{ old('pendidikan') == 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                                        <option value="Magister" {{ old('pendidikan') == 'Magister' ? 'selected' : '' }}>Magister</option>
                                        <option value="Doktor" {{ old('pendidikan') == 'Doktor' ? 'selected' : '' }}>Doktor</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" id="tambah_pekerjaan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('pekerjaan') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_nip" class="block text-sm font-medium text-gray-700">NIP</label>
                                    <input type="text" name="nip" id="tambah_nip" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('nip') }}">
                                    @error('nip')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6">
                            <button type="button" onclick="closeTambahModalKeluarga()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormKeluarga" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA KELUARGA JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalKeluarga').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA KELUARGA --}}
                @if(isset($keluarga))
                    <div id="editModalKeluarga" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Data Keluarga</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormKeluarga" method="POST" action="{{ route('backend.data_keluarga.update', $keluarga) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_keluarga">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_nama" class="block text-sm font-medium text-gray-700" stle="margin-top: -25px;">Nama</label>
                                        <input type="text" name="nama" id="edit_nama" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nama', $keluarga->nama) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                        <input type="text" name="nik" id="edit_nik" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nik', $keluarga->nik) }}">
                                        @error('nik')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tmpt_lahir" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                        <input type="text" name="tmpt_lahir" id="edit_tmpt_lahir" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tmpt_lahir', $keluarga->tmpt_lahir) }}" min="1950" max="{{ date('Y') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_tgl_lahir" class="block text-sm font-medium text-gray-700">tgl_lahir</label>
                                        <input type="date" name="tgl_lahir" id="edit_tgl_lahir" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tgl_lahir', $keluarga->tgl_lahir) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="edit_jenis_kelamin" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_status_keluarga" class="block text-sm font-medium text-gray-700">Status Keluarga</label>
                                        <select name="status_keluarga" id="edit_status_keluarga" required
                                            class=" mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                                            <option value="">Pilih Status</option>
                                            <option value="Suami/istri" {{ old('status_keluarga') == 'Suami/istri' ? 'selected' : '' }}>Suami/istri</option>
                                            <option value="Anak Kandung" {{ old('status_keluarga') == 'Anak Kandung' ? 'selected' : '' }}>Anak Kandung</option>
                                            <option value="Anak Angkat/tiri" {{ old('status_keluarga') == 'Anak Angkat/tiri' ? 'selected' : '' }}>Anak Angkat/tiri</option>
                                            <option value="Orang Tua" {{ old('status_keluarga') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                            <option value="Mertua" {{ old('status_keluarga') == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                                            <option value="Saudara" {{ old('status_keluarga') == 'Saudara' ? 'selected' : '' }}>Saudara</option>
                                            <option value="Keponakan" {{ old('status_keluarga') == 'Keponakan' ? 'selected' : '' }}>Keponakan</option>
                                            <option value="Cucu" {{ old('status_keluarga') == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pendidikan" class="block text-sm font-medium text-gray-700">Pendidikan</label>
                                        <select name="pendidikan" id="edit_pendidikan" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="Belum Sekolah" {{ old('pendidikan') == 'Belum Sekolah' ? 'selected' : '' }}>Belum Sekolah</option>
                                        <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA/K" {{ old('pendidikan') == 'SMA/K' ? 'selected' : '' }}>SMA/K</option>
                                        <option value="Diploma" {{ old('pendidikan') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                        <option value="Sarjana" {{ old('pendidikan') == 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                                        <option value="Magister" {{ old('pendidikan') == 'Magister' ? 'selected' : '' }}>Magister</option>
                                        <option value="Doktor" {{ old('pendidikan') == 'Doktor' ? 'selected' : '' }}>Doktor</option>
                                    </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                        <input type="text" name="pekerjaan" id="edit_pekerjaan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('pekerjaan') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_nip" class="block text-sm font-medium text-gray-700">NIP</label>
                                        <input type="text" name="nip" id="edit_nip" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" value="{{ old('nip') }}">
                                        @error('nip')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6">
                                <button type="button" onclick="closeEditModalKeluarga()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormKeluarga" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA KELUARGA JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalKeluarga').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
            {{-- TAMBAHKAN NAVIGASI PAGINATION DI SINI --}}
            <div class="mt-4 flex justify-end p-4">
                {{ $data_keluarga->links('pagination::tailwind') }}
            </div>

        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA KELUARGA--}}
    <script>
        console.log(document.getElementById('tambahFormKeluarga').action);
        function openTambahModalKeluarga() {
        document.getElementById('tambahModalKeluarga').classList.remove('hidden');
        }

        function closeTambahModalKeluarga() {
            document.getElementById('tambahModalKeluarga').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA KELUARGA--}}
    <script>
        function openEditModalKeluarga(id, nama, nik, tmpt_lahir, tgl_lahir, jenis_kelamin, status_keluarga,pendidikan, pekerjaan, nip) {
            document.getElementById('edit_id_keluarga').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_nik').value = nik;
            document.getElementById('edit_tmpt_lahir').value = tmpt_lahir;
            document.getElementById('edit_tgl_lahir').value = tgl_lahir;
            document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
            document.getElementById('edit_status_keluarga').value = status_keluarga;
            document.getElementById('edit_pendidikan').value = pendidikan;
            document.getElementById('edit_pekerjaan').value = pekerjaan;
            document.getElementById('edit_nip').value = nip

            document.getElementById('editFormKeluarga').action = `/admin/data_keluarga/${id}`;
            document.getElementById('editModalKeluarga').classList.remove('hidden');
        }

        function closeEditModalKeluarga() {
            document.getElementById('editModalKeluarga').classList.add('hidden');
        }
    </script>
@endsection