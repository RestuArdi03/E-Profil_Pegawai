@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Profil Pegawai
        <button type="button"
            onclick="openEditModalPegawai(
                {{ $pegawai->id }},
                '{{ addslashes(e($pegawai->nama)) }}',
                '{{ addslashes(e($pegawai->nip)) }}',
                '{{ addslashes(e($pegawai->no_kk)) }}',
                '{{ addslashes(e($pegawai->tpt_lahir)) }}',
                '{{ addslashes(e($pegawai->tgl_lahir)) }}',
                '{{ addslashes(e($pegawai->no_karpeg)) }}',
                '{{ $pegawai->agama_id }}',
                '{{ addslashes(e($pegawai->golongan_darah)) }}',
                '{{ addslashes(e($pegawai->status_kawin)) }}',
                '{{ addslashes(e($pegawai->tgl_kawin)) }}',
                '{{ addslashes(e($pegawai->no_karis_karsu)) }}',
                '{{ addslashes(e($pegawai->almt_rumah)) }}',
                '{{ addslashes(e($pegawai->tmt_pensiun)) }}',
                '{{ $pegawai->instansi_id }}',
                '{{ $pegawai->unit_kerja_id }}',
                '{{ $pegawai->satuan_kerja_id }}'
            )"
            class="inline-block px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md shadow-sm">
            <span class="material-icons" style="margin-right: 5px; margin-left: -5px; font-size: 16px;">edit</span>
        Edit
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

    @if($pegawai)
        <div class="p-1">
            <div class="overflow-x-auto ">
                <table class="min-w-full divide-y divide-gray-200 border border-collapse">
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800" style="width: 300px;">
                                Nama
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                NIP
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->nip }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                No Kartu Keluarga
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->no_kk }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Tempat Lahir
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->tpt_lahir }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Tanggal Lahir
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->tgl_lahir }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                No Karpeg
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->no_karpeg }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Agama
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->agama->nm_agama }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Golongan Darah
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->golongan_darah ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Status Perkawinan
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->status_kawin }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Tanggal Perkawinan
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->tgl_kawin ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                No Karis/Karsu
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->no_karis_karsu }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Alamat Rumah
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->almt_rumah }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Tamat Pensiun
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->tmt_pensiun }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Instansi
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->instansi->nm_instansi }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Unit Kerja
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                 {{ optional($pegawai->instansi->latestUnitKerja)->nm_unit_kerja ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Satuan Kerja
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ optional(optional($pegawai->instansi->latestUnitKerja)->latestSatuanKerja)->nm_satuan_kerja ?? '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>Data pegawai belum ada untuk akun ini.</p>
    @endif

    <!-- Modal Edit Pegawai / Employee Edit Modal -->
    <div id="editModalPegawai" class="fixed inset-0 z-50 hidden flex justify-center items-center bg-black/50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4" style="max-width: 800px; max-height: 1200px;">
            <div class="p-6">
                <h2 class="text-base font-semibold">Edit Data Profil Pegawai</h2>
            </div>

            <div id="editScrollContainer" class="form_edit p-6 overflow-y-auto">
                <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3" style="margin-top: -25px;">
                        <label for="edit_foto" class="block text-sm font-medium text-gray-700">Foto Pegawai</label>
                        <div class= "w-full flex items-center border border-gray-300 rounded-md shadow-sm px-3 bg-white text-sm text-gray-900 mt-1">
                            <button type="button" id="custom-upload" class="text-green-700 rounded-md bg-green-50">Pilih File</button>
                            <hr style="border: 1px solid #ccc; height: 40px; margin-right: 10px; margin-left: 10px;" >
                            <span id="file-name">{{ $pegawai->foto ?? 'Tidak ada file yang dipilih' }}</span>
                        </div>
                        <input type="file" name="foto" id="edit_foto" class="hidden"/>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama" id="edit_nama" value="{{ old('nama', $pegawai->nama) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nip" class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" name="nip" id="edit_nip" value="{{ old('nip', $pegawai->nip) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                            @error('nip')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_no_kk" class="block text-sm font-medium text-gray-700">No Kartu Keluarga</label>
                        <input type="text" name="no_kk" id="edit_no_kk" value="{{ old('no_kk', $pegawai->no_kk) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tpt_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tpt_lahir" id="edit_tpt_lahir" value="{{ old('tpt_lahir', $pegawai->tpt_lahir) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" id="edit_tgl_lahir" value="{{ old('tgl_lahir', $pegawai->tgl_lahir) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_no_karpeg" class="block text-sm font-medium text-gray-700">No Karpeg</label>
                        <input type="text" name="no_karpeg" id="edit_no_karpeg" value="{{ old('no_karpeg', $pegawai->no_karpeg) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                            @error('no_karpeg')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_agama" class="block text-sm font-medium text-gray-700">Agama</label>
                        <select name="agama_id" id="edit_agama" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                            <option value="">-- Pilih Agama --</option>
                            @foreach ($agama as $a)
                                <option value="{{ $a->id }}" {{ old('agama_id') == $a->id ? 'selected' : '' }}>
                                    {{ $a->nm_agama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_golongan_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                        <select name="golongan_darah" id="edit_golongan_darah"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                            <option value="">Pilih Golongan Darah</option>
                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status_kawin" class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                        <select name="status_kawin" id="edit_status_kawin" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                            <option value="">Pilih Status</option>
                            <option value="Belum Kawin" {{ old('status_kawin') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_kawin') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai" {{ old('status_kawin') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tgl_kawin" class="block text-sm font-medium text-gray-700">Tanggal Perkawinan</label>
                        <input type="date" name="tgl_kawin" id="edit_tgl_kawin" value="{{ old('tgl_kawin', $pegawai->tgl_kawin) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                    </div>
                    <div class="mb-3">
                        <label for="edit_no_karis_karsu" class="block text-sm font-medium text-gray-700">No Karis/Karsu</label>
                        <input type="text" name="no_karis_karsu" id="edit_no_karis_karsu" value="{{ old('no_karis_karsu', $pegawai->no_karis_karsu) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                        @error('no_karis_karsu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_almt_rumah" class="block text-sm font-medium text-gray-700">Alamat Rumah</label>
                        <input type="text" name="almt_rumah" id="edit_almt_rumah" value="{{ old('almt_rumah', $pegawai->almt_rumah) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tmt_pensiun" class="block text-sm font-medium text-gray-700">Tamat Pensiun</label>
                        <input type="date" name="tmt_pensiun" id="edit_tmt_pensiun" value="{{ old('tmt_pensiun', $pegawai->tmt_pensiun) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_instansi" class="block text-sm font-medium text-gray-700">Instansi</label>
                        <select name="instansi_id" id="edit_instansi"
                            class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-200 focus:outline-none text-sm" required>
                            <option value="">Pilih Instansi</option>
                            @foreach($instansis as $instansi)
                                <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>
                                    {{ $instansi->nm_instansi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ✅ Hidden input untuk prefill JS --}}
                    <input type="hidden" id="old_unit_kerja_id" value="{{ old('unit_kerja_id', $pegawai->unit_kerja_id) }}">
                    <input type="hidden" id="old_satuan_kerja_id" value="{{ old('satuan_kerja_id', $pegawai->satuan_kerja_id) }}">

                    <div class="mb-3">
                        <label for="edit_unit_kerja" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                        <select name="unit_kerja_id" id="edit_unit_kerja"
                            class=" form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                            <option value="">Pilih Unit Kerja</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_satuan_kerja" class="block text-sm font-medium text-gray-700">Satuan Kerja</label>
                        <select name="satuan_kerja_id" id="edit_satuan_kerja"
                            class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                            <option value="">Pilih Satuan Kerja</option>
                        </select>
                    </div>
                </form>
            </div>
            <!-- Tombol Aksi / Action Buttons -->
            <div class="flex justify-end gap-2 p-6">
                <button type="button" onclick="closeEditModalPegawai()"
                        class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                    Batal
                </button>
                <button type="submit" form="editForm"
                        class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                    Simpan
                </button>
            </div>
            
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('editModalPegawai');
                if (modal) {
                    // Jika pakai Tailwind UI atau Alpine
                    modal.classList.remove('hidden');
                    modal.classList.add('block');
                }

                // Jika pakai Bootstrap modal
                // new bootstrap.Modal(modal).show();
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('modalEditPegawai');
                if (modal) {
                    modal.classList.remove('hidden');
                    modal.classList.add('block');
                }

                const instansi_id = document.getElementById('edit_instansi')?.value;
                const unit_kerja_id = document.getElementById('old_unit_kerja_id')?.value;
                const satuan_kerja_id = document.getElementById('old_satuan_kerja_id')?.value;

                console.log("🔥 Error detected, triggering prefill...");
                console.log("Prefill triggered:", instansi_id, unit_kerja_id, satuan_kerja_id);

                // ✅ Tambahkan delay agar dropdown siap
                setTimeout(() => {
                    window.prefillDropdown(instansi_id, unit_kerja_id, satuan_kerja_id);
                }, 500);
            });
        </script>
    @endif
    
    <script>
        function openEditModalPegawai(id , nama, nip, no_kk, tpt_lahir, tgl_lahir, no_karpeg, agama_id, golongan_darah, status_kawin, tgl_kawin, no_karis_karsu, almt_rumah, tmt_pensiun, instansi_id, unit_kerja_id, satuan_kerja_id) {
            console.log('Edit modal triggered');
            console.log("Instansi ID:", instansi_id);
            console.log("Unit Kerja ID:", unit_kerja_id);
            console.log("Satuan Kerja ID:", satuan_kerja_id);

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_nip').value = nip;
            document.getElementById('edit_no_kk').value = no_kk;
            document.getElementById('edit_tpt_lahir').value = tpt_lahir;
            document.getElementById('edit_tgl_lahir').value = tgl_lahir;
            document.getElementById('edit_no_karpeg').value = no_karpeg;
            document.getElementById('edit_agama').value = agama_id;
            document.getElementById('edit_golongan_darah').value = golongan_darah;
            document.getElementById('edit_status_kawin').value = status_kawin;
            document.getElementById('edit_tgl_kawin').value = tgl_kawin;
            document.getElementById('edit_no_karis_karsu').value = no_karis_karsu;
            document.getElementById('edit_almt_rumah').value = almt_rumah;
            document.getElementById('edit_tmt_pensiun').value = tmt_pensiun;
            document.getElementById('edit_instansi').value = instansi_id;
            document.getElementById('edit_unit_kerja').value = unit_kerja_id;
            document.getElementById('edit_satuan_kerja').value = satuan_kerja_id;
            
            const form = document.getElementById('editForm');
            form.action = `/admin/pegawai/${id}`; // pastikan route update sesuai
            
            prefillDropdown(instansi_id, unit_kerja_id, satuan_kerja_id);
            console.log("Prefill triggered:", instansi_id, unit_kerja_id, satuan_kerja_id);
            document.getElementById('editModalPegawai').classList.remove('hidden');
            setTimeout(() => {
                prefillDropdown(instansi_id, unit_kerja_id, satuan_kerja_id);
            }, 100);
        }

        function closeEditModalPegawai() {
            document.getElementById('editModalPegawai').classList.add('hidden');
        }
    </script>

    <script> //Edit Foto
        document.getElementById('custom-upload').addEventListener('click', function () {
            document.getElementById('edit_foto').click();
        });

        document.getElementById('edit_foto').addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name || 'Tidak ada file yang dipilih';
            document.getElementById('file-name').textContent = fileName;
        });

        document.getElementById('editForm').addEventListener('submit', function(e) {
        });
    </script>
 
    <script> //Status Kawin dan Tanggal Kawin
        document.addEventListener('DOMContentLoaded', function () {
            const statusKawinSelect = document.getElementById('edit_status_kawin');
            const tglKawinInput = document.getElementById('edit_tgl_kawin');

            function handleStatusChange() {
                const status = statusKawinSelect.value;

                if (status === 'Kawin') {
                    tglKawinInput.required = true;
                    tglKawinInput.disabled = false;
                } else {
                    tglKawinInput.required = false;
                    tglKawinInput.value = '';
                    tglKawinInput.disabled = true;
                }
            }

            // Jalankan saat halaman dimuat
            handleStatusChange();

            // Jalankan saat status berubah
            statusKawinSelect.addEventListener('change', handleStatusChange);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const instansiSelect = document.getElementById('edit_instansi');
            const unitKerjaSelect = document.getElementById('edit_unit_kerja');
            const satuanKerjaSelect = document.getElementById('edit_satuan_kerja');

            // ✅ Prefill saat modal dibuka
            window.prefillDropdown = function(instansi_id, unit_kerja_id, satuan_kerja_id) {
                instansiSelect.value = instansi_id;
                unitKerjaSelect.innerHTML = '<option value="">Loading...</option>';
                satuanKerjaSelect.innerHTML = '<option value="">Pilih Satuan Kerja</option>';

                fetch(`/admin/get-unit-kerja/${instansi_id}`)
                    .then(res => res.json())
                    .then(data => {
                        unitKerjaSelect.innerHTML = '<option value="">Pilih Unit Kerja</option>';
                        data.forEach(unit => {
                            const option = document.createElement('option');
                            option.value = unit.id;
                            option.textContent = unit.nm_unit_kerja;
                            if (unit.id == unit_kerja_id) option.selected = true;
                            unitKerjaSelect.appendChild(option);
                        });

                        return fetch(`/admin/get-satuan-kerja/${unit_kerja_id}`);
                    })
                    .then(res => res.json())
                    .then(data => {
                        satuanKerjaSelect.innerHTML = '<option value="">Pilih Satuan Kerja</option>';
                        data.forEach(satuan => {
                            const option = document.createElement('option');
                            option.value = satuan.id;
                            option.textContent = satuan.nm_satuan_kerja;
                            if (satuan.id == satuan_kerja_id) option.selected = true;
                            satuanKerjaSelect.appendChild(option);
                        });

                        // ✅ Tambahkan log di sini
                        console.log("Unit Kerja selected:", unitKerjaSelect.value);
                        console.log("Satuan Kerja selected:", satuanKerjaSelect.value);
                    });
            };

            instansiSelect.addEventListener('change', function () {
                const instansiId = this.value;
                unitKerjaSelect.innerHTML = '<option value="">Loading...</option>';
                satuanKerjaSelect.innerHTML = '<option value="">Pilih Satuan Kerja</option>';

                fetch(`/admin/get-unit-kerja/${instansiId}`)
                    .then(res => res.json())
                    .then(data => {
                        unitKerjaSelect.innerHTML = '<option value="">Pilih Unit Kerja</option>';
                        data.forEach(unit => {
                            unitKerjaSelect.innerHTML += `<option value="${unit.id}">${unit.nm_unit_kerja}</option>`;
                        });
                    });
            });

            // ✅ Fetch satuan kerja saat unit kerja berubah
            unitKerjaSelect.addEventListener('change', function () {
                const unitKerjaId = this.value;
                satuanKerjaSelect.innerHTML = '<option value="">Loading...</option>';

                fetch(`/admin/get-satuan-kerja/${unitKerjaId}`)
                    .then(response => response.json())
                    .then(data => {
                        satuanKerjaSelect.innerHTML = '<option value="">Pilih Satuan Kerja</option>';
                        data.forEach(satuan => {
                            satuanKerjaSelect.innerHTML += `<option value="${satuan.id}">${satuan.nm_satuan_kerja}</option>`;
                        });
                    });
            });

            // Optional: expose prefillDropdown globally if needed
            window.prefillDropdown = prefillDropdown;
        });
    </script>

@endsection