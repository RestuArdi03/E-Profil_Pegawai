@extends('main.layout')

@section('content')
    <h1 class="text-xl">Riwayat Kenaikan Gaji Bulanan</h1>
    <!-- Profil Pegawai yang login -->
    <div class="bg-white shadow rounded-xl p-6 mb-6">
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
    
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 50px;">No</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pejabat Penetap</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal TMT</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jumlah Gaji</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($riwayat_kgb as $kgb)
                            <tr>
                                <td class="border px-6 py-3 text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-gray-800">{{ $kgb->pejabat_penetap }}</td>
                                <td class="border px-6 py-3 text-gray-800">{{ $kgb->no_sk }}</td>
                                <td class="border px-6 py-3 text-gray-800">{{ $kgb->tgl_sk }}</td>
                                <td class="border px-6 py-3 text-gray-800">{{ $kgb->tgl_tmt }}</td>
                                <td class="border px-6 py-3 text-gray-800">Rp {{ number_format($kgb->jml_gaji, 2, ',', '.') }}</td>
                                <td class="border px-6 py-3 text-gray-800">{{ $kgb->ket ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada data Riwayat KGB.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection