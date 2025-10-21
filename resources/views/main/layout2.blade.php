<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E-Profil Pegawai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Tailwind Admin Dashboard, A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta name="description" content="Download a Tailwind admin template, designed to create responsive and customizable admin dashboards quickly and efficiently. Ideal for developers and startups. ">
    <meta name="description" content="Explore a Tailwind admin dashboard template that offers sleek, responsive designs and easy customization, perfect for managing admin interfaces with modern UI components.">
    <meta name="description" content="Explore a Tailwind admin dashboard template with sleek, responsive designs and easy customization. Perfect for managing modern admin interfaces with top-notch UI components.">
    <meta content="MyraStudio" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo_komdigi.png') }}">

    <!-- Jsvectormap plugin css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">

    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Ikon Google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


</head>

<body>

    <div class="wrapper">
        <!-- Start Sidebar -->
        <aside id="app-menu"
            class="hs-overlay fixed inset-y-0 start-0 z-60 hidden w-sidenav min-w-sidenav -translate-x-full transform overflow-y-auto bg-body transition-all duration-300 hs-overlay-open:translate-x-0 lg:bottom-0 lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full rtl:hs-overlay-open:translate-x-0 rtl:lg:translate-x-0 print:hidden [--body-scroll:true] [--overlay-backdrop:true] lg:[--overlay-backdrop:false]">
            <div class="sticky top-0 flex h-16 items-center justify-center px-6">
                <a href="{{ route('backend.beranda') }}">
                    <img src="{{ asset('assets/images/Simasneg2.png') }}" alt="logo" class="flex h-10">
                </a>
            </div>
          
             <div class="h-[calc(100%-64px)] p-4 lg:ps-8" data-simplebar>
                <ul class="admin-menu hs-accordion-group flex w-full flex-col gap-1.5">
                    <li class="menu-item">
                        <a class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.beranda') }}">
                            <i class="material-icons">dashboard</i>
                            Beranda
                        </a>
                    </li>
                    
                    <li class="menu-item hs-accordion  {{ request()->routeIs('backend.pegawai.show') || request()->routeIs('backend.pendidikan.show') || request()->routeIs('backend.jabatan.show') || request()->routeIs('backend.plh_plt.show') || request()->routeIs('backend.golongan.show') || request()->routeIs('backend.golongan.show') || request()->routeIs('backend.diklat.show') || request()->routeIs('backend.gaji.show') ||request()->routeIs('backend.kgb.show') || request()->routeIs('backend.penghargaan.show') || request()->routeIs('backend.slks.show') || request()->routeIs('backend.organisasi.show') || request()->routeIs('backend.prestasiKerja.show') || request()->routeIs('backend.asesmen.show') || request()->routeIs('backend.kesejahteraan.show') || request()->routeIs('backend.keluarga.show') || request()->routeIs('backend.dokumen.show')  ? 'hs-accordion-active' : '' }}">
                        <a class=" hgroup flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.daftar_pegawai') }}"
                        class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all 
                                {{ request()->routeIs('backend.pegawai.show') || request()->routeIs('backend.pendidikan.show') || request()->routeIs('backend.jabatan.show') || request()->routeIs('backend.plh_plt.show') || request()->routeIs('backend.golongan.show') || request()->routeIs('backend.golongan.show') || request()->routeIs('backend.diklat.show') || request()->routeIs('backend.gaji.show') ||request()->routeIs('backend.kgb.show') || request()->routeIs('backend.penghargaan.show') || request()->routeIs('backend.slks.show') || request()->routeIs('backend.organisasi.show') || request()->routeIs('backend.prestasiKerja.show') || request()->routeIs('backend.asesmen.show') || request()->routeIs('backend.kesejahteraan.show') || request()->routeIs('backend.keluarga.show') || request()->routeIs('backend.dokumen.show') ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                            <i class="material-icons">group</i>
                            <span class="menu-text">Daftar Pegawai</span>
                        </a>

                        {{-- Dropdown: hanya muncul saat route detail aktif --}}
                        <div class="hs-accordion-content {{ request()->routeIs('backend.pegawai.show') || request()->routeIs('backend.pendidikan.show') || request()->routeIs('backend.jabatan.show') || request()->routeIs('backend.plh_plt.show') || request()->routeIs('backend.golongan.show') || request()->routeIs('backend.golongan.show') || request()->routeIs('backend.diklat.show') || request()->routeIs('backend.gaji.show') ||request()->routeIs('backend.kgb.show') || request()->routeIs('backend.penghargaan.show') || request()->routeIs('backend.slks.show') || request()->routeIs('backend.organisasi.show') || request()->routeIs('backend.prestasiKerja.show') || request()->routeIs('backend.asesmen.show') || request()->routeIs('backend.kesejahteraan.show') || request()->routeIs('backend.keluarga.show') || request()->routeIs('backend.dokumen.show') ? '' : 'hidden' }} w-full overflow-hidden transition-[height] duration-300">
                            <ul class="mt-2 space-y-2">
                                <li class="menu-item">
                                    <a href="{{ route('backend.pegawai.show', session('pegawai_id') ?? 1) }}"
                                    class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5">
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Profil Pegawai
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.pendidikan.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat Pendidikan
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.jabatan.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat Jabatan
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.plh_plt.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat PLH/PLT
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.golongan.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat Golongan
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.diklat.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat Diklat
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.gaji.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat Gaji
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.kgb.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat KGB
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.penghargaan.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat Penghargaan
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.slks.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat SLKS
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.organisasi.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat Organisasi
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.prestasiKerja.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Nilai Prestasi Kerja
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.asesmen.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat Asesmen
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.kesejahteraan.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Riwayat Kesejahteraan
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.keluarga.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Data Keluarga
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5"
                                    href="{{ route('backend.dokumen.show', session('pegawai_id') ?? 1) }}"
                                    >
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Dokumen
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </li>

                    <li class="menu-item hs-accordion  {{ request()->routeIs('backend.unit_kerja.by_instansi')  ? 'hs-accordion-active' : '' }}">
                        <a class=" hgroup flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.daftar_instansi') }}"
                        class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all 
                                {{ request()->routeIs('backend.unit_kerja.by_instansi') ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                            <i class="material-icons">domain</i>
                            <span class="menu-text">Daftar Instansi</span>
                        </a>

                        {{-- Dropdown: hanya muncul saat route detail aktif --}}
                        <div class="hs-accordion-content {{ request()->routeIs('backend.unit_kerja.by_instansi') || request()->routeIs('backend.satuan_kerja.by_unit_kerja') ? '' : 'hidden' }} w-full overflow-hidden transition-[height] duration-300">
                            <ul class="mt-2 space-y-2">
                                <li class="menu-item">
                                    <a href="{{ route('backend.unit_kerja.by_instansi', session('instansi_id') ?? 1) }}"
                                    class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5">
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Daftar Unit Kerja
                                    </a>
                                </li>
                            </ul>

                            <div class="hs-accordion-content {{ request()->routeIs('backend.unit_kerja.by_instansi') || request()->routeIs('backend.satuan_kerja.by_unit_kerja') ? '' : 'hidden' }} w-full overflow-hidden transition-[height] duration-300">
                                <ul class="mt-2 space-y-2">
                                    <li class="menu-item">
                                        <a href="{{ route('backend.satuan_kerja.by_unit_kerja', session('unit_kerja_id') ?? 1) }}"
                                        class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5">
                                            <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                            Daftar Satuan Kerja
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <li class="menu-item">
                        <a class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.daftar_jabatan') }}">
                            <i class="material-icons">manage_accounts</i>
                            Daftar Jabatan
                        </a>
                    </li>
                    
                    <li class="menu-item">
                        <a class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.daftar_eselon') }}">
                            <i class="material-icons">recent_actors</i>
                            Daftar Eselon
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.daftar_user') }}">
                            <i class="material-icons">account_box</i>
                            Daftar User
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.daftar_golongan') }}">
                            <i class="material-icons">group_work
                            </i>
                            Daftar Golongan
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.daftar_strata') }}">
                            <i class="material-icons">cast_for_education</i>
                            Daftar Strata
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.daftar_agama') }}">
                            <i class="material-icons">mosque</i>
                            Daftar Agama
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                            href="{{ route('backend.daftar_folder') }}">
                            <i class="material-icons">folder</i>
                            Daftar Folder
                        </a>
                    </li>

                    <li class="menu-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full space-y-2 flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5">
                                <span class="material-icons">logout</span>
                                Logout
                            </button>
                        </form>
                    </li>
                    
                </ul>
            </div>
        </aside>
        <!-- End Sidebar -->


        <!-- Mobile Nav Start -->
        <div class="md:hidden flex">
            <div
                class="fixed bottom-0 z-50 shadow-md w-full h-16 flex items-center justify-between px-5 gap-4 bg-white border-b border-default-100">

                <a href="#" class="flex flex-col items-center justify-center gap-1 text-default-600">
                    <i data-lucide="gauge" class="size-5"></i>
                    <span class="text-xs font-semibold">Home</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center gap-1 text-default-600">
                    <i data-lucide="search" class="size-5"></i>
                    <span class="text-xs font-semibold">Search</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center gap-1 text-default-600">
                    <i data-lucide="compass" class="size-5"></i>
                    <span class="text-xs font-semibold">Explore</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center gap-1 text-default-600">
                    <i data-lucide="bell" class="size-5"></i>
                    <span class="text-xs font-semibold">Alerts</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center gap-1 text-default-600">
                    <i data-lucide="circle-user" class="size-5"></i>
                    <span class="text-xs font-semibold">Profile</span>
                </a>
            </div>
        </div>
        <!-- Mobile Nav End -->

        <!-- Start Page Content here -->
        <div class="page-content">

            <!-- Topbar Start -->
            <header class="app-header md:hidden h-16 flex items-center lg:bg-opacity-10 bg-white  backdrop-blur-sm">
                <div class="container flex items-center gap-4">
                    <!-- Topbar Brand Logo -->
                    <a href="{{ route('backend.beranda') }}" class="md:hidden flex">
                        <img src="{{ asset('assets/images/logo_kp.png')}}" class="h-6" alt="Small logo">
                    </a>

                    <!-- Sidenav Menu Toggle Button -->
                    <button id="button-toggle-menu" class="text-default-500 hover:text-default-600 p-2 rounded-full cursor-pointer"
                        data-hs-overlay="#app-menu" aria-label="Toggle navigation">
                        <i class="i-tabler-menu-2 text-2xl"></i>
                    </button>

                    <!-- Language Dropdown Button -->
                    <div class="ms-auto hs-dropdown relative inline-flex [--placement:bottom-right]">
                        <button type="button" class="hs-dropdown-toggle inline-flex items-center">
                            <img src="{{ asset('assets/images/flags/us.jpg')}}" alt="user-image" class="h-4 w-6">
                        </button>

                        <div
                            class="hs-dropdown-menu duration mt-2 min-w-48 rounded-lg border border-default-200 bg-white p-2 opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 hidden">
                            <a href="javascript:void(0);"
                                class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100">
                                <img src="{{ asset('assets/images/flags/germany.jpg')}}" alt="user-image" class="h-4">
                                <span class="align-middle">German</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);"
                                class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100">
                                <img src="{{ asset('assets/images/flags/italy.jpg')}}" alt="user-image" class="h-4">
                                <span class="align-middle">Italian</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);"
                                class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100">
                                <img src="{{ asset('assets/images/flags/spain.jpg')}}" alt="user-image" class="h-4">
                                <span class="align-middle">Spanish</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);"
                                class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100">
                                <img src="{{ asset('assets/images/flags/russia.jpg')}}" alt="user-image" class="h-4">
                                <span class="align-middle">Russian</span>
                            </a>
                        </div>
                    </div>

                    <!-- Fullscreen Toggle Button -->
                    <div class="md:flex hidden">
                        <button data-toggle="fullscreen" type="button" class="nav-link p-2">
                            <span class="sr-only">Fullscreen Mode</span>
                            <span class="flex items-center justify-center size-6">
                                <i class="i-tabler-maximize text-2xl flex group-[-fullscreen]:hidden"></i>
                                <i class="i-tabler-minimize text-2xl hidden group-[-fullscreen]:flex"></i>
                            </span>
                        </button>
                    </div>

                    <!-- Profile Dropdown Button -->
                    <div class="relative">
                        <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                            <button type="button" class="hs-dropdown-toggle nav-link flex items-center gap-2">
                                <img src="{{ asset('assets/images/users/avatar-4.jpg')}}" alt="user-image" class="rounded-full h-10">
                                <i class="i-tabler-chevron-down text-sm ms-2"></i>
                            </button>
                            <div
                                class="hs-dropdown-menu duration mt-2 min-w-48 rounded-lg border border-default-200 bg-white p-2 opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 hidden">
                                <a class="flex items-center py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100"
                                    href="#">
                                    Profile
                                </a>
                                <a class="flex items-center py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100"
                                    href="#">
                                    Feed
                                </a>
                                <a class="flex items-center py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100"
                                    href="#">
                                    Analytics
                                </a>
                                <a class="flex items-center py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100"
                                    href="#">
                                    Settings
                                </a>
                                <a class="flex items-center py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100"
                                    href="#">
                                    Support
                                </a>
                                <hr class="my-2">
                                <a class="flex items-center py-2 px-3 rounded-md text-sm text-default-800 hover:bg-gray-100"
                                    href="#">
                                    Log Out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Topbar End -->

            <main>
                <div class="container py-6">
                    <!-- Start Content-->
                    @yield('content')
                    <!-- End Content-->
                </div> <!-- container -->
            </main>
        </div>
    </div>

    <!-- Plugin Js (Mandatory in All Pages) -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/preline/preline.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/lucide/umd/lucide.min.js') }}"></script>
    <script src="{{ asset('assets/libs/iconify-icon/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- App Js (Mandatory in All Pages) -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Apexcharts js -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector Map Js -->
    <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>

    <!-- Tambahkan di layout utama (biasanya di <head>) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Dashboard Project Page js -->
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('assets/libs/preline/preline.js') }}"></script>


</body>

</html>