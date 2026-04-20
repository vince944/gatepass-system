<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body class="bg-[#f3f3f3] h-screen overflow-hidden font-sans overflow-x-hidden">

    <!-- Mobile Sidebar Overlay -->
    <div id="mobileSidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- Mobile Sidebar Drawer -->
    <aside
        id="mobileSidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-[#173a6b] text-white transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden"
        aria-hidden="true"
    >
        <div class="flex h-full min-h-0 flex-col overflow-y-auto">
            <div class="shrink-0 px-4 py-6 border-b border-white/10 flex items-start justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <img src="/images/dap_logo.png" alt="DAP Logo" class="w-12 h-12 object-contain rounded-md shrink-0">
                    <div class="min-w-0">
                        <h1 class="text-[16px] font-bold leading-tight truncate">DAP Equipment</h1>
                        <p class="text-[12px] text-white/80 mt-1 truncate">
                            {{ ucfirst((string) (auth()->user()?->role ?? 'User')) }}
                        </p>
                    </div>
                </div>
                <button
                    type="button"
                    id="mobileSidebarCloseBtn"
                    class="text-white/90 hover:text-white text-[22px] leading-none px-2"
                    aria-label="Close menu"
                >
                    ×
                </button>
            </div>

            <nav class="flex-1 min-h-0 overflow-y-auto px-3 py-6 space-y-2">
                <button type="button" data-mobile-nav="gatepass-request" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-semibold text-left text-white hover:bg-white/10 transition">
                    <i class="fa-regular fa-file-lines text-[18px]"></i>
                    <span>Gatepass Request</span>
                </button>
                <button type="button" data-mobile-nav="gatepass-history" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-semibold text-left text-white hover:bg-white/10 transition">
                    <i class="fa-solid fa-clock-rotate-left text-[18px]"></i>
                    <span>Request History</span>
                </button>
                <div class="px-1 pt-2 pb-1">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-white/55">Admin Control</p>
                </div>
                <button type="button" data-mobile-nav="dashboard" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-semibold text-left text-white hover:bg-white/10 transition">
                    <i class="fa-solid fa-border-all text-[18px]"></i>
                    <span>Dashboard</span>
                </button>
                <button type="button" data-mobile-nav="items-tracker" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-semibold text-left text-white hover:bg-white/10 transition">
                    <i class="fa-solid fa-list-check text-[18px]"></i>
                    <span>Items Tracker</span>
                </button>
                <button type="button" data-mobile-nav="inventory-portal" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-semibold text-left text-white hover:bg-white/10 transition">
                    <i class="fa-solid fa-cube text-[18px]"></i>
                    <span>Inventory Portal</span>
                </button>
                <button type="button" data-mobile-nav="reports" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-semibold text-left text-white hover:bg-white/10 transition">
                    <i class="fa-solid fa-chart-pie text-[18px]" aria-hidden="true"></i>
                    <span>Reports</span>
                </button>
            </nav>

            <div class="shrink-0 mt-auto px-6 py-6 border-t border-white/10 mb-2">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-semibold text-left text-white/90 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-right-from-bracket text-[18px]"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex min-h-0 h-screen flex-col md:flex-row overflow-hidden">

        <!-- Sidebar -->
        <aside class="hidden lg:flex h-screen min-h-screen max-h-screen w-full md:w-72 lg:w-80 bg-[#173a6b] text-white flex-col shrink-0 overflow-y-auto">
            <div class="shrink-0">
                <!-- Logo / Title -->
                <div class="px-4 py-8 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <img src="/images/dap_logo.png" alt="DAP Logo" class="w-[56px] h-[56px] object-contain rounded-md">
                        <div>
                            <h1 class="text-[19px] font-bold leading-tight">DAP Equipment</h1>
                            <p class="text-[15px] text-white/90 mt-1">Logistics Division</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-3 py-10 space-y-3 pb-6">
                    <button id="navGatepassRequest" type="button" class="w-full flex items-center gap-4 px-6 py-4 text-[17px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition text-left">
                        <i class="fa-regular fa-file-lines text-[20px]"></i>
                        <span>Gatepass Request</span>
                    </button>

                    <button id="navGatepassHistory" type="button" class="w-full flex items-center gap-4 px-6 py-4 text-[17px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition text-left">
                        <i class="fa-solid fa-clock-rotate-left text-[20px]"></i>
                        <span>Request History</span>
                    </button>

                    <div class="px-1 pt-2 pb-1">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-white/55">Admin Control</p>
                    </div>

                    <button id="navDashboard" type="button" class="w-full flex items-center gap-4 bg-[#47698f] rounded-2xl px-6 py-4 text-[17px] font-semibold text-left text-white">
                        <i class="fa-solid fa-border-all text-[20px]"></i>
                        <span>Dashboard</span>
                    </button>

                    <button id="navAdminItemsTracker" type="button" class="w-full flex items-center gap-4 px-6 py-4 text-[17px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition text-left">
                        <i class="fa-solid fa-list-check text-[20px]"></i>
                        <span>Items Tracker</span>
                    </button>

                    <button id="navAdminInventoryPortal" type="button" class="w-full flex items-center gap-4 px-6 py-4 text-[17px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition text-left">
                        <i class="fa-solid fa-cube text-[20px]"></i>
                        <span>Inventory Portal</span>
                    </button>

                    <button id="navReports" type="button" class="w-full flex items-center gap-4 px-6 py-4 text-[17px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition text-left">
                        <i class="fa-solid fa-chart-pie text-[20px]" aria-hidden="true"></i>
                        <span>Reports</span>
                    </button>
                </nav>
            </div>

            <!-- Logout -->
            <div class="mt-auto shrink-0 px-8 py-8 border-t border-white/10 mb-2">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="flex items-center gap-4 text-[18px] font-semibold text-white/90 hover:text-white transition">
                        <i class="fa-solid fa-right-from-bracket text-[22px]"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-h-0 min-w-0 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="shrink-0 bg-[#f3f3f3] border-b border-black/10 px-4 sm:px-6 lg:px-8 py-4 sm:py-7 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <button
                        type="button"
                        id="mobileSidebarOpenBtn"
                        class="lg:hidden inline-flex items-center justify-center w-11 h-11 rounded-xl bg-white border border-gray-200 text-[#173a6b] hover:bg-gray-50 transition shrink-0"
                        aria-label="Open menu"
                    >
                        <i class="fa-solid fa-bars text-[18px]"></i>
                    </button>
                    <div class="min-w-0">
                        <h2 id="pageTitle" class="text-[20px] sm:text-[42px] font-bold text-black leading-none break-words">Dashboard</h2>
                        <p id="pageSubtitle" class="hidden sm:block text-[16px] sm:text-[18px] text-[#3e5573] mt-2 break-words">Manage gate pass requests and approvals</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <button onclick="openAdminProfileModal()" class="w-11 h-11 sm:w-[52px] sm:h-[52px] rounded-xl sm:rounded-full bg-[#003b95] text-white flex items-center justify-center text-[20px] sm:text-[24px] shrink-0">
                        <i class="fa-regular fa-user"></i>
                    </button>
                </div>
            </header>

            <!-- Content -->
            <section class="flex-1 min-h-0 w-full max-w-full min-w-0 overflow-y-auto overflow-x-hidden px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

                @include('partials.coordinator-employee-gatepass', [
                    'employee' => $gatepassEmployee ?? null,
                    'employeeFullName' => $gatepassEmployeeFullName ?? null,
                    'equipment' => $gatepassEquipment ?? collect(),
                ])

                @include('partials.coordinator-workspace-sections')

                <!-- DASHBOARD SECTION -->
                <div id="adminGatepassOverviewSection">
                    <!-- Stat Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5 mb-8 items-stretch">

                        <!-- Pending Approval -->
                        <div class="relative bg-white rounded-[20px] shadow-md px-5 sm:px-6 py-6 overflow-hidden min-h-[124px] h-full">
                            <div class="absolute -top-8 -right-8 w-[102px] h-[102px] bg-[#efe7d4] rounded-full"></div>
                            <div class="relative z-10 flex items-end justify-between gap-4 min-w-0">
                                <div class="min-w-0">
                                    <p class="text-[14px] sm:text-[15px] text-[#3e5573] mb-4 break-words">Pending Approval</p>
                                    <h3 id="cardPendingCount" class="text-[34px] sm:text-[38px] font-bold text-[#003b95] leading-none">{{ (int) (($counts['pending'] ?? 0)) }}</h3>
                                </div>
                                <div class="w-[44px] h-[44px] rounded-[14px] bg-[#f6b400] flex items-center justify-center text-white text-[20px] shrink-0">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Approved -->
                        <div class="relative bg-white rounded-[20px] shadow-md px-5 sm:px-6 py-6 overflow-hidden min-h-[124px] h-full">
                            <div class="absolute -top-8 -right-8 w-[102px] h-[102px] bg-[#dce3ef] rounded-full"></div>
                            <div class="relative z-10 flex items-end justify-between gap-4 min-w-0">
                                <div class="min-w-0">
                                    <p class="text-[14px] sm:text-[15px] text-[#3e5573] mb-4 break-words">Approved</p>
                                    <h3 id="cardApprovedCount" class="text-[34px] sm:text-[38px] font-bold text-[#003b95] leading-none">{{ (int) (($counts['approved'] ?? 0)) }}</h3>
                                </div>
                                <div class="w-[44px] h-[44px] rounded-[14px] bg-[#003b95] flex items-center justify-center text-white text-[20px] shrink-0">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Active Outside -->
                        <div class="relative bg-white rounded-[20px] shadow-md px-5 sm:px-6 py-6 overflow-hidden min-h-[124px] h-full">
                            <div class="absolute -top-8 -right-8 w-[102px] h-[102px] bg-[#efe7d4] rounded-full"></div>
                            <div class="relative z-10 flex items-end justify-between gap-4 min-w-0">
                                <div class="min-w-0">
                                    <p class="text-[14px] sm:text-[15px] text-[#3e5573] mb-4 break-words">Active Outside</p>
                                    <h3 id="cardActiveOutsideCount" class="text-[34px] sm:text-[38px] font-bold text-[#003b95] leading-none">{{ (int) (($counts['active_outside'] ?? 0)) }}</h3>
                                </div>
                                <div class="w-[44px] h-[44px] rounded-[14px] bg-[#f6b400] flex items-center justify-center text-[#003b95] text-[20px] shrink-0">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Requests -->
                        <div class="relative bg-white rounded-[20px] shadow-md px-5 sm:px-6 py-6 overflow-hidden min-h-[124px] h-full">
                            <div class="absolute -top-8 -right-8 w-[102px] h-[102px] bg-[#dce3ef] rounded-full"></div>
                            <div class="relative z-10 flex items-end justify-between gap-4 min-w-0">
                                <div class="min-w-0">
                                    <p class="text-[14px] sm:text-[15px] text-[#3e5573] mb-4 break-words">Total Requests</p>
                                    <h3 id="cardTotalCount" class="text-[34px] sm:text-[38px] font-bold text-[#001d4f] leading-none">{{ (int) (($counts['total'] ?? 0)) }}</h3>
                                </div>
                                <div class="w-[44px] h-[44px] rounded-[14px] bg-[#f6b400] flex items-center justify-center text-[#003b95] text-[22px] shrink-0">
                                    <i class="fa-regular fa-file-lines"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Gate pass search & status filter (submits automatically while typing / on status change) -->
                    <div class="mb-6 w-full min-w-0">
                        <form
                            id="gatepassDashboardFilterForm"
                            method="GET"
                            action="{{ route('admin.dashboard') }}"
                            class="flex w-full min-w-0 flex-col items-stretch gap-3 sm:flex-row sm:flex-nowrap sm:items-center sm:gap-4 md:gap-5"
                        >
                            <div class="relative min-w-0 w-full sm:flex-1 sm:min-w-0">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[18px] pointer-events-none" aria-hidden="true">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <label for="gp_q" class="sr-only">Search by gate pass number</label>
                                <input
                                    id="gp_q"
                                    type="search"
                                    name="gp_q"
                                    value="{{ $gatepassListSearch ?? '' }}"
                                    placeholder="Search gate pass number…"
                                    autocomplete="off"
                                    class="w-full h-[48px] rounded-2xl border border-gray-300 bg-white pl-12 pr-4 text-[16px] text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#003b95]/25 focus:border-[#003b95]"
                                >
                            </div>
                            <div class="w-full shrink-0 sm:w-[200px] sm:max-w-[220px] sm:flex-none">
                                <label for="gp_status" class="sr-only">Filter by status</label>
                                <select
                                    id="gp_status"
                                    name="gp_status"
                                    class="w-full h-[48px] rounded-2xl border border-gray-300 bg-white px-4 text-[16px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#003b95]/25 focus:border-[#003b95]"
                                >
                                    <option value="" @selected(($gatepassListStatus ?? '') === '')>Select status</option>
                                    <option value="pending" @selected(strtolower((string) ($gatepassListStatus ?? '')) === 'pending')>Pending</option>
                                    <option value="approved" @selected(strtolower((string) ($gatepassListStatus ?? '')) === 'approved')>Approved</option>
                                    <option value="rejected" @selected(strtolower((string) ($gatepassListStatus ?? '')) === 'rejected')>Rejected</option>
                                    <option value="returned" @selected(strtolower((string) ($gatepassListStatus ?? '')) === 'returned')>Returned</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Dashboard Table -->
                    <div class="bg-white border border-gray-200 overflow-hidden rounded-2xl">
                        <div class="overflow-x-auto rounded-2xl">
                            <table class="w-full border-collapse min-w-[900px]">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left px-4 sm:px-6 py-6 text-[14px] sm:text-[16px] font-semibold text-[#4b6790] uppercase whitespace-nowrap">Gate Pass No</th>
                                        <th class="text-left px-4 sm:px-6 py-6 text-[14px] sm:text-[16px] font-semibold text-[#4b6790] uppercase whitespace-nowrap">Employee</th>
                                        <th class="text-left px-4 sm:px-6 py-6 text-[14px] sm:text-[16px] font-semibold text-[#4b6790] uppercase whitespace-nowrap">Center</th>
                                        <th class="text-left px-4 sm:px-6 py-6 text-[14px] sm:text-[16px] font-semibold text-[#4b6790] uppercase whitespace-nowrap">Items</th>
                                        <th class="text-left px-4 sm:px-6 py-6 text-[14px] sm:text-[16px] font-semibold text-[#4b6790] uppercase whitespace-nowrap">Request Date</th>
                                        <th class="text-left px-4 sm:px-6 py-6 text-[14px] sm:text-[16px] font-semibold text-[#4b6790] uppercase whitespace-nowrap">Status</th>
                                        <th class="text-left px-4 sm:px-6 py-6 text-[14px] sm:text-[16px] font-semibold text-[#4b6790] uppercase whitespace-nowrap">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $statusBadge = function (?string $status): string {
                                            $s = strtolower(trim((string) $status));

                                            return match ($s) {
                                                'approved' => 'bg-green-100 text-green-800 border border-green-200',
                                                'rejected' => 'bg-red-100 text-red-800 border border-red-200',
                                                'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                                'returned' => 'bg-gray-100 text-gray-800 border border-gray-200',
                                                'active outside' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                                default => 'bg-gray-100 text-gray-800 border border-gray-200',
                                            };
                                        };
                                    @endphp

                                    @php
                                        $gatepassRequestsCollection = $requests ?? collect();
                                        $gatepassRequestsPerPage = 5;
                                        $gatepassRequestsPageName = 'gatepass_requests_page';
                                        $gatepassRequestsCurrentPage = (int) request()->query($gatepassRequestsPageName, 1);
                                        if ($gatepassRequestsCurrentPage < 1) {
                                            $gatepassRequestsCurrentPage = 1;
                                        }

                                        $gatepassRequestsTotal = $gatepassRequestsCollection->count();
                                        $gatepassRequestsItems = $gatepassRequestsCollection
                                            ->forPage($gatepassRequestsCurrentPage, $gatepassRequestsPerPage)
                                            ->values();

                                        $gatepassRequestsPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
                                            $gatepassRequestsItems,
                                            $gatepassRequestsTotal,
                                            $gatepassRequestsPerPage,
                                            $gatepassRequestsCurrentPage,
                                            [
                                                'path' => request()->url(),
                                                'pageName' => $gatepassRequestsPageName,
                                            ]
                                        );

                                        $gatepassRequestsPaginator = $gatepassRequestsPaginator->appends(
                                            request()->except($gatepassRequestsPageName)
                                        );
                                    @endphp

                                    @forelse ($gatepassRequestsPaginator as $req)
                                        @php
                                            $employeeName = $req->requester?->employee_name ?? $req->requester?->user?->name ?? '—';
                                            $itemsText = $req->items
                                                ?->map(function ($it) {
                                                    $inv = $it->inventory;
                                                    $prop = trim((string) ($inv?->current_prop_no ?? ''));
                                                    $desc = trim((string) ($inv?->description ?? ''));
                                                    $label = trim(($prop !== '' ? ($prop.' - ') : '').$desc);

                                                    return $label !== '' ? $label : null;
                                                })
                                                ->filter()
                                                ->values()
                                                ->implode(', ') ?? '';
                                        @endphp

                                        <tr class="border-b border-gray-200 align-top" id="gatepassRow-{{ $req->gatepass_no }}">
                                            <td class="px-4 sm:px-6 py-6 text-[15px] text-gray-800 whitespace-nowrap">{{ $req->gatepass_no }}</td>
                                            <td class="px-4 sm:px-6 py-6 text-[15px] text-gray-800">{{ $employeeName }}</td>
                                            <td class="px-4 sm:px-6 py-6 text-[15px] text-gray-800">{{ $req->center }}</td>
                                            <td class="px-4 sm:px-6 py-6 text-[14px] text-gray-700">
                                                @if ($itemsText !== '')
                                                    <div class="line-clamp-2 max-w-[420px]">
                                                        {{ $itemsText }}
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
                                            <td class="px-4 sm:px-6 py-6 text-[15px] text-gray-800 whitespace-nowrap">
                                                {{ optional($req->request_date)->format('Y-m-d') }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-6 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold {{ $statusBadge($req->status) }}"
                                                    id="statusBadge-{{ $req->gatepass_no }}"
                                                    data-status="{{ $req->status }}"
                                                >
                                                    {{ $req->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-6">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <button
                                                        type="button"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-600 text-white shadow-sm ring-1 ring-inset ring-black/5 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600/30 disabled:opacity-50 disabled:cursor-not-allowed {{ strtolower(trim((string) $req->status)) === 'rejected' ? '!hidden' : '' }}"
                                                        onclick="approveGatepass(this)"
                                                        data-url="{{ route('admin.gatepass-requests.approve', $req->gatepass_no) }}"
                                                        data-gatepass-no="{{ $req->gatepass_no }}"
                                                        @disabled(strtolower($req->status) === 'approved')
                                                        aria-label="Approve"
                                                        title="Approve"
                                                    >
                                                        <i class="fa-solid fa-check text-[14px]" aria-hidden="true"></i>
                                                        <span class="sr-only">Approve</span>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#003b95] text-white shadow-sm ring-1 ring-inset ring-black/5 hover:bg-[#002d73] focus:outline-none focus:ring-2 focus:ring-[#003b95]/30"
                                                        onclick="viewGatepass(this)"
                                                        data-url="{{ route('admin.gatepass-requests.show', $req->gatepass_no) }}"
                                                        data-gatepass-no="{{ $req->gatepass_no }}"
                                                        aria-label="View details"
                                                        title="View details"
                                                    >
                                                        <i class="fa-solid fa-eye text-[14px]" aria-hidden="true"></i>
                                                        <span class="sr-only">View</span>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#003b95] shadow-sm ring-1 ring-inset ring-black/5 hover:bg-[#003b95]/10 focus:outline-none focus:ring-2 focus:ring-[#003b95]/30"
                                                        onclick="openAuditTrailsModal(this)"
                                                        data-url="{{ route('admin.gatepass-requests.show', $req->gatepass_no) }}"
                                                        data-gatepass-no="{{ $req->gatepass_no }}"
                                                        aria-label="Audit Trails"
                                                        title="Audit Trails"
                                                    >
                                                        <i class="fa-solid fa-clipboard-list text-[14px]" aria-hidden="true"></i>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        data-action="take-actions"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#f6b400] text-black shadow-sm ring-1 ring-inset ring-black/5 hover:bg-[#e5a900] focus:outline-none focus:ring-2 focus:ring-[#f6b400]/30 {{ strtolower(trim((string) $req->status)) === 'rejected' ? '' : '!hidden' }}"
                                                        onclick="openTakeActionsModal(this)"
                                                        data-url="{{ route('admin.gatepass-requests.show', $req->gatepass_no) }}"
                                                        data-gatepass-no="{{ $req->gatepass_no }}"
                                                        aria-label="Take actions"
                                                        title="Take actions"
                                                    >
                                                        <i class="fa-solid fa-pen-to-square text-[14px]" aria-hidden="true"></i>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        data-action="reject-action"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-sm ring-1 ring-inset ring-black/5 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600/30 disabled:opacity-50 disabled:cursor-not-allowed {{ strtolower(trim((string) $req->status)) === 'rejected' ? '!hidden' : '' }}"
                                                        onclick="rejectGatepass(this)"
                                                        data-url="{{ route('admin.gatepass-requests.reject', $req->gatepass_no) }}"
                                                        data-gatepass-no="{{ $req->gatepass_no }}"
                                                        @disabled(strtolower(trim((string) $req->status)) === 'rejected')
                                                        aria-label="Reject"
                                                        title="Reject"
                                                    >
                                                        <i class="fa-solid fa-xmark text-[16px]" aria-hidden="true"></i>
                                                        <span class="sr-only">Reject</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="border-b border-gray-200">
                                            <td colspan="7" class="px-6 py-14 text-center text-gray-400 text-[16px]">
                                                No gate pass requests found
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Design -->
                        <div id="gatepassRequestsPagination" class="flex items-center justify-between px-6 py-5 border-t border-gray-200">
                            <p class="text-[16px] text-[#3e5573] whitespace-nowrap">
                                @php
                                    $gatepassFrom = $gatepassRequestsPaginator->firstItem();
                                    $gatepassTo = $gatepassRequestsPaginator->lastItem();
                                    $gatepassTotal = $gatepassRequestsPaginator->total();
                                    $gatepassCurrentPage = $gatepassRequestsPaginator->currentPage();
                                @endphp
                                @if ($gatepassTotal > 0)
                                    Showing {{ $gatepassFrom }}–{{ $gatepassTo }} of {{ $gatepassTotal }} results
                                @else
                                    Showing 0–0 of 0 results
                                @endif
                            </p>

                            <div class="flex flex-wrap items-center gap-2">
                                @php
                                    $gatepassPrevUrl = $gatepassRequestsPaginator->previousPageUrl();
                                    $gatepassNextUrl = $gatepassRequestsPaginator->nextPageUrl();
                                    $gatepassLastPage = $gatepassRequestsPaginator->lastPage();
                                    if ($gatepassLastPage <= 3) {
                                        $gatepassPageWindowStart = 1;
                                        $gatepassPageWindowEnd = $gatepassLastPage;
                                    } else {
                                        $gatepassPageWindowStart = max(1, min($gatepassCurrentPage - 1, $gatepassLastPage - 2));
                                        $gatepassPageWindowEnd = min($gatepassLastPage, $gatepassPageWindowStart + 2);
                                    }
                                @endphp

                                @if ($gatepassPrevUrl)
                                    <a href="{{ $gatepassPrevUrl }}" class="px-4 py-2 rounded-xl border border-gray-300 bg-white text-[16px] font-medium">
                                        Previous
                                    </a>
                                @else
                                    <span class="px-4 py-2 rounded-xl border border-gray-300 text-gray-400 bg-gray-50 text-[16px] font-medium cursor-not-allowed" aria-disabled="true">
                                        Previous
                                    </span>
                                @endif

                                @for ($page = $gatepassPageWindowStart; $page <= $gatepassPageWindowEnd; $page++)
                                    @if ($page === $gatepassCurrentPage)
                                        <span class="w-auto min-w-[40px] h-[40px] px-3 inline-flex items-center justify-center rounded-xl bg-[#020826] text-white text-[16px] font-semibold" aria-current="page">{{ $page }}</span>
                                    @else
                                        <a href="{{ $gatepassRequestsPaginator->url($page) }}" class="min-w-[40px] h-[40px] px-3 inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white text-[16px] font-medium">{{ $page }}</a>
                                    @endif
                                @endfor

                                @if ($gatepassNextUrl)
                                    <a href="{{ $gatepassNextUrl }}" class="px-4 py-2 rounded-xl border border-gray-300 bg-white text-[16px] font-medium">
                                        Next
                                    </a>
                                @else
                                    <span class="px-4 py-2 rounded-xl border border-gray-300 text-gray-400 bg-gray-50 text-[16px] font-medium cursor-not-allowed" aria-disabled="true">
                                        Next
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <!-- REPORTS SECTION -->
                <div id="reportsSection" class="hidden">
                    <div class="space-y-6">
                        <!-- SYSTEM-WIDE MOVEMENT TRACKING -->
                        <div class="bg-white border border-gray-200 overflow-hidden rounded-[22px] px-6 sm:px-8 py-6 sm:py-8">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between mb-6">
                                <div>
                                    <h3 class="text-[20px] sm:text-[24px] font-bold text-black leading-tight">
                                        System-Wide Movement Tracking
                                    </h3>
                                    <p class="text-[14px] sm:text-[16px] text-[#3e5573] mt-2">
                                        Outgoing vs Incoming Statistics
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-center">
                                <div class="lg:col-span-2">
                                    <div class="relative h-[240px] sm:h-[280px]">
                                        <canvas id="movementDoughnutChart"></canvas>
                                    </div>

                                    <div class="mt-4 space-y-2">
                                        <p class="text-[14px] sm:text-[15px] text-gray-700">
                                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-[#f6b400] mr-2 align-middle"></span>
                                            Outgoing:
                                            <span id="movementOutgoingPercent" class="font-semibold text-black">0%</span>
                                            (<span id="movementOutgoingCount" class="font-semibold text-black">0</span>)
                                        </p>
                                        <p class="text-[14px] sm:text-[15px] text-gray-700">
                                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-[#003b95] mr-2 align-middle"></span>
                                            Incoming:
                                            <span id="movementIncomingPercent" class="font-semibold text-black">0%</span>
                                            (<span id="movementIncomingCount" class="font-semibold text-black">0</span>)
                                        </p>
                                    </div>
                                </div>

                                <div class="lg:col-span-3">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div class="bg-[#f6f7fb] border border-gray-200 rounded-2xl px-5 py-4">
                                            <p class="text-[14px] font-semibold text-[#3e5573]">Outgoing</p>
                                            <h4 id="movementOutgoingCardCount" class="text-[30px] font-bold text-[#003b95] leading-none mt-3">0</h4>
                                        </div>
                                        <div class="bg-[#f6f7fb] border border-gray-200 rounded-2xl px-5 py-4">
                                            <p class="text-[14px] font-semibold text-[#3e5573]">Incoming</p>
                                            <h4 id="movementIncomingCardCount" class="text-[30px] font-bold text-[#003b95] leading-none mt-3">0</h4>
                                        </div>
                                        <div class="bg-[#f6f7fb] border border-gray-200 rounded-2xl px-5 py-4">
                                            <p class="text-[14px] font-semibold text-[#3e5573]">Total Movements</p>
                                            <h4 id="movementTotalCardCount" class="text-[30px] font-bold text-[#003b95] leading-none mt-3">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- GATE PASS TRENDS -->
                        <div class="bg-white border border-gray-200 overflow-hidden rounded-[22px] px-6 sm:px-8 py-6 sm:py-8">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                                <div>
                                    <h3 class="text-[20px] sm:text-[24px] font-bold text-black leading-tight">
                                        Gate Pass Trends
                                    </h3>
                                    <p id="gatepassTrendsSubtitle" class="text-[14px] sm:text-[16px] text-[#3e5573] mt-2">
                                        Last 7 days
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center justify-start sm:justify-end gap-2">
                                    <button type="button" data-trends-filter="daily" class="trendsFilterBtn bg-[#003b95] text-white px-4 py-2 rounded-xl text-[14px] font-semibold">
                                        Daily
                                    </button>
                                    <button type="button" data-trends-filter="weekly" class="trendsFilterBtn bg-white text-[#003b95] border border-[#003b95]/30 hover:bg-[#003b95]/10 px-4 py-2 rounded-xl text-[14px] font-semibold">
                                        Weekly
                                    </button>
                                    <button type="button" data-trends-filter="monthly" class="trendsFilterBtn bg-white text-[#003b95] border border-[#003b95]/30 hover:bg-[#003b95]/10 px-4 py-2 rounded-xl text-[14px] font-semibold">
                                        Monthly
                                    </button>
                                    <button type="button" data-trends-filter="quarterly" class="trendsFilterBtn bg-white text-[#003b95] border border-[#003b95]/30 hover:bg-[#003b95]/10 px-4 py-2 rounded-xl text-[14px] font-semibold">
                                        Quarterly
                                    </button>
                                    <button type="button" data-trends-filter="yearly" class="trendsFilterBtn bg-white text-[#003b95] border border-[#003b95]/30 hover:bg-[#003b95]/10 px-4 py-2 rounded-xl text-[14px] font-semibold">
                                        Yearly
                                    </button>
                                </div>
                            </div>

                            <div class="relative h-[340px] sm:h-[380px]">
                                <canvas id="gatepassTrendsBarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </main>
    </div>

    @include('partials.coordinator-workspace-modals')

    <!-- Toast (Animated Alerts) -->
    <div id="toastContainer" class="fixed top-6 right-6 z-[60] space-y-3 pointer-events-none"></div>

    <style>
        .toast {
            transform: translateY(-12px);
            opacity: 0;
            transition: transform 200ms ease, opacity 200ms ease;
        }
        .toast.toast-show {
            transform: translateY(0);
            opacity: 1;
        }
    </style>

    <!-- New Gate Pass Request Modal -->
    <div id="newGatePassModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[900px] bg-white rounded-[18px] shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[24px] font-bold text-[#003b95]">New Gate Pass Request</h2>
                <button type="button" onclick="closeNewGatePassModal()" class="text-[#98a2b3] hover:text-black text-[28px] leading-none">
                    ×
                </button>
            </div>

            <!-- Body -->
            <form id="newGatePassForm" class="px-7 py-6 max-h-[78vh] overflow-y-auto space-y-7">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[14px] font-semibold text-[#243b5a] mb-2">
                            Gate Pass No
                        </label>
                        <input
                            id="gatePassNoField"
                            type="text"
                            readonly
                            class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none"
                        >
                    </div>

                    <div>
                        <label class="block text-[14px] font-semibold text-[#243b5a] mb-2">
                            Purpose <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="purposeField"
                            type="text"
                            placeholder="Enter purpose"
                            class="w-full h-[46px] rounded-xl border border-gray-300 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                        <p id="purposeError" class="mt-1 text-[13px] text-red-500 hidden">
                            Purpose is required.
                        </p>
                    </div>
                </div>

                <div>
                    <label class="block text-[14px] font-semibold text-[#243b5a] mb-2">
                        The items will be brought to <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="broughtToField"
                        type="text"
                        placeholder="Enter destination / area"
                        class="w-full h-[46px] rounded-xl border border-gray-300 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    >
                    <p id="broughtToError" class="mt-1 text-[13px] text-red-500 hidden">
                        This field cannot be blank.
                    </p>
                </div>

                <!-- Equipment Selection -->
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row md:items-end gap-4">
                        <div class="flex-1">
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-2">
                                Select Equipment from Inventory
                            </label>
                            <select
                                id="equipmentSelect"
                                class="w-full h-[46px] rounded-xl border border-gray-300 bg-white px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                                <option value="">-- Choose equipment --</option>
                                @foreach (($equipment ?? collect()) as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->current_prop_no ? $item->current_prop_no.' - ' : '' }}{{ $item->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button
                            type="button"
                            onclick="addSelectedEquipment()"
                            class="px-5 py-3 rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[15px] font-semibold whitespace-nowrap"
                        >
                            Add
                        </button>
                    </div>
                    <p id="equipmentError" class="mt-1 text-[13px] text-red-500 hidden">
                        Please add at least one equipment.
                    </p>

                    <div class="border border-gray-200 rounded-2xl overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-[14px] font-semibold text-[#4b6790]">#</th>
                                    <th class="px-4 py-3 text-[14px] font-semibold text-[#4b6790]">Equipment</th>
                                    <th class="px-4 py-3 text-[14px] font-semibold text-[#4b6790] text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody id="selectedEquipmentBody">
                                <tr id="noEquipmentRow">
                                    <td colspan="3" class="px-4 py-4 text-center text-[14px] text-gray-400">
                                        No equipment added yet.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6 mt-4 flex justify-end gap-4">
                    <button
                        type="button"
                        onclick="closeNewGatePassModal()"
                        class="px-6 sm:px-8 h-[44px] rounded-xl border border-gray-300 bg-white text-[15px] font-semibold text-black hover:bg-gray-50 transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-6 sm:px-8 h-[44px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[15px] font-semibold transition"
                    >
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Admin Profile Modal -->
    <div id="adminProfileModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[1150px] bg-white rounded-[18px] shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[26px] font-bold text-[#003b95]">Admin Profile</h2>
                <button type="button" onclick="closeAdminProfileModal()" class="text-[#98a2b3] hover:text-black text-[28px] leading-none">
                    ×
                </button>
            </div>

            <!-- Body -->
            <div class="px-7 py-6 max-h-[78vh] overflow-y-auto">
                @php
                    $adminUser = auth()->user();
                    $adminEmployee = \App\Models\Employee::query()
                        ->where('user_id', $adminUser?->id)
                        ->first();
                @endphp

                <form id="adminProfileForm" class="space-y-8" method="POST" action="{{ route('employee.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div id="adminProfileAlertSuccess" class="hidden rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[14px] text-emerald-800"></div>
                    <div id="adminProfileAlertError" class="hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[14px] text-red-800"></div>

                    <!-- Profile Information -->
                    <div>
                        <h3 class="text-[18px] font-semibold text-[#003b95] mb-5">Profile Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            <div>
                                <label for="profileEmployeeName" class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Full Name
                                </label>
                                <input
                                    id="profileEmployeeName"
                                    name="employee_name"
                                    type="text"
                                    value="{{ old('employee_name', $adminEmployee?->employee_name ?? $adminUser?->name ?? '') }}"
                                    required
                                    autocomplete="name"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <p id="adminProfileErrorEmployeeName" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
                            </div>

                            <div>
                                <label for="profileCenter" class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Center/Office
                                </label>
                                <input
                                    id="profileCenter"
                                    name="center"
                                    type="text"
                                    value="{{ old('center', $adminEmployee?->center ?? '') }}"
                                    required
                                    autocomplete="organization"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <p id="adminProfileErrorCenter" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
                            </div>

                            <div>
                                <label for="profileEmail" class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Email Address
                                </label>
                                <input
                                    id="profileEmail"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', $adminUser?->email ?? '') }}"
                                    required
                                    autocomplete="email"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <p id="adminProfileErrorEmail" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div>
                        <h3 class="text-[18px] font-semibold text-[#003b95] mb-5">Change Password</h3>
                        <p class="text-[13px] text-[#667085] mb-4">Leave password fields empty to keep your current password.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            <div>
                                <label for="profileCurrentPassword" class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Current Password
                                </label>
                                <input
                                    id="profileCurrentPassword"
                                    name="current_password"
                                    type="password"
                                    placeholder="Enter current password"
                                    autocomplete="current-password"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <p id="adminProfileErrorCurrentPassword" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
                            </div>

                            <div>
                                <label for="profileNewPassword" class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    New Password
                                </label>
                                <input
                                    id="profileNewPassword"
                                    name="password"
                                    type="password"
                                    placeholder="Enter new password"
                                    autocomplete="new-password"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <p id="adminProfileErrorPassword" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
                            </div>

                            <div>
                                <label for="profilePasswordConfirmation" class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Confirm New Password
                                </label>
                                <input
                                    id="profilePasswordConfirmation"
                                    name="password_confirmation"
                                    type="password"
                                    placeholder="Confirm new password"
                                    autocomplete="new-password"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <p id="adminProfileErrorPasswordConfirmation" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 pt-7 flex flex-col-reverse sm:flex-row sm:justify-end gap-4">
                        <button
                            type="button"
                            onclick="closeAdminProfileModal()"
                            class="px-6 sm:px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[16px] font-semibold text-black hover:bg-gray-50 transition whitespace-nowrap">
                            Cancel
                        </button>

                        <button
                            id="adminProfileSubmitBtn"
                            type="submit"
                            class="px-6 sm:px-10 h-[46px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold transition whitespace-nowrap disabled:opacity-60 disabled:cursor-not-allowed">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Gate Pass Details Modal -->
    <div id="gatepassDetailsModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[980px] bg-white rounded-[18px] shadow-2xl overflow-hidden border border-gray-200">
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[24px] font-bold text-[#003b95]">Gate Pass Request Details</h2>
                <button type="button" onclick="closeGatepassDetailsModal()" class="text-[#98a2b3] hover:text-black text-[28px] leading-none">×</button>
            </div>

            <div class="px-7 py-6 max-h-[78vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4">
                        <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Gate Pass No.</p>
                        <p id="gpDetailGatepassNo" class="mt-2 text-[16px] font-semibold text-gray-900">—</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4">
                        <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Status</p>
                        <div class="mt-2">
                            <span id="gpDetailStatus" class="inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold bg-gray-100 text-gray-800 border border-gray-200">—</span>
                        </div>
                    </div>

                    <div class="md:col-span-2 rounded-2xl border border-gray-200 bg-white px-5 py-4">
                        <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-4">Request Information</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Request Date</p>
                                <p id="gpDetailRequestDate" class="mt-2 text-[15px] font-semibold text-gray-900">—</p>
                            </div>
                            <div>
                                <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Purpose</p>
                                <p id="gpDetailPurpose" class="mt-2 text-[15px] font-semibold text-gray-900">—</p>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Item will be brought to</p>
                                <p id="gpDetailDestination" class="mt-2 text-[15px] font-semibold text-gray-900">—</p>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Remarks</p>
                                <p id="gpDetailRemarks" class="mt-2 text-[15px] font-semibold text-gray-900 whitespace-pre-line">—</p>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Rejection Reason</p>
                                <p id="gpDetailRejectionReason" class="mt-2 text-[15px] font-semibold text-gray-900 whitespace-pre-line">—</p>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Rejected By</p>
                                <div class="mt-2">
                                    <span
                                        id="gpDetailRejectedByGuard"
                                        class="inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold bg-gray-100 text-gray-800 border border-gray-200"
                                    >—</span>
                                </div>
                            </div>
                        </div>
                    </div>

            <div class="md:col-span-2">
                <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4">
                    <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-3">Items</p>
                    <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-[12px] font-semibold text-gray-600 uppercase tracking-wide">#</th>
                                <th class="px-4 py-3 text-[12px] font-semibold text-gray-600 uppercase tracking-wide">Item</th>
                                <th class="px-4 py-3 text-[12px] font-semibold text-gray-600 uppercase tracking-wide">Property No.</th>
                            </tr>
                            </thead>
                            <tbody id="gpDetailItemsBody" class="divide-y divide-gray-100">
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-[14px] text-gray-400">No items.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                </div>

                <div class="border-t border-gray-200 pt-6 mt-8 flex justify-end">
                    <button type="button" onclick="closeGatepassDetailsModal()" class="px-6 sm:px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[15px] font-semibold text-black hover:bg-gray-50 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Take Actions Modal (Rejected only) -->
    <div id="takeActionsModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[680px] bg-white rounded-[18px] shadow-2xl overflow-hidden border border-gray-200">
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[24px] font-bold text-[#003b95]">Take Actions</h2>
                <button
                    type="button"
                    onclick="closeTakeActionsModal()"
                    class="text-[#98a2b3] hover:text-black text-[28px] leading-none"
                    aria-label="Close"
                >
                    ×
                </button>
            </div>

            <div class="px-7 py-6 max-h-[78vh] overflow-y-auto">
                <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4">
                    <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Gate Pass No.</p>
                    <p id="takeActionsGatepassNo" class="mt-2 text-[16px] font-semibold text-gray-900">—</p>
                </div>

                <div class="mt-5">
                    <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2">Remarks</p>
                    <textarea
                        id="takeActionsRemarks"
                        rows="5"
                        placeholder="Enter remarks..."
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
                    ></textarea>
                </div>

                <div class="border-t border-gray-200 pt-6 mt-8 flex justify-end gap-4">
                    <button
                        type="button"
                        onclick="closeTakeActionsModal()"
                        class="px-6 sm:px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[15px] font-semibold text-black hover:bg-gray-50 transition"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        onclick="confirmTakeActions()"
                        class="px-6 sm:px-10 h-[46px] rounded-xl bg-[#f6b400] hover:bg-[#e5a900] text-black text-[15px] font-semibold transition"
                    >
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Confirmation Modal -->
    <div id="rejectConfirmationModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[560px] bg-white rounded-[18px] shadow-2xl overflow-hidden border border-gray-200">
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[24px] font-bold text-[#003b95]">Reject Request</h2>
                <button
                    type="button"
                    onclick="closeRejectConfirmationModal()"
                    class="text-[#98a2b3] hover:text-black text-[28px] leading-none"
                    aria-label="Close"
                >
                    ×
                </button>
            </div>

            <div class="px-7 py-6">
                <p class="text-[15px] text-gray-700">
                    Are you sure you want to reject this gate pass request?
                </p>

                <div class="mt-5 rounded-2xl border border-gray-200 bg-white px-5 py-4">
                    <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2">Gate Pass No.</p>
                    <p id="rejectConfirmationGatepassNo" class="text-[16px] font-semibold text-gray-900">—</p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6 mt-8 flex justify-end gap-4 px-7 pb-7">
                <button
                    type="button"
                    onclick="closeRejectConfirmationModal()"
                    class="px-6 sm:px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[15px] font-semibold text-black hover:bg-gray-50 transition"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="rejectConfirmationConfirmBtn"
                    onclick="confirmRejectGatepass()"
                    class="px-6 sm:px-10 h-[46px] rounded-xl bg-red-600 hover:bg-red-700 text-white text-[15px] font-semibold transition"
                >
                    Reject
                </button>
            </div>
        </div>
    </div>

    <!-- Audit Trails Modal -->
    <div id="auditTrailsModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[980px] bg-white rounded-[18px] shadow-2xl overflow-hidden border border-gray-200">
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[24px] font-bold text-[#003b95]">Audit Trails</h2>
                <button
                    type="button"
                    onclick="closeAuditTrailsModal()"
                    class="text-[#98a2b3] hover:text-black text-[28px] leading-none"
                    aria-label="Close"
                >
                    ×
                </button>
            </div>

            <div class="px-7 py-6 max-h-[78vh] overflow-hidden">
                <div class="space-y-5">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p id="auditItemTitle" class="text-[14px] font-semibold text-gray-900 truncate">—</p>
                                <p id="auditItemSerial" class="mt-2 text-[13px] text-gray-600 whitespace-nowrap">—</p>
                            </div>
                            <span
                                id="auditItemCurrentPropBadge"
                                class="inline-flex items-center px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-[12px] font-semibold text-gray-800 whitespace-nowrap"
                            >
                                Current Prop No: —
                            </span>
                        </div>

                        <div class="mt-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Select Item</p>
                                <select
                                    id="auditItemSelect"
                                    onchange="handleAuditItemSelectChange()"
                                    class="w-full sm:w-auto h-[42px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none focus:ring-1 focus:ring-blue-600"
                                >
                                    <option value="">—</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            <button type="button" data-audit-tab="property" onclick="setAuditTrailsTab('property')" class="auditTabBtn px-4 py-2 rounded-xl bg-[#003b95] text-white text-[14px] font-semibold">
                                Property No History
                            </button>
                            <button type="button" data-audit-tab="remarks" onclick="setAuditTrailsTab('remarks')" class="auditTabBtn px-4 py-2 rounded-xl bg-white text-[#003b95] border border-[#003b95]/30 hover:bg-[#003b95]/10 text-[14px] font-semibold">
                                Remarks History
                            </button>
                            <button type="button" data-audit-tab="end_user" onclick="setAuditTrailsTab('end_user')" class="auditTabBtn px-4 py-2 rounded-xl bg-white text-[#003b95] border border-[#003b95]/30 hover:bg-[#003b95]/10 text-[14px] font-semibold">
                                End User History
                            </button>
                            <button type="button" data-audit-tab="unit_cost" onclick="setAuditTrailsTab('unit_cost')" class="auditTabBtn px-4 py-2 rounded-xl bg-white text-[#003b95] border border-[#003b95]/30 hover:bg-[#003b95]/10 text-[14px] font-semibold">
                                Unit Cost History
                            </button>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-4 overflow-y-auto max-h-[280px]" id="auditTabContent">
                            <div class="text-[14px] text-gray-400">Select an item to view audit trails.</div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-4">
                        <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-3">Incoming / Outgoing History</p>
                        <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white max-h-[200px] overflow-y-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-[12px] font-semibold text-gray-600 uppercase tracking-wide">Type</th>
                                    <th class="px-4 py-3 text-[12px] font-semibold text-gray-600 uppercase tracking-wide">Date/Time</th>
                                    <th class="px-4 py-3 text-[12px] font-semibold text-gray-600 uppercase tracking-wide">Guard</th>
                                    <th class="px-4 py-3 text-[12px] font-semibold text-gray-600 uppercase tracking-wide">Requester</th>
                                    <th class="px-4 py-3 text-[12px] font-semibold text-gray-600 uppercase tracking-wide">Remarks</th>
                                </tr>
                                </thead>
                                <tbody id="auditInOutBody" class="divide-y divide-gray-100">
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-[14px] text-gray-400">No history.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $adminGatepassSnippet = file_get_contents(resource_path('views/partials/coordinator-gatepass-employee-snippet.js'));
        $adminGatepassSnippet = str_replace(
            "{{ route('employee.gatepass-requests.dashboard') }}",
            route('employee.gatepass-requests.dashboard'),
            $adminGatepassSnippet
        );
        $adminGatepassSnippet = str_replace(
            "{{ route('employee.gatepass-requests.history') }}",
            route('employee.gatepass-requests.history'),
            $adminGatepassSnippet
        );
        $adminGatepassSnippet = str_replace(
            "{{ route('employee.gatepass-requests.show', ['gatepass_no' => '__GP__']) }}",
            route('employee.gatepass-requests.show', ['gatepass_no' => '__GP__']),
            $adminGatepassSnippet
        );
        $adminGatepassSnippet = str_replace(
            "{{ asset('storage') }}",
            asset('storage'),
            $adminGatepassSnippet
        );
    @endphp
    <script>
        {!! $adminGatepassSnippet !!}
    </script>

    <script>
        let nextGatePassNumber = 'GP2601';

        function incrementGatePassNumber(currentValue) {
            const s = String(currentValue ?? '').trim();
            const match = s.match(/(\d+)$/);
            const currentNumeric = match ? parseInt(match[1], 10) : 2601;
            return 'GP' + (currentNumeric + 1);
        }

        const adminGatepassShowUrlTemplate = "{{ route('admin.gatepass-requests.show', ['gatepassNo' => '__GP__']) }}";
        const adminGatepassStoreQrUrlTemplate = "{{ route('admin.gatepass-requests.store-qr-code', ['gatepassNo' => '__GP__']) }}";

        (function setupGatepassDashboardLiveFilter() {
            const form = document.getElementById('gatepassDashboardFilterForm');
            const qInput = document.getElementById('gp_q');
            const statusSelect = document.getElementById('gp_status');

            if (!form || !qInput || !statusSelect) {
                return;
            }

            let debounceTimer = null;
            const debounceMs = 350;

            function clearDebounce() {
                if (debounceTimer !== null) {
                    clearTimeout(debounceTimer);
                    debounceTimer = null;
                }
            }

            function submitFilterForm() {
                clearDebounce();
                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            }

            qInput.addEventListener('input', function () {
                clearDebounce();
                debounceTimer = setTimeout(submitFilterForm, debounceMs);
            });

            statusSelect.addEventListener('change', function () {
                submitFilterForm();
            });
        }());

        const navDashboard = document.getElementById('navDashboard');
        const navGatepassRequest = document.getElementById('navGatepassRequest');
        const navGatepassHistory = document.getElementById('navGatepassHistory');
        const navAdminItemsTracker = document.getElementById('navAdminItemsTracker');
        const navAdminInventoryPortal = document.getElementById('navAdminInventoryPortal');
        const navReports = document.getElementById('navReports');

        const gatepassEmployeePanel = document.getElementById('gatepassEmployeePanel');
        const adminGatepassOverviewSection = document.getElementById('adminGatepassOverviewSection');
        const reportsSection = document.getElementById('reportsSection');
        const coordinatorWorkspaceDashboardSection = document.getElementById('dashboardSection');
        const coordinatorWorkspaceInventorySection = document.getElementById('inventoryPortalSection');

        const pageTitle = document.getElementById('pageTitle');
        const pageSubtitle = document.getElementById('pageSubtitle');

        const adminNavButtons = [navDashboard, navGatepassRequest, navGatepassHistory, navAdminItemsTracker, navAdminInventoryPortal, navReports].filter(Boolean);

        function hideCoordinatorWorkspaceSections() {
            if (coordinatorWorkspaceDashboardSection) {
                coordinatorWorkspaceDashboardSection.classList.add('hidden');
            }
            if (coordinatorWorkspaceInventorySection) {
                coordinatorWorkspaceInventorySection.classList.add('hidden');
            }
        }

        function setActiveAdminNav(activeButton) {
            adminNavButtons.forEach(function (btn) {
                if (btn === activeButton) {
                    btn.classList.add('bg-[#47698f]', 'text-white');
                    btn.classList.remove('text-white/90', 'hover:bg-white/10');
                } else {
                    btn.classList.remove('bg-[#47698f]', 'text-white');
                    btn.classList.add('text-white/90', 'hover:bg-white/10');
                }
            });
        }

        function showDashboardSection() {
            hideCoordinatorWorkspaceSections();
            if (gatepassEmployeePanel) {
                gatepassEmployeePanel.classList.add('hidden');
            }

            adminGatepassOverviewSection.classList.remove('hidden');
            reportsSection.classList.add('hidden');

            pageTitle.textContent = 'Dashboard';
            pageSubtitle.textContent = 'Manage gate pass requests and approvals';
            pageSubtitle.classList.remove('hidden');

            setActiveAdminNav(navDashboard);

            if (window.location.hash === '#gatepass-request' || window.location.hash === '#gatepass-history') {
                window.history.replaceState(null, '', window.location.pathname + window.location.search);
            }
        }

        function showAdminGatepassRequestSection() {
            hideCoordinatorWorkspaceSections();
            if (gatepassEmployeePanel) {
                gatepassEmployeePanel.classList.remove('hidden');
            }

            adminGatepassOverviewSection.classList.add('hidden');
            reportsSection.classList.add('hidden');

            pageSubtitle.textContent = 'My gate pass requests';
            pageSubtitle.classList.remove('hidden');

            if (typeof window.coordinatorGatepassLazyInit === 'function') {
                window.coordinatorGatepassLazyInit();
            }

            if (typeof window.coordinatorGpShowMyRequestsPanel === 'function') {
                window.coordinatorGpShowMyRequestsPanel();
            }

            setActiveAdminNav(navGatepassRequest);

            if (window.location.hash !== '#gatepass-request') {
                window.history.replaceState(null, '', '#gatepass-request');
            }
        }

        function showAdminGatepassHistorySection() {
            hideCoordinatorWorkspaceSections();
            if (gatepassEmployeePanel) {
                gatepassEmployeePanel.classList.remove('hidden');
            }

            adminGatepassOverviewSection.classList.add('hidden');
            reportsSection.classList.add('hidden');

            pageSubtitle.textContent = 'Request history';
            pageSubtitle.classList.remove('hidden');

            if (typeof window.coordinatorGatepassLazyInit === 'function') {
                window.coordinatorGatepassLazyInit();
            }

            if (typeof window.coordinatorGpShowHistoryPanel === 'function') {
                window.coordinatorGpShowHistoryPanel();
            }

            setActiveAdminNav(navGatepassHistory);

            if (window.location.hash !== '#gatepass-history') {
                window.history.replaceState(null, '', '#gatepass-history');
            }
        }

        function showReportsSection() {
            hideCoordinatorWorkspaceSections();
            if (gatepassEmployeePanel) {
                gatepassEmployeePanel.classList.add('hidden');
            }

            adminGatepassOverviewSection.classList.add('hidden');
            reportsSection.classList.remove('hidden');

            pageTitle.textContent = 'Reports';
            pageSubtitle.textContent = '';
            pageSubtitle.classList.add('hidden');

            setActiveAdminNav(navReports);
            initReportsAnalyticsIfNeeded();
        }

        function showAdminItemsTrackerWorkspace() {
            hideCoordinatorWorkspaceSections();

            if (typeof window.cwsShowItemsTrackerHome === 'function') {
                window.cwsShowItemsTrackerHome();
            } else {
                if (adminGatepassOverviewSection) {
                    adminGatepassOverviewSection.classList.add('hidden');
                }
                if (reportsSection) {
                    reportsSection.classList.add('hidden');
                }
                if (gatepassEmployeePanel) {
                    gatepassEmployeePanel.classList.add('hidden');
                }
                const embedded = document.getElementById('dashboardSection');
                if (embedded) {
                    embedded.classList.remove('hidden');
                }
            }

            pageTitle.textContent = 'Items Tracker';
            pageSubtitle.textContent = 'List of Inventory';
            pageSubtitle.classList.remove('hidden');
        }

        function showAdminInventoryPortalWorkspace() {
            hideCoordinatorWorkspaceSections();

            if (typeof window.cwsShowInventoryPortal === 'function') {
                window.cwsShowInventoryPortal();
            } else {
                if (adminGatepassOverviewSection) {
                    adminGatepassOverviewSection.classList.add('hidden');
                }
                if (reportsSection) {
                    reportsSection.classList.add('hidden');
                }
                if (gatepassEmployeePanel) {
                    gatepassEmployeePanel.classList.add('hidden');
                }
                const embedded = document.getElementById('inventoryPortalSection');
                if (embedded) {
                    embedded.classList.remove('hidden');
                }
            }

            pageTitle.textContent = 'Asset Inventory Management';
            pageSubtitle.textContent = 'Manage all equipment inventory';
            pageSubtitle.classList.remove('hidden');
        }

        navDashboard.addEventListener('click', showDashboardSection);
        if (navGatepassRequest) {
            navGatepassRequest.addEventListener('click', showAdminGatepassRequestSection);
        }
        if (navGatepassHistory) {
            navGatepassHistory.addEventListener('click', showAdminGatepassHistorySection);
        }
        if (navAdminItemsTracker) {
            navAdminItemsTracker.addEventListener('click', function () {
                showAdminItemsTrackerWorkspace();
                setActiveAdminNav(navAdminItemsTracker);
            });
        }
        if (navAdminInventoryPortal) {
            navAdminInventoryPortal.addEventListener('click', function () {
                showAdminInventoryPortalWorkspace();
                setActiveAdminNav(navAdminInventoryPortal);
            });
        }
        navReports.addEventListener('click', showReportsSection);

        function openNewGatePassModal() {
            const modal = document.getElementById('newGatePassModal');
            const gatePassInput = document.getElementById('gatePassNoField');
            const form = document.getElementById('newGatePassForm');

            if (form) {
                form.reset();
            }

            clearNewGatePassErrors();
            resetSelectedEquipmentTable();

            if (gatePassInput) {
                gatePassInput.value = nextGatePassNumber;
            }

            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeNewGatePassModal() {
            const modal = document.getElementById('newGatePassModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function clearNewGatePassErrors() {
            const errorIds = ['purposeError', 'broughtToError', 'equipmentError'];
            errorIds.forEach(function (id) {
                const el = document.getElementById(id);
                if (el) {
                    el.classList.add('hidden');
                }
            });
        }

        function resetSelectedEquipmentTable() {
            const tbody = document.getElementById('selectedEquipmentBody');
            const noRow = document.getElementById('noEquipmentRow');
            if (tbody && noRow) {
                tbody.innerHTML = '';
                tbody.appendChild(noRow);
            }
        }

        function addSelectedEquipment() {
            const select = document.getElementById('equipmentSelect');
            const tbody = document.getElementById('selectedEquipmentBody');
            const noRow = document.getElementById('noEquipmentRow');
            const equipmentError = document.getElementById('equipmentError');

            if (!select || !tbody || !noRow) {
                return;
            }

            const value = select.value;
            const label = select.options[select.selectedIndex]?.text || '';

            if (!value) {
                if (equipmentError) {
                    equipmentError.textContent = 'Please select equipment before adding.';
                    equipmentError.classList.remove('hidden');
                }
                return;
            }

            if (equipmentError) {
                equipmentError.classList.add('hidden');
            }

            if (noRow.parentElement === tbody) {
                tbody.removeChild(noRow);
            }

            const index = tbody.children.length + 1;
            const tr = document.createElement('tr');

            tr.innerHTML = ''
                + '<td class="px-4 py-3 text-[14px] text-gray-700">' + index + '</td>'
                + '<td class="px-4 py-3 text-[14px] text-gray-800">' + label + '</td>'
                + '<td class="px-4 py-3 text-right">'
                + '  <button type="button" class="text-red-500 text-[14px] font-semibold" onclick="removeSelectedEquipment(this)">Remove</button>'
                + '</td>';

            tbody.appendChild(tr);
            select.value = '';
        }

        function removeSelectedEquipment(button) {
            const row = button.closest('tr');
            const tbody = document.getElementById('selectedEquipmentBody');
            const noRow = document.getElementById('noEquipmentRow');

            if (!row || !tbody || !noRow) {
                return;
            }

            tbody.removeChild(row);

            if (tbody.children.length === 0) {
                tbody.appendChild(noRow);
            } else {
                Array.from(tbody.children).forEach(function (tr, idx) {
                    const cell = tr.querySelector('td');
                    if (cell) {
                        cell.textContent = idx + 1;
                    }
                });
            }
        }

        function validateNewGatePassForm() {
            const purpose = document.getElementById('purposeField');
            const broughtTo = document.getElementById('broughtToField');
            const tbody = document.getElementById('selectedEquipmentBody');
            const noRow = document.getElementById('noEquipmentRow');

            const purposeError = document.getElementById('purposeError');
            const broughtToError = document.getElementById('broughtToError');
            const equipmentError = document.getElementById('equipmentError');

            let valid = true;

            if (!purpose || !purpose.value.trim()) {
                if (purposeError) {
                    purposeError.classList.remove('hidden');
                }
                valid = false;
            } else if (purposeError) {
                purposeError.classList.add('hidden');
            }

            if (!broughtTo || !broughtTo.value.trim()) {
                if (broughtToError) {
                    broughtToError.classList.remove('hidden');
                }
                valid = false;
            } else if (broughtToError) {
                broughtToError.classList.add('hidden');
            }

            if (!tbody || !noRow) {
                return valid;
            }

            const hasEquipment = !(tbody.children.length === 1 && tbody.children[0] === noRow);

            if (!hasEquipment) {
                if (equipmentError) {
                    equipmentError.textContent = 'Please add at least one equipment.';
                    equipmentError.classList.remove('hidden');
                }
                valid = false;
            } else if (equipmentError) {
                equipmentError.classList.add('hidden');
            }

            return valid;
        }

        function adminClearProfileFormMessages() {
            const fieldErrorIds = [
                'adminProfileErrorEmployeeName',
                'adminProfileErrorCenter',
                'adminProfileErrorEmail',
                'adminProfileErrorCurrentPassword',
                'adminProfileErrorPassword',
                'adminProfileErrorPasswordConfirmation',
            ];

            for (const id of fieldErrorIds) {
                const el = document.getElementById(id);
                if (el) {
                    el.textContent = '';
                    el.classList.add('hidden');
                }
            }

            const successEl = document.getElementById('adminProfileAlertSuccess');
            const errorEl = document.getElementById('adminProfileAlertError');

            if (successEl) {
                successEl.textContent = '';
                successEl.classList.add('hidden');
            }

            if (errorEl) {
                errorEl.textContent = '';
                errorEl.classList.add('hidden');
            }
        }

        function adminShowProfileTopError(message) {
            const errorEl = document.getElementById('adminProfileAlertError');
            const successEl = document.getElementById('adminProfileAlertSuccess');

            if (successEl) {
                successEl.classList.add('hidden');
            }

            if (errorEl) {
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
            }
        }

        function adminShowProfileSuccess(message) {
            const successEl = document.getElementById('adminProfileAlertSuccess');
            const errorEl = document.getElementById('adminProfileAlertError');

            if (errorEl) {
                errorEl.classList.add('hidden');
            }

            if (successEl) {
                successEl.textContent = message;
                successEl.classList.remove('hidden');
            }
        }

        function adminShowProfileValidationErrors(errors) {
            if (!errors || typeof errors !== 'object') {
                return;
            }

            const map = {
                employee_name: 'adminProfileErrorEmployeeName',
                center: 'adminProfileErrorCenter',
                email: 'adminProfileErrorEmail',
                current_password: 'adminProfileErrorCurrentPassword',
                password: 'adminProfileErrorPassword',
                password_confirmation: 'adminProfileErrorPasswordConfirmation',
            };

            for (const [key, elId] of Object.entries(map)) {
                const msgs = errors[key];
                if (!Array.isArray(msgs) || msgs.length === 0) {
                    continue;
                }

                const el = document.getElementById(elId);
                if (el) {
                    el.textContent = msgs[0];
                    el.classList.remove('hidden');
                }
            }
        }

        function adminWireProfileForm() {
            const form = document.getElementById('adminProfileForm');
            if (!form) {
                return;
            }

            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                adminClearProfileFormMessages();

                const submitBtn = document.getElementById('adminProfileSubmitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                }

                const action = form.getAttribute('action') || '';
                const formData = new FormData(form);

                try {
                    const response = await fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            Accept: 'application/json',
                        },
                        body: formData,
                    });

                    let data = {};
                    try {
                        data = await response.json();
                    } catch (parseErr) {
                        data = {};
                    }

                    if (response.status === 422 && data.errors) {
                        adminShowProfileValidationErrors(data.errors);
                        adminShowProfileTopError(data.message || 'Please correct the errors below.');
                        return;
                    }

                    if (!response.ok) {
                        adminShowProfileTopError(data.message || 'Unable to update profile. Please try again.');
                        return;
                    }

                    adminShowProfileSuccess(data.message || 'Profile updated successfully.');
                    showToast(data.message || 'Profile updated successfully.', 'success');

                    if (data.data) {
                        const nameInput = document.getElementById('profileEmployeeName');
                        const centerInput = document.getElementById('profileCenter');
                        const emailInput = document.getElementById('profileEmail');

                        if (nameInput) nameInput.value = data.data.employee_name || '';
                        if (centerInput) centerInput.value = data.data.center || '';
                        if (emailInput) emailInput.value = data.data.email || '';
                    }

                    const cur = document.getElementById('profileCurrentPassword');
                    const neu = document.getElementById('profileNewPassword');
                    const conf = document.getElementById('profilePasswordConfirmation');

                    if (cur) cur.value = '';
                    if (neu) neu.value = '';
                    if (conf) conf.value = '';
                } catch (err) {
                    adminShowProfileTopError('Network error. Please try again.');
                } finally {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                    }
                }
            });
        }

        adminWireProfileForm();

        function openAdminProfileModal() {
            const modal = document.getElementById('adminProfileModal');
            adminClearProfileFormMessages();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeAdminProfileModal() {
            const modal = document.getElementById('adminProfileModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('adminProfileModal');
            if (e.target === modal) {
                closeAdminProfileModal();
            }
        });

        function openMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileSidebarOverlay');
            if (!sidebar || !overlay) return;

            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            sidebar.setAttribute('aria-hidden', 'false');
            document.body.classList.add('overflow-hidden');
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileSidebarOverlay');
            if (!sidebar || !overlay) return;

            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
            sidebar.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('overflow-hidden');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            closeMobileSidebar();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const openBtn = document.getElementById('mobileSidebarOpenBtn');
            const closeBtn = document.getElementById('mobileSidebarCloseBtn');
            const overlay = document.getElementById('mobileSidebarOverlay');
            const sidebar = document.getElementById('mobileSidebar');

            if (openBtn) openBtn.addEventListener('click', openMobileSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeMobileSidebar);
            if (overlay) overlay.addEventListener('click', closeMobileSidebar);

            if (sidebar) {
                sidebar.querySelectorAll('button[data-mobile-nav]').forEach(function (el) {
                    el.addEventListener('click', function () {
                        const kind = el.getAttribute('data-mobile-nav');
                        if (kind === 'items-tracker') {
                            showAdminItemsTrackerWorkspace();
                        } else if (kind === 'inventory-portal') {
                            showAdminInventoryPortalWorkspace();
                        } else if (kind === 'dashboard') {
                            showDashboardSection();
                        } else if (kind === 'gatepass-request') {
                            showAdminGatepassRequestSection();
                        } else if (kind === 'gatepass-history') {
                            showAdminGatepassHistorySection();
                        } else if (kind === 'reports') {
                            showReportsSection();
                        }
                        closeMobileSidebar();
                    });
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const params = new URLSearchParams(window.location.search);
            const cw = params.get('cw');
            if (window.location.hash === '#gatepass-history') {
                showAdminGatepassHistorySection();
            } else if (window.location.hash === '#gatepass-request') {
                showAdminGatepassRequestSection();
            } else if (cw === 'inventory') {
                showAdminInventoryPortalWorkspace();
            } else if (cw === 'items') {
                showAdminItemsTrackerWorkspace();
            } else {
                showDashboardSection();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('newGatePassForm');
            if (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    if (validateNewGatePassForm()) {
                        nextGatePassNumber = incrementGatePassNumber(nextGatePassNumber);
                        closeNewGatePassModal();
                        alert('Gate pass request is valid and ready to be submitted.');
                    }
                });
            }
        });

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }

        function statusBadgeClasses(status) {
            const s = String(status || '').trim().toLowerCase();
            if (s === 'approved') return 'bg-green-100 text-green-800 border border-green-200';
            if (s === 'rejected') return 'bg-red-100 text-red-800 border border-red-200';
            if (s === 'pending') return 'bg-yellow-100 text-yellow-800 border border-yellow-200';
            if (s === 'returned') return 'bg-gray-100 text-gray-800 border border-gray-200';
            if (s === 'active outside') return 'bg-blue-100 text-blue-800 border border-blue-200';
            return 'bg-gray-100 text-gray-800 border border-gray-200';
        }

        function showToast(message, type) {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const kind = String(type || '').toLowerCase();
            const base = 'toast pointer-events-auto w-[340px] max-w-[calc(100vw-48px)] rounded-2xl border px-5 py-4 shadow-xl bg-white';
            let tone = 'border-blue-200';
            let icon = '<i class="fa-solid fa-circle-info text-[#003b95]"></i>';
            let title = 'Info';

            if (kind === 'success') {
                tone = 'border-green-200';
                icon = '<i class="fa-solid fa-circle-check text-green-600"></i>';
                title = 'Success';
            } else if (kind === 'error') {
                tone = 'border-red-200';
                icon = '<i class="fa-solid fa-circle-xmark text-red-600"></i>';
                title = 'Error';
            }

            const el = document.createElement('div');
            el.className = base + ' ' + tone;
            el.innerHTML =
                '<div class="flex items-start gap-3">' +
                '  <div class="mt-[2px] text-[18px]">' + icon + '</div>' +
                '  <div class="min-w-0">' +
                '    <p class="text-[14px] font-semibold text-gray-900">' + title + '</p>' +
                '    <p class="mt-1 text-[14px] text-gray-700 break-words">' + escapeHtml(message || '') + '</p>' +
                '  </div>' +
                '  <button type="button" class="ml-auto text-gray-400 hover:text-gray-700 text-[18px] leading-none" aria-label="Close">×</button>' +
                '</div>';

            const closeBtn = el.querySelector('button');
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    hideToast(el);
                });
            }

            container.appendChild(el);
            requestAnimationFrame(function () {
                el.classList.add('toast-show');
            });

            window.setTimeout(function () {
                hideToast(el);
            }, 3000);
        }

        function hideToast(el) {
            if (!el) return;
            el.classList.remove('toast-show');
            window.setTimeout(function () {
                el.remove();
            }, 220);
        }

        function updateRowStatus(gatepassNo, newStatus) {
            const badge = document.getElementById('statusBadge-' + gatepassNo);
            if (!badge) return;

            badge.textContent = newStatus;
            badge.dataset.status = newStatus;
            badge.className = 'inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold ' + statusBadgeClasses(newStatus);

            const row = document.getElementById('gatepassRow-' + gatepassNo);
            if (!row) return;

            const newStatusLower = String(newStatus || '').trim().toLowerCase();
            const approveBtn = row.querySelector('button[onclick="approveGatepass(this)"]');
            const rejectBtn = row.querySelector('button[onclick="rejectGatepass(this)"]');
            const takeActionsBtn = row.querySelector('button[data-action="take-actions"]');
            const rejectActionBtn = row.querySelector('button[data-action="reject-action"]');

            // For rejected status, only show "Take Actions" + "View".
            if (approveBtn) approveBtn.classList.toggle('!hidden', newStatusLower === 'rejected');
            if (approveBtn) approveBtn.disabled = newStatusLower === 'approved';
            if (rejectBtn) rejectBtn.disabled = newStatusLower === 'rejected';

            // Toggle between "Take Actions" and the normal reject button.
            if (takeActionsBtn) takeActionsBtn.classList.toggle('!hidden', newStatusLower !== 'rejected');
            if (rejectActionBtn) rejectActionBtn.classList.toggle('!hidden', newStatusLower === 'rejected');
        }

        function normalizeStatus(value) {
            return String(value || '').trim().toLowerCase();
        }

        function isActiveOutsideStatus(value) {
            const s = normalizeStatus(value);
            return s === 'active outside' || s === 'released outside';
        }

        function updateCardCount(elId, delta) {
            const el = document.getElementById(elId);
            if (!el) return;
            const current = parseInt(String(el.textContent || '0').replace(/[^\d-]/g, ''), 10) || 0;
            const next = Math.max(0, current + (delta || 0));
            el.textContent = String(next);
        }

        function updateCardsForStatusChange(oldStatus, newStatus) {
            const oldS = normalizeStatus(oldStatus);
            const newS = normalizeStatus(newStatus);
            if (oldS === newS) return;

            if (oldS === 'pending') updateCardCount('cardPendingCount', -1);
            if (newS === 'pending') updateCardCount('cardPendingCount', 1);

            if (oldS === 'approved') updateCardCount('cardApprovedCount', -1);
            if (newS === 'approved') updateCardCount('cardApprovedCount', 1);

            if (isActiveOutsideStatus(oldStatus)) updateCardCount('cardActiveOutsideCount', -1);
            if (isActiveOutsideStatus(newStatus)) updateCardCount('cardActiveOutsideCount', 1);
        }

        async function generateAndSaveGatepassQrCode(gatepassNo) {
            const showUrl = adminGatepassShowUrlTemplate.replace('__GP__', encodeURIComponent(gatepassNo));
            const storeUrl = adminGatepassStoreQrUrlTemplate.replace('__GP__', encodeURIComponent(gatepassNo));

            const res = await fetch(showUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            const payload = await res.json().catch(() => ({}));
            if (!res.ok) {
                throw new Error(payload?.message || 'Failed to load gate pass details.');
            }

            const data = payload?.data || {};
            const items = Array.isArray(data.items) ? data.items : [];

            // Encode the full gate pass data (including all items) into the QR content.
            const qrPayload = {
                gatepass_no: data.gatepass_no || gatepassNo,
                request_date: data.request_date || null,
                requester_name: data.requester_name || null,
                center_office: data.center || null,
                purpose: data.purpose || null,
                destination: data.destination || null,
                status: data.status || null,
                remarks: data.remarks || null,
                items: items.map(function (it) {
                    return {
                        order: it.order ?? null,
                        property_number: it.prop_no ?? null,
                        description: it.description ?? null,
                        serial_number: it.serial_no ?? null,
                        item_remarks: it.item_remarks ?? null,
                        inventory_id: it.inventory_id ?? null,
                        gatepass_item_id: it.gatepass_item_id ?? null,
                    };
                }),
            };

            const saveRes = await fetch(storeUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    qr_payload: qrPayload,
                }),
            });

            const savePayload = await saveRes.json().catch(() => ({}));

            if (!saveRes.ok) {
                throw new Error(savePayload?.message || 'Failed to save QR code.');
            }
        }

        async function approveGatepass(button) {
            const url = button?.dataset?.url;
            const gatepassNo = button?.dataset?.gatepassNo;
            if (!url || !gatepassNo) return;

            button.disabled = true;
            try {
                const oldStatus = document.getElementById('statusBadge-' + gatepassNo)?.dataset?.status;
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                });
                const payload = await res.json().catch(() => ({}));

                if (!res.ok) {
                    showToast(payload?.message || 'Failed to approve request.', 'error');
                    button.disabled = false;
                    return;
                }

                const newStatus = payload?.data?.status || 'Approved';
                updateRowStatus(gatepassNo, newStatus);
                updateCardsForStatusChange(oldStatus, newStatus);
                showToast(payload?.message || 'Approved successfully.', 'success');

                // Best-effort QR generation + save. Employee UI also has fallback generation.
                if (String(newStatus || '').toLowerCase() === 'approved') {
                    try {
                        await generateAndSaveGatepassQrCode(gatepassNo);
                    } catch (qrErr) {
                        showToast(
                            qrErr?.message || 'Approved, but QR code generation/save failed.',
                            'error'
                        );
                    }
                }
            } catch (e) {
                showToast('Failed to approve request.', 'error');
                button.disabled = false;
            }
        }

        let rejectConfirmationContext = {
            button: null,
            url: '',
            gatepassNo: '',
        };

        function openRejectConfirmationModal(button) {
            const url = button?.dataset?.url;
            const gatepassNo = button?.dataset?.gatepassNo;
            if (!url || !gatepassNo) return;

            rejectConfirmationContext = {
                button: button || null,
                url: url,
                gatepassNo: gatepassNo,
            };

            const modal = document.getElementById('rejectConfirmationModal');
            const gatepassNoEl = document.getElementById('rejectConfirmationGatepassNo');
            const confirmBtn = document.getElementById('rejectConfirmationConfirmBtn');

            if (confirmBtn) {
                confirmBtn.disabled = false;
            }

            if (rejectConfirmationContext.button) {
                rejectConfirmationContext.button.disabled = true;
            }

            if (gatepassNoEl) {
                gatepassNoEl.textContent = gatepassNo || '—';
            }

            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeRejectConfirmationModal(restoreButton) {
            if (restoreButton === undefined) {
                restoreButton = true;
            }

            const modal = document.getElementById('rejectConfirmationModal');
            if (!modal) return;

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');

            if (restoreButton && rejectConfirmationContext.button) {
                rejectConfirmationContext.button.disabled = false;
            }

            rejectConfirmationContext = {
                button: null,
                url: '',
                gatepassNo: '',
            };
        }

        async function confirmRejectGatepass() {
            const modal = document.getElementById('rejectConfirmationModal');
            const confirmBtn = document.getElementById('rejectConfirmationConfirmBtn');
            const ctx = rejectConfirmationContext || {};

            if (!ctx?.url || !ctx?.gatepassNo) {
                if (modal) {
                    closeRejectConfirmationModal(true);
                }
                return;
            }

            if (confirmBtn) {
                confirmBtn.disabled = true;
            }

            const buttonToRestore = ctx.button || null;

            try {
                const oldStatus = document.getElementById('statusBadge-' + ctx.gatepassNo)?.dataset?.status;
                const res = await fetch(ctx.url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                });
                const payload = await res.json().catch(() => ({}));

                if (!res.ok) {
                    showToast(payload?.message || 'Failed to reject request.', 'error');
                    if (buttonToRestore) buttonToRestore.disabled = false;
                    return;
                }

                const newStatus = payload?.data?.status || 'Rejected';
                updateRowStatus(ctx.gatepassNo, newStatus);
                updateCardsForStatusChange(oldStatus, newStatus);
                showToast(payload?.message || 'Rejected successfully.', 'success');

                // Status was updated successfully, so keep the original button disabled.
                rejectConfirmationContext = {
                    button: null,
                    url: '',
                    gatepassNo: '',
                };
                closeRejectConfirmationModal(false);
            } catch (e) {
                showToast('Failed to reject request.', 'error');
                if (buttonToRestore) buttonToRestore.disabled = false;
                closeRejectConfirmationModal(true);
            }
        }

        function rejectGatepass(button) {
            openRejectConfirmationModal(button);
        }

        function openGatepassDetailsModal() {
            const modal = document.getElementById('gatepassDetailsModal');
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeGatepassDetailsModal() {
            const modal = document.getElementById('gatepassDetailsModal');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        function openTakeActionsModal(button) {
            const modal = document.getElementById('takeActionsModal');
            if (!modal) return;

            const gatepassNo = button?.dataset?.gatepassNo || '';
            const url = button?.dataset?.url;

            const gatepassNoEl = document.getElementById('takeActionsGatepassNo');
            const remarksEl = document.getElementById('takeActionsRemarks');

            if (gatepassNoEl) gatepassNoEl.textContent = gatepassNo || '—';
            if (remarksEl) remarksEl.value = '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');

            // Best-effort prefill with existing rejection reason.
            if (!url || !remarksEl) return;

            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(function (res) {
                    return res.json().catch(function () {
                        return {};
                    });
                })
                .then(function (payload) {
                    const d = payload?.data || {};
                    if (typeof d.rejection_reason === 'string' && remarksEl) {
                        remarksEl.value = d.rejection_reason || '';
                    }
                })
                .catch(function () {
                    // Ignore prefill errors; user can still type.
                });
        }

        function closeTakeActionsModal() {
            const modal = document.getElementById('takeActionsModal');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        function confirmTakeActions() {
            const remarksEl = document.getElementById('takeActionsRemarks');
            const modal = document.getElementById('takeActionsModal');

            const remarks = String(remarksEl?.value || '').trim();
            if (!remarks) {
                showToast('Please enter remarks before saving.', 'error');
                return;
            }

            // UI-only confirmation (no backend call requested).
            showToast('Remarks captured.', 'success');
            closeTakeActionsModal();
        }

        // -----------------------------
        // Audit Trails Modal (UI only)
        // -----------------------------
        let auditTrailsData = null;
        let auditTrailsItems = [];
        let auditActiveTab = 'property';
        let auditSelectedItemIndex = 0;

        function openAuditTrailsModal(button) {
            const url = button?.dataset?.url;
            if (!url) return;

            const modal = document.getElementById('auditTrailsModal');
            if (!modal) return;

            auditTrailsData = null;
            auditTrailsItems = [];
            auditActiveTab = 'property';
            auditSelectedItemIndex = 0;

            const select = document.getElementById('auditItemSelect');
            const titleEl = document.getElementById('auditItemTitle');
            const serialEl = document.getElementById('auditItemSerial');
            const propBadgeEl = document.getElementById('auditItemCurrentPropBadge');
            const tabContentEl = document.getElementById('auditTabContent');
            const inOutBodyEl = document.getElementById('auditInOutBody');

            if (select) select.innerHTML = '<option value="">—</option>';
            if (titleEl) titleEl.textContent = 'Loading...';
            if (serialEl) serialEl.textContent = '—';
            if (propBadgeEl) propBadgeEl.textContent = 'Current Prop No: —';
            if (tabContentEl) tabContentEl.innerHTML = '<div class="text-[14px] text-gray-400">Loading audit trails...</div>';
            if (inOutBodyEl) inOutBodyEl.innerHTML = '<tr><td colspan="5" class="px-4 py-6 text-center text-[14px] text-gray-400">Loading...</td></tr>';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');

            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(function (res) {
                    return res.json().catch(() => ({}));
                })
                .then(function (payload) {
                    const d = payload?.data || {};
                    auditTrailsData = d;
                    auditTrailsItems = Array.isArray(d.items) ? d.items : [];

                    if (select) {
                        select.innerHTML = '<option value="">—</option>' +
                            auditTrailsItems.map(function (it, idx) {
                                const label = it?.description ? it.description : (it?.serial_no ? it.serial_no : ('Item #' + (it?.order ?? idx + 1)));
                                const serial = it?.serial_no ? ' (Serial: ' + it.serial_no + ')' : '';
                                return '<option value="' + idx + '">' + escapeHtml(label + serial) + '</option>';
                            }).join('');
                        if (auditTrailsItems.length > 0) {
                            select.value = String(auditSelectedItemIndex);
                        }
                    }

                    renderAuditItemHeader();
                    setAuditTrailsTab('property');
                    renderAuditIncomingOutgoingHistory();
                })
                .catch(function () {
                    showToast('Failed to load audit trails.', 'error');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                });
        }

        function closeAuditTrailsModal() {
            const modal = document.getElementById('auditTrailsModal');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        function setAuditTrailsTab(tabKey) {
            auditActiveTab = tabKey;

            const tabButtons = Array.from(document.querySelectorAll('#auditTrailsModal .auditTabBtn'));
            tabButtons.forEach(function (btn) {
                const key = btn?.dataset?.auditTab;
                const isActive = key === auditActiveTab;
                if (isActive) {
                    btn.classList.add('bg-[#003b95]', 'text-white');
                    btn.classList.remove('bg-white', 'text-[#003b95]', 'border', 'border-[#003b95]/30', 'hover:bg-[#003b95]/10');
                } else {
                    btn.classList.add('bg-white', 'text-[#003b95]', 'border', 'border-[#003b95]/30');
                    btn.classList.remove('bg-[#003b95]', 'text-white');
                }
            });

            renderAuditTabContent();
        }

        function handleAuditItemSelectChange() {
            const select = document.getElementById('auditItemSelect');
            if (!select) return;

            const val = String(select.value || '');
            if (val === '') {
                auditSelectedItemIndex = 0;
            } else {
                const idx = parseInt(val, 10);
                auditSelectedItemIndex = Number.isFinite(idx) ? idx : 0;
            }

            renderAuditItemHeader();
            renderAuditTabContent();
        }

        function renderAuditItemHeader() {
            const titleEl = document.getElementById('auditItemTitle');
            const serialEl = document.getElementById('auditItemSerial');
            const propBadgeEl = document.getElementById('auditItemCurrentPropBadge');

            if (!auditTrailsItems.length) {
                if (titleEl) titleEl.textContent = '—';
                if (serialEl) serialEl.textContent = '—';
                if (propBadgeEl) propBadgeEl.textContent = 'Current Prop No: —';
                return;
            }

            const item = auditTrailsItems[auditSelectedItemIndex] || auditTrailsItems[0];
            const desc = item?.description || 'Item';
            const serial = item?.serial_no || '—';
            const propNo = item?.prop_no || '—';

            if (titleEl) titleEl.textContent = desc;
            if (serialEl) serialEl.textContent = 'Serial: ' + serial;
            if (propBadgeEl) propBadgeEl.textContent = 'Current Property No: ' + propNo;
        }

        function renderAuditTabContent() {
            const tabContentEl = document.getElementById('auditTabContent');
            if (!tabContentEl) return;

            if (!auditTrailsItems.length) {
                tabContentEl.innerHTML = '<div class="text-[14px] text-gray-400">No audit trails.</div>';
                return;
            }

            const item = auditTrailsItems[auditSelectedItemIndex] || auditTrailsItems[0];
            const eq = item?.equipment_history || {};

            const renderRows = function (rows, getValue, getDate, extraHtml) {
                if (!Array.isArray(rows) || rows.length === 0) {
                    return '<div class="text-[14px] text-gray-500">No records.</div>';
                }

                return rows.map(function (h) {
                    const value = getValue(h);
                    const at = getDate(h);
                    const extra = extraHtml ? extraHtml(h) : '';

                    return (
                        '<div class="flex items-start justify-between gap-4 rounded-xl border border-gray-100 bg-white px-3 py-2">' +
                        '  <div class="min-w-0">' +
                        '    <div class="flex items-center gap-2 min-w-0">' +
                        '      <span class="font-bold text-gray-900 text-[13px] break-words">' + escapeHtml(value) + '</span>' +
                        '      ' + extra +
                        '    </div>' +
                        '  </div>' +
                        '  <div class="text-right text-[12px] text-gray-500 whitespace-nowrap">' + escapeHtml(at) + '</div>' +
                        '</div>'
                    );
                }).join('');
            };

            let rowsHtml = '';
            if (auditActiveTab === 'property') {
                const propHist = Array.isArray(eq.prop_no_history) ? eq.prop_no_history : [];
                rowsHtml = renderRows(
                    propHist,
                    function (h) { return h.prop_no || '—'; },
                    function (h) { return h.changed_at || h.created_at || '—'; },
                    function (h) {
                        if (!h.is_current) return '';
                        return '<span class="inline-flex items-center px-2 py-[2px] rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200 whitespace-nowrap">Current</span>';
                    }
                );
            } else if (auditActiveTab === 'remarks') {
                const remarksHist = Array.isArray(eq.remarks_history) ? eq.remarks_history : [];
                rowsHtml = renderRows(
                    remarksHist,
                    function (h) { return h.remark_text || '—'; },
                    function (h) { return h.created_at || '—'; },
                    function () { return ''; }
                );
            } else if (auditActiveTab === 'end_user') {
                const endUserHist = Array.isArray(eq.end_user_history) ? eq.end_user_history : [];
                rowsHtml = renderRows(
                    endUserHist,
                    function (h) { return h.end_user || '—'; },
                    function (h) { return h.created_at || '—'; },
                    function () { return ''; }
                );
            } else if (auditActiveTab === 'unit_cost') {
                const unitCostHist = Array.isArray(eq.unit_cost_history) ? eq.unit_cost_history : [];
                rowsHtml = renderRows(
                    unitCostHist,
                    function (h) { return h.unit_cost !== undefined && h.unit_cost !== null ? String(h.unit_cost) : '—'; },
                    function (h) { return h.created_at || '—'; },
                    function () { return ''; }
                );
            } else {
                rowsHtml = '<div class="text-[14px] text-gray-400">Unknown tab.</div>';
            }

            tabContentEl.innerHTML = '<div class="space-y-2">' + rowsHtml + '</div>';
        }

        function renderAuditIncomingOutgoingHistory() {
            const bodyEl = document.getElementById('auditInOutBody');
            if (!bodyEl) return;

            const logs = Array.isArray(auditTrailsData?.incoming_outgoing_history)
                ? auditTrailsData.incoming_outgoing_history
                : [];

            if (!logs.length) {
                bodyEl.innerHTML = '<tr><td colspan="5" class="px-4 py-6 text-center text-[14px] text-gray-400">No history.</td></tr>';
                return;
            }

            bodyEl.innerHTML = logs.map(function (log) {
                const type = log.log_type || '—';
                const dt = log.log_datetime || '—';
                const guard = log.guard_name || log.guard_employee_id || log.scanned_by_guard_id || '—';
                const requester = log.requester_name || log.requester_employee_id || '—';
                const remarks = log.remarks || '—';

                return (
                    '<tr class="border-t border-gray-100">' +
                    '<td class="px-4 py-3 text-[14px] text-gray-700 whitespace-nowrap">' + escapeHtml(type) + '</td>' +
                    '<td class="px-4 py-3 text-[14px] text-gray-700 whitespace-nowrap">' + escapeHtml(dt) + '</td>' +
                    '<td class="px-4 py-3 text-[14px] text-gray-800">' + escapeHtml(guard) + '</td>' +
                    '<td class="px-4 py-3 text-[14px] text-gray-800">' + escapeHtml(requester) + '</td>' +
                    '<td class="px-4 py-3 text-[14px] text-gray-700">' + escapeHtml(remarks) + '</td>' +
                    '</tr>'
                );
            }).join('');
        }

        async function viewGatepass(button) {
            const url = button?.dataset?.url;
            if (!url) return;

            try {
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                const payload = await res.json().catch(() => ({}));
                if (!res.ok) {
                    showToast(payload?.message || 'Failed to load details.', 'error');
                    return;
                }

                const d = payload?.data || {};
                document.getElementById('gpDetailGatepassNo').textContent = d.gatepass_no || '—';

                const statusEl = document.getElementById('gpDetailStatus');
                statusEl.textContent = d.status || '—';
                statusEl.className = 'inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold ' + statusBadgeClasses(d.status);

                document.getElementById('gpDetailRequestDate').textContent = d.request_date || '—';
                document.getElementById('gpDetailPurpose').textContent = d.purpose || '—';
                document.getElementById('gpDetailDestination').textContent = d.destination || '—';
                document.getElementById('gpDetailRemarks').textContent = d.remarks || '—';

                const rejectionReasonEl = document.getElementById('gpDetailRejectionReason');
                if (rejectionReasonEl) {
                    rejectionReasonEl.textContent = d.rejection_reason || '—';
                }

                const rejectedByGuardEl = document.getElementById('gpDetailRejectedByGuard');
                const isRejected = String(d.status || '').trim().toLowerCase() === 'rejected';
                if (rejectedByGuardEl) {
                    if (isRejected && d.rejected_by_guard) {
                        const guardName = d.rejected_by_guard_name || '';
                        rejectedByGuardEl.textContent = guardName
                            ? 'Rejected by Guard: ' + guardName
                            : 'Rejected by Guard';
                        rejectedByGuardEl.className = 'inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold bg-red-50 text-red-800 border border-red-200';
                    } else {
                        rejectedByGuardEl.textContent = '—';
                        rejectedByGuardEl.className = 'inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold bg-gray-100 text-gray-800 border border-gray-200';
                    }
                }

                const itemsBody = document.getElementById('gpDetailItemsBody');
                const items = Array.isArray(d.items) ? d.items : [];
                if (itemsBody) {
                    if (items.length === 0) {
                        itemsBody.innerHTML = '<tr><td colspan="3" class="px-4 py-6 text-center text-[14px] text-gray-400">No items.</td></tr>';
                    } else {
                        itemsBody.innerHTML = items.map(function (it) {
                            const itemLabel = it.description || '—';
                            const itemPropNo = it.prop_no || '—';
                            const order = it.order || '';
                            return (
                                '<tr class="border-t border-gray-100">' +
                                '<td class="px-4 py-3 text-[14px] text-gray-700 whitespace-nowrap">' + order + '</td>' +
                                '<td class="px-4 py-3 text-[14px] text-gray-800">' + escapeHtml(itemLabel) + '</td>' +
                                '<td class="px-4 py-3 text-[14px] text-gray-700 whitespace-nowrap">' + escapeHtml(itemPropNo) + '</td>' +
                                '</tr>'
                            );
                        }).join('');
                    }
                }

                const equipmentAuditEl = document.getElementById('gpDetailEquipmentAudit');
                if (equipmentAuditEl) {
                    if (!items.length) {
                        equipmentAuditEl.innerHTML = '<div class="text-[14px] text-gray-400">No audit trails.</div>';
                    } else {
                        equipmentAuditEl.innerHTML = items.map(function (it) {
                            const eq = it.equipment_history || {};

                            const propHist = Array.isArray(eq.prop_no_history) ? eq.prop_no_history : [];
                            const remarksHist = Array.isArray(eq.remarks_history) ? eq.remarks_history : [];
                            const endUserHist = Array.isArray(eq.end_user_history) ? eq.end_user_history : [];
                            const unitCostHist = Array.isArray(eq.unit_cost_history) ? eq.unit_cost_history : [];

                            const propHtml = propHist.length
                                ? propHist.map(function (h) {
                                    const propNo = h.prop_no || '—';
                                    const at = h.changed_at || h.created_at || '—';
                                    const isCurrent = Boolean(h.is_current);
                                    const currentBadge = isCurrent
                                        ? '<span class="ml-2 inline-flex items-center px-2 py-[2px] rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">Current</span>'
                                        : '';

                                    return (
                                        '<div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-white px-3 py-2">' +
                                        '  <div class="mt-2 w-2 h-2 rounded-full bg-[#003b95] flex-shrink-0"></div>' +
                                        '  <div class="flex-1 flex items-start justify-between gap-3">' +
                                        '    <div class="min-w-0">' +
                                        '      <span class="font-semibold text-gray-900 text-[13px] whitespace-nowrap overflow-hidden text-ellipsis">' + escapeHtml(propNo) + '</span>' +
                                        currentBadge +
                                        '    </div>' +
                                        '    <div class="text-right text-[12px] text-gray-500 whitespace-nowrap">' + escapeHtml(at) + '</div>' +
                                        '  </div>' +
                                        '</div>'
                                    );
                                }).join('')
                                : '<div class="text-[13px] text-gray-500">No property history.</div>';

                            const remarksHtml = remarksHist.length
                                ? remarksHist.map(function (h) {
                                    const text = h.remark_text || '—';
                                    const at = h.created_at || '—';
                                    return (
                                        '<div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-white px-3 py-2">' +
                                        '  <div class="mt-2 w-2 h-2 rounded-full bg-gray-300 flex-shrink-0"></div>' +
                                        '  <div class="flex-1 flex items-start justify-between gap-3">' +
                                        '    <div class="min-w-0 pr-2">' +
                                        '      <div class="font-semibold text-gray-900 text-[13px] whitespace-pre-line break-words">' + escapeHtml(text) + '</div>' +
                                        '    </div>' +
                                        '    <div class="text-right text-[12px] text-gray-500 whitespace-nowrap">' + escapeHtml(at) + '</div>' +
                                        '  </div>' +
                                        '</div>'
                                    );
                                }).join('')
                                : '<div class="text-[13px] text-gray-500">No remarks history.</div>';

                            const endUserHtml = endUserHist.length
                                ? endUserHist.map(function (h) {
                                    const text = h.end_user || '—';
                                    const at = h.created_at || '—';
                                    return (
                                        '<div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-white px-3 py-2">' +
                                        '  <div class="mt-2 w-2 h-2 rounded-full bg-gray-300 flex-shrink-0"></div>' +
                                        '  <div class="flex-1 flex items-start justify-between gap-3">' +
                                        '    <div class="min-w-0">' +
                                        '      <span class="font-semibold text-gray-900 text-[13px]">' + escapeHtml(text) + '</span>' +
                                        '    </div>' +
                                        '    <div class="text-right text-[12px] text-gray-500 whitespace-nowrap">' + escapeHtml(at) + '</div>' +
                                        '  </div>' +
                                        '</div>'
                                    );
                                }).join('')
                                : '<div class="text-[13px] text-gray-500">No end-user history.</div>';

                            const unitCostHtml = unitCostHist.length
                                ? unitCostHist.map(function (h) {
                                    const value = h.unit_cost !== undefined && h.unit_cost !== null ? String(h.unit_cost) : '—';
                                    const at = h.created_at || '—';
                                    return (
                                        '<div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-white px-3 py-2">' +
                                        '  <div class="mt-2 w-2 h-2 rounded-full bg-gray-300 flex-shrink-0"></div>' +
                                        '  <div class="flex-1 flex items-start justify-between gap-3">' +
                                        '    <div class="min-w-0">' +
                                        '      <span class="font-semibold text-gray-900 text-[13px]">' + escapeHtml(value) + '</span>' +
                                        '    </div>' +
                                        '    <div class="text-right text-[12px] text-gray-500 whitespace-nowrap">' + escapeHtml(at) + '</div>' +
                                        '  </div>' +
                                        '</div>'
                                    );
                                }).join('')
                                : '<div class="text-[13px] text-gray-500">No unit-cost history.</div>';

                            const itemDescription = it.description || '—';
                            const serialNo = it.serial_no || '—';
                            const currentPropNo = it.prop_no || '—';
                            const order = it.order || '';

                            return (
                                '<div class="rounded-2xl border border-gray-200 bg-white p-5">' +
                                '  <div class="flex items-start justify-between gap-4">' +
                                '    <div class="min-w-0">' +
                                '      <p class="text-[14px] font-semibold text-gray-900 truncate">' + escapeHtml(itemDescription) + '</p>' +
                                '      <p class="mt-1 text-[13px] text-gray-600 whitespace-nowrap">Serial: ' + escapeHtml(serialNo) + '</p>' +
                                '      <p class="mt-2 text-[12px] text-gray-500">' + escapeHtml('Item # ' + order) + '</p>' +
                                '    </div>' +
                                '    <span class="inline-flex items-center px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-[12px] font-semibold text-gray-800 whitespace-nowrap">' +
                                '      Current Property No: ' + escapeHtml(currentPropNo) +
                                '    </span>' +
                                '  </div>' +
                                '  <div class="mt-6 space-y-6">' +
                                '    <div>' +
                                '      <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-3">Property No History</p>' +
                                '      <div class="space-y-2">' + propHtml + '</div>' +
                                '    </div>' +
                                '    <div>' +
                                '      <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-3">Remarks History</p>' +
                                '      <div class="space-y-2">' + remarksHtml + '</div>' +
                                '    </div>' +
                                '    <div>' +
                                '      <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-3">End User History</p>' +
                                '      <div class="space-y-2">' + endUserHtml + '</div>' +
                                '    </div>' +
                                '    <div>' +
                                '      <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-3">Unit Cost History</p>' +
                                '      <div class="space-y-2">' + unitCostHtml + '</div>' +
                                '    </div>' +
                                '  </div>' +
                                '</div>'
                            );
                        }).join('');
                    }
                }

                const inOutBody = document.getElementById('gpDetailIncomingOutgoingBody');
                const logs = Array.isArray(d.incoming_outgoing_history) ? d.incoming_outgoing_history : [];
                if (inOutBody) {
                    if (!logs.length) {
                        inOutBody.innerHTML = '<tr><td colspan="5" class="px-4 py-6 text-center text-[14px] text-gray-400">No history.</td></tr>';
                    } else {
                        inOutBody.innerHTML = logs.map(function (log) {
                            const type = log.log_type || '—';
                            const dt = log.log_datetime || '—';
                            const guard = log.guard_name || log.guard_employee_id || log.scanned_by_guard_id || '—';
                            const requester = log.requester_name || log.requester_employee_id || '—';
                            const remarks = log.remarks || '—';

                            return (
                                '<tr class="border-t border-gray-100">' +
                                '<td class="px-4 py-3 text-[14px] text-gray-700 whitespace-nowrap">' + escapeHtml(type) + '</td>' +
                                '<td class="px-4 py-3 text-[14px] text-gray-700 whitespace-nowrap">' + escapeHtml(dt) + '</td>' +
                                '<td class="px-4 py-3 text-[14px] text-gray-800">' + escapeHtml(guard) + '</td>' +
                                '<td class="px-4 py-3 text-[14px] text-gray-800">' + escapeHtml(requester) + '</td>' +
                                '<td class="px-4 py-3 text-[14px] text-gray-700">' + escapeHtml(remarks) + '</td>' +
                                '</tr>'
                            );
                        }).join('');
                    }
                }

                openGatepassDetailsModal();
            } catch (e) {
                showToast('Failed to load details.', 'error');
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = String(text || '');
            return div.innerHTML;
        }

        // -----------------------------
        // Reports / Analytics (Chart.js)
        // -----------------------------
        @php
            $movementTrackingDefault = [
                'incoming_count' => 0,
                'outgoing_count' => 0,
                'total_movements' => 0,
            ];
        @endphp
        const movementTracking = @json($movementTracking ?? $movementTrackingDefault);

        const gatepassTrendsByFilter = @json($gatepassTrendsByFilter ?? []);

        let reportsChartsInitialized = false;
        let movementDoughnutChart = null;
        let gatepassTrendsBarChart = null;

        function initReportsAnalyticsIfNeeded() {
            if (reportsChartsInitialized) return;

            const movementCanvas = document.getElementById('movementDoughnutChart');
            const trendsCanvas = document.getElementById('gatepassTrendsBarChart');
            if (!movementCanvas || !trendsCanvas) return;

            if (!window.Chart) {
                // Chart.js failed to load.
                return;
            }

            reportsChartsInitialized = true;

            const incoming = Number(movementTracking?.incoming_count ?? 0);
            const outgoing = Number(movementTracking?.outgoing_count ?? 0);
            const total = Number(movementTracking?.total_movements ?? (incoming + outgoing));

            const safePct = (value) => {
                if (!total || total <= 0) return 0;
                return (value / total) * 100;
            };

            // Movement summary labels
            const outgoingPercentEl = document.getElementById('movementOutgoingPercent');
            const incomingPercentEl = document.getElementById('movementIncomingPercent');
            const outgoingCountEl = document.getElementById('movementOutgoingCount');
            const incomingCountEl = document.getElementById('movementIncomingCount');
            const outgoingCardCountEl = document.getElementById('movementOutgoingCardCount');
            const incomingCardCountEl = document.getElementById('movementIncomingCardCount');
            const totalCardCountEl = document.getElementById('movementTotalCardCount');

            const outgoingPct = safePct(outgoing);
            const incomingPct = safePct(incoming);

            if (outgoingPercentEl) outgoingPercentEl.textContent = outgoingPct.toFixed(1) + '%';
            if (incomingPercentEl) incomingPercentEl.textContent = incomingPct.toFixed(1) + '%';
            if (outgoingCountEl) outgoingCountEl.textContent = String(outgoing);
            if (incomingCountEl) incomingCountEl.textContent = String(incoming);
            if (outgoingCardCountEl) outgoingCardCountEl.textContent = String(outgoing);
            if (incomingCardCountEl) incomingCardCountEl.textContent = String(incoming);
            if (totalCardCountEl) totalCardCountEl.textContent = String(total);

            // Doughnut chart (Incoming / Outgoing)
            const movementCtx = movementCanvas.getContext('2d');
            movementDoughnutChart = new Chart(movementCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Outgoing', 'Incoming'],
                    datasets: [{
                        data: [outgoing, incoming],
                        backgroundColor: ['#f6b400', '#003b95'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 10,
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const pct = total > 0 ? (value / total) * 100 : 0;
                                    return label + ': ' + value + ' (' + pct.toFixed(1) + '%)';
                                }
                            }
                        }
                    }
                }
            });

            // Bar chart (Gate Pass Trends)
            const trendsCtx = trendsCanvas.getContext('2d');
            const colors = {
                total: '#003b95',
                approved: '#00b84f',
                rejected: '#ef4444',
                pending: '#f6b400',
                active_outside: '#2962ff',
            };

            const dailyData = gatepassTrendsByFilter?.daily || null;
            const initial = dailyData?.labels?.length ? dailyData : (gatepassTrendsByFilter?.weekly || dailyData);

            const baseLabels = initial?.labels?.length ? initial.labels : ['No data'];

            gatepassTrendsBarChart = new Chart(trendsCtx, {
                type: 'bar',
                data: {
                    labels: baseLabels,
                    datasets: [
                        {
                            label: 'Total Requests',
                            data: initial?.total ?? [0],
                            backgroundColor: colors.total,
                            borderColor: colors.total,
                            borderWidth: 1,
                        },
                        {
                            label: 'Approved',
                            data: initial?.approved ?? [0],
                            backgroundColor: colors.approved,
                            borderColor: colors.approved,
                            borderWidth: 1,
                        },
                        {
                            label: 'Rejected',
                            data: initial?.rejected ?? [0],
                            backgroundColor: colors.rejected,
                            borderColor: colors.rejected,
                            borderWidth: 1,
                        },
                        {
                            label: 'Pending',
                            data: initial?.pending ?? [0],
                            backgroundColor: colors.pending,
                            borderColor: colors.pending,
                            borderWidth: 1,
                        },
                        {
                            label: 'Active Outside',
                            data: initial?.active_outside ?? [0],
                            backgroundColor: colors.active_outside,
                            borderColor: colors.active_outside,
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset?.label || '';
                                    const value = context.parsed?.y ?? 0;
                                    return label + ': ' + value;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: true,
                                maxRotation: 0,
                                minRotation: 0,
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            }
                        }
                    }
                }
            });

            // Filter buttons
            const filterButtons = Array.from(document.querySelectorAll('.trendsFilterBtn'));
            const subtitleEl = document.getElementById('gatepassTrendsSubtitle');
            const subtitleByFilter = {
                daily: 'Last 7 days',
                weekly: 'Weekly overview',
                monthly: 'Monthly overview',
                quarterly: 'Quarterly overview',
                yearly: 'Yearly overview',
            };

            const setActiveFilterButton = (filterKey) => {
                filterButtons.forEach(function(btn) {
                    const key = btn?.dataset?.trendsFilter;
                    const isActive = key === filterKey;

                    if (isActive) {
                        btn.classList.add('bg-[#003b95]', 'text-white', 'border', 'border-[#003b95]');
                        btn.classList.remove(
                            'bg-white',
                            'text-[#003b95]',
                            'border-[#003b95]/30',
                            'hover:bg-[#003b95]/10'
                        );
                    } else {
                        btn.classList.remove('bg-[#003b95]', 'text-white', 'border', 'border-[#003b95]');
                        btn.classList.add('bg-white', 'text-[#003b95]', 'border', 'border-[#003b95]/30', 'hover:bg-[#003b95]/10');
                    }
                });
            };

            const applyGatepassTrendsFilter = (filterKey) => {
                if (!gatepassTrendsBarChart) return;

                const payload = gatepassTrendsByFilter?.[filterKey] ?? null;

                const labels = payload?.labels?.length ? payload.labels : ['No data'];
                const total = payload?.total?.length ? payload.total : [0];
                const approved = payload?.approved?.length ? payload.approved : [0];
                const rejected = payload?.rejected?.length ? payload.rejected : [0];
                const pending = payload?.pending?.length ? payload.pending : [0];
                const activeOutside = payload?.active_outside?.length ? payload.active_outside : [0];

                gatepassTrendsBarChart.data.labels = labels;
                gatepassTrendsBarChart.data.datasets[0].data = total;
                gatepassTrendsBarChart.data.datasets[1].data = approved;
                gatepassTrendsBarChart.data.datasets[2].data = rejected;
                gatepassTrendsBarChart.data.datasets[3].data = pending;
                gatepassTrendsBarChart.data.datasets[4].data = activeOutside;
                gatepassTrendsBarChart.update();

                if (subtitleEl) {
                    subtitleEl.textContent = subtitleByFilter[filterKey] ?? '';
                }

                setActiveFilterButton(filterKey);
            };

            filterButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const filterKey = btn?.dataset?.trendsFilter;
                    if (!filterKey) return;
                    applyGatepassTrendsFilter(filterKey);
                });
            });

            // Ensure the correct filter is applied initially.
            applyGatepassTrendsFilter('daily');

            // Helps Chart.js compute layout now that cards are visible.
            setTimeout(function() {
                movementDoughnutChart?.resize?.();
                gatepassTrendsBarChart?.resize?.();
            }, 50);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const flashSuccess = @json(session('success'));
            if (flashSuccess) {
                showToast(flashSuccess, 'success');
            }
            const flashStatus = @json(session('status'));
            if (flashStatus) {
                showToast(flashStatus, 'success');
            }
        });

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('gatepassDetailsModal');
            if (e.target === modal) {
                closeGatepassDetailsModal();
            }
        });
    </script>

    @include('partials.coordinator-workspace-script')

</body>
</html>