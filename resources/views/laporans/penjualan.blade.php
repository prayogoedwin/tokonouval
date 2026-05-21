<x-layouts.app>
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ $title }}</span>
    </div>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $title }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Manage System {{ $title }}</p>
        </div>
        <div class="flex gap-2">
            @if(auth()->user()->hasPermission('view-laporanpenjualans'))
            <a href="{{ route('laporans.penjualan.export', request()->all()) }}">
                <x-button type="secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ __('Download Excel') }}
                </x-button>
            </a>
            @endif
            @if(auth()->user()->hasPermission('create-laporanpenjualans'))
            @if (($canCreate ?? true) !== false)
            <a href="{{ route('laporans.penjualan.create') }}">
                <x-button type="primary">{{ __('Create ' . $title) }}</x-button>
            </a>
            @endif
            @endif


        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Section Wrapper Form Filter -->
        <div class="p-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
            <form action="{{ route('laporans.penjualan') }}" method="get" id="filter-form">
                <div class="flex flex-col sm:flex-row sm:items-end gap-4 max-w-3xl">
                    <!-- Start Date Group -->
                    <div class="flex-1">
                        <label for="startdate" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">
                            Start Date
                        </label>
                        <div class="relative">
                            <input type="date" id="startdate" name="startdate"
                                value="{{ $startdate }}"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-500 transition-colors">
                        </div>
                    </div>

                    <!-- End Date Group -->
                    <div class="flex-1">
                        <label for="enddate" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">
                            End Date
                        </label>
                        <div class="relative">
                            <input type="date" id="enddate" name="enddate"
                                value="{{ $enddate }}"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-500 transition-colors">
                        </div>
                    </div>

                    <!-- Toko Select Group -->
                    <div class="flex-1">
                        <label for="toko" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">
                            Toko
                        </label>
                        <div class="relative">
                            <select id="toko" name="toko" class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-500 transition-colors">
                                <option value="">Semua Toko</option>
                                @foreach($tokos as $toko)
                                <option value="{{ $toko->id }}" {{ request('toko') == $toko->id ? 'selected' : '' }}>
                                    {{ $toko->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2 pt-2 sm:pt-0">
                        <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all cursor-pointer h-[38px]">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z" />
                            </svg>
                            Filter
                        </button>

                        @if(request('startdate') || request('enddate') || request('toko'))
                        <a href="{{ route('laporans.penjualan') }}"
                            class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none transition-all h-[38px]">
                            Reset
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Current Filter Info Status -->
        <div class="px-5 py-3 bg-blue-50/50 dark:bg-blue-950/20 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>
                Menampilkan data
                dari <strong>{{ \Carbon\Carbon::parse($startdate)->translatedFormat('d M Y') }}</strong> sampai <strong>{{ \Carbon\Carbon::parse($enddate)->translatedFormat('d M Y') }}</strong>
                untuk
                @if(request('toko'))
                toko <strong>{{ $tokos->firstWhere('id', request('toko'))->name ?? 'Terpilih' }}</strong>
                @else
                <strong>Semua Toko</strong>
                @endif
            </span>
        </div>

        <!-- Section Tabel -->
        <div class="p-4 overflow-x-auto">
            <table id="dynamic-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        @foreach($columns as $column)
                        @if($column['intable'])
                        @php
                        $isNumeric = in_array($column['value'], ['harga_beli', 'harga_jual', 'jumlah', 'sub_total', 'keuntungan']);
                        @endphp
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider {{ $isNumeric ? 'text-right' : 'text-left' }}">
                            {{ $column['title'] }}
                        </th>
                        @endif
                        @endforeach

                        @if($tableaction)
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                        @endif
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        // Define arrays of column values that should be right-aligned
        const rightAlignedColumns = ['harga_beli', 'harga_jual', 'terjual', 'kas_masuk', 'pendapatan', 'stok_saat_ini'];

        $columnsdata = [
            @foreach($columns as $column)
            @if($column["intable"]) {
                data: '{{ $column["value"] }}',
                // Check if the current column value should be right-aligned
                className: rightAlignedColumns.includes('{{ $column["value"] }}') ? 'text-right' : 'text-left'
            },
            @endif
            @endforeach
            @if($tableaction) {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                className: 'text-right whitespace-nowrap'
            }
            @endif
        ];

        console.log('$columnsdata:', $columnsdata);
        // Ambil parameter dari URL browser
        const urlParams = new URLSearchParams(window.location.search);
        const startdate = urlParams.get('startdate');
        const enddate = urlParams.get('enddate');
        const toko = urlParams.get('toko');


        $(document).ready(function() {
            $('#dynamic-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    'url': '{{ route("laporans.penjualan") }}',
                    'data': function(d) {
                        d.startdate = startdate;
                        d.enddate = enddate;
                        d.toko = toko;
                    }
                },
                columns: $columnsdata,
                order: [
                    [4, 'desc']
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search " + "{{ $title }}",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ {{ strtolower($title) }}",
                    infoEmpty: "No {{ strtolower($title) }} found",
                    infoFiltered: "(filtered from _MAX_ total {{ strtolower($title) }})",
                    zeroRecords: "No matching {{ strtolower($title) }} found",
                    emptyTable: "No {{ strtolower($title) }} available"
                },
                dom: '<"flex flex-col md:flex-row justify-between items-center mb-4"lf>rt<"flex flex-col md:flex-row justify-between items-center mt-4"ip>',
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                stripeClasses: ['bg-white dark:bg-gray-800', 'bg-gray-50 dark:bg-gray-900']
            });
        });
    </script>

    <style>
        /* Table borders and styling */
        #dynamic-table {
            border-collapse: separate !important;
            border-spacing: 0;
        }

        #dynamic-table thead th {
            border-bottom: 2px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .dark #dynamic-table thead th {
            border-bottom-color: #374151;
            background-color: #1f2937;
        }

        #dynamic-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .dark #dynamic-table tbody tr {
            border-bottom-color: #374151;
        }

        /* Alternating row colors (striping) */
        #dynamic-table tbody tr.odd {
            background-color: #ffffff;
        }

        #dynamic-table tbody tr.even {
            background-color: #f9fafb;
        }

        .dark #dynamic-table tbody tr.odd {
            background-color: #1f2937;
        }

        .dark #dynamic-table tbody tr.even {
            background-color: #111827;
        }

        #dynamic-table tbody tr:hover {
            background-color: #e5e7eb !important;
        }

        .dark #dynamic-table tbody tr:hover {
            background-color: #374151 !important;
        }

        #dynamic-table tbody td {
            border-right: 1px solid #e5e7eb;
            padding: 12px 24px;
        }

        .dark #dynamic-table tbody td {
            border-right-color: #374151;
        }

        #dynamic-table tbody td:last-child {
            border-right: none;
        }

        #dynamic-table thead th {
            border-right: 1px solid #e5e7eb;
        }

        .dark #dynamic-table thead th {
            border-right-color: #374151;
        }

        #dynamic-table thead th:last-child {
            border-right: none;
        }

        /* Action links styling - keep inline */
        #dynamic-table tbody td a,
        #dynamic-table tbody td form {
            display: inline;
            white-space: nowrap;
        }

        /* DataTables controls styling */
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            @apply px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-3 py-1 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 mx-1;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600;
        }

        .dataTables_wrapper .dataTables_info {
            @apply text-sm text-gray-600 dark:text-gray-400;
        }
    </style>
</x-layouts.app>