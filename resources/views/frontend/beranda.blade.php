@extends('main.layout')

@section('content')
<div class="py-4">
    <h1 class="text-2xl font-bold text-gray-800">Selamat Datang di E-Profile Pegawai</h1>

    <!-- Profil Pegawai yang login -->
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Profil Anda</h2>
        <div class="flex items-center gap-6">

        @php
            $pegawai = Auth::user()->pegawai;
            $jabatanTerbaru = $pegawai?->riwayatJabatan?->sortByDesc('created_at')->first()?->jabatan;

            $fotoPath = 'foto_pegawai/' . ($pegawai->foto ?? '');
            $fotoUrl = file_exists(public_path($fotoPath)) && $pegawai->foto
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
            </div>
        </div>
    </div>

    <!-- Statistik Data -->
    <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-blue-100">
                <div class=" text-blue-800">
                    <h3 class="text-lg font-semibold">Data Riwayat Pendidikan</h3>
                    <p class="text-2xl font-bold mt-2">{{ $pendidikanCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-green-100">
                <div class=" text-green-800">
                    <h3 class="text-lg font-semibold">Data Riwayat Jabatan</h3>
                    <p class="text-2xl font-bold mt-2">{{ $jabatanCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-yellow-100">
                <div class=" text-yellow-800">
                    <h3 class="text-lg font-semibold">Data Riwayat PLH/PLT</h3>
                    <p class="text-2xl font-bold mt-2">{{ $plhpltCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-yellow-100">
                <div class=" text-yelloq-800">
                    <h3 class="text-lg font-semibold">Data Riwayat Golongan</h3>
                    <p class="text-2xl font-bold mt-2">{{ $golonganCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-blue-100">
                <div class=" text-blue-800">
                    <h3 class="text-lg font-semibold">Data Riwayat Diklat</h3>
                    <p class="text-2xl font-bold mt-2">{{ $diklatCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-green-100">
                <div class=" text-green-800">
                    <h3 class="text-lg font-semibold">Data Riwayat Gaji</h3>
                    <p class="text-2xl font-bold mt-2">{{ $gajiCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-green-100">
                <div class=" text-green-800">
                    <h3 class="text-lg font-semibold">Data Riwayat KGB</h3>
                    <p class="text-2xl font-bold mt-2">{{ $kgbCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-yellow-100">
                <div class=" text-yellow-800">
                    <h3 class="text-lg font-semibold">Data Riwayat Penghargaan</h3>
                    <p class="text-2xl font-bold mt-2">{{ $penghargaanCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-blue-100">
                <div class=" text-blue-800">
                    <h3 class="text-lg font-semibold">Data Riwayat SLKS</h3>
                    <p class="text-2xl font-bold mt-2">{{ $slksCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-blue-100">
                <div class=" text-blue-800">
                    <h3 class="text-lg font-semibold">Data Riwayat Organisasi</h3>
                    <p class="text-2xl font-bold mt-2">{{ $organisasiCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-green-100">
                <div class=" text-green-800">
                    <h3 class="text-lg font-semibold">Data Jumlah Prestasi Kerja</h3>
                    <p class="text-2xl font-bold mt-2">{{ $prestasiCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-yellow-100">
                <div class=" text-yellow-800">
                    <h3 class="text-lg font-semibold">Data Riwayat Asesmen</h3>
                    <p class="text-2xl font-bold mt-2">{{ $asesmenCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-yellow-100">
                <div class=" text-yellow-800">
                    <h3 class="text-lg font-semibold">Data Riwayat Kesejahteraan</h3>
                    <p class="text-2xl font-bold mt-2">{{ $kesejahteraanCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-blue-100">
                <div class=" text-blue-800">
                    <h3 class="text-lg font-semibold">Data Jumlah Keluarga</h3>
                    <p class="text-2xl font-bold mt-2">{{ $keluargaCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body bg-green-100">
                <div class="text-green-800">
                    <h3 class="text-lg font-semibold">Data Jumlah Dokumen</h3>
                    <p class="text-2xl font-bold mt-2">{{ $dokumenCount ?? 0 }}</p>
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
                    <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nama</th>
                    <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($latestUpdates as $index => $update)
                    <tr>
                        <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                        <td class="border px-6 py-3 text-sm text-gray-800">{{ $update['nama'] }}</td>
                        <td class="border px-6 py-3 text-sm text-gray-800">{{ \Carbon\Carbon::parse($update['created_at'])->format('d M Y H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border py-3 text-center text-gray-800">
                            Belum ada aktivitas terbaru
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
