@extends('main.layout2')
@section('content')
    <h1 class="text-xl">Riwayat Jabatan</h1>
    <!-- Profil Pegawai -->
    <div class="mb-6">
        @php
            $jabatanTerbaru = $pegawai->riwayatJabatan?->sortByDesc('created_at')->first()?->jabatan;

            $fotoPath = 'foto_pegawai/' . ($pegawai->foto ?? '');
            $fotoUrl = file_exists(public_path($fotoPath)) && $pegawai->foto
                ? asset($fotoPath)
                : asset('assets/images/users/default.png');
        @endphp

        <div class="bg-white shadow rounded-xl p-6 mb-6">
            <div class="flex items-center gap-6">
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
                        Jabatan: {{ $jabatanTerbaru ?? 'Staff' }}
                    </p>
                </div>
            </div>
        </div>        
    </div>

    <!-- Flash Notification / Pemberitahuan -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-4 right-4 z-[999] bg-red-500 text-white px-4 py-2 rounded shadow text-sm">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100" style="width: 50px;">No</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jabatan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Eselon</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jenis Jabatan</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">TMT</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">No SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Tanggal SK</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Pejabat Penetap</th>
                            <th class="border border-gray-200 px-6 py-3 text-sm text-default-100">Jenis Mutasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat_jabatan as $rj)
                            <tr class="odd:bg-white even:bg-gray-100">
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->jabatan ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->eselon->nm_eselon ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->jenis_jabatan->jenis_jabatan ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->tmt ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->no_sk ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ \Carbon\Carbon::parse($rj->tgl_sk)->format('d-m-Y') ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->pejabat_penetap ?? '-' }}
                                </td>
                                <td class="border border-gray px-6 py-3 text-sm text-gray-800">
                                    {{ $rj->jenis_mutasi ?? '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center border border-gray px-6 py-3 text-sm text-default-800">
                                    Belum ada data Riwayat Jabatan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
