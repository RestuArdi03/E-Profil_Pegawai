@extends('main.layout2')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Profil Pegawai</h1>

    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 50px;">No</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama Pegawai</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">NIP</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pegawai as $item)
                            <tr>
                                <td class="border px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-4 text-sm text-gray-800">{{ $item->nama }}</td>
                                <td class="border px-6 py-4 text-sm text-gray-800">{{ $item->nip }}</td>
                                <td class="border px-6 py-4 text-sm text-gray-800 space-x-2">
                                    <a href="{{ route('backend.pegawai.edit', $item->id) }}"
                                       class="inline-block px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('backend.pegawai.destroy', $item->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection