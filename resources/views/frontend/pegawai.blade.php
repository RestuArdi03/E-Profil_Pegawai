@extends('main.layout')
@section('content')
    <h1 class="text-xl">Profil Pegawai</h1>
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
                    NIP: {{ $pegawai->nip ?? '1234567890' }}
                </p>
                <p class="text-gray-600 text-sm">
                    Jabatan: {{ $jabatanTerbaru ?? 'Staff' }}
                </p>
            </div>
        </div>
    </div>
    
    @if($pegawai)
        <div class="p-1">
            <div class="overflow-x-auto ">
                <table class="min-w-full divide-y divide-gray-200 border border-collapse">
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800" style="width: 300px;">
                                Nama
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                NIP
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->nip }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                No Kartu Keluarga
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->no_kk }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Tempat Lahir
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->tpt_lahir }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Tanggal Lahir
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->tgl_lahir }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                No Karpeg
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->no_karpeg }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Agama
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->agama }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Golongan Darah
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->golongan_darah ?? '-'}}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Status Perkawinan
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->status_kawin }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Tanggal Perkawinan
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->tgl_kawin ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                No Karis/Karsu
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->no_karis_karsu }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Alamat Rumah
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->almt_rumah }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Tamat Pensiun
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->tmt_pensiun }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Instansi
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ $pegawai->instansi->nm_instansi }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Unit Kerja
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                 {{ optional($pegawai->instansi->latestUnitKerja)->nm_unit_kerja ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm font-medium text-default-800">
                                Satuan Kerja
                            </td>
                            <td class="border border-gray-200 px-6 py-3 whitespace-nowrap text-sm text-default-800">
                                {{ optional(optional($pegawai->instansi->latestUnitKerja)->latestSatuanKerja)->nm_satuan_kerja ?? '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>Data pegawai belum ada untuk akun ini.</p>
    @endif
@endsection