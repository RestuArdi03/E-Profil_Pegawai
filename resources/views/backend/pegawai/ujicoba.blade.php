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

                        <div class="hs-accordion-content {{ request()->routeIs('backend.unit_kerja.by_instansi') || request()->routeIs('backend.satuan_kerja.by_unit_kerja') ? '' : 'hidden' }} w-full overflow-hidden transition-[height] duration-300">
                            <ul class="mt-2 space-y-2">
                                <li class="menu-item">
                                    <a href="{{ route('backend.satuan_kerja.by_unit_kerja', session('unit_kerja_id') ?? 1) }}"
                                    class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5">
                                        <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                        Daftar Satuan Kerja
                                    </a>
                                </li>