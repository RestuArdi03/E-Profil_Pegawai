@extends('main.layout2')

@section('content')
    <h1 class="text-xl font-semibold mb-6">Tambah Instansi Baru</h1>

    <!-- Tampilkan Notifikasi Error Validasi -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Gagal menyimpan data!</strong>
            <span class="block sm:inline"> Mohon periksa kembali input Anda.</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- Kartu Form -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-default-200">
        <!-- Form akan POST ke rute 'backend.instansi.store' -->
        <form action="{{ route('backend.instansi.store') }}" method="POST">
            @csrf
            
            <!-- Tombol Kembali -->
            <a href="{{ route('backend.daftar_instansi') }}" class="inline-block mb-4 px-4 py-2 text-sm text-default-700 border border-default-300 bg-default-100 rounded-lg hover:bg-default-200 transition-all">
                <i class="material-icons text-base align-middle me-1">arrow_back</i> Kembali ke Daftar
            </a>

            <!-- Field Nama Instansi -->
            <div class="mb-4">
                <label for="nm_instansi" class="block text-sm font-medium text-gray-700 mb-1">Nama Instansi</label>
                <input type="text" 
                       id="nm_instansi" 
                       name="nm_instansi" 
                       value="{{ old('nm_instansi') }}" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                       placeholder="Masukkan nama instansi lengkap" 
                       required>
            </div>

            <!-- Field Kode Instansi -->
            <div class="mb-6">
                <label for="kd_instansi" class="block text-sm font-medium text-gray-700 mb-1">Kode Instansi</label>
                <input type="text" 
                       id="kd_instansi" 
                       name="kd_instansi" 
                       value="{{ old('kd_instansi') }}" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                       placeholder="Masukkan kode unik instansi (maks. 50 karakter)" 
                       required>
            </div>

            </div>
            
            <div class="mb-4">
                <label for="alamat_instansi" class="block text-sm font-medium text-gray-700 mb-1">Alamat Instansi</label>
                <textarea id="alamat_instansi" 
                          name="alamat_instansi" 
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                          placeholder="Masukkan alamat lengkap instansi">{{ old('alamat_instansi') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="telp_instansi" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" 
                        id="telp_instansi" 
                        name="telp_instansi" 
                        value="{{ old('telp_instansi') }}" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        placeholder="Cth: (021) 1234567">
            </div>

            <div class="mb-4">
                <label for="fax_instansi" class="block text-sm font-medium text-gray-700 mb-1">Nomor Fax</label>
                <input type="text" 
                        id="fax_instansi" 
                        name="fax_instansi" 
                        value="{{ old('fax_instansi') }}" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        placeholder="Cth: (021) 7654321">
            </div>

            <div class="mb-6">
                <label for="urutan_instansi" class="block text-sm font-medium text-gray-700 mb-1">Urutan Instansi</label>
                <input type="number" 
                        id="urutan_instansi" 
                        name="urutan_instansi" 
                        value="{{ old('urutan_instansi', 99) }}" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        placeholder="Masukkan angka urutan tampilan (misal: 1)">
            </div>
            
            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-block px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-lg transition-all">
                    Simpan Data Instansi
                </button>
            </div>
        </form>
    </div>
@endsection
