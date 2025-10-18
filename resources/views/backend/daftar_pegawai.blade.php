@extends('main.layout2')@section('content')
    <h1 class="text-xl font-semibold mb-4">Daftar Pegawai
        <button type="button"
        onclick="openTambahModal()"
        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow-sm">
            <span class="material-icons" style="margin-right: 5px; margin-left: -5px;font-size: 16px;">add</span>
            Tambah Data
        </button>
    </h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif


    <div class="mb-4">
        
    </div>

    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 50px;">No</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Pegawai</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">NIP</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pegawai as $item)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $item->nama }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $item->nip }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800 space-x-2 text-center align-middle">
                                    <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('backend.pegawai.show', $item->id) }}"
                                        class="inline-block px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                                        <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">zoom_in</span>
                                            Detail
                                        </a>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('backend.daftar_pegawai.destroy', $item->id) }}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                                <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">delete</span>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pegawai dan Akun User -->
    <div id="tambahModal" class="fixed inset-0 z-50 hidden flex justify-center items-center bg-black/50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 1200px;">
            <div class="p-6">
                <h2 class="text-base font-semibold">Tambah Akun User dan Data Pegawai</h2>
            </div>

            <div id="tambahScrollContainer" class="form_edit p-6 overflow-y-auto">
                <form id="tambahForm" method="POST" action="{{ route('backend.daftar_pegawai.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="mb-3">
                        <label for="tambah_foto" class="block text-sm font-medium text-gray-700" style="margin-top: -45px;">Foto Pegawai</label>
                        <div class= "w-full flex items-center border border-gray-300 rounded-md shadow-sm px-3 bg-white text-sm text-gray-900">
                            <button type="button" id="custom-upload" class="text-green-700 rounded-md bg-green-50">Pilih File</button>
                            <hr style="border: 1px solid #ccc; height: 40px; margin-right: 10px; margin-left: 10px;" >
                            <span id="file-name">Tidak ada file yang dipilih</span>
                        </div>
                        <input type="file" name="foto" id="tambah_foto" class="hidden"/>
                    </div>

                    <div class="mb-3">
                        <label for="tambah_nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama" id="tambah_nama" value="{{ old('nama') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" required name="nip" id="nip" class="form-control mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-200 focus:outline-none text-sm @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                        @error('nip')
                            <div class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tambah_no_kk" class="block text-sm font-medium text-gray-700">No Kartu Keluarga</label>
                        <input type="text" name="no_kk" id="tambah_no_kk" value="{{ old('no_kk') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_tpt_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tpt_lahir" id="tambah_tpt_lahir" value="{{ old('tpt_lahir') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" id="tambah_tgl_lahir" value="{{ old('tgl_lahir') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="no_karpeg" class="block text-sm font-medium text-gray-700">No. Karpeg</label>
                        <input type="text" required name="no_karpeg" id="no_karpeg" class="form-control mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm @error('no_karpeg') is-invalid @enderror" value="{{ old('no_karpeg') }}">
                        @error('no_karpeg')
                            <div class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tambah_agama" class="block text-sm font-medium text-gray-700">Agama</label>
                        <select name="agama_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                            <option value="">-- Pilih Agama --</option>
                            @foreach ($agama as $a)
                                <option value="{{ $a->id }}" {{ old('agama_id') == $a->id ? 'selected' : '' }}>
                                    {{ $a->nm_agama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_golongan_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                        <select name="golongan_darah" id="tambah_golongan_darah"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                            <option value="">Pilih Golongan Darah</option>
                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_status_kawin" class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                        <select name="status_kawin" id="tambah_status_kawin" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                            <option value="">Pilih Status</option>
                            <option value="Belum Kawin" {{ old('status_kawin') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_kawin') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai" {{ old('status_kawin') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tambah_tgl_kawin" class="block text-sm font-medium text-gray-700">Tanggal Kawin</label>
                        <input type="date" name="tgl_kawin" id="tambah_tgl_kawin"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" value="{{ old('tgl_kawin') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="no_karis_karsu" class="block text-sm font-medium text-gray-700">No. Karis/Karsu</label>
                        <input type="text" required name="no_karis_karsu" id="no_karis_karsu" class="form-control mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm @error('no_karis_karsu') is-invalid @enderror" value="{{ old('no_karis_karsu') }}">
                        @error('no_karis_karsu')
                            <div class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tambah_almt_rumah" class="block text-sm font-medium text-gray-700">Alamat Rumah</label>
                        <input type="text" name="almt_rumah" id="tambah_almt_rumah" value="{{ old('almt_rumah') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_tmt_pensiun" class="block text-sm font-medium text-gray-700">Tamat Pensiun</label>
                        <input type="date" name="tmt_pensiun" id="tambah_tmt_pensiun" value="{{ old('tmt_pensiun') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                    </div>

                    <div class="mb-3">
                        <label for="tambah_instansi" class="block text-sm font-medium text-gray-700">Instansi</label>
                        <select name="instansi_id" id="tambah_instansi"
                            class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-200 focus:outline-none text-sm" required>
                            <option value="">Pilih Instansi</option>
                            @foreach($instansis as $instansi)
                                <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>
                                    {{ $instansi->nm_instansi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tambah_unit_kerja" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                        <select name="unit_kerja_id" id="tambah_unit_kerja"
                            class=" form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                            <option value="">Pilih Unit Kerja</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tambah_satuan_kerja" class="block text-sm font-medium text-gray-700">Satuan Kerja</label>
                        <select name="satuan_kerja_id" id="tambah_satuan_kerja"
                            class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm" required>
                            <option value="">Pilih Satuan Kerja</option>
                        </select>
                    </div>

                </form>
            </div>

            <!-- Tombol Aksi / Action Buttons -->
            <div class="flex justify-end gap-2 p-6">
                <button type="button" onclick="closeTambahModal()"
                        class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                    Batal
                </button>
                <button type="submit" form="tambahForm"
                        class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Trigger buka modal secara otomatis
                const modal = document.getElementById('tambahModal');
                if (modal) {
                    modal.classList.remove('hidden'); // Tailwind-style
                    modal.classList.add('flex');      // atau 'block' sesuai modal
                }
            });
        </script>
    @endif

    <script>
        function openTambahModal() {
            document.getElementById('tambahModal')?.classList.remove('hidden');
        }

        function closeTambahModal() {
            document.getElementById('tambahModal')?.classList.add('hidden');
        }
    </script>
    <script>
        document.getElementById('custom-upload').addEventListener('click', function () {
            document.getElementById('tambah_foto').click();
        });

        document.getElementById('tambah_foto').addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name || 'Tidak ada file yang dipilih';
            document.getElementById('file-name').textContent = fileName;
        });

        document.getElementById('tambahForm').addEventListener('submit', function(e) {
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const instansiSelect = document.getElementById('tambah_instansi');
            const unitKerjaSelect = document.getElementById('tambah_unit_kerja');
            const satuanKerjaSelect = document.getElementById('tambah_satuan_kerja');

            const oldUnitKerja = "{{ old('unit_kerja_id') }}";
            const oldSatuanKerja = "{{ old('satuan_kerja_id') }}";

            // Saat instansi dipilih
            instansiSelect.addEventListener('change', function () {
                const instansiId = this.value;
                fetch(`/admin/get-unit-kerja/${instansiId}`)
                    .then(res => res.json())
                    .then(data => {
                        unitKerjaSelect.innerHTML = '<option value="">Pilih Unit Kerja</option>';
                        data.forEach(item => {
                            const selected = item.id == oldUnitKerja ? 'selected' : '';
                            unitKerjaSelect.innerHTML += `<option value="${item.id}" ${selected}>${item.nm_unit_kerja}</option>`;
                        });

                        satuanKerjaSelect.innerHTML = '<option value="">Pilih Satuan Kerja</option>';
                    });
            });

            // Saat unit kerja dipilih
            unitKerjaSelect.addEventListener('change', function () {
                const unitKerjaId = this.value;
                fetch(`/admin/get-satuan-kerja/${unitKerjaId}`)
                    .then(res => res.json())
                    .then(data => {
                        satuanKerjaSelect.innerHTML = '<option value="">Pilih Satuan Kerja</option>';
                        data.forEach(item => {
                            const selected = item.id == oldSatuanKerja ? 'selected' : '';
                            satuanKerjaSelect.innerHTML += `<option value="${item.id}" ${selected}>${item.nm_satuan_kerja}</option>`;
                        });
                    });
            });

            // Jika ada old instansi, trigger fetch unit kerja
            const oldInstansi = "{{ old('instansi_id') }}";
            if (oldInstansi) {
                instansiSelect.value = oldInstansi;
                instansiSelect.dispatchEvent(new Event('change'));

                // Tambahan: tunggu fetch unit kerja selesai, lalu trigger fetch satuan kerja
                setTimeout(() => {
                    if (oldUnitKerja) {
                        unitKerjaSelect.value = oldUnitKerja;
                        unitKerjaSelect.dispatchEvent(new Event('change'));
                    }
                }, 800); // delay kecil untuk pastikan unit kerja sudah terisi
            }
        });
    </script>
    
    {{-- JAVASCRIPT UNTUK STATUS PERKAWAINAN DAN TANGGAL KAWIN--}}
    <script>
        const statusKawin = document.getElementById('tambah_status_kawin');
        const tglKawin = document.getElementById('tambah_tgl_kawin');

        function toggleTanggalKawin() {
            if (statusKawin.value === 'Belum Kawin' || statusKawin.value === 'Cerai' || statusKawin.value === '') {
            tglKawin.disabled = true;
            tglKawin.value = ''; // kosongkan jika dinonaktifkan
            } else {
            tglKawin.disabled = false;
            }
        }

        // Jalankan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', toggleTanggalKawin);

        // Jalankan saat status kawin berubah
        statusKawin.addEventListener('change', toggleTanggalKawin);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusKawin = document.getElementById('tambah_status_kawin');
            const tglKawin = document.getElementById('tambah_tgl_kawin');

            function toggleRequired() {
                if (statusKawin.value === 'Kawin') {
                    tglKawin.setAttribute('required', 'required');
                } else {
                    tglKawin.removeAttribute('required');
                }
            }

            statusKawin.addEventListener('change', toggleRequired);
            toggleRequired(); // inisialisasi saat halaman dimuat
        });
    </script>

@endsection