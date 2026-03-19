<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-[#f3f3f3] min-h-screen font-sans">

    <div class="flex flex-col md:flex-row min-h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-full md:w-72 lg:w-80 bg-[#173a6b] text-white flex flex-col justify-between shrink-0 md:min-h-screen">
            <div>
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
                <nav class="px-3 py-10 space-y-3">
                    <button id="navDashboard" type="button" class="w-full flex items-center gap-4 bg-[#47698f] rounded-2xl px-6 py-4 text-[17px] font-semibold text-left text-white">
                        <i class="fa-solid fa-border-all text-[20px]"></i>
                        <span>Dashboard</span>
                    </button>

                    <button id="navItemTracking" type="button" class="w-full flex items-center gap-4 px-6 py-4 text-[17px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition text-left">
                        <i class="fa-solid fa-cubes-stacked text-[20px]"></i>
                        <span>Item Tracking</span>
                    </button>

                    <button type="button" class="w-full flex items-center gap-4 px-6 py-4 text-[17px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition text-left">
                        <i class="fa-regular fa-file-lines text-[20px]"></i>
                        <span>Reports</span>
                    </button>
                </nav>
            </div>

            <div class="px-6 py-8"></div>
            <!-- Logout -->
            <div class="px-8 py-10 border-t border-white/10">
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
        <main class="flex-1 min-w-0 flex flex-col">

            <!-- Header -->
            <header class="bg-[#f3f3f3] border-b border-black/10 px-4 sm:px-6 lg:px-8 py-6 sm:py-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div class="min-w-0">
                    <h2 id="pageTitle" class="text-[32px] sm:text-[42px] font-bold text-black leading-none break-words">Dashboard</h2>
                    <p id="pageSubtitle" class="text-[16px] sm:text-[18px] text-[#3e5573] mt-2 break-words">Manage gate pass requests and approvals</p>
                </div>

                <button onclick="openAdminProfileModal()" class="w-[52px] h-[52px] rounded-full bg-[#003b95] text-white flex items-center justify-center text-[24px] shrink-0 self-start sm:self-auto">
                    <i class="fa-regular fa-user"></i>
                </button>
            </header>

            <!-- Content -->
            <section class="w-full max-w-full min-w-0 px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

                <!-- DASHBOARD SECTION -->
                <div id="dashboardSection">
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

                                    @forelse (($requests ?? collect()) as $req)
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
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-600 text-white shadow-sm ring-1 ring-inset ring-black/5 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600/30 disabled:opacity-50 disabled:cursor-not-allowed"
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
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-sm ring-1 ring-inset ring-black/5 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600/30 disabled:opacity-50 disabled:cursor-not-allowed"
                                                        onclick="rejectGatepass(this)"
                                                        data-url="{{ route('admin.gatepass-requests.reject', $req->gatepass_no) }}"
                                                        data-gatepass-no="{{ $req->gatepass_no }}"
                                                        @disabled(strtolower($req->status) === 'rejected')
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
                    </div>
                </div>


                <!-- ITEM TRACKING SECTION -->
                <div id="itemTrackingSection" class="hidden">
                    <div class="bg-white border border-gray-200 overflow-hidden rounded-[22px]">

                        <!-- Search Bar -->
                        <div class="px-5 py-5 border-b border-gray-200">
                            <form method="GET" action="{{ route('admin.dashboard') }}">
                                <input type="hidden" name="tab" value="items">
                                <div class="relative w-full max-w-full sm:max-w-[540px]">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <input
                                        type="text"
                                        name="q"
                                        value="{{ $trackedItemsSearch ?? '' }}"
                                        placeholder="Search by Gate Pass No, Item, Serial No, Property No, Employee..."
                                        class="w-full h-[48px] rounded-2xl border border-gray-300 bg-white pl-12 pr-4 text-[16px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
                                    >
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto rounded-2xl">
                            <table class="w-full min-w-[1200px]">
                                <thead>
                                    <tr class="border-b border-gray-200 text-left">
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Gate Pass No</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Item Description</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Serial Number</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Employee</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Office</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Property Number</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Status</th>
                                    </tr>
                                </thead>

                                <tbody id="itemTrackingTableBody">
                                    @forelse (($trackedItems ?? null) as $row)
                                        @php
                                            $office = trim((string) ($row->destination ?? ''));
                                            if ($office === '') {
                                                $office = trim((string) ($row->center ?? ''));
                                            } else {
                                                $centerText = trim((string) ($row->center ?? ''));
                                                if ($centerText !== '') {
                                                    $office = $centerText.' / '.$office;
                                                }
                                            }
                                        @endphp
                                        <tr class="border-b border-gray-100">
                                            <td class="px-7 py-5 text-[15px] text-gray-800 whitespace-nowrap">{{ $row->gatepass_no }}</td>
                                            <td class="px-7 py-5 text-[15px] text-gray-800">{{ $row->item_description ?? '—' }}</td>
                                            <td class="px-7 py-5 text-[15px] text-gray-800 whitespace-nowrap">{{ $row->serial_no ?? '—' }}</td>
                                            <td class="px-7 py-5 text-[15px] text-gray-800">{{ $row->employee_full_name ?? '—' }}</td>
                                            <td class="px-7 py-5 text-[15px] text-gray-800">{{ $office !== '' ? $office : '—' }}</td>
                                            <td class="px-7 py-5 text-[15px] text-gray-800 whitespace-nowrap">{{ $row->property_number ?? '—' }}</td>
                                            <td class="px-7 py-5 text-[15px] text-gray-800 whitespace-nowrap">{{ $row->request_status ?? '—' }}</td>
                                        </tr>
                                    @empty
                                        <tr class="border-b border-gray-200">
                                            <td colspan="7" class="px-7 py-14 text-center text-gray-400 text-[16px]">
                                                No tracked items yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Design -->
                        <div class="flex items-center justify-between px-7 py-5 border-t border-gray-200">
                            <p class="text-[16px] text-[#3e5573]">
                                @php
                                    $p = $trackedItems ?? null;
                                    $from = $p?->firstItem() ?? 0;
                                    $to = $p?->lastItem() ?? 0;
                                    $total = $p?->total() ?? 0;
                                @endphp
                                Showing {{ $from }}–{{ $to }} of {{ $total }} results
                            </p>

                            <div class="flex items-center gap-2">
                                @php
                                    $prevUrl = ($trackedItems ?? null)?->previousPageUrl();
                                    $nextUrl = ($trackedItems ?? null)?->nextPageUrl();
                                    $currentPage = ($trackedItems ?? null)?->currentPage() ?? 1;
                                    $lastPage = ($trackedItems ?? null)?->lastPage() ?? 1;
                                @endphp

                                @if ($prevUrl)
                                    <a href="{{ $prevUrl }}" class="px-4 py-2 rounded-xl border border-gray-300 bg-white text-[16px] font-medium">
                                        Previous
                                    </a>
                                @else
                                    <span class="px-4 py-2 rounded-xl border border-gray-300 text-gray-400 bg-gray-50 text-[16px] font-medium cursor-not-allowed">
                                        Previous
                                    </span>
                                @endif

                                <span class="w-auto min-w-[40px] h-[40px] px-3 inline-flex items-center justify-center rounded-xl bg-[#020826] text-white text-[16px] font-semibold">
                                    {{ $currentPage }}
                                </span>

                                @if ($nextUrl)
                                    <a href="{{ $nextUrl }}" class="px-4 py-2 rounded-xl border border-gray-300 bg-white text-[16px] font-medium">
                                        Next
                                    </a>
                                @else
                                    <span class="px-4 py-2 rounded-xl border border-gray-300 text-gray-400 bg-gray-50 text-[16px] font-medium cursor-not-allowed">
                                        Next
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </main>
    </div>

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
                <form class="space-y-8">

                    <!-- Profile Information -->
                    <div>
                        <h3 class="text-[18px] font-semibold text-[#003b95] mb-5">Profile Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Full Name
                                </label>
                                <input
                                    type="text"
                                    value="Admin User"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Center/Office
                                </label>
                                <input
                                    type="text"
                                    value="Logistics Division"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Email Address
                                </label>
                                <input
                                    type="email"
                                    value="admin@dap.com"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Upload Signature -->
                    <div>
                        <h3 class="text-[18px] font-semibold text-[#003b95] mb-5">Upload Signature</h3>

                        <div class="grid grid-cols-1 xl:grid-cols-[380px_1fr] gap-6 items-start">
                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Signature File
                                </label>

                                <label class="w-full min-h-[170px] rounded-2xl border-2 border-dashed border-gray-300 bg-[#fbfcfe] flex flex-col items-center justify-center text-center px-6 cursor-pointer hover:border-[#003b95] transition">
                                    <i class="fa-solid fa-signature text-[32px] text-[#98a2b3] mb-4"></i>
                                    <span class="text-[16px] font-semibold text-[#003b95]">Upload Signature</span>
                                    <span class="text-[13px] text-[#667085] mt-2">PNG, JPG, JPEG</span>
                                    <input type="file" class="hidden" accept=".png,.jpg,.jpeg">
                                </label>
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Signature Preview
                                </label>

                                <div class="w-full min-h-[170px] rounded-2xl border border-gray-200 bg-white flex items-center justify-center text-[#98a2b3] text-[15px]">
                                    No signature uploaded yet.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div>
                        <h3 class="text-[18px] font-semibold text-[#003b95] mb-5">Change Password</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Current Password
                                </label>
                                <input
                                    type="password"
                                    placeholder="Enter current password"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    New Password
                                </label>
                                <input
                                    type="password"
                                    placeholder="Enter new password"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Confirm New Password
                                </label>
                                <input
                                    type="password"
                                    placeholder="Confirm new password"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 pt-7 flex justify-end gap-4">
                        <button
                            type="button"
                            onclick="closeAdminProfileModal()"
                            class="px-6 sm:px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[16px] font-semibold text-black hover:bg-gray-50 transition whitespace-nowrap">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-6 sm:px-10 h-[46px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold transition whitespace-nowrap">
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

    <script>
        let nextGatePassNumber = 260000;

        const adminGatepassShowUrlTemplate = "{{ route('admin.gatepass-requests.show', ['gatepassNo' => '__GP__']) }}";
        const adminGatepassStoreQrUrlTemplate = "{{ route('admin.gatepass-requests.store-qr-code', ['gatepassNo' => '__GP__']) }}";

        const navDashboard = document.getElementById('navDashboard');
        const navItemTracking = document.getElementById('navItemTracking');

        const dashboardSection = document.getElementById('dashboardSection');
        const itemTrackingSection = document.getElementById('itemTrackingSection');

        const pageTitle = document.getElementById('pageTitle');
        const pageSubtitle = document.getElementById('pageSubtitle');

        function activateAdminNav(activeButton, inactiveButton) {
            activeButton.classList.add('bg-[#47698f]', 'text-white');
            activeButton.classList.remove('text-white/90', 'hover:bg-white/10');

            inactiveButton.classList.remove('bg-[#47698f]', 'text-white');
            inactiveButton.classList.add('text-white/90', 'hover:bg-white/10');
        }

        function showDashboardSection() {
            dashboardSection.classList.remove('hidden');
            itemTrackingSection.classList.add('hidden');

            pageTitle.textContent = 'Dashboard';
            pageSubtitle.textContent = 'Manage gate pass requests and approvals';

            activateAdminNav(navDashboard, navItemTracking);
        }

        function showItemTrackingSection() {
            dashboardSection.classList.add('hidden');
            itemTrackingSection.classList.remove('hidden');

            pageTitle.textContent = 'Item Tracking';
            pageSubtitle.textContent = 'Track all items with gate passes';

            activateAdminNav(navItemTracking, navDashboard);
        }

        navDashboard.addEventListener('click', showDashboardSection);
        navItemTracking.addEventListener('click', showItemTrackingSection);

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

        function openAdminProfileModal() {
            const modal = document.getElementById('adminProfileModal');
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

        document.addEventListener('DOMContentLoaded', function () {
            const shouldShowItemTracking = @json((bool) ($showItemTracking ?? false));
            if (shouldShowItemTracking) {
                showItemTrackingSection();
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
                        nextGatePassNumber += 1;
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

            const approveBtn = row.querySelector('button[onclick="approveGatepass(this)"]');
            const rejectBtn = row.querySelector('button[onclick="rejectGatepass(this)"]');
            if (approveBtn) approveBtn.disabled = String(newStatus || '').toLowerCase() === 'approved';
            if (rejectBtn) rejectBtn.disabled = String(newStatus || '').toLowerCase() === 'rejected';
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

        async function rejectGatepass(button) {
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
                    showToast(payload?.message || 'Failed to reject request.', 'error');
                    button.disabled = false;
                    return;
                }

                const newStatus = payload?.data?.status || 'Rejected';
                updateRowStatus(gatepassNo, newStatus);
                updateCardsForStatusChange(oldStatus, newStatus);
                showToast(payload?.message || 'Rejected successfully.', 'success');
            } catch (e) {
                showToast('Failed to reject request.', 'error');
                button.disabled = false;
            }
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

        document.addEventListener('DOMContentLoaded', function () {
            const flashSuccess = @json(session('success'));
            if (flashSuccess) {
                showToast(flashSuccess, 'success');
            }
        });

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('gatepassDetailsModal');
            if (e.target === modal) {
                closeGatepassDetailsModal();
            }
        });
    </script>

</body>
</html>