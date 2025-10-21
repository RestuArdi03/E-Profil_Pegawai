@extends('main.layout2')@section('content')
    <h1 class="text-xl font-semibold mb-4">Daftar User
        <button type="button"
        onclick="openTambahModalUser()"
        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow-sm">
            <span class="material-icons" style="margin-right: 5px; margin-left: -5px;font-size: 16px;">add</span>
            Tambah Data
        </button>
    </h1>

    {{-- FITUR SORT BY --}}
    @php
        // Tentukan URL dasar untuk memudahkan pembuatan link filter
        $currentRoute = route('backend.daftar_user');
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

            <option value="{{ $currentRoute }}?sort_by=username&direction=asc" 
                {{ $currentSortBy == 'username' && $currentDirection == 'asc' ? 'selected' : '' }}>
                Username (A-Z)
            </option>
            
            <option value="{{ $currentRoute }}?sort_by=username&direction=desc" 
                {{ $currentSortBy == 'username' && $currentDirection == 'desc' ? 'selected' : '' }}>
                Username (Z-A)
            </option>
            
            <option value="{{ $currentRoute }}?sort_by=updated_at&direction=desc" 
                {{ $currentSortBy == 'updated_at' && $currentDirection == 'desc' ? 'selected' : '' }}>
                Terakhir Diedit
            </option>

        </select>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600">
                            <tr>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 50px;">No</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Username</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Email</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Pegawai</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Kode Role</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 250px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $u)
                                <tr>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $users->firstItem() + $loop->iteration - 1 }}</td>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $u->username }}</td>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $u->email }}</td>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ optional($u->pegawai)->nama ?? '-' }}</td>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $u->role }}</td>
                                    <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                        <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                            {{-- Tombol Edit --}}
                                            <button type="button"
                                                onclick="openEditModalUser(
                                                    {{ $u->id }},
                                                    '{{ addslashes(e($u->username)) }}',
                                                    '{{ addslashes(e($u->email)) }}',
                                                    '{{ $u->pegawai_id }}',
                                                    '{{ $u->role }}'
                                                )"
                                                class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                                <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                                Edit
                                            </button>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('backend.user.destroy', $u->id) }}" method="POST" class="inline-block"
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
                                <td colspan="6" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada data User.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                                        @error('username')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="tambah_email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="text" name="email" id="tambah_email" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('email') }}">
                                        @error('email')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="tambah_password" class="block text-sm font-medium text-gray-700">Password</label>
                                        <input type="password" name="password" id="tambah_password" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                        @error('password')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="tambah_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" id="tambah_password_confirmation"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-200 focus:outline-none text-sm" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium">Nama Pegawai</label>
                                        <select name="pegawai_id" id="pegawai_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                            <option value="">-- Pilih Pegawai --</option>
                                            @foreach ($pegawaiBelumDipakai as $pgw)
                                                <option value="{{ $pgw->id }}" {{ old('pegawai_id') == $pgw->id ? 'selected' : '' }}>
                                                {{ $pgw->nama }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tambah_role" class="block text-sm font-medium text-gray-700">Kode Role</label>
                                        <select name="role" id="tambah_role" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                                            <option value="">Pilih Role</option>
                                            <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>0 - Pegawai</option>
                                            <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>1 - Admin</option>
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
                                <button type="button" onclick="closeTambahModalUser()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="tambahFormUser" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                    {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA DAFTAR USER JIKA ADA ERROR--}}
                    @if ($errors->any() && old('mode') === 'tambah')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('tambahModalUser').classList.remove('hidden');
                            });
                        </script>
                    @endif

                    {{-- MODUL EDIT DATA DAFTAR USER --}}
                    @if(isset($u))
                        <div id="editModalUser" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                            style="max-width: 800px; max-height: 800px;">
                                <div class="p-6">
                                    <h2 class="text-base font-semibold">Edit Daftar User</h2>
                                </div>

                                <div class="form_edit p-6 overflow-y-auto">
                                    <form id="editFormUser" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="id" id="edit_id_user">
                                        <input type="hidden" name="mode" value="edit">

                                        <div class="mb-3">
                                            <label for="edit_username" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Username</label>
                                            <input type="text" name="username" id="edit_username" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('username', $u->username) }}">
                                            @error('username')
                                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="text" name="email" id="edit_email" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('email', $u->email) }}">
                                            @error('email')
                                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="block text-sm font-medium">Nama Pegawai</label>
                                            <select name="pegawai_id" id="edit_pegawai_id" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required>
                                                <option value="">-- Pilih Nama Pegawai --</option>
                                                    @foreach ($pegawai as $pgw)
                                                        {{-- PENTING: Gunakan session() atau old() sebagai fallback utama untuk seleksi --}}
                                                        @php
                                                            $isSelected = old('pegawai_id', $u->pegawai_id ?? null) == $pgw->id;
                                                        @endphp
                                                        
                                                        <option 
                                                            value="{{ $pgw->id }}" 
                                                            {{-- SUNTIKKAN STATUS TERPAKAI (TRUE/FALSE) --}}
                                                            data-used="{{ $pgw->user ? 'true' : 'false' }}"
                                                            {{ $isSelected ? 'selected' : '' }}
                                                        >
                                                            {{ $pgw->nama }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                            {{-- Tambahkan error display --}}
                                            @error('pegawai_id')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_role" class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                                            <select name="role" id="edit_role" required
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                                                <option value="">Pilih Role</option>
                                                <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>0 - Pegawai</option>
                                                <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>1 - Admin</option>
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
                                    <button type="button" onclick="closeEditModalUser()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                    <button type="submit" form="editFormUser" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                                </div>
                            </div>
                        </div>

                        {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA DAFTAR USER JIKA ADA ERROR --}}
                        @if ($errors->any() && old('mode') === 'edit')
                            <script>
                                window.addEventListener('DOMContentLoaded', () => {
                                    document.getElementById('editModalUser').classList.remove('hidden');
                                });
                            </script>
                        @endif
                    @endif

                </div>
                {{-- TAMBAHKAN NAVIGASI PAGINATION DI SINI --}}
                <div class="mt-4 flex justify-end p-4">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA DAFTAR USER--}}
    <script>
        console.log(document.getElementById('tambahFormUser').action);
        function openTambahModalUser() {
        document.getElementById('tambahModalUser').classList.remove('hidden');
        }

        function closeTambahModalUser() {
            document.getElementById('tambahModalUser').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA DAFTAR USER --}}
    <script>
        // Fungsi utama yang dipanggil dari tombol Edit
        function openEditModalUser(id, username, email, pegawai_id, role) {
            
            // Mengisi data dasar
            document.getElementById('edit_id_user').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;

            const select = document.getElementById('edit_pegawai_id');
            
            // Konversi ID pegawai ke string untuk perbandingan yang konsisten
            const currentPegawaiId = pegawai_id.toString(); 

            // 1. Jalankan Logika Filtering
            for (const option of select.options) {
                // Selalu tampilkan opsi yang sebelumnya disembunyikan
                option.hidden = false; 
                
                // Logika Sembunyi: Jika sudah terpakai OLEH USER LAIN
                if (option.dataset.used === "true" && option.value !== currentPegawaiId) {
                    option.hidden = true;
                }
            }
            
            // 2. Prefill: Set nilai yang sudah tersimpan (atau nilai yang dikirim dari tombol)
            // Nilai ini penting agar opsi yang seharusnya terseleksi (terutama yang tersembunyi) tetap terseleksi
            select.value = pegawai_id;

            // 3. Set Action URL Form
            const updateUrl = "{{ route('backend.user.update', ':id') }}";
            document.getElementById('editFormUser').action = updateUrl.replace(':id', id);
            
            // Tampilkan Modal
            document.getElementById('editModalUser').classList.remove('hidden');
        }

        function closeEditModalUser() {
            document.getElementById('editModalUser').classList.add('hidden');
        }
    </script>

@endsection