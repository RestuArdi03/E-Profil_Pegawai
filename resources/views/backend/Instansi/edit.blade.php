@extends('main.layout2')

@section('content')
    <!-- JUDUL HALAMAN -->
    <h1 class="text-xl font-semibold mb-4">Edit Data Instansi</h1>

    <!-- FORM EDIT INSTANSI -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        
        <!-- Pesan Error Validasi -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <strong class="font-bold">Oops! Ada masalah saat menyimpan data:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('backend.instansi.update', $instansi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Field Nama Instansi -->
            <div class="mb-4">
                <label for="nm_instansi" class="block text-sm font-medium text-gray-700 mb-1">Nama Instansi</label>
                <input type="text" 
                       id="nm_instansi" 
                       name="nm_instansi" 
                       value="{{ old('nm_instansi', $instansi->nm_instansi) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 @error('nm_instansi') border-red-500 @enderror"
                       required>
                @error('nm_instansi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Field Kode Instansi -->
            <div class="mb-6">
                <label for="kd_instansi" class="block text-sm font-medium text-gray-700 mb-1">Kode Instansi</label>
                <input type="text" 
                       id="kd_instansi" 
                       name="kd_instansi" 
                       value="{{ old('kd_instansi', $instansi->kd_instansi) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 @error('kd_instansi') border-red-500 @enderror"
                       required>
                @error('kd_instansi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit"
                        class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md">
                    Simpan Perubahan
                </button>
                <a href="{{ route('backend.daftar_instansi') }}"
                   class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 shadow-md">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection