            <aside :class="{ 'w-full md:w-64': sidebarOpen, 'w-0 md:w-16 hidden md:block': !sidebarOpen }"
                class="bg-sidebar text-sidebar-foreground border-r border-gray-200 dark:border-gray-700 sidebar-transition overflow-hidden">
                <!-- Sidebar Content -->
                <div class="h-full flex flex-col">
                    <!-- Sidebar Menu -->
                    <nav class="flex-1 overflow-y-auto custom-scrollbar py-4">
                        <ul class="space-y-1 px-2">
                            <x-layouts.sidebar-link href="{{ route('dashboard') }}" icon='fas-house'
                                :active="request()->routeIs('dashboard*')">Dashboard</x-layouts.sidebar-link>

                            <x-layouts.sidebar-two-level-link-parent title="User Management" icon="fas-users"
                                :active="request()->routeIs('users*') || request()->routeIs('roles*') || request()->routeIs('permissions*')">
                                <x-layouts.sidebar-two-level-link href="{{ route('users.index') }}" icon='fas-user'
                                    :active="request()->routeIs('users*')">Users</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('roles.index') }}" icon='fas-shield'
                                    :active="request()->routeIs('roles*')">Roles</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('permissions.index') }}" icon='fas-key'
                                    :active="request()->routeIs('permissions*')">Permissions</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>

                            <x-layouts.sidebar-link href="{{ route('tokos.index') }}" icon='fas-store'
                                :active="request()->routeIs('tokos*')">Toko Management
                            </x-layouts.sidebar-link>

                            <x-layouts.sidebar-link href="{{ route('kasir.dashboard') }}" icon='fas-cash-register'
                                :active="request()->routeIs('kasir*')">Kasir
                            </x-layouts.sidebar-link>

                            <x-layouts.sidebar-link href="{{ route('penjualans.index') }}" icon='fas-chart-line'
                                :active="request()->routeIs('penjualans*')">Penjualan Management
                            </x-layouts.sidebar-link>

                            

                            <x-layouts.sidebar-two-level-link-parent title="Produk Management" icon="fas-boxes-stacked"
                                :active="request()->routeIs('produks*') || request()->routeIs('kategories*') || request()->routeIs('satuans*')">

                                <x-layouts.sidebar-two-level-link href="{{ route('produks.index') }}" icon='fas-box'
                                    :active="request()->routeIs('produks*')">Produk</x-layouts.sidebar-two-level-link>

                                <x-layouts.sidebar-two-level-link href="{{ route('kategories.index') }}" icon='fas-tags'
                                    :active="request()->routeIs('kategories*')">Kategori</x-layouts.sidebar-two-level-link>

                                <x-layouts.sidebar-two-level-link href="{{ route('satuans.index') }}" icon='fas-scale-balanced'
                                    :active="request()->routeIs('satuans*')">Satuan</x-layouts.sidebar-two-level-link>

                            </x-layouts.sidebar-two-level-link-parent>

                            <x-layouts.sidebar-link href="{{ route('stoks.index') }}" icon='fas-boxes-packing'
                                :active="request()->routeIs('stoks*')">Stok
                            </x-layouts.sidebar-link>

                            <x-layouts.sidebar-link href="{{ route('laporans.penjualan') }}" icon='fas-chart-line'
                                :active="request()->routeIs('laporans*')">Laporan
                            </x-layouts.sidebar-link>

                            
                        </ul>
                    </nav>
                </div>
            </aside>