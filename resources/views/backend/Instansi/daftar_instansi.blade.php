@extends('main.layout2')

@section('content')

    <h1 class="text-xl font-semibold mb-4">Instansi</h1>

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

    <div class="mb-6 flex justify-end">
        <a href="{{ route('backend.instansi.create') }}"
           class="inline-flex items-center px-5 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Instansi Baru
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-600">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider" style="width: 50px;">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider" style="width: 150px;">
                        Kode
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                        Nama Instansi
                    </th>
                    {{-- START: KOLOM BARU DITAMBAHKAN --}}
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                        Alamat
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider" style="width: 130px;">
                        Telp / Fax
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider" style="width: 50px;">
                        Urut
                    </th>
                    {{-- END: KOLOM BARU DITAMBAHKAN --}}
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider" style="width: 180px;">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($instansi as $item)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 text-sm text-center text-gray-900 font-medium">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 text-center">
                            {{-- INI PERBAIKAN: Memanggil kd_instansi yang sudah diset di form --}}
                            {{ $item->kd_instansi }} 
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            {{ $item->nm_instansi ?? $item->nama_instansi ?? 'N/A' }}
                        </td>
                        {{-- START: DATA BARU DITAMPILKAN --}}
                        <td class="px-6 py-4 text-sm text-gray-800">
                            {{ \Illuminate\Support\Str::limit($item->alamat_instansi, 50, '...') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 leading-tight">
                            T: {{ $item->telp_instansi ?? '-' }}<br>
                            F: {{ $item->fax_instansi ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center text-gray-800 font-medium">
                            {{ $item->urutan_instansi }}
                        </td>
                        {{-- END: DATA BARU DITAMPILKAN --}}
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
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 italic">
                            Belum ada data Instansi yang tercatat. Silakan tambahkan data baru!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection