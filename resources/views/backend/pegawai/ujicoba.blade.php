{{-- MODAL TAMBAH DATA DAFTAR USER --}}
                    <div id="tambahModalUser" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Tambah Daftar User</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="tambahFormUser" method="POST" action="{{ route('backend.user.store') }}">
                                    @csrf

                                    <input type="hidden" name="id" id="tambah_id_user">
                                    <input type="hidden" name="mode" value="tambah">

                                    <div class="mb-3">
                                        <label for="tambah_username" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Username</label>
                                        <input type="text" name="username" id="tambah_username" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('username') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="tambah_email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="text" name="email" id="tambah_email" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('email') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium">Nama Pegawai</label>
                                        <select name="pegawai_id" id="pegawai_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                            <option value="">-- Pilih Pegawai --</option>
                                            @foreach ($pegawai as $pgw)
                                                <option value="{{ $pgw->id }}" {{ old('pegawai_id') == $pgw->id ? 'selected' : '' }}>
                                                {{ $pgw->nama }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tambah_role" class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                                        <select name="role" id="tambah_role" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                                            <option value="">Pilih Role</option>
                                            <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>0</option>
                                            <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>3</option>
                                            <option value="4" {{ old('role') == '4' ? 'selected' : '' }}>4</option>
                                            <option value="5" {{ old('role') == '5' ? 'selected' : '' }}>5</option>
                                            <option value="6" {{ old('role') == '6' ? 'selected' : '' }}>6</option>
                                        </select>
                                    </div>

                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                <button type="button" onclick="closeTambahModalAgama()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="tambahFormAgama" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                    {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA DAFTAR USER JIKA ADA ERROR--}}
                    @if ($errors->any() && old('mode') === 'tambah')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('tambahModalAgama').classList.remove('hidden');
                            });
                        </script>
                    @endif

                    {{-- MODUL EDIT DATA DAFTAR USER --}}
                    @if(isset($agm))
                        <div id="editModalAgama" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                            style="max-width: 800px; max-height: 800px;">
                                <div class="p-6">
                                    <h2 class="text-base font-semibold">Edit Daftar Agama</h2>
                                </div>

                                <div class="form_edit p-6 overflow-y-auto">
                                    <form id="editFormAgama" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="id" id="edit_id_agama">
                                        <input type="hidden" name="mode" value="edit">

                                        <div class="mb-3">
                                            <label for="edit_nm_agama" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Agama</label>
                                            <input type="text" name="nm_agama" id="edit_nm_agama" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_agama', $agm->nm_agama) }}">
                                        </div>

                                    </form>
                                </div>
                                <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                    <button type="button" onclick="closeEditModalAgama()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                    <button type="submit" form="editFormAgama" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                                </div>
                            </div>
                        </div>

                        {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA DAFTAR USER JIKA ADA ERROR --}}
                        @if ($errors->any() && old('mode') === 'edit')
                            <script>
                                window.addEventListener('DOMContentLoaded', () => {
                                    document.getElementById('editModalAgama').classList.remove('hidden');
                                });
                            </script>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA DAFTAR USER--}}
    <script>
        console.log(document.getElementById('tambahFormAgama').action);
        function openTambahModalAgama() {
        document.getElementById('tambahModalAgama').classList.remove('hidden');
        }

        function closeTambahModalAgama() {
            document.getElementById('tambahModalAgama').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA DAFTAR USER--}}
    <script>
        function openEditModalAgama(id, nm_agama) {
            document.getElementById('edit_id_agama').value = id;
            document.getElementById('edit_nm_agama').value = nm_agama;
            
            // 1. Ambil URL rute Laravel yang benar menggunakan helper route()
            const updateUrl = "{{ route('backend.agama.update', ':id') }}";
            
            // 2. Ganti placeholder ':id' dengan ID yang dikirim
            document.getElementById('editFormAgama').action = updateUrl.replace(':id', id);
            
            document.getElementById('editModalAgama').classList.remove('hidden');
        }

        function closeEditModalAgama() {
            document.getElementById('editModalAgama').classList.add('hidden');
        }
    </script>