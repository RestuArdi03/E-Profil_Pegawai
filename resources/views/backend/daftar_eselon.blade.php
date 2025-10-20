@extends('main.layout2')@section('content')
    <h1 class="text-xl font-semibold mb-4">Daftar Eselon
        <button type="button"
        onclick="openTambahModalEselon()"
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
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Eselon</th>
                                <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 250px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($eselon as $esln)
                                <tr>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="border px-6 py-3 text-sm text-gray-800">{{ $esln->nm_eselon }}</td>
                                    <td class="border text-sm px-6 py-3 text-gray-800 text-center align-middle">
                                        <div class="flex flex-nowrap items-center gap-2 overflow-auto justify-center">
                                            {{-- Tombol Edit --}}
                                            <button type="button"
                                                onclick="openEditModalEselon(
                                                    {{ $esln->id }},
                                                    '{{ addslashes(e($esln->nm_eselon)) }}'
                                                )"
                                                class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600 flex flex-nowrap items-center gap-2 overflow-auto">
                                                <span class="material-icons" style="margin-right: 3px; margin-left: -3px; font-size: 12px;">edit</span>
                                                Edit
                                            </button>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('backend.eselon.destroy', $esln->id) }}" method="POST" class="inline-block"
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
                                    <td colspan="3" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                        Belum ada data Nama Eselon.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- MODAL TAMBAH DATA DAFTAR ESELON --}}
                    <div id="tambahModalEselon" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-green-300 outline outline-green-600 outline-offset-4" style="max-width: 800px; max-height: 800px;">
                            <div class="p-6">
                                <h2 class="text-base font-semibold">Tambah Eselon</h2>
                            </div>

                            <div class="form_edit p-6 overflow-y-auto">
                                <form id="tambahFormEselon" method="POST" action="{{ route('backend.eselon.store') }}">
                                    @csrf

                                    <input type="hidden" name="id" id="tambah_id_eselon">
                                    <input type="hidden" name="mode" value="tambah">

                                    <div class="mb-3">
                                        <label for="tambah_nm_eselon" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Eselon</label>
                                        <input type="text" name="nm_eselon" id="tambah_nm_eselon" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_eselon') }}">
                                        @error('nm_eselon')
                                            <div class="text-red-600 text-sm mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </form>
                            </div>
                            <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                <button type="button" onclick="closeTambahModalEselon()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                <button type="submit" form="tambahFormEselon" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                    {{-- MEMUNCULKAN KEMBALI MODAL TAMBAH DATA DAFTAR ESELON JIKA ADA ERROR--}}
                    @if ($errors->any() && old('mode') === 'tambah')
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('tambahModalEselon').classList.remove('hidden');
                            });
                        </script>
                    @endif

                    {{-- MODUL EDIT DATA DAFTAR ESELON --}}
                    @if(isset($esln))
                        <div id="editModalEselon" class="fixed inset-0 z-50 p-4 hidden flex justify-center items-center bg-black/50">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl border border-blue-300 outline outline-blue-600 outline-offset-4"
                            style="max-width: 800px; max-height: 800px;">
                                <div class="p-6">
                                    <h2 class="text-base font-semibold">Edit Eselon</h2>
                                </div>

                                <div class="form_edit p-6 overflow-y-auto">
                                    <form id="editFormEselon" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="id" id="edit_id_eselon">
                                        <input type="hidden" name="mode" value="edit">

                                        <div class="mb-3">
                                            <label for="edit_nm_eselon" class="block text-sm font-medium text-gray-700" style="margin-top: -25px;">Nama Eselon</label>
                                            <input type="text" name="nm_eselon" id="edit_nm_eselon" class="mt-1 block w-full border border-gray-300 rounded-md text-sm" required value="{{ old('nm_eselon', $esln->nm_eselon) }}">
                                            @error('nm_eselon')
                                                <div class="text-red-600 text-sm mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </form>
                                </div>
                                <div class="flex justify-end gap-2 p-6" style="margin-top: -25px">
                                    <button type="button" onclick="closeEditModalEselon()" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Batal</button>
                                    <button type="submit" form="editFormEselon" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                                </div>
                            </div>
                        </div>

                        {{-- MEMUNCULKAN KEMBALI MODAL EDIT DATA DAFTAR ESELON JIKA ADA ERROR --}}
                        @if ($errors->any() && old('mode') === 'edit')
                            <script>
                                window.addEventListener('DOMContentLoaded', () => {
                                    document.getElementById('editModalEselon').classList.remove('hidden');
                                });
                            </script>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL TAMBAH DATA DAFTAR ESELON--}}
    <script>
        console.log(document.getElementById('tambahFormEselon').action);
        function openTambahModalEselon() {
        document.getElementById('tambahModalEselon').classList.remove('hidden');
        }

        function closeTambahModalEselon() {
            document.getElementById('tambahModalEselon').classList.add('hidden');
        }
    </script>

    {{-- JAVASCRIPT UNTUK MODAL EDIT DATA DAFTAR ESELON--}}
    <script>
        function openEditModalEselon(id, nm_eselon) {
            document.getElementById('edit_id_eselon').value = id;
            document.getElementById('edit_nm_eselon').value = nm_eselon;
            
            // 1. Ambil URL rute Laravel yang benar menggunakan helper route()
            const updateUrl = "{{ route('backend.eselon.update', ':id') }}";
            
            // 2. Ganti placeholder ':id' dengan ID yang dikirim
            document.getElementById('editFormEselon').action = updateUrl.replace(':id', id);
            
            document.getElementById('editModalEselon').classList.remove('hidden');
        }

        function closeEditModalEselon() {
            document.getElementById('editModalEselon').classList.add('hidden');
        }
    </script>

@endsection