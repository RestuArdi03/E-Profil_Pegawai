@extends('main.layout2')

@section('content')
<div class="py-4">
    <h1 class="text-2xl font-bold text-gray-800">Selamat Datang di Halaman Backend E-Profile Pegawai</h1>

    <!-- Profil Pegawai yang login -->
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Profil Anda</h2>
        <div class="flex items-center gap-6">

        @php
            $user = Auth::user();
            // Gunakan Safe Operator saat mengambil relasi pegawai, karena bisa null
            $pegawai = $user->pegawai; 

            // Jabatan sudah benar (menggunakan ?->)
            $jabatanTerbaru = $pegawai?->riwayatJabatan?->sortByDesc('created_at')->first()?->jabatan;

            // 1. Ambil nama file foto dengan Safe Operator. Jika $pegawai null, kembalikan string kosong.
            $fotoFilename = $pegawai?->foto ?? '';
            
            $fotoPath = 'foto_pegawai/' . $fotoFilename;

            // 2. Perbaiki logika $fotoUrl dengan pengecekan ganda yang aman
            // Pengecekan harus memastikan $pegawai TIDAK NULL sebelum mencoba mengakses $pegawai->foto
            $fotoUrl = (
                $pegawai && // Pastikan $pegawai adalah objek
                $fotoFilename && // Pastikan nama file ada
                file_exists(public_path($fotoPath))
            )
                ? asset($fotoPath)
                : asset('assets/images/users/default.png');
        @endphp

        <img src="{{ $fotoUrl }}"
            alt="Foto Pegawai"
            class="w-24 h-24 object-cover rounded-full border border-gray-300 shadow-sm"
            style="aspect-ratio: 1 / 1; max-width: 100px;">

            <div>
                <p class="text-gray-800 font-medium text-lg">
                    {{ $pegawai->nama ?? 'Nama Pegawai' }}
                </p>
                <p class="text-gray-600 text-sm">
                    NIP: {{ $pegawai->nip ?? '-' }}
                </p>
                <p class="text-gray-600 text-sm">
                    Jabatan: {{ $jabatanTerbaru ?? '-' }}
                </p>
                <p class="text-gray-600 text-sm">
                    Role: 
                    {{-- Memeriksa apakah variabel $user ada dan memiliki properti role --}}
                    @if (isset($user) && $user->role !== null)
                        @if ($user->role == 0)
                            Pegawai
                        @elseif ($user->role == 1)
                            Admin
                        @else
                            {{-- Jika role memiliki nilai lain (2, 3, 4, dst.) --}}
                            Role {{ $user->role }}
                        @endif
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Statistik Data -->
    <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-blue-100">
                <div class=" text-blue-800">
                    <h3 class="text-lg font-semibold">Jumlah Data Pegawai</h3>
                    <p class="text-2xl font-bold mt-2">{{ $pegawaiCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-green-100">
                <div class=" text-green-800">
                    <h3 class="text-lg font-semibold">Jumlah Data Instansi</h3>
                    <p class="text-2xl font-bold mt-2">{{ $instansiCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-yellow-100">
                <div class=" text-yellow-800">
                    <h3 class="text-lg font-semibold">Jumlah Data Unit Kerja</h3>
                    <p class="text-2xl font-bold mt-2">{{ $unit_kerjaCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-yellow-100">
                <div class=" text-yelloq-800">
                    <h3 class="text-lg font-semibold">Jumlah Data Satuan Kerja</h3>
                    <p class="text-2xl font-bold mt-2">{{ $satuan_kerjaCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-blue-100">
                <div class=" text-blue-800">
                    <h3 class="text-lg font-semibold">Jumlah Data Jabatan</h3>
                    <p class="text-2xl font-bold mt-2">{{ $jenis_jabatanCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-green-100">
                <div class=" text-green-800">
                    <h3 class="text-lg font-semibold">Jumlah Data Eselon</h3>
                    <p class="text-2xl font-bold mt-2">{{ $eselonCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-green-100">
                <div class=" text-green-800">
                    <h3 class="text-lg font-semibold">Jumlah Data User</h3>
                    <p class="text-2xl font-bold mt-2">{{ $usersCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-yellow-100">
                <div class=" text-yellow-800">
                    <h3 class="text-lg font-semibold">Jumlah Data Golongan</h3>
                    <p class="text-2xl font-bold mt-2">{{ $golonganCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-blue-100">
                <div class=" text-blue-800">
                    <h3 class="text-lg font-semibold">Jumlah Data Strata</h3>
                    <p class="text-2xl font-bold mt-2">{{ $strataCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-blue-100">
                <div class=" text-blue-800">
                    <h3 class="text-lg font-semibold">Jumlah Data Agama</h3>
                    <p class="text-2xl font-bold mt-2">{{ $agamaCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Ringkas Dokumen -->
    <h2 class="text-lg font-semibold text-gray-700 mb-4" style="margin-top: 50px">Update Data Terbaru</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 50px;">No</th>
                    <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tabel</th>
                    <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Data Update</th>
                    <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tipe Update</th>
                    <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($latestUpdates as $index => $update)
                    <tr>
                        <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                        <td class="border px-6 py-3 text-sm text-gray-800">{{ $update['kategori'] }}</td>
                        <td class="border px-6 py-3 text-sm text-gray-800">{{ $update['data_update'] }}</td>
                        <td class="border px-6 py-3 text-sm text-gray-800">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($update['tipe_update'] === 'Tambah Data') bg-green-100 text-green-800
                                @elseif($update['tipe_update'] === 'Edit Data') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $update['tipe_update'] }}
                            </span>
                        </td>
                        <td class="border px-6 py-3 text-sm text-gray-800">{{ \Carbon\Carbon::parse($update['created_at'])->format('d M Y H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border py-3 text-center text-gray-800">
                            Belum ada aktivitas terbaru
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
