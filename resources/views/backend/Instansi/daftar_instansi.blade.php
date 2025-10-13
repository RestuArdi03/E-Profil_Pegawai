@extends('main.layout2')@section('content')<h1 class="text-xl font-semibold mb-4">Instansi</h1>

{{-- PEMBERITAHUAN (FLASH MESSAGES) --}}
@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
        <p class="font-bold">Berhasil!</p>
        <p>{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
        <p class="font-bold">Error!</p>
        <p>{{ session('error') }}</p>
    </div>
@endif

{{-- TOMBOL TAMBAH DATA & FORM PENCARIAN --}}
<div class="mb-4 flex justify-between items-center">
    {{-- Form Pencarian (Hanya Query String) --}}
    <form action="{{ route('backend.daftar_instansi') }}" method="GET" class="w-full max-w-[400px]">
        <div class="relative">
            <input type="text" name="search" placeholder="Cari Kode atau Nama Instansi..." 
                   value="{{ request('search') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
            <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400 hover:text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </div>
    </form>

    {{-- Tombol Tambah Data --}}
    <a href="{{ route('backend.instansi.create') }}"
       class="inline-flex items-center px-5 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105 ml-4">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Instansi Baru
    </a>
</div>

{{-- PAGINATION LINKS --}}
<div class="mb-4">
    {{ $instansi->links() }}
</div>

{{-- TABEL DATA INSTANSI --}}
<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-blue-600">
            <tr>
                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider" style="width: 50px;">
                    NO
                </th>
                {{-- HEADER ID BARU --}}
                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider" style="width: 50px;">
                    ID
                </th>
                {{-- HEADER KODE INSTANSI --}}
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider" style="width: 100px;"> 
                    KODE INSTANSI
                </th>
                {{-- HEADER KODE --}}
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider" style="width: 80px;"> 
                    KODE
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider" style="width: 250px;">
                    NAMA INSTANSI
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider" style="width: 200px;"> 
                    ALAMAT
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider" style="width: 140px;"> 
                    TELP / FAX
                </th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider" style="width: 50px;">
                    URUT
                </th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider" style="width: 150px;">
                    AKSI
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($instansi as $item)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 text-sm text-center text-gray-900 font-medium">
                        {{ $instansi->firstItem() + $loop->index }}
                    </td>
                    
                    {{-- DATA ID BARU --}}
                    <td class="px-6 py-4 text-sm text-center text-gray-900 font-medium">
                        {{ $item->id }}
                    </td>
                    
                    {{-- DATA KODE INSTANSI --}}
                    <td class="px-6 py-4 text-sm text-gray-800 text-center">
                        {{ $item->kd_instansi ?? '-' }} 
                    </td>
                    {{-- DATA KODE --}}
                    <td class="px-6 py-4 text-sm text-gray-800 text-center">
                        {{ $item->kode ?? '-' }} 
                    </td>
                    
                    {{-- DATA NAMA INSTANSI --}}
                    <td class="px-6 py-4 text-sm text-gray-800 whitespace-normal">
                        {{ $item->nm_instansi ?? 'N/A' }}
                    </td>
                    
                    {{-- DATA ALAMAT (Logic sederhana) --}}
                    <td class="px-6 py-4 text-sm text-gray-800 whitespace-normal"> 
                        {{ $item->alamat_instansi ?? '-' }}
                    </td>
                    
                    {{-- DATA TELP / FAX (Logic sederhana) --}}
                    <td class="px-6 py-4 text-sm text-gray-800 leading-tight whitespace-normal">
                        T: {{ $item->telp_instansi ?? '-' }}<br>
                        F: {{ $item->fax_instansi ?? '-' }}
                    </td>
                    
                    {{-- DATA URUT --}}
                    <td class="px-6 py-4 text-sm text-center text-gray-800 font-medium">
                        {{ $item->urutan_instansi ?? '-' }}
                    </td>
                    
                    {{-- DATA AKSI --}}
                    <td class="px-6 py-4 text-sm text-center space-x-2">
                        <a href="{{ route('backend.instansi.edit', $item->id) }}"
                           class="inline-block px-3 py-1 text-xs font-semibold text-white bg-yellow-500 rounded hover:bg-yellow-600 transition duration-150 transform hover:scale-105 shadow">
                            Edit
                        </a>
                         <form action="{{ route('backend.instansi.destroy', $item->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Apakah Anda YAKIN ingin menghapus data instansi {{ $item->nm_instansi ?? 'ini' }}? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded hover:bg-red-700 transition duration-150 transform hover:scale-105 shadow">
                                Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="px-6 py-8 text-center text-gray-500 italic">
                    Belum ada data Instansi yang tercatat. Silakan tambahkan data baru!
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>{{-- PAGINATION LINKS --}}<div class="mt-4">{{ $instansi->links() }}</div>@endsection