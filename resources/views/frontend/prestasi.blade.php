@extends('main.layout')
@section('content')
    <h1 class="text-xl">Nilai Prestasi Kerja</h1>
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
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tahun</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">SKP</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nilai Prestasi Kerja</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Nilai Perilaku kerja</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Klasifikasi Nilai</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pejabat Penetap</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($nilai_prestasi_kerja as $nilai)
                            <tr>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $nilai->tahun }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ number_format($nilai->skp, 2) }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ number_format($nilai->nilai_prestasi_kerja, 2) }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ number_format($nilai->nilai_perilaku_kerja, 2) }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $nilai->klasifikasi_nilai }}</td>
                                <td class="border px-6 py-3 text-sm text-gray-800">{{ $nilai->pejabat_penilai }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada data Riwayat Nilai Prestasi Kerja.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
@endsection