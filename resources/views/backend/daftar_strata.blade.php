@extends('main.layout2')@section('content')
    <h1 class="text-xl font-semibold mb-4">Daftar Strata
        <button type="button"
        onclick="openTambahModalStrata()"
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
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600">
                            <tr>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 50px;">No</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Strata</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jurusan</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 250px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($strata as $s)
                                <tr>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $s->nm_strata }}</td>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $s->jurusan }}</td>
                                    <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                        <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                            {{-- Tombol Edit --}}
                                            <button type="button"
                                                onclick="openEditModalStrata(
                                                    {{ $s->id }},
                                                    '{{ addslashes(e($s->nm_strata)) }}',
                                                    '{{ addslashes(e($s->jurusan)) }}'
                                                )"
                                                class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                                <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                                Edit
                                            </button>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('backend.strata.destroy', $s->id) }}" method="POST" class="inline-block"
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
                            @endforeach
                        </tbody>
                    </table>

                    {{-- MODAL TAMBAH DATA DAFTAR STRATA --}}
                    <div id="tambahModalStrata" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Tambah Daftar Strata</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="tambahFormStrata" method="POST" action="{{ route('backend.strata.store') }}">
                                    @csrf

                                    <input type="hidden" name="id" id="tambah_id_strata">
                                    <input type="hidden" name="mode" value="tambah">

                                    <div class="mb-3">
                                        <label for="tambah_nm_strata" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Strata</label>
                                        <input type="text" name="nm_strata" id="tambah_nm_strata" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_strata') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tambah_jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                                        <input type="text" name="jurusan" id="tambah_jurusan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jurusan') }}">
                                    </div>

                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                <button type="button" onclick="closeTambahModalStrata()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="tambahFormStrata" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                    {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA DAFTAR STRATA JIKA ADA ERROR--}}
                    @if ($errors->any() && old('mode') === 'tambah')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('tambahModalStrata').classList.remove('hidden');
                            });
                        </script>
                    @endif

                    {{-- MODUL EDIT DATA DAFTAR STRATA --}}
                    @if(isset($s))
                        <div id="editModalStrata" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                            style="max-width: 800px; max-height: 800px;">
                                <div class="p-6">
                                    <h2 class="text-base font-semibold">Edit Daftar Strata</h2>
                                </div>

                                <div class="form_edit p-6 overflow-y-auto">
                                    <form id="editFormStrata" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="id" id="edit_id_strata">
                                        <input type="hidden" name="mode" value="edit">

                                        <div class="mb-3">
                                            <label for="edit_nm_strata" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Strata</label>
                                            <input type="text" name="nm_strata" id="edit_nm_strata" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_strata', $s->nm_strata) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                                            <input type="text" name="jurusan" id="edit_jurusan" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('jurusan', $s->jurusan) }}">
                                        </div>

                                    </form>
                                </div>
                                <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                    <button type="button" onclick="closeEditModalStrata()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                    <button type="submit" form="editFormStrata" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                                </div>
                            </div>
                        </div>

                        {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA DAFTAR STRATA JIKA ADA ERROR --}}
                        @if ($errors->any() && old('mode') === 'edit')
                            <script>
                                window.addEventListener('DOMContentLoaded', () => {
                                    document.getElementById('editModalStrata').classList.remove('hidden');
                                });
                            </script>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA DAFTAR STRATA--}}
    <script>
        console.log(document.getElementById('tambahFormStrata').action);
        function openTambahModalStrata() {
        document.getElementById('tambahModalStrata').classList.remove('hidden');
        }

        function closeTambahModalStrata() {
            document.getElementById('tambahModalStrata').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA DAFTAR STRATA--}}
    <script>
        function openEditModalStrata(id, nm_strata, jurusan) {
            document.getElementById('edit_id_strata').value = id;
            document.getElementById('edit_nm_strata').value = nm_strata;
            document.getElementById('edit_jurusan').value = jurusan;
            
            // 1. Ambil URL rute Laravel yang benar menggunakan helper route()
            const updateUrl = "{{ route('backend.strata.update', ':id') }}";
            
            // 2. Ganti placeholder ':id' dengan ID yang dikirim
            document.getElementById('editFormStrata').action = updateUrl.replace(':id', id);
            
            document.getElementById('editModalStrata').classList.remove('hidden');
        }

        function closeEditModalStrata() {
            document.getElementById('editModalStrata').classList.add('hidden');
        }
    </script>

@endsection