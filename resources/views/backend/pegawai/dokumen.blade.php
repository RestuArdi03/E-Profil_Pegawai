@extends('main.layout2')

@section('content')
    <h1 class="text-xl">Dokumen
        <button type="button"
        onclick="openTambahModalDokumen()"
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Dokumen</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Folder</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($dokumen as $dok)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $dok->nm_dokumen }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $dok->folder->nm_folder ?? '-'}}</td>
                                <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Lihat --}}
                                        <button type="button"
                                            onclick="window.open('{{ asset('storage/' . $dok->file_path) }}', '_blank')"
                                            class="px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700 flex flex-nowrap items-center gap-2 overflow-auto">
                                            Lihat
                                        </button>

                                        
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="openEditModalDokumen(
                                                {{ $dok->id }},
                                                '{{ addslashes(e($dok->nm_dokumen)) }}',
                                                '{{ addslashes(e($dok->folder->id)) }}',
                                                '{{ addslashes(e($dok->file_path)) }}'
                                            )"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                            <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                            Edit
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.dokumen.destroy', $dok->id) }}" method="POST" class="inline-block"
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
                                <td colspan="4" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada Dokumen.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- MODAL TAMBAH DATA DOKUMEN --}}
                <div id="tambahModalDokumen" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                        <div class="p-6">
                            <h2 class="text-base font-semibold">Tambah Dokumen</h2>
                        </div>

                        <div class="form_edit p-6 overflow-y-auto">
                            <form id="tambahFormDokumen" method="POST" action="/admin/dokumen/store" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                <input type="hidden" name="mode" value="tambah">

                                <div class="mb-3">
                                    <label for="tambah_nm_dokumen" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Dokumen</label>
                                    <input type="text" name="nm_dokumen" id="tambah_nm_dokumen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_dokumen') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Folder</label>
                                    <select name="folder_id" id="folder_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                        <option value="">-- Pilih nama folder --</option>
                                        @foreach ($folder as $f)
                                            <option value="{{ $f->id }}"
                                                {{ old('folder_id') == $f->id ? 'selected' : '' }}>
                                            {{ $f->nm_folder }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tambah_file_path" class="block text-sm font-medium text-gray-700">Upload Dokumen</label>
                                    <div class= "w-full flex items-center border border-gray-300 rounded-md shadow-sm px-3 bg-white text-sm text-gray-900 mt-1">
                                        <button type="button" id="custom-upload" class="text-green-700 rounded-md bg-green-50">Pilih File</button>
                                        <hr style="border: 1px solid #ccc; height: 40px; margin-right: 10px; margin-left: 10px;" >
                                        <span id="file-name">Tidak ada file yang dipilih</span>
                                    </div>
                                    <input type="file" name="file_path" id="tambah_file_path" class="hidden" required accept=".pdf,.doc,.docx,.jpg,.png">
                                    @error('file_path')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </form>
                        </div>
                        <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                            <button type="button" onclick="closeTambahModalDokumen()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                            <button type="submit" form="tambahFormDokumen" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                        </div>
                    </div>
                </div>
                {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA DOKUMEN JIKA ADA ERROR--}}
                @if ($errors->any() && old('mode') === 'tambah')
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('tambahModalDokumen').classList.remove('hidden');
                        });
                    </script>
                @endif

                {{-- MODAL EDIT DOKUMEN --}}
                @if(isset($dok))
                    <div id="editModalDokumen" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                        style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Edit Dokumen</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="editFormDokumen" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="id" id="edit_id_dokumen">
                                    <input type="hidden" name="mode" value="edit">

                                    <div class="mb-3">
                                        <label for="edit_nm_dokumen" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Dokumen</label>
                                        <input type="text" name="nm_dokumen" id="edit_nm_dokumen" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_dokumen', $dok->nm_dokumen) }}">
                                        @error('nm_dokumen')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Folder</label>
                                        <select name="folder_id" id="edit_folder_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                            <option value="">-- Pilih nama folder --</option>
                                            @foreach ($folder as $f)
                                                <option value="{{ $f->id }}"
                                                    @if (old('folder_id') == $f->id) 
                                                        selected 
                                                    @elseif (!old('folder_id') && $dok->folder_id == $f->id)
                                                        selected
                                                    @endif>
                                                    {{ $f->nm_folder }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('folder_id')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_file_path" class="block text-sm font-medium text-gray-700">Upload Dokumen</label>
                                        <div class="w-full flex items-center border border-gray-300 rounded-md shadow-sm px-3 bg-white text-sm text-gray-900 mt-1">
                                            <button type="button" id="edit-custom-upload-dokumen" class="text-green-700 rounded-md bg-green-50">Pilih File</button>
                                            <hr style="border: 1px solid #ccc; height: 40px; margin-right: 10px; margin-left: 10px;" >
                                            <span id="edit-file-name-dokumen">{{ $dok->file_path ?? 'Tidak ada file yang dipilih' }}</span>
                                        </div>
                                        <input type="file" name="file_path" id="edit_file_path" class="hidden" accept=".pdf,.doc,.docx,.jpg,.png">
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                <button type="button" onclick="closeEditModalDokumen()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="editFormDokumen" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                        
                    {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA DOKUMEN JIKA ADA ERROR --}}
                    @if ($errors->any() && old('mode') === 'edit')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                const modal = document.getElementById('editModalDokumen');
                                if (modal) {
                                    modal.classList.remove('hidden');
                                }

                                // 1. Ambil data old() non-file
                                const oldId = '{{ old('id') }}';
                                const oldNmDokumen = '{{ old('nm_dokumen') }}';
                                const oldFolderId = '{{ old('folder_id') }}';
                                
                                // 2. Suntikkan data old() ke dalam field
                                //    Pastikan elemen-elemen ini ada dan memiliki ID yang benar
                                document.getElementById('edit_id_dokumen').value = oldId;
                                document.getElementById('edit_nm_dokumen').value = oldNmDokumen;
                                document.getElementById('edit_folder_id').value = oldFolderId;
                                
                                // 3. Set action form ke ID yang lama
                                document.getElementById('editFormDokumen').action = `/admin/dokumen/${oldId}`;
                                
                                // 4. Update tampilan nama file menjadi 'Tidak ada file yang dipilih' 
                                //    (karena input file di-reset browser, dan ini adalah perilaku yang benar)
                                document.getElementById('edit-file-name-dokumen').textContent = 'Tidak ada file yang dipilih';

                                // Opsional: Tampilkan pesan error file jika ada
                                @error('file_path')
                                    // Jika validasi file gagal, ini harus memicu alert atau konsol log
                                    console.error("Validasi File Gagal: {{ $message }}"); 
                                @enderror
                            });
                        </script>
                    @endif
                @endif
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA DOKUMEN--}}
    <script>
        console.log(document.getElementById('tambahFormDokumen').action);
        function openTambahModalDokumen() {
        document.getElementById('tambahModalDokumen').classList.remove('hidden');
        }

        function closeTambahModalDokumen() {
            document.getElementById('tambahModalDokumen').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA DOKUMEN--}}
    <script>
        function openEditModalDokumen(id, nm_dokumen, folder_id, file_path) {
            document.getElementById('edit_id_dokumen').value = id;
            document.getElementById('edit_nm_dokumen').value = nm_dokumen;
            document.getElementById('edit_folder_id').value = folder_id;

            document.getElementById('editFormDokumen').action = `/admin/dokumen/${id}`;
            document.getElementById('editModalDokumen').classList.remove('hidden');
        }

        function closeEditModalDokumen() {
            document.getElementById('editModalDokumen').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK DOKUMEN--}}
    <script> //Tambah dokumen
        document.getElementById('custom-upload').addEventListener('click', function () {
            document.getElementById('tambah_file_path').click();
        });

        document.getElementById('tambah_file_path').addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name || 'Tidak ada file yang dipilih';
            document.getElementById('file-name').textContent = fileName;
        });

        document.getElementById('tambahFormDokumen').addEventListener('submit', function(e) {
        });
    </script>

    <script>    // Edit dokumen
        document.getElementById('edit-custom-upload-dokumen').addEventListener('click', function () { // ID BARU
            document.getElementById('edit_file_path').click();
        });

        document.getElementById('edit_file_path').addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name || 'Tidak ada file yang dipilih';
            document.getElementById('edit-file-name-dokumen').textContent = fileName; // ID BARU
        });

        document.getElementById('editFormDokumen').addEventListener('submit', function(e) {
            // ... (kode submit)
        });
    </script>

@endsection