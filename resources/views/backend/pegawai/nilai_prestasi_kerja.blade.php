@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Nilai Prestasi Kerja
        <button type="button"
        onclick="openTambahModalPrestasi()"
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tahun</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">SKP</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nilai Prestasi Kerja</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nilai Perilaku kerja</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Klasifikasi Nilai</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pejabat Penetap</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($nilai_prestasi_kerja as $nilai)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $nilai->tahun }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ number_format($nilai->skp, 2) }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ number_format($nilai->nilai_prestasi_kerja, 2) }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ number_format($nilai->nilai_perilaku_kerja, 2) }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $nilai->klasifikasi_nilai }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $nilai->pejabat_penilai }}</td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalPrestasi(
                                                {{ $nilai->id }},
                                                '{{ addslashes(e($nilai->tahun)) }}',
                                                '{{ addslashes(e($nilai->skp)) }}',
                                                '{{ addslashes(e($nilai->nilai_prestasi_kerja)) }}',
                                                '{{ addslashes(e($nilai->nilai_perilaku_kerja)) }}',
                                                '{{ addslashes(e($nilai->klasifikasi_nilai)) }}',
                                                '{{ addslashes(e($nilai->pejabat_penilai)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.prestasiKerja.destroy', $nilai->id) }}" method="POST" class="inline-block"
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
                                    Belum ada data Riwayat Nilai Prestasi Kerja.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            {{-- MODAL TAMBAH DATA NILAI PRESTASI KERJA --}}
                <div id="tambahModalPrestasi" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah NILAI PRESTASI KERJA</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormPrestasi" method="POST" action="/admin/nilai_prestasi_kerja/store">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="id" id="tambah_id_prestasi">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_tahun" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Tahun</label>
                                    <input type="number" name="tahun" id="tambah_tahun" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" min="1950" max="{{ date('Y') }}" required value="{{ old('tahun') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_skp" class="block text-sm font-medium text-gray-700">SKP</label>
                                    <input type="text" name="skp" id="tambah_skp" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('skp') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_nilai_prestasi_kerja" class="block text-sm font-medium text-gray-700">Nilai Prestasi Kerja</label>
                                    <input type="text" name="nilai_prestasi_kerja" id="tambah_nilai_prestasi_kerja" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nilai_prestasi_kerja') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_nilai_perilaku_kerja" class="block text-sm font-medium text-gray-700">Nilai Perilaku kerja</label>
                                    <input type="text" name="nilai_perilaku_kerja" id="tambah_nilai_perilaku_kerja" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nilai_perilaku_kerja') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_klasifikasi_nilai" class="block text-sm font-medium text-gray-700">Klasifikasi Nilai</label>
                                    <input type="text" name="klasifikasi_nilai" id="tambah_klasifikasi_nilai" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('klasifikasi_nilai') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="tambah_pejabat_penilai" class="block text-sm font-medium text-gray-700">Pejabat Penilai</label>
                                    <input type="text" name="pejabat_penilai" id="tambah_pejabat_penilai" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penilai') }}">
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                            <button type="button" onclick="closeTambahModalPrestasi()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormPrestasi" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA NILAI PRESTASI KERJA JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalPrestasi').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODUL EDIT DATA NILAI PRESTASI KERJA --}}
                @if(isset($nilai))
                    <div id="editModalPrestasi" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Nilai Prestasi Kerja</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormPrestasi" method="POST" action="{{ route('backend.nilai_prestasi_kerja.update', $nilai) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_prestasi">
                                    <input type="hidden" name="mode" value="edit">
                                    
                                    <div class="mb-3">
                                        <label for="edit_tahun" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Tahun</label>
                                        <input type="number" name="tahun" id="edit_tahun" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('tahun', $nilai->tahun) }}" min="1950" max="{{ date('Y') }}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_skp" class="block text-sm font-medium text-gray-700">SKP</label>
                                        <input type="text" name="skp" id="edit_skp" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('skp', $nilai->skp) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_nilai_prestasi_kerja" class="block text-sm font-medium text-gray-700">Nilai Prestasi Kerja</label>
                                        <input type="text" name="nilai_prestasi_kerja" id="edit_nilai_prestasi_kerja" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nilai_prestasi_kerja', $nilai->nilai_prestasi_kerja) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_nilai_perilaku_kerja" class="block text-sm font-medium text-gray-700">Nilai Perilaku Kerja</label>
                                        <input type="text" name="nilai_perilaku_kerja" id="edit_nilai_perilaku_kerja" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nilai_perilaku_kerja', $nilai->nilai_perilaku_kerja) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_klasifikasi_nilai" class="block text-sm font-medium text-gray-700">Klasifikasi Nilai</label>
                                        <input type="text" name="klasifikasi_nilai" id="edit_klasifikasi_nilai" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('klasifikasi_nilai', $nilai->klasifikasi_nilai) }}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_pejabat_penilai" class="block text-sm font-medium text-gray-700">Pejabat Penilai</label>
                                        <input type="text" name="pejabat_penilai" id="edit_pejabat_penilai" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('pejabat_penilai', $nilai->pejabat_penilai) }}">
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                <button type="button" onclick="closeEditModalPrestasi()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormPrestasi" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA NILAI PRESTASI KERJA JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('editModalPrestasi').classList.remove('hidden');
                            });
                        </script>
                    @endif
                @endif

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA NILAI PRESTASI KERJA--}}
    <script>
        console.log(document.getElementById('tambahFormPrestasi').action);
        function openTambahModalPrestasi() {
        document.getElementById('tambahModalPrestasi').classList.remove('hidden');
        }

        function closeTambahModalPrestasi() {
            document.getElementById('tambahModalPrestasi').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA NILAI PRESTASI KERJA--}}
    <script>
        function openEditModalPrestasi(id, tahun, skp, nilai_prestasi_kerja, nilai_perilaku_kerja, klasifikasi_nilai, pejabat_penilai) {
            document.getElementById('edit_id_prestasi').value = id;
            document.getElementById('edit_tahun').value = tahun;
            document.getElementById('edit_skp').value = skp;
            document.getElementById('edit_nilai_prestasi_kerja').value = nilai_prestasi_kerja;
            document.getElementById('edit_nilai_perilaku_kerja').value = nilai_perilaku_kerja;
            document.getElementById('edit_klasifikasi_nilai').value = klasifikasi_nilai;
            document.getElementById('edit_klasifikasi_nilai').value = pejabat_penilai;

            document.getElementById('editFormPrestasi').action = `/admin/nilai_prestasi_kerja/${id}`;
            document.getElementById('editModalPrestasi').classList.remove('hidden');
        }

        function closeEditModalPrestasi() {
            document.getElementById('editModalPrestasi').classList.add('hidden');
        }
    </script>

@endsection