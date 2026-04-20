<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Coordinator Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        @keyframes loginSuccessToastAnim {
            0% {
                opacity: 0;
                transform: translateX(-24px);
            }

            15% {
                opacity: 1;
                transform: translateX(0);
            }

            70% {
                opacity: 1;
                transform: translateX(0);
            }

            100% {
                opacity: 0;
                transform: translateX(-24px);
            }
        }

        #loginSuccessToast.show-login-toast {
            animation: loginSuccessToastAnim 2.3s ease-out forwards;
        }

        @keyframes formErrorToastAnim {
            0% {
                opacity: 0;
                transform: translateY(-8px);
            }

            15% {
                opacity: 1;
                transform: translateY(0);
            }

            70% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-8px);
            }
        }

        #formErrorToast.show-form-error-toast {
            animation: formErrorToastAnim 2.6s ease-out forwards;
        }

        @keyframes addEmployeeEmailExistsAnim {
            0% {
                opacity: 0;
                transform: translate(-50%, -12px);
            }

            12% {
                opacity: 1;
                transform: translate(-50%, 0);
            }

            72% {
                opacity: 1;
                transform: translate(-50%, 0);
            }

            100% {
                opacity: 0;
                transform: translate(-50%, -8px);
            }
        }

        #addEmployeeFormErrorAlert.show-add-employee-email-exists {
            animation: addEmployeeEmailExistsAnim 2.8s ease-out forwards;
        }

        #editEmployeeFormErrorAlert.show-edit-employee-email-exists {
            animation: addEmployeeEmailExistsAnim 2.8s ease-out forwards;
        }

        @keyframes itemSuccessToastAnim {
            0% {
                opacity: 0;
                transform: translateX(-24px);
            }

            15% {
                opacity: 1;
                transform: translateX(0);
            }

            70% {
                opacity: 1;
                transform: translateX(0);
            }

            100% {
                opacity: 0;
                transform: translateX(-24px);
            }
        }

        #itemSuccessToast.show-item-success-toast {
            animation: itemSuccessToastAnim 2.3s ease-out forwards;
        }
    </style>
</head>
<body class="bg-[#f5f5f5] h-screen overflow-hidden overflow-x-hidden font-sans">

    <!-- Login success toast (top-right) -->
    <div id="loginSuccessToast"
         class="fixed top-4 right-4 z-40 flex items-center gap-3 rounded-xl bg-white text-[#16a34a] px-4 py-2 shadow-lg text-[13px] font-medium pointer-events-none opacity-0 border border-[#e5e7eb]">
        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#16a34a]/10">
            <i class="fa-solid fa-check text-[14px]"></i>
        </span>
        <span>Login successfully</span>
    </div>

    <!-- Item added success toast (top-right) -->
    <div id="itemSuccessToast"
         class="fixed top-16 right-4 z-40 flex items-center gap-3 rounded-xl bg-white text-[#16a34a] px-4 py-2 shadow-lg text-[13px] font-medium pointer-events-none opacity-0 border border-[#e5e7eb]">
        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#16a34a]/10">
            <i class="fa-solid fa-check text-[14px]"></i>
        </span>
        <span>Equipment added successfully</span>
    </div>


    <div class="flex min-h-0 h-screen flex-col md:flex-row overflow-hidden">

        <!-- Sidebar -->
        <aside class="flex h-auto min-h-0 shrink-0 flex-col w-full md:h-screen md:max-h-screen md:w-72 lg:w-80 bg-[#173a6b] text-white">

            <!-- Top Section -->
            <div class="shrink-0">
                <div class="px-4 py-8 border-b border-white/10">
                    <div class="flex items-start gap-3">
                        <img src="/images/dap_logo.png" alt="DAP Logo" class="w-[46px] h-[46px] object-contain rounded-md">
                        <div>
                            <h1 class="text-[17px] font-bold leading-tight">DAP Admin</h1>
                            <h1 class="text-[17px] font-bold leading-tight">Coordinator</h1>
                        </div>
                    </div>
                </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4 py-6">
            <div id="deleteConfirmCard" class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 transform transition-all duration-150 opacity-0 scale-95">
                <h3 id="deleteConfirmTitle" class="text-[18px] font-semibold text-[#111827] mb-2">Delete equipment?</h3>
                <p id="deleteConfirmMessage" class="text-[14px] text-[#4b5563] mb-5">
                    This will permanently remove the selected equipment from the inventory for this employee.
                </p>
                <div class="flex justify-end gap-3">
                    <button
                        type="button"
                        id="cancelDeleteBtn"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-[14px] text-[#111827] hover:bg-gray-50 transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        id="confirmDeleteBtn"
                        class="px-4 py-2 rounded-lg bg-red-600 text-white text-[14px] hover:bg-red-700 transition"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>

                <nav class="px-4 py-4 space-y-3">
                    <button
                        id="navGatepassRequest"
                        type="button"
                        class="w-full flex items-center gap-4 rounded-2xl px-5 py-4 text-[16px] font-semibold text-left text-white/90 hover:bg-white/10 transition"
                    >
                        <i class="fa-regular fa-file-lines text-[18px]"></i>
                        <span>Gatepass Request</span>
                    </button>

                    <button
                        id="navGatepassHistory"
                        type="button"
                        class="w-full flex items-center gap-4 rounded-2xl px-5 py-4 text-[16px] font-semibold text-left text-white/90 hover:bg-white/10 transition"
                    >
                        <i class="fa-solid fa-clock-rotate-left text-[18px]"></i>
                        <span>Request History</span>
                    </button>

                    <div class="px-1 pt-2 pb-1">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-white/55">Coordinator Control</p>
                    </div>

                    <button id="navDashboard" type="button"
                        class="w-full flex items-center gap-4 bg-[#47698f] rounded-2xl px-5 py-4 text-[16px] font-semibold text-left text-white">
                        <i class="fa-solid fa-border-all text-[18px]"></i>
                        <span>Dashboard</span>
                    </button>

                    <button id="navInventoryPortal" type="button"
                        class="w-full flex items-center gap-4 px-5 py-4 text-[16px] font-semibold text-left text-white/90 hover:bg-white/10 rounded-2xl transition">
                        <i class="fa-solid fa-cube text-[18px]"></i>
                        <span>Inventory Portal</span>
                    </button>

                    <button id="navEmployeeManagement" type="button"
                        class="w-full flex items-center gap-4 px-5 py-4 text-[16px] font-semibold text-left text-white/90 hover:bg-white/10 rounded-2xl transition">
                        <i class="fa-solid fa-users text-[18px]"></i>
                        <span>Employee</span>
                    </button>
                </nav>
            </div>

            <!-- Logout Bottom -->
            <div class="mt-auto shrink-0 px-8 py-10 border-t border-white/10">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-4 text-[18px] font-semibold text-white/90 hover:text-white transition">
                        <i class="fa-solid fa-right-from-bracket text-[22px]"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-h-0 min-w-0 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="shrink-0 bg-[#f5f5f5] border-b border-black/10 px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between sm:gap-6">
                    <div class="min-w-0">
                        <h2 id="pageTitle" class="text-[22px] md:text-[24px] font-bold text-black leading-none break-words">Dashboard</h2>
                        <p id="pageSubtitle" class="text-[14px] text-[#556b86] mt-2 break-words">List of Inventory</p>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <button
                            id="newRequestBtn"
                            type="button"
                            onclick="openRequestModal()"
                            class="hidden bg-[#f6b400] hover:bg-[#e6a800] text-[#003b95] font-semibold text-[14px] px-5 py-2.5 rounded-2xl flex items-center gap-2 transition whitespace-nowrap"
                        >
                            <i class="fa-solid fa-plus text-[16px]"></i>
                            <span>New Request</span>
                        </button>

                        <button
                            id="openAdminProfileModalBtn"
                            type="button"
                            onclick="openAdminProfileModal()"
                            class="h-[42px] w-[42px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white flex items-center justify-center transition shrink-0"
                            aria-label="Open profile"
                        >
                            <i class="fa-regular fa-user"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <section class="flex-1 min-h-0 w-full max-w-full min-w-0 overflow-y-auto overflow-x-hidden px-4 sm:px-6 lg:px-8 py-7">

                @include('partials.coordinator-employee-gatepass')

                <!-- DASHBOARD SECTION -->
                <div id="dashboardSection">
                    @php
                        $trackerCount = collect($dashboardTrackerMovements ?? [])->count();
                    @endphp
                    <!-- Stat Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <button id="cardTracker" type="button"
                            class="stat-card text-left bg-white border-2 border-[#2f73ff] rounded-[18px] px-6 py-6 min-h-[200px] transition">
                            <p class="text-[16px] text-[#556b86] mb-3">Items Tracker</p>
                            <h3 class="text-[28px] font-semibold text-black leading-none mb-10">{{ $trackerCount }}</h3>
                            <p class="text-[14px] text-[#556b86] mb-2">Latest movements</p>
                            <p class="text-[14px] text-[#2f73ff] font-medium">Click to view →</p>
                        </button>

                        <button id="cardTotal" type="button"
                            class="stat-card text-left bg-white border border-gray-200 rounded-[18px] px-6 py-6 min-h-[200px] transition hover:border-[#2f73ff]">
                            <p class="text-[16px] text-[#556b86] mb-3">Total Items</p>
                            <h3 class="text-[28px] font-semibold text-black leading-none mb-10">{{ $totalCount }}</h3>
                            <p class="text-[14px] text-[#556b86] mb-2">In inventory</p>
                            <p class="text-[14px] text-[#00a63e] font-medium">Click to view →</p>
                        </button>
                    </div>

                    <!-- Table Card -->
                    <div class="bg-white border border-gray-200 rounded-[18px] overflow-hidden">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between px-6 py-6">
                            <div class="min-w-0">
                                <h3 id="tableTitle" class="text-[17px] font-semibold text-black">Items Tracker</h3>
                                <p id="tableDescription" class="text-[14px] text-[#667085] mt-1">Showing {{ $trackerCount }} item(s) with movement history</p>
                            </div>
                        </div>

                        <div id="itemsTrackerSearchWrap" class="hidden px-6 pb-4">
                            <label for="itemsTrackerSearchInput" class="sr-only">Search items by owner, property number, or description</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-[#667085]">
                                    <i class="fa-solid fa-magnifying-glass text-[14px]"></i>
                                </span>
                                <input
                                    type="search"
                                    id="itemsTrackerSearchInput"
                                    name="items_tracker_search"
                                    autocomplete="off"
                                    placeholder="Search by owner, property number, or description…"
                                    class="h-[42px] w-full rounded-xl border border-gray-200 bg-white pl-10 pr-4 text-[14px] text-black placeholder:text-[#98a2b3] focus:border-[#2f73ff] focus:outline-none focus:ring-2 focus:ring-[#2f73ff]/30"
                                />
                            </div>
                        </div>

                        <div class="px-6">
                            <div class="overflow-x-auto rounded-2xl">
                                <table class="w-full min-w-[1100px]">
                                    <thead id="tableHeadTracker">
                                        <tr class="bg-[#003b95] text-white text-left">
                                            <th class="px-4 py-4 text-[14px] font-semibold">#</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Property Number</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Description</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Owner</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Latest Movement Date and Time</th>
                                        </tr>
                                    </thead>
                                    <thead id="tableHeadTotal" class="hidden">
                                        <tr class="bg-[#003b95] text-white text-left">
                                            <th class="px-4 py-4 text-[14px] font-semibold">#</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Property Number</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Description</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Assigned Employee</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tbodyTracker" class="hidden">
                                        @foreach($dashboardTrackerMovements as $index => $movement)
                                            <tr
                                                class="tracker-item-row {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} text-[14px] text-[#111827] cursor-pointer hover:bg-blue-50 transition"
                                                data-row-original-index="{{ $index + 1 }}"
                                                data-prop-no="{{ $movement['prop_no'] ?? '' }}"
                                                data-description="{{ $movement['description'] ?? '' }}"
                                                data-owner-name="{{ e($movement['owner_name'] ?? '—') }}"
                                                data-incoming-history="{{ e(json_encode($movement['incoming_history'] ?? [])) }}"
                                                data-outgoing-history="{{ e(json_encode($movement['outgoing_history'] ?? [])) }}"
                                            >
                                                <td class="px-4 py-3 align-top">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3 align-top">{{ $movement['prop_no'] ?? '' }}</td>
                                                <td class="px-4 py-3 align-top">{{ $movement['description'] ?? '' }}</td>
                                                <td class="px-4 py-3 align-top">{{ $movement['owner_name'] ?? '—' }}</td>
                                                <td class="px-4 py-3 align-top">{{ $movement['latest_movement_datetime'] ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tbody id="tbodyTotal" class="hidden">
                                        @foreach($dashboardTotalItems as $index => $item)
                                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} text-[14px] text-[#111827]">
                                                <td class="px-4 py-3 align-top">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3 align-top">{{ $item->prop_no }}</td>
                                                <td class="px-4 py-3 align-top">{{ $item->description }}</td>
                                                <td class="px-4 py-3 align-top">{{ $item->employee?->employee_name ?? '' }}</td>
                                                @php
                                                    $dashStatusLabel = match ($item->status) {
                                                        'A' => 'Active',
                                                        'I' => 'In Use',
                                                        'D' => 'Defective/Disposed',
                                                        default => $item->status,
                                                    };
                                                @endphp
                                                <td class="px-4 py-3 align-top">{{ $dashStatusLabel }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div
                                id="trackerSearchNoResults"
                                class="hidden border-b border-gray-200 py-10 text-center text-[15px] text-[#667085] rounded-b-2xl"
                            >
                                No items match your search.
                            </div>

                            <div
                                id="emptyState"
                                class="py-12 text-center text-[#98a2b3] text-[15px] border-b border-gray-200 {{ $trackerCount > 0 ? 'hidden' : '' }}"
                            >
                                No inventory data available yet.
                            </div>

                        </div>
                    </div>
                </div>

                <!-- INVENTORY PORTAL SECTION -->
                <div id="inventoryPortalSection" class="hidden">
                    <div class="bg-white border border-gray-200 rounded-[18px] overflow-hidden mb-6">
                        <div class="px-6 py-6">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                <h3 class="text-[18px] font-bold text-black uppercase mb-0">Asset Inventory Management</h3>
                                <button
                                    id="openAddItemModal"
                                    type="button"
                                    class="hidden h-[42px] w-full sm:w-auto px-4 rounded-xl bg-[#f6b400] hover:bg-[#e5a900] text-[#003b95] font-semibold text-[14px] flex items-center justify-center gap-2 transition shrink-0 whitespace-nowrap"
                                >
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Add Item</span>
                                </button>
                            </div>

                            <form method="GET" action="{{ route('admin.coordinator.index') }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-6">
                                    <div>
                                        <label class="block text-[14px] font-semibold text-black mb-2">Employee Name</label>
                                        <select
                                            id="employeeSelect"
                                            name="employee_id"
                                            class="w-full h-[42px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none"
                                        >
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->employee_id }}" @selected($employee->employee_id === $selectedEmployeeId)>
                                                    {{ $employee->employee_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-[14px] font-semibold text-black mb-2">Employee Type</label>
                                        <input
                                            id="employeeTypeField"
                                            type="text"
                                            value="{{ $selectedEmployee?->employee_type ?? '' }}"
                                            class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-[#667085] focus:outline-none"
                                            readonly
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-[14px] font-semibold text-black mb-2">Employee No.</label>
                                        <input
                                            id="employeeNumberField"
                                            type="text"
                                            value="{{ $selectedEmployeeId }}"
                                            class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-black focus:outline-none"
                                            readonly
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-[14px] font-semibold text-black mb-2">Center</label>
                                        <input
                                            id="employeeCenterField"
                                            type="text"
                                            value="{{ $selectedEmployee?->center ?? '' }}"
                                            class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-black focus:outline-none"
                                            readonly
                                        >
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-[18px] overflow-hidden">
                        <!-- TABLE CONTROLS (Search + Filter + Add) -->
                        <div class="px-6 py-5 border-b border-gray-200">
                            <div class="flex flex-col md:flex-row md:items-end gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </span>
                                        <input
                                            type="text"
                                            name="search"
                                            value="{{ $search }}"
                                            placeholder="Search by property number, description, or serial number..."
                                            class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 pl-11 pr-4 text-[14px] text-[#667085] placeholder:text-[#667085] focus:outline-none"
                                        >
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="overflow-x-auto rounded-2xl">
                            <table class="w-full min-w-max table-auto text-sm">
                                <thead>
                                    <tr class="bg-[#003b95] text-white text-left">
                                        <th class="w-12 px-3 py-2 text-xs font-semibold whitespace-nowrap">#</th>
                                        <th class="w-28 px-3 py-2 text-xs font-semibold whitespace-nowrap">Property Number</th>
                                        <th class="w-24 px-3 py-2 text-xs font-semibold whitespace-nowrap">Account Code</th>
                                        <th class="w-28 px-3 py-2 text-xs font-semibold whitespace-nowrap">Serial Number</th>
                                        <th class="w-40 px-3 py-2 text-xs font-semibold whitespace-nowrap">Description / Specification</th>
                                        <th class="w-24 px-3 py-2 text-xs font-semibold whitespace-nowrap">Unit Price</th>
                                        <th class="w-20 px-3 py-2 text-xs font-semibold whitespace-nowrap">Status</th>
                                        <th class="w-32 min-w-[120px] px-3 py-2 text-xs font-semibold whitespace-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="inventoryPortalTableBody">
                                    @forelse($items as $index => $item)
                                        <tr
                                            class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} text-[#111827]"
                                            data-inventory-id="{{ $item->id }}"
                                            data-accountability="{{ strtolower($item->accountability ?? 'Accountable') }}"
                                        >
                                            <td class="px-3 py-2 align-top whitespace-nowrap">{{ $index + 1 }}</td>
                                            <td class="px-3 py-2 align-top whitespace-nowrap truncate">{{ $item->prop_no }}</td>
                                            <td class="px-3 py-2 align-top whitespace-nowrap truncate">{{ $item->acct_code }}</td>
                                            <td class="px-3 py-2 align-top whitespace-nowrap truncate">{{ $item->serial_no }}</td>
                                            <td class="px-3 py-2 align-top whitespace-nowrap truncate" title="{{ $item->description }}">{{ $item->description }}</td>
                                            <td class="px-3 py-2 align-top whitespace-nowrap truncate">
                                                {{ $item->unit_cost !== null ? number_format($item->unit_cost, 2) : '' }}
                                            </td>
                                            @php
                                                $portalStatusLabel = match ($item->status) {
                                                    'A' => 'Active',
                                                    'I' => 'In Use',
                                                    'D' => 'Defective/Disposed',
                                                    default => $item->status,
                                                };
                                            @endphp
                                            <td class="px-3 py-2 align-top whitespace-nowrap truncate">{{ $portalStatusLabel }}</td>
                                            <td class="px-3 py-2 align-top">
                                                <div class="flex items-center gap-2 whitespace-nowrap">
                                                    <button
                                                        type="button"
                                                        class="inventory-see-more p-1.5 rounded-lg border border-gray-300 text-xs text-[#003b95] hover:bg-gray-50 transition"
                                                        data-mrr="{{ $item->mrr_no }}"
                                                        data-center="{{ $item->center ?? $selectedEmployee?->center ?? '' }}"
                                                        data-accountability="{{ $item->accountability ?? 'Accountable' }}"
                                                        data-end-user="{{ $item->end_user ?? '' }}"
                                                        data-movement-type="{{ $item->latest_movement['type'] ?? '' }}"
                                                        data-movement-requester="{{ $item->latest_movement['requester_name'] ?? '' }}"
                                                        data-movement-datetime="{{ $item->latest_movement['datetime'] ?? '' }}"
                                                        title="See more details"
                                                    >
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="inventory-edit p-1.5 rounded-lg border border-gray-300 text-xs text-[#047857] hover:bg-gray-50 transition"
                                                        data-update-url="{{ route('admin.coordinator.items.update', $item->id) }}"
                                                        data-inventory-id="{{ $item->id }}"
                                                        data-employee-id="{{ $selectedEmployeeId }}"
                                                        data-prop-no="{{ $item->prop_no }}"
                                                        data-acct-code="{{ $item->acct_code }}"
                                                        data-serial-no="{{ $item->serial_no }}"
                                                        data-description="{{ $item->description }}"
                                                        data-unit-cost="{{ $item->unit_cost }}"
                                                        data-center="{{ $item->center ?? $selectedEmployee?->center ?? '' }}"
                                                        data-status="{{ $item->status }}"
                                                        data-accountability="{{ $item->accountability ?? 'Accountable' }}"
                                                        data-end-user="{{ $item->end_user ?? '' }}"
                                                        data-remarks="{{ $item->remarks ?? '' }}"
                                                        data-mrr="{{ $item->mrr_no }}"
                                                        title="Edit equipment"
                                                    >
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.coordinator.items.destroy', $item->id) }}" class="inventory-delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="employee_id" value="{{ $selectedEmployeeId }}">
                                                        <button
                                                            type="submit"
                                                            class="inventory-delete p-1.5 rounded-lg border border-red-300 text-xs text-red-600 hover:bg-red-50 transition"
                                                            title="Delete"
                                                        >
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-4 py-6 text-center text-[14px] text-[#98a2b3]">
                                                No inventory items available for the selected employee.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div id="inventoryPortalPagination" class="hidden flex flex-wrap items-center justify-center gap-2 border-t border-gray-200 px-6 py-4" aria-label="Inventory pagination"></div>

                </div>
                </div>

                <!-- EMPLOYEE MANAGEMENT SECTION -->
                <div id="employeeManagementSection" class="hidden">
                    <div class="bg-white border border-gray-200 rounded-[18px] overflow-hidden">
                        <div class="px-6 py-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <h3 class="text-[17px] font-semibold text-black">Employee Management</h3>
                                <p class="text-[14px] text-[#667085] mt-1">Manage employee records</p>
                            </div>
                            <button id="openAddEmployeeModal" type="button"
                                class="w-full sm:w-auto h-[42px] px-4 rounded-xl bg-[#f6b400] hover:bg-[#e5a900] text-[#003b95] font-semibold text-[14px] flex items-center justify-center gap-2 transition whitespace-nowrap">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Employee</span>
                            </button>
                        </div>

                        <div class="overflow-x-auto rounded-2xl">
                            <table class="w-full min-w-[980px]">
                                <thead>
                                    <tr class="bg-[#003b95] text-white text-left">
                                        <th class="px-4 py-4 text-[14px] font-semibold">#</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Employee ID</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Employee Name</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Center</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Employee Type</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Created At</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employeeManagementTableBody">
                                    @php
                                        $formatEmployeeTimestamp = static function ($value): string {
                                            if ($value === null) {
                                                return '-';
                                            }

                                            if ($value instanceof \DateTimeInterface) {
                                                return $value->format('Y-m-d H:i:s');
                                            }

                                            $stringValue = trim((string) $value);
                                            if ($stringValue === '') {
                                                return '-';
                                            }

                                            try {
                                                return \Illuminate\Support\Carbon::parse($stringValue)->format('Y-m-d H:i:s');
                                            } catch (\Throwable $e) {
                                                return $stringValue;
                                            }
                                        };
                                    @endphp
                                    @forelse($employeeRecords as $index => $employeeRecord)
                                        <tr data-employee-id="{{ $employeeRecord->employee_id }}" class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} text-[14px] text-[#111827]">
                                            <td class="px-4 py-3 align-top">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 align-top">{{ $employeeRecord->employee_id }}</td>
                                            <td class="px-4 py-3 align-top">{{ $employeeRecord->employee_name }}</td>
                                            <td class="px-4 py-3 align-top">{{ $employeeRecord->center }}</td>
                                            <td class="px-4 py-3 align-top">{{ $employeeRecord->employee_type ?? '—' }}</td>
                                            <td class="px-4 py-3 align-top">{{ $formatEmployeeTimestamp($employeeRecord->created_at) }}</td>
                                            <td class="px-4 py-3 align-top">
                                                <div class="flex items-center gap-2">
                                                    <button
                                                        type="button"
                                                        class="employee-edit p-1.5 rounded-lg border border-gray-300 text-xs text-[#047857] hover:bg-gray-50 transition"
                                                        data-employee-id="{{ $employeeRecord->employee_id }}"
                                                        data-employee-name="{{ $employeeRecord->employee_name }}"
                                                        data-email="{{ $employeeRecord->user?->email ?? '' }}"
                                                        data-user-linked="{{ $employeeRecord->user_id ? '1' : '0' }}"
                                                        data-center="{{ $employeeRecord->center }}"
                                                        data-employee-type="{{ $employeeRecord->employee_type ?? '' }}"
                                                        data-role="{{ $employeeRecord->user?->role ?? '' }}"
                                                        data-update-url="{{ route('admin.coordinator.employees.update', $employeeRecord->employee_id) }}"
                                                        title="Edit employee"
                                                    >
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.coordinator.employees.destroy', $employeeRecord->employee_id) }}" class="employee-delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            type="submit"
                                                            class="employee-delete p-1.5 rounded-lg border border-red-300 text-xs text-red-600 hover:bg-red-50 transition"
                                                            title="Delete employee"
                                                        >
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-6 text-center text-[14px] text-[#98a2b3]">
                                                No employees available.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div id="employeeManagementPagination" class="hidden flex flex-wrap items-center justify-end gap-2 border-t border-gray-200 px-6 py-4" aria-label="Employee list pagination"></div>
                    </div>
                </div>

                <!-- Add Item Modal -->
                <div id="addItemModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4 py-6">
                    <div id="addItemModalCard" class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden relative">
                        <!-- Form error toast (inside modal, top) -->
                        <div id="formErrorToast"
                             class="absolute left-1/2 top-3 -translate-x-1/2 z-20 flex items-center gap-3 rounded-xl bg-white text-[#dc2626] px-4 py-2 shadow-lg text-[13px] font-medium opacity-0 border border-[#fee2e2] pointer-events-none">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#dc2626]/10">
                                <i class="fa-solid fa-triangle-exclamation text-[14px]"></i>
                            </span>
                            <span id="formErrorToastMessage">Please complete all required fields.</span>
                        </div>
                        
                        <!-- Modal Header -->
                        <div class="bg-[#003b95] px-6 py-4 flex items-start justify-between">
                            <div>
                                <h3 class="text-white text-[22px] font-bold leading-tight">Add New Equipment</h3>
                                <p class="text-white/80 text-[14px] mt-1">Add equipment item details</p>
                                <p class="text-white/70 text-[12px] mt-1">Fields marked with * are required.</p>
                            </div>
                            <button id="closeAddItemModal" type="button" class="text-white text-[22px] hover:text-white/80 transition">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form
                            id="addItemForm"
                            method="POST"
                            action="{{ route('admin.coordinator.items.store', ['employee_id' => $selectedEmployeeId]) }}"
                            class="max-h-[75vh] overflow-y-auto px-6 py-6"
                        >
                            @csrf
                            <input type="hidden" name="employee_id" value="{{ $selectedEmployeeId }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                                <!-- Property Number -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Property Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="property_number" placeholder="Enter property number"
                                        value="{{ old('property_number') }}"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                    @error('property_number')
                                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Account Code -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Account Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="rca_acctcode" placeholder="Enter account code"
                                        value="{{ old('rca_acctcode') }}"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                    @error('rca_acctcode')
                                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- MRR -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        MRR
                                    </label>
                                    <input type="text" name="mrr" placeholder="Enter MRR"
                                        value="{{ old('mrr') }}"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white-100 px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                    @error('mrr')
                                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Serial Number -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Serial Number
                                    </label>
                                    <input type="text" name="serialno" placeholder="Enter serial number"
                                        value="{{ old('serialno') }}"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white-100 px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                    @error('serialno')
                                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description / Specification -->
                                <div class="md:col-span-2">
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Description / Specification <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="description"
                                        placeholder="Enter description or specification"
                                        value="{{ old('description') }}"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                    >
                                    @error('description')
                                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Unit Cost -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Unit Cost <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" step="0.01" name="unit_cost" placeholder="Enter unit cost"
                                        value="{{ old('unit_cost') }}"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                    @error('unit_cost')
                                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Center -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Center
                                    </label>
                                    <select name="center"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                        <option value="">Select center</option>
                                        <option value="ICTD">ICTD</option>
                                        <option value="HR">HR</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                        <option value="">Select status</option>
                                        <option value="Available">Available</option>
                                        <option value="In Use">In Use</option>
                                        <option value="Defective">Defective</option>
                                        <option value="Disposed">Disposed</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- End User -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        End User
                                    </label>
                                    <input type="text" name="end_user" placeholder="Enter end user name"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white-100 px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                </div>

                                <!-- Accountability -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Accountability <span class="text-red-500">*</span>
                                    </label>
                                    <select name="accountability"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                        <option value="">Select accountability</option>
                                        <option value="Accountable">Accountable</option>
                                        <option value="Unaccountable">Unaccountable</option>
                                    </select>
                                    @error('accountability')
                                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Remarks -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Remarks
                                    </label>
                                    <input type="text" name="remarks" placeholder="Enter remarks"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white-100 px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                                <button id="cancelAddItemModal" type="button"
                                    class="px-5 h-[42px] rounded-xl border border-gray-300 text-[14px] font-medium text-black hover:bg-gray-50 transition">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-5 h-[42px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[14px] font-semibold flex items-center gap-2 transition">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Add Equipment</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Employee Modal -->
                <div id="editEmployeeModal" class="fixed inset-0 z-50 hidden bg-black/40 px-4 py-6 sm:px-6">
                    <div class="flex min-h-full items-center justify-center">
                    <div class="relative w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
                        <div
                            id="editEmployeeFormErrorAlert"
                            class="pointer-events-none absolute left-1/2 top-3 z-20 flex max-w-[calc(100%-1.5rem)] -translate-x-1/2 items-center gap-3 rounded-xl border border-[#fee2e2] bg-white px-4 py-2 text-[13px] font-medium text-[#dc2626] opacity-0 shadow-lg sm:max-w-md"
                            role="alert"
                            aria-live="polite"
                        >
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#dc2626]/10">
                                <i class="fa-solid fa-triangle-exclamation text-[14px]" aria-hidden="true"></i>
                            </span>
                            <span id="editEmployeeFormErrorAlertMessage">This email already exists.</span>
                        </div>
                        <div class="bg-[#003b95] px-6 py-4 flex items-start justify-between">
                            <div>
                                <h3 class="text-white text-[22px] font-bold leading-tight">Edit Employee</h3>
                                <p class="text-white/80 text-[14px] mt-1">Update employee details</p>
                            </div>
                            <button id="closeEditEmployeeModal" type="button" class="text-white text-[22px] hover:text-white/80 transition">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <form id="editEmployeeForm" method="POST" action="" class="px-6 py-6">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Employee ID</label>
                                    <input id="editEmployeeNumberField" type="text" class="w-full h-[44px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-black focus:outline-none" readonly>
                                </div>
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Employee Name</label>
                                    <input id="editEmployeeNameField" type="text" name="employee_name" class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[14px] font-semibold text-black mb-2">Email</label>
                                    <input id="editEmployeeEmailField" type="email" name="email" autocomplete="email" class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-600" placeholder="user@example.com">
                                    <p id="editEmployeeEmailHint" class="mt-1 hidden text-[12px] text-gray-500">This employee has no linked user account. Email cannot be edited here.</p>
                                </div>
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Center</label>
                                    <input id="editEmployeeCenterField" type="text" name="center" class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20" required>
                                </div>
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Employee Type</label>
                                    <select id="editEmployeeTypeField" name="employee_type" class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20" required>
                                        <option value="" selected>Select type</option>
                                        <option value="Plantilla">Plantilla</option>
                                        <option value="Nonplantilla">Nonplantilla</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[14px] font-semibold text-black mb-2">Role</label>
                                    <input
                                        id="editEmployeeRoleField"
                                        type="text"
                                        name="role"
                                        autocomplete="off"
                                        placeholder="e.g. employee"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-600"
                                    >
                                    <p id="editEmployeeRoleHint" class="mt-1 hidden text-[12px] text-gray-500">Role is only available when this employee has a linked user account.</p>
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                                <button id="cancelEditEmployeeModal" type="button" class="px-5 h-[42px] rounded-xl border border-gray-300 text-[14px] font-medium text-black hover:bg-gray-50 transition">
                                    Cancel
                                </button>
                                <button type="submit" class="px-5 h-[42px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[14px] font-semibold flex items-center gap-2 transition">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span>Update Employee</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>

                <!-- Add Employee Modal -->
                <div id="addEmployeeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4 py-4 sm:px-6 sm:py-6">
                    <div class="flex min-h-full items-center justify-center">
                        <div class="relative w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl max-h-[90vh] flex flex-col">
                            <div
                                id="addEmployeeFormErrorAlert"
                                class="pointer-events-none absolute left-1/2 top-3 z-20 flex max-w-[calc(100%-1.5rem)] -translate-x-1/2 items-center gap-3 rounded-xl border border-[#fee2e2] bg-white px-4 py-2 text-[13px] font-medium text-[#dc2626] opacity-0 shadow-lg sm:max-w-md"
                                role="alert"
                                aria-live="polite"
                            >
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#dc2626]/10">
                                    <i class="fa-solid fa-triangle-exclamation text-[14px]" aria-hidden="true"></i>
                                </span>
                                <span id="addEmployeeFormErrorAlertMessage">This email already exists.</span>
                            </div>
                            <div class="flex items-start justify-between bg-[#003b95] px-5 py-4 sm:px-6">
                                <div>
                                    <h3 class="text-xl font-bold leading-tight text-white sm:text-[22px]">Add Employee</h3>
                                    <p class="mt-1 text-sm text-white/80">Create a new employee record</p>
                                </div>
                                <button id="closeAddEmployeeModal" type="button" class="text-[22px] text-white transition hover:text-white/80">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <form id="addEmployeeForm" method="POST" action="{{ route('admin.coordinator.employees.store') }}" class="flex-1 overflow-y-auto px-4 py-5 sm:px-6 sm:py-6">
                                @csrf
                                <input type="hidden" name="employee_id" value="">

                                <div class="space-y-5">
                                    <div class="rounded-2xl border border-gray-200 bg-[#f8f8f8] p-4 sm:p-5">
                                        <div class="mb-4">
                                            <h4 class="text-sm font-bold leading-tight text-[#003b95]">User Information</h4>
                                            <p class="mt-1 text-xs text-gray-600 sm:text-[13px]">
                                                An invitation email will be sent with a secure link to set their password (valid for 3 days).
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-x-6 md:gap-y-5">
                                            <div>
                                                <label class="mb-2 block text-sm font-semibold text-black">Name</label>
                                                <input
                                                    id="addEmployeeNameField"
                                                    type="text"
                                                    name="name"
                                                    class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                                    required
                                                >
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-sm font-semibold text-black">Email</label>
                                                <input
                                                    id="addEmployeeEmailField"
                                                    type="email"
                                                    name="email"
                                                    class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                                    required
                                                >
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="mb-2 block text-sm font-semibold text-black">Role</label>
                                                <input
                                                    id="addEmployeeRoleField"
                                                    type="text"
                                                    name="role"
                                                    placeholder="e.g. employee"
                                                    class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                                    required
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-2xl border border-gray-200 bg-[#f8f8f8] p-4 sm:p-5">
                                        <div class="mb-4">
                                            <h4 class="text-sm font-bold leading-tight text-[#003b95]">Employee Details</h4>
                                            <p class="mt-1 text-xs text-gray-600 sm:text-[13px]">
                                                Provide employee metadata used for gatepass inventory.
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-x-6 md:gap-y-5">
                                            <div>
                                                <label class="mb-2 block text-sm font-semibold text-black">Employee ID</label>
                                                <input
                                                    id="addEmployeeIdField"
                                                    type="text"
                                                    value="Auto-generated on save"
                                                    readonly
                                                    class="h-11 w-full rounded-xl border border-gray-300 bg-gray-100 px-4 text-sm text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                                >
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-sm font-semibold text-black">Center</label>
                                                <input
                                                    id="addEmployeeCenterField"
                                                    type="text"
                                                    name="center"
                                                    class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                                    required
                                                >
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="mb-2 block text-sm font-semibold text-black">Employee Type</label>
                                                <select
                                                    id="addEmployeeTypeField"
                                                    name="employee_type"
                                                    class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                                    required
                                                >
                                                    <option value="Plantilla" selected>Plantilla</option>
                                                    <option value="Nonplantilla">Nonplantilla</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 border-t border-gray-200 pt-5">
                                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                                        <button
                                            id="cancelAddEmployeeModal"
                                            type="button"
                                            class="h-11 rounded-xl border border-gray-300 px-5 text-sm font-medium text-black transition hover:bg-gray-50"
                                        >
                                            Cancel
                                        </button>

                                        <button
                                            type="submit"
                                            class="flex h-11 items-center justify-center gap-2 rounded-xl bg-[#003b95] px-5 text-sm font-semibold text-white transition hover:bg-[#002d73]"
                                        >
                                            <i class="fa-solid fa-plus"></i>
                                            <span>Add Employee</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Item Modal -->
                <div id="editItemModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4 py-6">
                    <div id="editItemModalCard" class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden relative">
                        <!-- Modal Header -->
                        <div class="bg-[#003b95] px-6 py-4 flex items-start justify-between">
                            <div>
                                <h3 class="text-white text-[22px] font-bold leading-tight">Edit Equipment</h3>
                                <p class="text-white/80 text-[14px] mt-1">Update equipment item details</p>
                            </div>
                            <button id="closeEditItemModal" type="button" class="text-white text-[22px] hover:text-white/80 transition">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form
                            id="editItemForm"
                            method="POST"
                            action=""
                            class="max-h-[75vh] overflow-y-auto px-6 py-6"
                        >
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="employee_id" id="editEmployeeIdField" value="{{ $selectedEmployeeId }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                                <!-- Property Number -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Property Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="property_number" id="editPropertyNumberField" placeholder="Enter property number"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                    <p id="editPropertyNumberError" class="mt-1 text-[12px] text-red-600 hidden" role="alert"></p>
                                </div>

                                <!-- Account Code -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Account Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="rca_acctcode" id="editAccountCodeField" placeholder="Enter account code"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                    <p id="editAccountCodeError" class="mt-1 text-[12px] text-red-600 hidden" role="alert"></p>
                                </div>

                                <!-- Serial Number -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Serial Number
                                    </label>
                                    <input type="text" name="serialno" id="editSerialNumberField" placeholder="Enter serial number"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                    <p id="editSerialNumberError" class="mt-1 text-[12px] text-red-600 hidden" role="alert"></p>
                                </div>

                                <!-- MRR -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        MRR
                                    </label>
                                    <input type="text" name="mrr" id="editMrrField" placeholder="Enter MRR"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                </div>

                                <!-- Description / Specification -->
                                <div class="md:col-span-2">
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Description / Specification <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="description"
                                        id="editDescriptionField"
                                        placeholder="Enter description or specification"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                    >
                                </div>

                                <!-- Unit Cost -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Unit Cost <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" step="0.01" name="unit_cost" id="editUnitCostField" placeholder="Enter unit cost"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                </div>

                                <!-- Center -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Center
                                    </label>
                                    <select name="center" id="editCenterField"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                        <option value="">Select center</option>
                                        <option value="ICTD">ICTD</option>
                                        <option value="HR">HR</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" id="editStatusField"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                        <option value="">Select status</option>
                                        <option value="Available">Available</option>
                                        <option value="In Use">In Use</option>
                                        <option value="Defective">Defective</option>
                                        <option value="Disposed">Disposed</option>
                                    </select>
                                </div>

                                <!-- End User -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        End User
                                    </label>
                                    <input type="text" name="end_user" id="editEndUserField" placeholder="Enter end user name"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                </div>

                                <!-- Accountability -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Accountability <span class="text-red-500">*</span>
                                    </label>
                                    <select name="accountability" id="editAccountabilityField"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                        <option value="">Select accountability</option>
                                        <option value="Accountable">Accountable</option>
                                        <option value="Unaccountable">Unaccountable</option>
                                    </select>
                                </div>

                                <!-- Remarks -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Remarks
                                    </label>
                                    <input type="text" name="remarks" id="editRemarksField" placeholder="Enter remarks"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                                <button id="cancelEditItemModal" type="button"
                                    class="px-5 h-[42px] rounded-xl border border-gray-300 text-[14px] font-medium text-black hover:bg-gray-50 transition">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-5 h-[42px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[14px] font-semibold flex items-center gap-2 transition">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span>Update Equipment</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </section>
        </main>
    </div>

    <div id="trackerHistoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 px-4 py-6">
        <div class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl overflow-hidden">
            <div class="bg-[#003b95] px-6 py-4 flex items-center justify-between">
                <div>
                    <h3 id="trackerHistoryTitle" class="text-white text-[18px] font-bold">Item Movement History</h3>
                    <p id="trackerHistorySubtitle" class="text-white/80 text-[13px] mt-1">Incoming and outgoing records</p>
                </div>
                <button id="closeTrackerHistoryModal" type="button" class="text-white text-[20px] hover:text-white/80 transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                        <p class="text-[13px] font-semibold text-emerald-800 mb-3">Incoming History (Date and Time)</p>
                        <ul id="incomingHistoryList" class="space-y-2 text-[13px] text-[#14532d]"></ul>
                    </div>
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                        <p class="text-[13px] font-semibold text-amber-800 mb-3">Outgoing History (Date and Time)</p>
                        <ul id="outgoingHistoryList" class="space-y-2 text-[13px] text-[#78350f]"></ul>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button id="dismissTrackerHistoryModal" type="button"
                    class="px-4 h-[38px] rounded-xl border border-gray-300 text-[13px] font-medium text-[#111827] hover:bg-gray-100 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- See More Modal -->
    <div id="seeMoreModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4 py-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-[#003b95] px-6 py-4 flex items-center justify-between">
                <h3 class="text-white text-[18px] font-bold">Equipment Details</h3>
                <button id="closeSeeMoreModal" type="button" class="text-white text-[20px] hover:text-white/80 transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="px-6 py-5 text-[14px] text-[#111827]">
                <div class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-[140px_1fr] items-start sm:items-center gap-2 sm:gap-3">
                        <span class="font-semibold text-[#4b5563]">MRR:</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between min-w-0">
                            <span id="seeMoreMrr" class="text-[13px] text-[#111827] break-words min-w-0">N/A</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-[140px_1fr] items-start sm:items-center gap-2 sm:gap-3">
                        <span class="font-semibold text-[#4b5563]">Center:</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between min-w-0">
                            <span id="seeMoreCenter" class="text-[13px] text-[#111827] break-words min-w-0">N/A</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-[140px_1fr] items-start sm:items-center gap-2 sm:gap-3">
                        <span class="font-semibold text-[#4b5563]">Accountability:</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between min-w-0">
                            <span id="seeMoreAccountability" class="text-[13px] text-[#111827] break-words min-w-0">N/A</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-[140px_1fr] items-start sm:items-center gap-2 sm:gap-3">
                        <span class="font-semibold text-[#4b5563]">End User:</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between min-w-0">
                            <span id="seeMoreEndUser" class="text-[13px] text-[#111827] break-words min-w-0">N/A</span>
                        </div>
                    </div>
                    <div class="pt-1">
                        <p class="text-[12px] font-semibold text-[#4b5563] uppercase tracking-wide mb-2">Incoming / Outgoing Tracker</p>
                        <div id="seeMoreMovementCard" class="rounded-xl border border-gray-200 bg-[#f8fafc] px-4 py-3 space-y-2">
                            <p id="seeMoreMovementHeadline" class="text-[13px] font-semibold text-[#334155]">
                                No incoming/outgoing history available
                            </p>
                            <p class="text-[12px] text-[#64748b]">
                                <span id="seeMoreMovementActorLabel" class="font-medium">Released to / requested by:</span>
                                <span id="seeMoreMovementActorValue" class="text-[#334155]">N/A</span>
                            </p>
                            <p class="text-[12px] text-[#64748b]">
                                <span class="font-medium">Date and time:</span>
                                <span id="seeMoreMovementDatetime" class="text-[#334155]">N/A</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button id="dismissSeeMoreModal" type="button"
                        class="px-4 h-[38px] rounded-xl border border-gray-300 text-[13px] font-medium text-[#111827] hover:bg-gray-100 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Admin Profile Modal -->
    <div id="adminProfileModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[1150px] bg-white rounded-[18px] shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[26px] font-bold text-[#003b95]">Profile</h2>
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

    @php
        $coordinatorGatepassJs = file_get_contents(resource_path('views/partials/coordinator-gatepass-employee-snippet.js'));
        $coordinatorGatepassJs = str_replace(
            "{{ route('employee.gatepass-requests.dashboard') }}",
            route('employee.gatepass-requests.dashboard'),
            $coordinatorGatepassJs
        );
        $coordinatorGatepassJs = str_replace(
            "{{ route('employee.gatepass-requests.history') }}",
            route('employee.gatepass-requests.history'),
            $coordinatorGatepassJs
        );
        $coordinatorGatepassJs = str_replace(
            "{{ route('employee.gatepass-requests.show', ['gatepass_no' => '__GP__']) }}",
            route('employee.gatepass-requests.show', ['gatepass_no' => '__GP__']),
            $coordinatorGatepassJs
        );
        $coordinatorGatepassJs = str_replace(
            "{{ asset('storage') }}",
            asset('storage'),
            $coordinatorGatepassJs
        );
    @endphp
    <script>
        {!! $coordinatorGatepassJs !!}
    </script>

    <script>
    const gatepassEmployeePanel = document.getElementById('gatepassEmployeePanel');
    const navGatepassRequest = document.getElementById('navGatepassRequest');
    const navGatepassHistory = document.getElementById('navGatepassHistory');
    const newRequestBtn = document.getElementById('newRequestBtn');

    const navDashboard = document.getElementById('navDashboard');
    const navInventoryPortal = document.getElementById('navInventoryPortal');
    const navEmployeeManagement = document.getElementById('navEmployeeManagement');

    const sidebarNavAll = [navGatepassRequest, navGatepassHistory, navDashboard, navInventoryPortal, navEmployeeManagement];

    const dashboardSection = document.getElementById('dashboardSection');
    const inventoryPortalSection = document.getElementById('inventoryPortalSection');
    const employeeManagementSection = document.getElementById('employeeManagementSection');

    const pageTitle = document.getElementById('pageTitle');
    const pageSubtitle = document.getElementById('pageSubtitle');

    const cardTracker = document.getElementById('cardTracker');
    const cardTotal = document.getElementById('cardTotal');

    const tableTitle = document.getElementById('tableTitle');
    const tableDescription = document.getElementById('tableDescription');
    const tableFooterText = document.getElementById('tableFooterText');
    const emptyState = document.getElementById('emptyState');
    const tableHeadTracker = document.getElementById('tableHeadTracker');
    const tableHeadTotal = document.getElementById('tableHeadTotal');

    const itemsTrackerSearchWrap = document.getElementById('itemsTrackerSearchWrap');
    const itemsTrackerSearchInput = document.getElementById('itemsTrackerSearchInput');
    const trackerSearchNoResults = document.getElementById('trackerSearchNoResults');

    const tbodyTracker = document.getElementById('tbodyTracker');
    const tbodyTotal = document.getElementById('tbodyTotal');
    const trackerHistoryModal = document.getElementById('trackerHistoryModal');
    const closeTrackerHistoryModal = document.getElementById('closeTrackerHistoryModal');
    const dismissTrackerHistoryModal = document.getElementById('dismissTrackerHistoryModal');
    const trackerHistoryTitle = document.getElementById('trackerHistoryTitle');
    const trackerHistorySubtitle = document.getElementById('trackerHistorySubtitle');
    const incomingHistoryList = document.getElementById('incomingHistoryList');
    const outgoingHistoryList = document.getElementById('outgoingHistoryList');

    const employeeSelect = document.getElementById('employeeSelect');
    const searchInput = document.querySelector('input[name="search"]');
    const employeeTypeField = document.getElementById('employeeTypeField');
    const employeeNumberField = document.getElementById('employeeNumberField');
    const employeeCenterField = document.getElementById('employeeCenterField');
    const inventoryPortalTableBody = document.getElementById('inventoryPortalTableBody');
    const inventoryPortalPaginationEl = document.getElementById('inventoryPortalPagination');
    const employeeManagementPaginationEl = document.getElementById('employeeManagementPagination');
    const accountabilityFilter = document.getElementById('accountabilityFilter');

    const INVENTORY_PORTAL_PAGE_SIZE = 5;
    const EMPLOYEE_MANAGEMENT_PAGE_SIZE = 5;
    let inventoryPortalCurrentPage = 1;
    let employeeManagementCurrentPage = 1;

    // Add Item Modal
    const openAddItemModal = document.getElementById('openAddItemModal');
    const addItemModal = document.getElementById('addItemModal');
    const closeAddItemModal = document.getElementById('closeAddItemModal');
    const cancelAddItemModal = document.getElementById('cancelAddItemModal');
    const currentDateField = document.getElementById('currentDateField');
    const addItemForm = document.getElementById('addItemForm');
    const formErrorToast = document.getElementById('formErrorToast');
    const formErrorToastMessage = document.getElementById('formErrorToastMessage');

    // Edit Item Modal
    const editItemModal = document.getElementById('editItemModal');
    const editItemForm = document.getElementById('editItemForm');
    const closeEditItemModalBtn = document.getElementById('closeEditItemModal');
    const cancelEditItemModalBtn = document.getElementById('cancelEditItemModal');
    const editEmployeeIdField = document.getElementById('editEmployeeIdField');
    const editPropertyNumberField = document.getElementById('editPropertyNumberField');
    const editAccountCodeField = document.getElementById('editAccountCodeField');
    const editSerialNumberField = document.getElementById('editSerialNumberField');
    const editMrrField = document.getElementById('editMrrField');
    const editDescriptionField = document.getElementById('editDescriptionField');
    const editUnitCostField = document.getElementById('editUnitCostField');
    const editCenterField = document.getElementById('editCenterField');
    const editStatusField = document.getElementById('editStatusField');
    const editEndUserField = document.getElementById('editEndUserField');
    const editAccountabilityField = document.getElementById('editAccountabilityField');
    const editRemarksField = document.getElementById('editRemarksField');
    const employeeManagementTableBody = document.getElementById('employeeManagementTableBody');
    const editEmployeeModal = document.getElementById('editEmployeeModal');
    const editEmployeeForm = document.getElementById('editEmployeeForm');
    const closeEditEmployeeModalBtn = document.getElementById('closeEditEmployeeModal');
    const cancelEditEmployeeModalBtn = document.getElementById('cancelEditEmployeeModal');
    const editEmployeeNumberField = document.getElementById('editEmployeeNumberField');
    const editEmployeeNameField = document.getElementById('editEmployeeNameField');
    const editEmployeeEmailField = document.getElementById('editEmployeeEmailField');
    const editEmployeeEmailHint = document.getElementById('editEmployeeEmailHint');
    const editEmployeeCenterField = document.getElementById('editEmployeeCenterField');
    const editEmployeeTypeField = document.getElementById('editEmployeeTypeField');
    const editEmployeeRoleField = document.getElementById('editEmployeeRoleField');
    const editEmployeeRoleHint = document.getElementById('editEmployeeRoleHint');
    const openAddEmployeeModalBtn = document.getElementById('openAddEmployeeModal');
    const addEmployeeModal = document.getElementById('addEmployeeModal');
    const addEmployeeForm = document.getElementById('addEmployeeForm');
    const closeAddEmployeeModalBtn = document.getElementById('closeAddEmployeeModal');
    const cancelAddEmployeeModalBtn = document.getElementById('cancelAddEmployeeModal');

    const csrfToken = '{{ csrf_token() }}';
    const addItemDuplicateCheckUrl = @json(route('admin.coordinator.items.duplicate-check'));

    const dashboardCounts = {
        tracker: {{ $trackerCount }},
        total: {{ $totalCount }},
    };

    function activateSidebar(activeBtn, allButtons) {
        allButtons.forEach((button) => {
            if (!button) {
                return;
            }

            button.classList.remove('bg-[#47698f]', 'text-white');
            button.classList.add('text-white/90', 'hover:bg-white/10');
        });

        if (activeBtn) {
            activeBtn.classList.add('bg-[#47698f]', 'text-white');
            activeBtn.classList.remove('text-white/90', 'hover:bg-white/10');
        }
    }

    function resetCards() {
        [cardTracker, cardTotal].forEach(card => {
            card.classList.remove('border-2', 'border-[#2f73ff]');
            card.classList.add('border', 'border-gray-200');
        });
    }

    function hideAllTables() {
        tbodyTracker.classList.add('hidden');
        tbodyTotal.classList.add('hidden');
    }

    function showTableHead(mode) {
        if (mode === 'tracker') {
            tableHeadTracker.classList.remove('hidden');
            tableHeadTotal.classList.add('hidden');
            return;
        }

        tableHeadTracker.classList.add('hidden');
        tableHeadTotal.classList.remove('hidden');
    }

    function createHistoryListItem(value) {
        const li = document.createElement('li');
        li.className = 'rounded-lg bg-white/80 border border-white px-3 py-2';
        li.textContent = value;

        return li;
    }

    function renderHistoryList(container, values, emptyLabel) {
        if (!container) {
            return;
        }

        container.innerHTML = '';
        if (!Array.isArray(values) || values.length === 0) {
            const li = createHistoryListItem(emptyLabel);
            container.appendChild(li);
            return;
        }

        values.forEach((value) => {
            const li = createHistoryListItem(String(value));
            container.appendChild(li);
        });
    }

    function closeTrackerHistoryModalDialog() {
        if (trackerHistoryModal) {
            trackerHistoryModal.classList.add('hidden');
            trackerHistoryModal.classList.remove('flex');
        }
    }

    function parseHistoryData(row, attributeName) {
        try {
            const parsed = JSON.parse(row.getAttribute(attributeName) || '[]');
            return Array.isArray(parsed) ? parsed : [];
        } catch (error) {
            return [];
        }
    }

    function showTrackerHistoryModalFromRow(row) {
        if (!row || !trackerHistoryModal || !trackerHistoryTitle || !trackerHistorySubtitle) {
            return;
        }

        const propNo = String(row.getAttribute('data-prop-no') || '').trim() || 'N/A';
        const description = String(row.getAttribute('data-description') || '').trim() || 'N/A';
        const incomingHistory = parseHistoryData(row, 'data-incoming-history');
        const outgoingHistory = parseHistoryData(row, 'data-outgoing-history');

        trackerHistoryTitle.textContent = `Item Movement History - ${propNo}`;
        trackerHistorySubtitle.textContent = description;

        renderHistoryList(incomingHistoryList, incomingHistory, 'No incoming history found.');
        renderHistoryList(outgoingHistoryList, outgoingHistory, 'No outgoing history found.');

        trackerHistoryModal.classList.remove('hidden');
        trackerHistoryModal.classList.add('flex');
    }

    function showEmptyState(message = 'No inventory data available yet.') {
        emptyState.textContent = message;
        emptyState.classList.remove('hidden');
    }

    function setFooterText(message) {
        if (tableFooterText) {
            tableFooterText.textContent = message;
        }
    }

    function resetTrackerTableRowsToServerOrder() {
        if (!tbodyTracker) {
            return;
        }

        tbodyTracker.querySelectorAll('tr.tracker-item-row').forEach((row) => {
            row.classList.remove('hidden');
            const orig = row.getAttribute('data-row-original-index');
            const firstTd = row.querySelector('td:first-child');

            if (firstTd && orig !== null) {
                firstTd.textContent = orig;
            }
        });
    }

    function updateTrackerFilterCopy(visibleCount, totalCount, query) {
        const q = (query || '').trim();

        if (tableDescription) {
            if (q === '') {
                tableDescription.textContent = `Showing ${totalCount} item(s) with movement history`;
            } else if (visibleCount === 0 && totalCount > 0) {
                tableDescription.textContent = 'No items match your search';
            } else {
                tableDescription.textContent = `Showing ${visibleCount} of ${totalCount} item(s) matching your search`;
            }
        }

        if (q === '') {
            setFooterText(`Showing ${totalCount} item(s)`);
        } else if (visibleCount === 0 && totalCount > 0) {
            setFooterText('No matches');
        } else {
            setFooterText(`Showing ${visibleCount} of ${totalCount} item(s)`);
        }
    }

    function applyItemsTrackerFilter() {
        if (!tbodyTracker || !itemsTrackerSearchInput) {
            return;
        }

        const totalCount = dashboardCounts.tracker;

        if (totalCount === 0) {
            return;
        }

        const q = (itemsTrackerSearchInput.value || '').trim().toLowerCase();
        const rows = tbodyTracker.querySelectorAll('tr.tracker-item-row');

        if (q === '') {
            resetTrackerTableRowsToServerOrder();

            if (trackerSearchNoResults) {
                trackerSearchNoResults.classList.add('hidden');
            }

            updateTrackerFilterCopy(totalCount, totalCount, '');

            return;
        }

        let visible = 0;

        rows.forEach((row) => {
            const prop = (row.getAttribute('data-prop-no') || '').toLowerCase();
            const desc = (row.getAttribute('data-description') || '').toLowerCase();
            const owner = (row.getAttribute('data-owner-name') || '').toLowerCase();
            const match = prop.includes(q) || desc.includes(q) || owner.includes(q);

            row.classList.toggle('hidden', !match);

            if (match) {
                visible++;
            }
        });

        let n = 0;

        rows.forEach((row) => {
            if (row.classList.contains('hidden')) {
                return;
            }

            n++;
            const firstTd = row.querySelector('td:first-child');

            if (firstTd) {
                firstTd.textContent = String(n);
            }
        });

        if (trackerSearchNoResults) {
            trackerSearchNoResults.classList.toggle('hidden', visible !== 0);
        }

        updateTrackerFilterCopy(visible, totalCount, q);
    }

    function showCoordinatorGatepassRequestSection() {
        if (gatepassEmployeePanel) {
            gatepassEmployeePanel.classList.remove('hidden');
        }

        dashboardSection.classList.add('hidden');
        inventoryPortalSection.classList.add('hidden');
        employeeManagementSection.classList.add('hidden');

        pageSubtitle.textContent = 'My gate pass requests';

        if (openAddItemModal) {
            openAddItemModal.classList.add('hidden');
        }

        if (typeof window.coordinatorGatepassLazyInit === 'function') {
            window.coordinatorGatepassLazyInit();
        }

        if (typeof window.coordinatorGpShowMyRequestsPanel === 'function') {
            window.coordinatorGpShowMyRequestsPanel();
        }

        activateSidebar(navGatepassRequest, sidebarNavAll);

        if (window.location.hash !== '#gatepass-request') {
            window.history.replaceState(null, '', '#gatepass-request');
        }
    }

    function showCoordinatorGatepassHistorySection() {
        if (gatepassEmployeePanel) {
            gatepassEmployeePanel.classList.remove('hidden');
        }

        dashboardSection.classList.add('hidden');
        inventoryPortalSection.classList.add('hidden');
        employeeManagementSection.classList.add('hidden');

        pageSubtitle.textContent = 'Request history';

        if (openAddItemModal) {
            openAddItemModal.classList.add('hidden');
        }

        if (typeof window.coordinatorGatepassLazyInit === 'function') {
            window.coordinatorGatepassLazyInit();
        }

        if (typeof window.coordinatorGpShowHistoryPanel === 'function') {
            window.coordinatorGpShowHistoryPanel();
        }

        activateSidebar(navGatepassHistory, sidebarNavAll);

        if (window.location.hash !== '#gatepass-history') {
            window.history.replaceState(null, '', '#gatepass-history');
        }
    }

    function showDashboardSection() {
        if (gatepassEmployeePanel) {
            gatepassEmployeePanel.classList.add('hidden');
        }

        dashboardSection.classList.remove('hidden');
        inventoryPortalSection.classList.add('hidden');
        employeeManagementSection.classList.add('hidden');

        pageTitle.textContent = 'Dashboard';
        pageSubtitle.textContent = 'List of Inventory';

        if (newRequestBtn) {
            newRequestBtn.classList.add('hidden');
        }

        if (openAddItemModal) {
            openAddItemModal.classList.add('hidden');
        }

        activateSidebar(navDashboard, sidebarNavAll);
        showTracker();
        if (window.location.hash !== '#dashboard') {
            window.history.replaceState(null, '', '#dashboard');
        }
    }

    function showInventoryPortalSection() {
        if (gatepassEmployeePanel) {
            gatepassEmployeePanel.classList.add('hidden');
        }

        dashboardSection.classList.add('hidden');
        inventoryPortalSection.classList.remove('hidden');
        employeeManagementSection.classList.add('hidden');

        pageTitle.textContent = 'Inventory Portal';
        pageSubtitle.textContent = 'Manage all equipment inventory';

        if (newRequestBtn) {
            newRequestBtn.classList.add('hidden');
        }

        if (openAddItemModal) {
            openAddItemModal.classList.remove('hidden');
        }

        activateSidebar(navInventoryPortal, sidebarNavAll);
        if (window.location.hash !== '#inventory-portal') {
            window.history.replaceState(null, '', '#inventory-portal');
        }
    }

    function showEmployeeManagementSection() {
        if (gatepassEmployeePanel) {
            gatepassEmployeePanel.classList.add('hidden');
        }

        dashboardSection.classList.add('hidden');
        inventoryPortalSection.classList.add('hidden');
        employeeManagementSection.classList.remove('hidden');

        pageTitle.textContent = 'Employee Management';
        pageSubtitle.textContent = 'Manage employee records';

        if (newRequestBtn) {
            newRequestBtn.classList.add('hidden');
        }

        if (openAddItemModal) {
            openAddItemModal.classList.add('hidden');
        }

        activateSidebar(navEmployeeManagement, sidebarNavAll);
        if (window.location.hash !== '#employee-management') {
            window.history.replaceState(null, '', '#employee-management');
        }

        loadEmployees();
    }

    function showTracker() {
        resetCards();
        hideAllTables();

        cardTracker.classList.remove('border', 'border-gray-200');
        cardTracker.classList.add('border-2', 'border-[#2f73ff]');
        tbodyTracker.classList.remove('hidden');
        showTableHead('tracker');

        tableTitle.textContent = 'Items Tracker';
        closeTrackerHistoryModalDialog();

        if (itemsTrackerSearchWrap) {
            itemsTrackerSearchWrap.classList.toggle('hidden', dashboardCounts.tracker === 0);
        }

        if (itemsTrackerSearchInput) {
            itemsTrackerSearchInput.value = '';
        }

        if (trackerSearchNoResults) {
            trackerSearchNoResults.classList.add('hidden');
        }

        resetTrackerTableRowsToServerOrder();

        if (dashboardCounts.tracker > 0) {
            emptyState.classList.add('hidden');
        } else {
            showEmptyState('No incoming/outgoing movement records available yet.');
        }

        updateTrackerFilterCopy(dashboardCounts.tracker, dashboardCounts.tracker, '');
    }

    function showTotal() {
        resetCards();
        hideAllTables();

        cardTotal.classList.remove('border', 'border-gray-200');
        cardTotal.classList.add('border-2', 'border-[#2f73ff]');
        tbodyTotal.classList.remove('hidden');
        showTableHead('total');

        tableTitle.textContent = 'Total Inventory Items';
        tableDescription.textContent = `Showing ${dashboardCounts.total} total item(s)`;
        setFooterText(`Showing ${dashboardCounts.total} item(s)`);
        closeTrackerHistoryModalDialog();

        if (itemsTrackerSearchWrap) {
            itemsTrackerSearchWrap.classList.add('hidden');
        }

        if (itemsTrackerSearchInput) {
            itemsTrackerSearchInput.value = '';
        }

        if (trackerSearchNoResults) {
            trackerSearchNoResults.classList.add('hidden');
        }

        resetTrackerTableRowsToServerOrder();

        if (dashboardCounts.total > 0) {
            emptyState.classList.add('hidden');
        } else {
            showEmptyState('No inventory items available yet.');
        }
    }

    function setTodayDate() {
        if (!currentDateField) return;

        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        currentDateField.value = `${year}-${month}-${day}`;
    }

    function showFormErrorToast(message) {
        if (!formErrorToast) {
            return;
        }

        if (formErrorToastMessage) {
            formErrorToastMessage.textContent = message;
        }

        formErrorToast.classList.remove('show-form-error-toast');
        void formErrorToast.offsetWidth;
        formErrorToast.classList.add('show-form-error-toast');
    }

    const addEmployeeFormErrorAlert = document.getElementById('addEmployeeFormErrorAlert');
    const addEmployeeFormErrorAlertMessage = document.getElementById('addEmployeeFormErrorAlertMessage');
    const addEmployeeEmailField = document.getElementById('addEmployeeEmailField');
    const editEmployeeFormErrorAlert = document.getElementById('editEmployeeFormErrorAlert');
    const editEmployeeFormErrorAlertMessage = document.getElementById('editEmployeeFormErrorAlertMessage');

    function isDuplicateEmailServerError(emailErrors) {
        if (!emailErrors) {
            return false;
        }

        const emailMessage = Array.isArray(emailErrors) ? emailErrors[0] : emailErrors;
        const emailText = String(emailMessage ?? '');

        if (emailText.length === 0) {
            return false;
        }

        return /already\s+(been\s+)?(taken|registered)|email\s+has\s+already|already registered|must\s+be\s+unique|has\s+already\s+been\s+taken/i.test(emailText);
    }

    function showAddEmployeeEmailExistsAlert(message) {
        const text = message && String(message).trim() !== '' ? String(message).trim() : 'This email already exists.';

        if (addEmployeeFormErrorAlertMessage) {
            addEmployeeFormErrorAlertMessage.textContent = text;
        }

        if (addEmployeeFormErrorAlert) {
            addEmployeeFormErrorAlert.classList.remove('show-add-employee-email-exists');
            void addEmployeeFormErrorAlert.offsetWidth;
            addEmployeeFormErrorAlert.classList.add('show-add-employee-email-exists');
        }

        if (addEmployeeEmailField) {
            addEmployeeEmailField.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
            void addEmployeeEmailField.offsetWidth;
            addEmployeeEmailField.classList.add('ring-2', 'ring-red-500', 'ring-offset-2');
            window.setTimeout(function () {
                addEmployeeEmailField.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
            }, 2800);
        }
    }

    function showEditEmployeeEmailExistsAlert(message) {
        const text = message && String(message).trim() !== '' ? String(message).trim() : 'This email already exists.';

        if (editEmployeeFormErrorAlertMessage) {
            editEmployeeFormErrorAlertMessage.textContent = text;
        }

        if (editEmployeeFormErrorAlert) {
            editEmployeeFormErrorAlert.classList.remove('show-edit-employee-email-exists');
            void editEmployeeFormErrorAlert.offsetWidth;
            editEmployeeFormErrorAlert.classList.add('show-edit-employee-email-exists');
        }

        if (editEmployeeEmailField) {
            editEmployeeEmailField.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
            void editEmployeeEmailField.offsetWidth;
            editEmployeeEmailField.classList.add('ring-2', 'ring-red-500', 'ring-offset-2');
            window.setTimeout(function () {
                editEmployeeEmailField.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
            }, 2800);
        }
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
                        'Accept': 'application/json',
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
                showItemSuccessToast(data.message || 'Profile updated successfully');

                if (data.data) {
                    const nameInput = document.getElementById('profileEmployeeName');
                    const centerInput = document.getElementById('profileCenter');
                    const emailInput = document.getElementById('profileEmail');

                    if (nameInput) {
                        nameInput.value = data.data.employee_name || '';
                    }

                    if (centerInput) {
                        centerInput.value = data.data.center || '';
                    }

                    if (emailInput) {
                        emailInput.value = data.data.email || '';
                    }
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

    function openAdminProfileModal() {
        const modal = document.getElementById('adminProfileModal');
        if (!modal) {
            return;
        }

        adminClearProfileFormMessages();

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeAdminProfileModal() {
        const modal = document.getElementById('adminProfileModal');
        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    window.addEventListener('click', function (e) {
        const modal = document.getElementById('adminProfileModal');
        if (!modal || modal.classList.contains('hidden')) {
            return;
        }

        if (e.target === modal) {
            closeAdminProfileModal();
        }
    });

    adminWireProfileForm();

    function isBlank(value) {
        return value === null || value === undefined || String(value).trim() === '';
    }

    function formatDetail(value) {
        if (value === null || value === undefined) {
            return 'N/A';
        }
        const trimmed = String(value).trim();
        return trimmed === '' ? 'N/A' : trimmed;
    }

    function formatEmployeeTimestamp(value) {
        if (value === null || value === undefined) {
            return '-';
        }

        const trimmed = String(value).trim();
        if (trimmed === '') {
            return '-';
        }

        const parsedDate = new Date(trimmed);
        if (Number.isNaN(parsedDate.getTime())) {
            return trimmed;
        }

        const year = parsedDate.getFullYear();
        const month = String(parsedDate.getMonth() + 1).padStart(2, '0');
        const day = String(parsedDate.getDate()).padStart(2, '0');
        const hours = String(parsedDate.getHours()).padStart(2, '0');
        const minutes = String(parsedDate.getMinutes()).padStart(2, '0');
        const seconds = String(parsedDate.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    function rowMatchesAccountabilityFilter(row, filter) {
        const rowAccountability = row.getAttribute('data-accountability') || 'accountable';

        if (filter === 'all') {
            return true;
        }
        if (filter === 'accountable') {
            return rowAccountability === 'accountable';
        }
        if (filter === 'unaccountable') {
            return rowAccountability === 'unaccountable';
        }

        return true;
    }

    function renderNumberedPaginationUI(container, currentPage, totalPages, onPageSelect) {
        if (!container) {
            return;
        }

        if (totalPages <= 1) {
            container.classList.add('hidden');
            container.innerHTML = '';

            return;
        }

        container.classList.remove('hidden');
        container.innerHTML = '';

        const baseBtn = 'min-w-[36px] h-9 rounded-lg text-[14px] font-medium transition px-2';
        const activeClasses = 'bg-[#003b95] text-white shadow-sm';
        const inactiveClasses = 'border border-gray-300 bg-white text-black hover:bg-gray-50';

        for (let p = 1; p <= totalPages; p += 1) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `${baseBtn} ${p === currentPage ? activeClasses : inactiveClasses}`;
            btn.textContent = String(p);
            btn.setAttribute('aria-label', `Page ${p}`);
            if (p === currentPage) {
                btn.setAttribute('aria-current', 'page');
            } else {
                btn.removeAttribute('aria-current');
            }
            btn.addEventListener('click', () => onPageSelect(p));
            container.appendChild(btn);
        }
    }

    /**
     * Employee Management: prev/next + at most three page number buttons, right-aligned in container.
     *
     * @param {number} currentPage
     * @param {number} totalPages
     * @param {number} [maxNumbers]
     * @returns {number[]}
     */
    function getEmployeePaginationVisiblePages(currentPage, totalPages, maxNumbers) {
        const max = maxNumbers ?? 3;

        if (totalPages <= max) {
            return Array.from({ length: totalPages }, (_, i) => i + 1);
        }

        const half = Math.floor(max / 2);
        let start = currentPage - half;

        if (start < 1) {
            start = 1;
        }

        if (start + max - 1 > totalPages) {
            start = totalPages - max + 1;
        }

        return Array.from({ length: max }, (_, i) => start + i);
    }

    function renderEmployeePaginationUI(container, currentPage, totalPages, onPageSelect) {
        if (!container) {
            return;
        }

        if (totalPages <= 1) {
            container.classList.add('hidden');
            container.innerHTML = '';

            return;
        }

        container.classList.remove('hidden');
        container.innerHTML = '';

        const baseBtn = 'min-w-[36px] h-9 rounded-lg text-[14px] font-medium transition px-2 shrink-0';
        const activeClasses = 'bg-[#003b95] text-white shadow-sm';
        const inactiveClasses = 'border border-gray-300 bg-white text-black hover:bg-gray-50';
        const navBtn = `${baseBtn} border border-gray-300 bg-white text-[#111827] hover:bg-gray-50 disabled:opacity-45 disabled:cursor-not-allowed disabled:hover:bg-white px-3`;

        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = navBtn;
        prevBtn.textContent = 'Prev';
        prevBtn.setAttribute('aria-label', 'Previous page');
        prevBtn.disabled = currentPage <= 1;
        prevBtn.addEventListener('click', () => onPageSelect(currentPage - 1));

        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = navBtn;
        nextBtn.textContent = 'Next';
        nextBtn.setAttribute('aria-label', 'Next page');
        nextBtn.disabled = currentPage >= totalPages;
        nextBtn.addEventListener('click', () => onPageSelect(currentPage + 1));

        container.appendChild(prevBtn);

        const visiblePages = getEmployeePaginationVisiblePages(currentPage, totalPages, 3);

        visiblePages.forEach((p) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `${baseBtn} ${p === currentPage ? activeClasses : inactiveClasses}`;
            btn.textContent = String(p);
            btn.setAttribute('aria-label', `Page ${p}`);
            if (p === currentPage) {
                btn.setAttribute('aria-current', 'page');
            }
            btn.addEventListener('click', () => onPageSelect(p));
            container.appendChild(btn);
        });

        container.appendChild(nextBtn);
    }

    function refreshInventoryPortalTableView(requestedPage) {
        if (!inventoryPortalTableBody) {
            return;
        }

        const filter = accountabilityFilter?.value || 'all';
        const dataRows = Array.from(inventoryPortalTableBody.querySelectorAll('tr[data-inventory-id]'));

        if (dataRows.length === 0) {
            inventoryPortalCurrentPage = 1;
            if (inventoryPortalPaginationEl) {
                inventoryPortalPaginationEl.classList.add('hidden');
                inventoryPortalPaginationEl.innerHTML = '';
            }

            return;
        }

        const visibleFiltered = dataRows.filter((row) => rowMatchesAccountabilityFilter(row, filter));

        if (visibleFiltered.length === 0) {
            dataRows.forEach((row) => row.classList.add('hidden'));
            inventoryPortalCurrentPage = 1;
            if (inventoryPortalPaginationEl) {
                inventoryPortalPaginationEl.classList.add('hidden');
                inventoryPortalPaginationEl.innerHTML = '';
            }

            return;
        }

        const totalPages = Math.ceil(visibleFiltered.length / INVENTORY_PORTAL_PAGE_SIZE);
        const nextPage = requestedPage !== undefined ? requestedPage : inventoryPortalCurrentPage;
        inventoryPortalCurrentPage = Math.max(1, Math.min(nextPage, totalPages));

        const start = (inventoryPortalCurrentPage - 1) * INVENTORY_PORTAL_PAGE_SIZE;

        dataRows.forEach((row) => {
            const fi = visibleFiltered.indexOf(row);

            if (fi === -1) {
                row.classList.add('hidden');

                return;
            }

            const inPage = fi >= start && fi < start + INVENTORY_PORTAL_PAGE_SIZE;
            row.classList.toggle('hidden', !inPage);

            if (inPage) {
                const firstTd = row.querySelector('td:first-child');
                if (firstTd) {
                    firstTd.textContent = String(fi + 1);
                }
                row.classList.remove('bg-white', 'bg-gray-50');
                row.classList.add(fi % 2 === 0 ? 'bg-white' : 'bg-gray-50');
            }
        });

        renderNumberedPaginationUI(
            inventoryPortalPaginationEl,
            inventoryPortalCurrentPage,
            totalPages,
            (p) => refreshInventoryPortalTableView(p),
        );
    }

    function applyEmployeeManagementPagination(requestedPage) {
        if (!employeeManagementTableBody) {
            return;
        }

        const dataRows = Array.from(employeeManagementTableBody.querySelectorAll('tr[data-employee-id]'));

        if (dataRows.length === 0) {
            employeeManagementCurrentPage = 1;
            if (employeeManagementPaginationEl) {
                employeeManagementPaginationEl.classList.add('hidden');
                employeeManagementPaginationEl.innerHTML = '';
            }

            return;
        }

        const totalPages = Math.ceil(dataRows.length / EMPLOYEE_MANAGEMENT_PAGE_SIZE);
        const nextPage = requestedPage !== undefined ? requestedPage : employeeManagementCurrentPage;
        employeeManagementCurrentPage = Math.max(1, Math.min(nextPage, totalPages));

        const start = (employeeManagementCurrentPage - 1) * EMPLOYEE_MANAGEMENT_PAGE_SIZE;

        dataRows.forEach((row, fi) => {
            const inPage = fi >= start && fi < start + EMPLOYEE_MANAGEMENT_PAGE_SIZE;
            row.classList.toggle('hidden', !inPage);

            if (inPage) {
                const firstTd = row.querySelector('td:first-child');
                if (firstTd) {
                    firstTd.textContent = String(fi + 1);
                }
                row.classList.remove('bg-white', 'bg-gray-50');
                row.classList.add(fi % 2 === 0 ? 'bg-white' : 'bg-gray-50');
            }
        });

        renderEmployeePaginationUI(
            employeeManagementPaginationEl,
            employeeManagementCurrentPage,
            totalPages,
            (p) => applyEmployeeManagementPagination(p),
        );
    }

    function renderEmployeeRows(employees) {
        if (!employeeManagementTableBody) {
            return;
        }

        employeeManagementTableBody.innerHTML = '';

        if (!employees || employees.length === 0) {
            employeeManagementTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-[14px] text-[#98a2b3]">
                        No employees available.
                    </td>
                </tr>
            `;
            applyEmployeeManagementPagination(1);

            return;
        }

        employees.forEach((employeeRecord, index) => {
            const row = document.createElement('tr');
            row.setAttribute('data-employee-id', (employeeRecord.employee_id ?? '').toString());
            row.className = `${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'} text-[14px] text-[#111827]`;
            row.innerHTML = `
                <td class="px-4 py-3 align-top">${index + 1}</td>
                <td class="px-4 py-3 align-top">${employeeRecord.employee_id ?? ''}</td>
                <td class="px-4 py-3 align-top">${employeeRecord.employee_name ?? ''}</td>
                <td class="px-4 py-3 align-top">${employeeRecord.center ?? ''}</td>
                <td class="px-4 py-3 align-top">${employeeRecord.employee_type ?? '—'}</td>
                <td class="px-4 py-3 align-top">${formatEmployeeTimestamp(employeeRecord.created_at)}</td>
                <td class="px-4 py-3 align-top">
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            class="employee-edit p-1.5 rounded-lg border border-gray-300 text-xs text-[#047857] hover:bg-gray-50 transition"
                            data-employee-id="${employeeRecord.employee_id ?? ''}"
                            data-employee-name="${employeeRecord.employee_name ?? ''}"
                            data-email="${employeeRecord.email ?? ''}"
                            data-user-linked="${employeeRecord.user_id ? '1' : '0'}"
                            data-center="${employeeRecord.center ?? ''}"
                            data-employee-type="${employeeRecord.employee_type ?? ''}"
                            data-role="${employeeRecord.role ?? ''}"
                            data-update-url="/coordinator/employees/${employeeRecord.employee_id ?? ''}"
                            title="Edit employee"
                        >
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <form method="POST" action="/coordinator/employees/${employeeRecord.employee_id ?? ''}" class="employee-delete-form">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button
                                type="submit"
                                class="employee-delete p-1.5 rounded-lg border border-red-300 text-xs text-red-600 hover:bg-red-50 transition"
                                title="Delete employee"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            `;
            employeeManagementTableBody.appendChild(row);
        });

        applyEmployeeManagementPagination(1);
    }

    async function loadEmployees() {
        try {
            const response = await fetch('/coordinator/employees', {
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                return;
            }

            const data = await response.json();
            renderEmployeeRows(data.employees ?? []);
        } catch (error) {
            // silent fail
        }
    }

    function statusLabelFromCode(code) {
        switch (code) {
            case 'A':
                return 'Active';
            case 'I':
                return 'In Use';
            case 'D':
                return 'Defective/Disposed';
            default:
                return code || '';
        }
    }

    async function loadEmployeeInventory() {
        if (!employeeSelect || !inventoryPortalTableBody) {
            return;
        }

        const params = new URLSearchParams();
        if (employeeSelect.value) {
            params.append('employee_id', employeeSelect.value);
        }
        if (searchInput && searchInput.value) {
            params.append('search', searchInput.value);
        }

        try {
            const response = await fetch(`/coordinator/dashboard?${params.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                return;
            }

            const data = await response.json();

            if (employeeTypeField) {
                employeeTypeField.value = data.selectedEmployee?.employee_type ?? '';
            }
            if (employeeNumberField) {
                employeeNumberField.value = data.selectedEmployeeId ?? '';
            }
            if (employeeCenterField) {
                employeeCenterField.value = data.selectedEmployee?.center ?? '';
            }

            inventoryPortalTableBody.innerHTML = '';

            if (!data.items || data.items.length === 0) {
                const hasSearch = !!(searchInput && searchInput.value && searchInput.value.trim() !== '');

                inventoryPortalTableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-[14px] text-[#98a2b3]">
                            ${hasSearch ? 'No records found.' : 'No inventory items available for the selected employee.'}
                        </td>
                    </tr>
                `;
                refreshInventoryPortalTableView(1);

                return;
            }

            data.items.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = `${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'} text-[14px] text-[#111827]`;
                row.setAttribute('data-inventory-id', (item.id ?? '').toString());
                row.setAttribute(
                    'data-accountability',
                    (item.accountability ?? 'Accountable').toString().toLowerCase()
                );
                row.innerHTML = `
                    <td class="px-4 py-3 align-top">${index + 1}</td>
                    <td class="px-4 py-3 align-top">${item.prop_no ?? ''}</td>
                    <td class="px-4 py-3 align-top">${item.acct_code ?? ''}</td>
                    <td class="px-4 py-3 align-top">${item.serial_no ?? ''}</td>
                    <td class="px-4 py-3 align-top">${item.description ?? ''}</td>
                    <td class="px-4 py-3 align-top">
                        ${item.unit_cost !== null && item.unit_cost !== undefined ? Number(item.unit_cost).toFixed(2) : ''}
                    </td>
                    <td class="px-4 py-3 align-top">${statusLabelFromCode(item.status ?? '')}</td>
                    <td class="px-4 py-3 align-top">
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                class="inventory-see-more px-2.5 py-1 rounded-lg border border-gray-300 text-[13px] text-[#003b95] hover:bg-gray-50 transition"
                                data-mrr="${item.mrr_no ?? ''}"
                                data-center="${item.center ?? data.selectedEmployee?.center ?? ''}"
                                data-accountability="${item.accountability ?? 'Accountable'}"
                                data-end-user="${item.end_user ?? ''}"
                                data-movement-type="${item.latest_movement?.type ?? ''}"
                                data-movement-requester="${item.latest_movement?.requester_name ?? ''}"
                                data-movement-datetime="${item.latest_movement?.datetime ?? ''}"
                                title="See more details"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button
                                type="button"
                                class="inventory-edit px-2.5 py-1 rounded-lg border border-gray-300 text-[13px] text-[#047857] hover:bg-gray-50 transition"
                                data-update-url="/coordinator/items/${item.id}"
                                data-inventory-id="${item.id ?? ''}"
                                data-employee-id="${data.selectedEmployeeId ?? ''}"
                                data-prop-no="${item.prop_no ?? ''}"
                                data-acct-code="${item.acct_code ?? ''}"
                                data-serial-no="${item.serial_no ?? ''}"
                                data-description="${item.description ?? ''}"
                                data-unit-cost="${item.unit_cost ?? ''}"
                                data-center="${item.center ?? data.selectedEmployee?.center ?? ''}"
                                data-status="${item.status ?? ''}"
                                data-accountability="${item.accountability ?? 'Accountable'}"
                                data-end-user="${item.end_user ?? ''}"
                                data-remarks="${item.remarks ?? ''}"
                                data-mrr="${item.mrr_no ?? ''}"
                                title="Edit equipment"
                            >
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form method="POST" action="/coordinator/items/${item.id}" class="inventory-delete-form">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="employee_id" value="${data.selectedEmployeeId ?? ''}">
                                <button
                                    type="submit"
                                    class="inventory-delete px-2 py-1 rounded-lg border border-red-300 text-[13px] text-red-600 hover:bg-red-50 transition"
                                    title="Delete"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                `;
                inventoryPortalTableBody.appendChild(row);
            });

            refreshInventoryPortalTableView(1);
        } catch (e) {
            // fail silently for now
        }
    }

    function openModal(options = {}) {
        if (!addItemModal) return;
        if (options.clearDuplicateState !== false) {
            resetAddItemDuplicateState();
        }
        addItemModal.classList.remove('hidden');
        addItemModal.classList.add('flex');
        setTodayDate();
    }

    function closeModal() {
        if (!addItemModal) return;
        addItemModal.classList.add('hidden');
        addItemModal.classList.remove('flex');
        resetAddItemDuplicateState();

        if (formErrorToast) {
            formErrorToast.classList.remove('show-form-error-toast');
        }
    }

    function showItemSuccessToast(message = 'Equipment updated successfully') {
        const toast = document.getElementById('itemSuccessToast');
        if (!toast) {
            return;
        }

        const span = toast.querySelector('span:last-child');
        if (span) {
            span.textContent = message;
        }

        toast.classList.remove('show-item-success-toast');
        void toast.offsetWidth;
        toast.classList.add('show-item-success-toast');
    }

    function statusLabelFromHumanOrCode(codeOrLabel) {
        const value = (codeOrLabel || '').toString().trim().toUpperCase();
        if (value === 'A' || value === 'AVAILABLE') {
            return 'Available';
        }
        if (value === 'I' || value === 'IN USE') {
            return 'In Use';
        }
        if (value === 'D' || value === 'DEFECTIVE' || value === 'DISPOSED' || value === 'DEFECTIVE/DISPOSED') {
            // Default to "Defective" for code D
            return 'Defective';
        }
        return '';
    }

    function openEditModalFromButton(button) {
        if (!editItemModal || !editItemForm) {
            return;
        }

        const updateUrl = button.getAttribute('data-update-url') || '';
        const inventoryId = button.getAttribute('data-inventory-id') || '';
        const employeeId = button.getAttribute('data-employee-id') || employeeSelect?.value || '';

        editItemForm.action = updateUrl || (inventoryId ? `/coordinator/items/${inventoryId}` : '');

        if (editEmployeeIdField) {
            editEmployeeIdField.value = employeeId || '';
        }
        if (editPropertyNumberField) {
            editPropertyNumberField.value = button.getAttribute('data-prop-no') || '';
        }
        if (editAccountCodeField) {
            editAccountCodeField.value = button.getAttribute('data-acct-code') || '';
        }
        if (editSerialNumberField) {
            editSerialNumberField.value = button.getAttribute('data-serial-no') || '';
        }
        if (editMrrField) {
            editMrrField.value = button.getAttribute('data-mrr') || '';
        }
        if (editDescriptionField) {
            editDescriptionField.value = button.getAttribute('data-description') || '';
        }
        if (editUnitCostField) {
            editUnitCostField.value = button.getAttribute('data-unit-cost') || '';
        }
        if (editCenterField) {
            const center = button.getAttribute('data-center') || '';
            editCenterField.value = center;
        }
        if (editStatusField) {
            const statusCodeOrLabel = button.getAttribute('data-status') || '';
            const label = statusLabelFromHumanOrCode(statusCodeOrLabel);
            editStatusField.value = label;
        }
        if (editEndUserField) {
            editEndUserField.value = button.getAttribute('data-end-user') || '';
        }
        if (editAccountabilityField) {
            editAccountabilityField.value = button.getAttribute('data-accountability') || '';
        }
        if (editRemarksField) {
            editRemarksField.value = button.getAttribute('data-remarks') || '';
        }

        resetEditItemDuplicateUi();

        editItemModal.classList.remove('hidden');
        editItemModal.classList.add('flex');
    }

    function closeEditModal() {
        if (!editItemModal) {
            return;
        }
        editItemModal.classList.add('hidden');
        editItemModal.classList.remove('flex');
        resetEditItemDuplicateUi();
    }

    let addItemDuplicateCheckTimer = null;
    let addItemDuplicateCheckSeq = 0;
    let lastAddItemDuplicateResult = false;

    function applyAddItemDuplicateFieldStyles(isDuplicate) {
        if (!addItemForm) {
            return;
        }
        ['property_number', 'rca_acctcode', 'serialno'].forEach((name) => {
            const el = addItemForm.querySelector(`[name="${name}"]`);
            if (!el) {
                return;
            }
            if (isDuplicate) {
                el.classList.remove('border-gray-300', 'focus:ring-[#003b95]/20');
                el.classList.add('border-red-500', 'ring-2', 'ring-red-500/40', 'focus:ring-red-500/30');
            } else {
                el.classList.add('border-gray-300', 'focus:ring-[#003b95]/20');
                el.classList.remove('border-red-500', 'ring-2', 'ring-red-500/40', 'focus:ring-red-500/30');
            }
        });
    }

    function resetAddItemDuplicateState() {
        if (addItemDuplicateCheckTimer) {
            clearTimeout(addItemDuplicateCheckTimer);
            addItemDuplicateCheckTimer = null;
        }
        addItemDuplicateCheckSeq += 1;
        lastAddItemDuplicateResult = false;
        applyAddItemDuplicateFieldStyles(false);
    }

    async function fetchAddItemDuplicateStatus(options = {}) {
        const forLiveCheck = options.forLiveCheck !== false;

        if (!addItemForm || !addItemDuplicateCheckUrl) {
            return false;
        }

        const prop = (addItemForm.querySelector('[name="property_number"]')?.value ?? '').trim();
        const acct = (addItemForm.querySelector('[name="rca_acctcode"]')?.value ?? '').trim();
        const serial = (addItemForm.querySelector('[name="serialno"]')?.value ?? '').trim();

        if (!prop || !acct) {
            applyAddItemDuplicateFieldStyles(false);
            lastAddItemDuplicateResult = false;
            return false;
        }

        const seq = ++addItemDuplicateCheckSeq;

        try {
            const url = new URL(addItemDuplicateCheckUrl, window.location.origin);
            url.searchParams.set('property_number', prop);
            url.searchParams.set('rca_acctcode', acct);
            url.searchParams.set('serialno', serial);

            const res = await fetch(url.toString(), {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            if (seq !== addItemDuplicateCheckSeq) {
                return lastAddItemDuplicateResult;
            }

            if (!res.ok) {
                return lastAddItemDuplicateResult;
            }

            const data = await res.json();
            const isDup = !!data.duplicate;

            applyAddItemDuplicateFieldStyles(isDup);

            if (forLiveCheck && isDup && !lastAddItemDuplicateResult) {
                showFormErrorToast('This item already exists.');
            }

            lastAddItemDuplicateResult = isDup;

            return isDup;
        } catch (err) {
            return lastAddItemDuplicateResult;
        }
    }

    function scheduleAddItemDuplicateCheck(immediate) {
        if (!addItemForm) {
            return;
        }
        if (addItemDuplicateCheckTimer) {
            clearTimeout(addItemDuplicateCheckTimer);
            addItemDuplicateCheckTimer = null;
        }
        const run = () => {
            addItemDuplicateCheckTimer = null;
            void fetchAddItemDuplicateStatus({ forLiveCheck: true });
        };
        if (immediate) {
            run();
            return;
        }
        addItemDuplicateCheckTimer = setTimeout(run, 400);
    }

    function wireAddItemDuplicateFieldListeners() {
        if (!addItemForm) {
            return;
        }
        ['property_number', 'rca_acctcode', 'serialno'].forEach((name) => {
            const el = addItemForm.querySelector(`[name="${name}"]`);
            if (!el) {
                return;
            }
            el.addEventListener('blur', () => scheduleAddItemDuplicateCheck(true));
            el.addEventListener('input', () => scheduleAddItemDuplicateCheck(false));
        });
    }

    async function submitAddItemForm(e) {
        if (!addItemForm) {
            return;
        }

        e.preventDefault();

        const propertyNumber = addItemForm.querySelector('[name="property_number"]')?.value;
        const accountCode = addItemForm.querySelector('[name="rca_acctcode"]')?.value;
        const description = addItemForm.querySelector('[name="description"]')?.value;
        const unitCost = addItemForm.querySelector('[name="unit_cost"]')?.value;
        const status = addItemForm.querySelector('[name="status"]')?.value;
        const accountability = addItemForm.querySelector('[name="accountability"]')?.value;

        if (
            isBlank(propertyNumber) ||
            isBlank(accountCode) ||
            isBlank(description) ||
            isBlank(unitCost) ||
            isBlank(status) ||
            isBlank(accountability)
        ) {
            openModal();
            showFormErrorToast('Please complete all required fields before adding equipment.');
            return;
        }

        try {
            const isDuplicate = await fetchAddItemDuplicateStatus({ forLiveCheck: false });
            if (isDuplicate) {
                openModal({ clearDuplicateState: false });
                showFormErrorToast('This item already exists.');
                return;
            }

            const formData = new FormData(addItemForm);

            if (employeeSelect?.value) {
                formData.set('employee_id', employeeSelect.value);
            }

            const response = await fetch(addItemForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const payload = await response.json().catch(() => ({}));

            if (!response.ok) {
                if (response.status === 422) {
                    const errs = payload.errors || {};
                    const dupFields = ['property_number', 'rca_acctcode', 'serialno'];
                    const isDup422 = dupFields.some((f) => (errs[f] || []).some((m) => String(m).includes('already exists')));
                    if (isDup422) {
                        applyAddItemDuplicateFieldStyles(true);
                        lastAddItemDuplicateResult = true;
                        showFormErrorToast('This item already exists.');
                    } else {
                        showFormErrorToast('Please fix the highlighted fields and try again.');
                    }
                }
                return;
            }

            addItemForm.reset();
            resetAddItemDuplicateState();
            closeModal();
            await loadEmployeeInventory();
            showItemSuccessToast('Equipment added successfully');
        } catch (error) {
            // silent fail for now
        }
    }

    if (addItemForm) {
        addItemForm.addEventListener('submit', submitAddItemForm);
        wireAddItemDuplicateFieldListeners();
    }

    let editItemFieldDupTimer = null;
    let editItemFieldDupSeq = 0;

    function getEditInventoryIdFromForm() {
        if (!editItemForm?.action) {
            return '';
        }
        const m = String(editItemForm.action).match(/\/coordinator\/items\/(\d+)/);
        return m ? m[1] : '';
    }

    function setSingleEditItemFieldDuplicateState(fieldName, message) {
        const errMap = {
            property_number: { inputName: 'property_number', errId: 'editPropertyNumberError' },
            rca_acctcode: { inputName: 'rca_acctcode', errId: 'editAccountCodeError' },
            serialno: { inputName: 'serialno', errId: 'editSerialNumberError' },
        };
        const cfg = errMap[fieldName];
        if (!cfg) {
            return;
        }
        const input = editItemForm?.querySelector(`[name="${cfg.inputName}"]`);
        const errEl = document.getElementById(cfg.errId);
        if (message) {
            if (input) {
                input.classList.remove('border-gray-300', 'focus:ring-[#003b95]/20');
                input.classList.add('border-red-500', 'ring-2', 'ring-red-500/40', 'focus:ring-red-500/30');
            }
            if (errEl) {
                errEl.textContent = message;
                errEl.classList.remove('hidden');
            }
        } else {
            if (input) {
                input.classList.add('border-gray-300', 'focus:ring-[#003b95]/20');
                input.classList.remove('border-red-500', 'ring-2', 'ring-red-500/40', 'focus:ring-red-500/30');
            }
            if (errEl) {
                errEl.textContent = '';
                errEl.classList.add('hidden');
            }
        }
    }

    function applyEditItemDuplicateErrors(errors) {
        const e = errors || {};
        setSingleEditItemFieldDuplicateState('property_number', e.property_number || '');
        setSingleEditItemFieldDuplicateState('rca_acctcode', e.rca_acctcode || '');
        setSingleEditItemFieldDuplicateState('serialno', e.serialno || '');
    }

    function resetEditItemDuplicateUi() {
        if (editItemFieldDupTimer) {
            clearTimeout(editItemFieldDupTimer);
            editItemFieldDupTimer = null;
        }
        editItemFieldDupSeq += 1;
        applyEditItemDuplicateErrors({});
    }

    async function fetchEditItemFieldDuplicates() {
        const inventoryId = getEditInventoryIdFromForm();
        if (!editItemForm || !inventoryId) {
            applyEditItemDuplicateErrors({});
            return { valid: true, errors: {} };
        }

        const prop = (editItemForm.querySelector('[name="property_number"]')?.value ?? '').trim();
        const acct = (editItemForm.querySelector('[name="rca_acctcode"]')?.value ?? '').trim();
        const serial = (editItemForm.querySelector('[name="serialno"]')?.value ?? '').trim();

        if (!prop || !acct) {
            applyEditItemDuplicateErrors({});
            return { valid: true, errors: {} };
        }

        const seq = ++editItemFieldDupSeq;

        try {
            const url = new URL(`${window.location.origin}/coordinator/items/${inventoryId}/check-field-duplicates`);
            url.searchParams.set('property_number', prop);
            url.searchParams.set('rca_acctcode', acct);
            url.searchParams.set('serialno', serial);

            const res = await fetch(url.toString(), {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            if (seq !== editItemFieldDupSeq) {
                return { valid: true, errors: {} };
            }

            if (!res.ok) {
                return { valid: true, errors: {} };
            }

            const data = await res.json();
            const errs = data.errors || {};
            applyEditItemDuplicateErrors(errs);

            return { valid: data.valid !== false, errors: errs };
        } catch (err) {
            return { valid: true, errors: {} };
        }
    }

    function scheduleEditItemFieldDuplicateCheck(immediate) {
        if (!editItemForm) {
            return;
        }
        if (editItemFieldDupTimer) {
            clearTimeout(editItemFieldDupTimer);
            editItemFieldDupTimer = null;
        }
        const run = () => {
            editItemFieldDupTimer = null;
            void fetchEditItemFieldDuplicates();
        };
        if (immediate) {
            run();
            return;
        }
        editItemFieldDupTimer = setTimeout(run, 400);
    }

    function wireEditItemDuplicateFieldListeners() {
        if (!editItemForm) {
            return;
        }
        ['property_number', 'rca_acctcode', 'serialno'].forEach((name) => {
            const el = editItemForm.querySelector(`[name="${name}"]`);
            if (!el) {
                return;
            }
            el.addEventListener('blur', () => scheduleEditItemFieldDuplicateCheck(true));
            el.addEventListener('input', () => scheduleEditItemFieldDuplicateCheck(false));
        });
    }

    function applyEditItemValidationErrorsFrom422(payload) {
        const raw = payload?.errors || {};
        const flat = {
            property_number: (raw.property_number && raw.property_number[0]) ? String(raw.property_number[0]) : '',
            rca_acctcode: (raw.rca_acctcode && raw.rca_acctcode[0]) ? String(raw.rca_acctcode[0]) : '',
            serialno: (raw.serialno && raw.serialno[0]) ? String(raw.serialno[0]) : '',
        };
        applyEditItemDuplicateErrors(flat);
    }

    async function submitEditItemForm(e) {
        if (!editItemForm) {
            return;
        }

        e.preventDefault();

        const propertyNumber = editItemForm.querySelector('[name="property_number"]')?.value;
        const accountCode = editItemForm.querySelector('[name="rca_acctcode"]')?.value;
        const description = editItemForm.querySelector('[name="description"]')?.value;
        const unitCost = editItemForm.querySelector('[name="unit_cost"]')?.value;
        const status = editItemForm.querySelector('[name="status"]')?.value;
        const accountability = editItemForm.querySelector('[name="accountability"]')?.value;

        if (
            isBlank(propertyNumber) ||
            isBlank(accountCode) ||
            isBlank(description) ||
            isBlank(unitCost) ||
            isBlank(status) ||
            isBlank(accountability)
        ) {
            showFormErrorToast('Please complete all required fields before updating equipment.');
            return;
        }

        const dupResult = await fetchEditItemFieldDuplicates();
        if (!dupResult.valid) {
            const firstMsg = dupResult.errors.property_number
                || dupResult.errors.rca_acctcode
                || dupResult.errors.serialno
                || 'Please fix the duplicate field errors before updating.';
            showFormErrorToast(firstMsg);
            return;
        }

        const formData = new FormData(editItemForm);
        formData.set('_method', 'PUT');

        try {
            const response = await fetch(editItemForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    applyEditItemValidationErrorsFrom422(data);
                    const first = data.errors.property_number?.[0]
                        || data.errors.rca_acctcode?.[0]
                        || data.errors.serialno?.[0]
                        || 'Please fix the highlighted fields and try again.';
                    showFormErrorToast(String(first));
                } else {
                    const message = data?.message || (response.status === 422 ? 'Please fix the highlighted fields and try again.' : 'Update failed. Please try again.');
                    showFormErrorToast(message);
                }
                return;
            }

            closeEditModal();
            await loadEmployeeInventory();
            showItemSuccessToast('Equipment updated successfully');
        } catch (error) {
            showFormErrorToast('Update failed. Please try again.');
        }
    }

    if (editItemForm) {
        editItemForm.addEventListener('submit', submitEditItemForm);
        wireEditItemDuplicateFieldListeners();
    }

    navDashboard.addEventListener('click', showDashboardSection);
    navInventoryPortal.addEventListener('click', showInventoryPortalSection);
    if (navEmployeeManagement) {
        navEmployeeManagement.addEventListener('click', showEmployeeManagementSection);
    }

    if (navGatepassRequest) {
        navGatepassRequest.addEventListener('click', showCoordinatorGatepassRequestSection);
    }

    if (navGatepassHistory) {
        navGatepassHistory.addEventListener('click', showCoordinatorGatepassHistorySection);
    }

    cardTracker.addEventListener('click', showTracker);
    cardTotal.addEventListener('click', showTotal);

    if (itemsTrackerSearchInput) {
        itemsTrackerSearchInput.addEventListener('input', applyItemsTrackerFilter);
    }

    if (tbodyTracker) {
        tbodyTracker.addEventListener('click', function (event) {
            const row = event.target.closest('tr.tracker-item-row');
            if (!row) {
                return;
            }

            tbodyTracker.querySelectorAll('tr.tracker-item-row').forEach((trackerRow) => {
                trackerRow.classList.remove('ring-2', 'ring-[#2f73ff]');
            });

            row.classList.add('ring-2', 'ring-[#2f73ff]');
            showTrackerHistoryModalFromRow(row);
        });
    }

    if (closeTrackerHistoryModal) {
        closeTrackerHistoryModal.addEventListener('click', closeTrackerHistoryModalDialog);
    }

    if (dismissTrackerHistoryModal) {
        dismissTrackerHistoryModal.addEventListener('click', closeTrackerHistoryModalDialog);
    }

    if (trackerHistoryModal) {
        trackerHistoryModal.addEventListener('click', function (event) {
            if (event.target === trackerHistoryModal) {
                closeTrackerHistoryModalDialog();
            }
        });
    }

    if (openAddItemModal) {
        openAddItemModal.addEventListener('click', openModal);
    }

    if (closeAddItemModal) {
        closeAddItemModal.addEventListener('click', closeModal);
    }

    if (cancelAddItemModal) {
        cancelAddItemModal.addEventListener('click', closeModal);
    }

    if (addItemModal) {
        addItemModal.addEventListener('click', function (e) {
            if (e.target === addItemModal) {
                closeModal();
            }
        });
    }

    if (editItemModal) {
        editItemModal.addEventListener('click', function (e) {
            if (e.target === editItemModal) {
                closeEditModal();
            }
        });
    }

    if (closeEditItemModalBtn) {
        closeEditItemModalBtn.addEventListener('click', closeEditModal);
    }

    if (cancelEditItemModalBtn) {
        cancelEditItemModalBtn.addEventListener('click', closeEditModal);
    }

    if (employeeSelect) {
        employeeSelect.addEventListener('change', loadEmployeeInventory);
    }

    if (searchInput) {
        let searchDebounceTimer = null;

        searchInput.addEventListener('input', function () {
            if (searchDebounceTimer) {
                clearTimeout(searchDebounceTimer);
            }

            searchDebounceTimer = setTimeout(function () {
                loadEmployeeInventory();
            }, 300);
        });
    }

    function applyAccountabilityFilter() {
        if (!inventoryPortalTableBody) {
            return;
        }

        refreshInventoryPortalTableView(1);
    }

    if (accountabilityFilter) {
        accountabilityFilter.addEventListener('change', applyAccountabilityFilter);
    }

    const seeMoreModal = document.getElementById('seeMoreModal');
    const closeSeeMoreModalBtn = document.getElementById('closeSeeMoreModal');
    const dismissSeeMoreModalBtn = document.getElementById('dismissSeeMoreModal');
    const seeMoreMrr = document.getElementById('seeMoreMrr');
    const seeMoreCenter = document.getElementById('seeMoreCenter');
    const seeMoreAccountability = document.getElementById('seeMoreAccountability');
    const seeMoreEndUser = document.getElementById('seeMoreEndUser');
    const seeMoreMovementCard = document.getElementById('seeMoreMovementCard');
    const seeMoreMovementHeadline = document.getElementById('seeMoreMovementHeadline');
    const seeMoreMovementActorLabel = document.getElementById('seeMoreMovementActorLabel');
    const seeMoreMovementActorValue = document.getElementById('seeMoreMovementActorValue');
    const seeMoreMovementDatetime = document.getElementById('seeMoreMovementDatetime');

    function setMovementTrackerFromTarget(target) {
        const movementType = String(target.getAttribute('data-movement-type') || '').trim().toUpperCase();
        const movementRequester = formatDetail(target.getAttribute('data-movement-requester'));
        const movementDatetime = formatDetail(target.getAttribute('data-movement-datetime'));

        if (!seeMoreMovementCard || !seeMoreMovementHeadline || !seeMoreMovementActorLabel || !seeMoreMovementActorValue || !seeMoreMovementDatetime) {
            return;
        }

        if (movementType === 'OUTGOING') {
            seeMoreMovementCard.className = 'rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 space-y-2';
            seeMoreMovementHeadline.textContent = 'This item is currently out';
            seeMoreMovementActorLabel.textContent = 'Released to / requested by:';
            seeMoreMovementActorValue.textContent = movementRequester;
            seeMoreMovementDatetime.textContent = movementDatetime;

            return;
        }

        if (movementType === 'INCOMING') {
            seeMoreMovementCard.className = 'rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 space-y-2';
            seeMoreMovementHeadline.textContent = 'This item is already back inside';
            seeMoreMovementActorLabel.textContent = 'Returned by:';
            seeMoreMovementActorValue.textContent = movementRequester;
            seeMoreMovementDatetime.textContent = movementDatetime;

            return;
        }

        seeMoreMovementCard.className = 'rounded-xl border border-gray-200 bg-[#f8fafc] px-4 py-3 space-y-2';
        seeMoreMovementHeadline.textContent = 'No incoming/outgoing history available';
        seeMoreMovementActorLabel.textContent = 'Released to / requested by:';
        seeMoreMovementActorValue.textContent = 'N/A';
        seeMoreMovementDatetime.textContent = 'N/A';
    }

    if (inventoryPortalTableBody && seeMoreModal) {
        inventoryPortalTableBody.addEventListener('click', function (event) {
            const target = event.target.closest('.inventory-see-more');
            if (!target) {
                return;
            }

            if (seeMoreMrr) {
                seeMoreMrr.textContent = formatDetail(target.getAttribute('data-mrr'));
            }
            if (seeMoreCenter) {
                seeMoreCenter.textContent = formatDetail(target.getAttribute('data-center'));
            }
            if (seeMoreAccountability) {
                seeMoreAccountability.textContent = formatDetail(target.getAttribute('data-accountability'));
            }
            if (seeMoreEndUser) {
                seeMoreEndUser.textContent = formatDetail(target.getAttribute('data-end-user'));
            }
            setMovementTrackerFromTarget(target);

            seeMoreModal.classList.remove('hidden');
            seeMoreModal.classList.add('flex');
        });
    }

    function closeSeeMoreModal() {
        if (!seeMoreModal) {
            return;
        }
        seeMoreModal.classList.add('hidden');
        seeMoreModal.classList.remove('flex');
    }

    if (closeSeeMoreModalBtn) {
        closeSeeMoreModalBtn.addEventListener('click', closeSeeMoreModal);
    }

    if (dismissSeeMoreModalBtn) {
        dismissSeeMoreModalBtn.addEventListener('click', closeSeeMoreModal);
    }

    if (seeMoreModal) {
        seeMoreModal.addEventListener('click', function (event) {
            if (event.target === seeMoreModal) {
                closeSeeMoreModal();
            }
        });
    }

    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    const deleteConfirmCard = document.getElementById('deleteConfirmCard');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const deleteConfirmTitle = document.getElementById('deleteConfirmTitle');
    const deleteConfirmMessage = document.getElementById('deleteConfirmMessage');
    let pendingDeleteForm = null;
    let pendingDeleteType = 'equipment';

    function openDeleteModal(form, type = 'equipment') {
        pendingDeleteForm = form;
        pendingDeleteType = type;
        if (!deleteConfirmModal || !deleteConfirmCard) {
            return;
        }

        if (deleteConfirmTitle && deleteConfirmMessage) {
            if (type === 'employee') {
                deleteConfirmTitle.textContent = 'Delete employee?';
                deleteConfirmMessage.textContent = 'This will permanently remove the selected employee record.';
            } else {
                deleteConfirmTitle.textContent = 'Delete equipment?';
                deleteConfirmMessage.textContent = 'This will permanently remove the selected equipment from the inventory for this employee.';
            }
        }

        deleteConfirmModal.classList.remove('hidden');
        deleteConfirmModal.classList.add('flex');
        deleteConfirmCard.classList.remove('opacity-0', 'scale-95');
        deleteConfirmCard.classList.add('opacity-100', 'scale-100');
    }

    function closeDeleteModal() {
        if (!deleteConfirmModal || !deleteConfirmCard) {
            return;
        }

        deleteConfirmCard.classList.add('opacity-0', 'scale-95');
        deleteConfirmCard.classList.remove('opacity-100', 'scale-100');

        setTimeout(() => {
            deleteConfirmModal.classList.add('hidden');
            deleteConfirmModal.classList.remove('flex');
        }, 150);
    }

    async function performDelete() {
        if (!pendingDeleteForm) {
            return;
        }

        try {
            const form = pendingDeleteForm;
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            if (!response.ok) {
                let data = {};
                try {
                    data = await response.json();
                } catch (parseErr) {
                    data = {};
                }

                const message = data?.message || 'Failed to delete. Please try again.';
                closeDeleteModal();
                window.alert(message);
                return;
            }

            closeDeleteModal();
            pendingDeleteForm = null;
            if (pendingDeleteType === 'employee') {
                await loadEmployees();
                showItemSuccessToast('Employee deleted successfully');
                return;
            }

            await loadEmployeeInventory();
            showItemSuccessToast('Equipment deleted successfully');
        } catch (error) {
            // silent fail
        }
    }

    if (inventoryPortalTableBody) {
        inventoryPortalTableBody.addEventListener('click', function (event) {
            const deleteButton = event.target.closest('.inventory-delete');
            if (deleteButton) {
                event.preventDefault();
                const form = deleteButton.closest('.inventory-delete-form');
                if (!form) {
                    return;
                }
                openDeleteModal(form, 'equipment');
                return;
            }

            const editButton = event.target.closest('.inventory-edit');
            if (editButton) {
                event.preventDefault();
                openEditModalFromButton(editButton);
            }
        });
    }

    function openEditEmployeeModalFromButton(button) {
        if (!editEmployeeModal || !editEmployeeForm) {
            return;
        }

        editEmployeeForm.action = button.getAttribute('data-update-url') || '';

        if (editEmployeeNumberField) {
            editEmployeeNumberField.value = button.getAttribute('data-employee-id') || '';
        }
        if (editEmployeeNameField) {
            editEmployeeNameField.value = button.getAttribute('data-employee-name') || '';
        }
        const userLinked = button.getAttribute('data-user-linked') === '1';
        if (editEmployeeEmailField) {
            editEmployeeEmailField.value = button.getAttribute('data-email') || '';
            editEmployeeEmailField.disabled = !userLinked;
            editEmployeeEmailField.required = userLinked;
        }
        if (editEmployeeEmailHint) {
            editEmployeeEmailHint.classList.toggle('hidden', userLinked);
        }
        if (editEmployeeCenterField) {
            editEmployeeCenterField.value = button.getAttribute('data-center') || '';
        }
        if (editEmployeeTypeField) {
            const typeValue = button.getAttribute('data-employee-type') || '';
            editEmployeeTypeField.value = (typeValue === 'Plantilla' || typeValue === 'Nonplantilla')
                ? typeValue
                : '';
        }
        if (editEmployeeRoleField) {
            editEmployeeRoleField.value = button.getAttribute('data-role') || '';
            editEmployeeRoleField.disabled = !userLinked;
            editEmployeeRoleField.required = userLinked;
        }
        if (editEmployeeRoleHint) {
            editEmployeeRoleHint.classList.toggle('hidden', userLinked);
        }

        if (editEmployeeFormErrorAlert) {
            editEmployeeFormErrorAlert.classList.remove('show-edit-employee-email-exists');
        }
        if (editEmployeeEmailField) {
            editEmployeeEmailField.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
        }

        editEmployeeModal.classList.remove('hidden');
    }

    function closeEditEmployeeModal() {
        if (!editEmployeeModal) {
            return;
        }
        if (editEmployeeFormErrorAlert) {
            editEmployeeFormErrorAlert.classList.remove('show-edit-employee-email-exists');
        }
        if (editEmployeeEmailField) {
            editEmployeeEmailField.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
        }
        editEmployeeModal.classList.add('hidden');
    }

    function openAddEmployeeModal() {
        if (!addEmployeeModal) {
            return;
        }
        if (addEmployeeFormErrorAlert) {
            addEmployeeFormErrorAlert.classList.remove('show-add-employee-email-exists');
        }
        if (addEmployeeEmailField) {
            addEmployeeEmailField.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
        }
        addEmployeeModal.classList.remove('hidden');
        addEmployeeModal.classList.add('flex');
    }

    function closeAddEmployeeModal() {
        if (!addEmployeeModal) {
            return;
        }
        if (addEmployeeFormErrorAlert) {
            addEmployeeFormErrorAlert.classList.remove('show-add-employee-email-exists');
        }
        if (addEmployeeEmailField) {
            addEmployeeEmailField.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
        }
        addEmployeeModal.classList.add('hidden');
        addEmployeeModal.classList.remove('flex');
    }

    if (closeEditEmployeeModalBtn) {
        closeEditEmployeeModalBtn.addEventListener('click', closeEditEmployeeModal);
    }
    if (cancelEditEmployeeModalBtn) {
        cancelEditEmployeeModalBtn.addEventListener('click', closeEditEmployeeModal);
    }
    if (editEmployeeModal) {
        editEmployeeModal.addEventListener('click', function (event) {
            if (event.target === editEmployeeModal) {
                closeEditEmployeeModal();
            }
        });
    }

    if (openAddEmployeeModalBtn) {
        openAddEmployeeModalBtn.addEventListener('click', openAddEmployeeModal);
    }

    if (closeAddEmployeeModalBtn) {
        closeAddEmployeeModalBtn.addEventListener('click', closeAddEmployeeModal);
    }

    if (cancelAddEmployeeModalBtn) {
        cancelAddEmployeeModalBtn.addEventListener('click', closeAddEmployeeModal);
    }

    if (addEmployeeModal) {
        addEmployeeModal.addEventListener('click', function (event) {
            if (event.target === addEmployeeModal) {
                closeAddEmployeeModal();
            }
        });
    }

    async function submitAddEmployeeForm(event) {
        if (!addEmployeeForm) {
            return;
        }

        event.preventDefault();

        const name = addEmployeeForm.querySelector('[name="name"]')?.value;
        const email = addEmployeeForm.querySelector('[name="email"]')?.value;
        const role = addEmployeeForm.querySelector('[name="role"]')?.value;
        const center = addEmployeeForm.querySelector('[name="center"]')?.value;
        const employeeType = addEmployeeForm.querySelector('[name="employee_type"]')?.value;

        if (isBlank(name) || isBlank(email) || isBlank(role) || isBlank(center) || isBlank(employeeType)) {
            showFormErrorToast('Please complete all required fields before adding employee.');
            return;
        }

        const emailTrimmed = String(email).trim();
        const atIndex = emailTrimmed.indexOf('@');
        const domain = atIndex >= 0 ? emailTrimmed.slice(atIndex + 1).toLowerCase() : '';
        if (atIndex < 1 || domain === '' || !domain.endsWith('.com')) {
            window.alert('Use an email with any domain that ends with .com (e.g. you@example.com).');
            return;
        }

        try {
            const formData = new FormData(addEmployeeForm);
            const response = await fetch(addEmployeeForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                let message = data?.message || 'Failed to add employee. Please try again.';
                if (response.status === 422) {
                    const validationErrors = data?.errors
                        ? Object.values(data.errors).flat().filter(Boolean)
                        : [];
                    if (validationErrors.length > 0) {
                        message = validationErrors[0];
                    }

                    const emailErrors = data?.errors?.email;
                    if (isDuplicateEmailServerError(emailErrors)) {
                        showAddEmployeeEmailExistsAlert('This email already exists.');
                        return;
                    }
                }
                showFormErrorToast(message);
                return;
            }

            addEmployeeForm.reset();
            const typeField = addEmployeeForm.querySelector('[name="employee_type"]');
            if (typeField) {
                typeField.value = 'Plantilla';
            }
            closeAddEmployeeModal();
            await loadEmployees();
            showItemSuccessToast(data?.message || 'Employee added successfully.');
        } catch (error) {
            showFormErrorToast('Failed to add employee. Please try again.');
        }
    }

    if (addEmployeeForm) {
        addEmployeeForm.addEventListener('submit', submitAddEmployeeForm);
    }

    async function submitEditEmployeeForm(event) {
        if (!editEmployeeForm) {
            return;
        }

        event.preventDefault();

        if (editEmployeeEmailField && !editEmployeeEmailField.disabled) {
            const emailVal = String(editEmployeeEmailField.value || '').trim();
            const atIndex = emailVal.indexOf('@');
            const domain = atIndex >= 0 ? emailVal.slice(atIndex + 1).toLowerCase() : '';
            if (atIndex < 1 || domain === '' || !domain.endsWith('.com')) {
                showEditEmployeeEmailExistsAlert('Use an email with any domain that ends with .com (e.g. you@example.com).');
                return;
            }
        }

        if (editEmployeeRoleField && !editEmployeeRoleField.disabled) {
            const roleVal = String(editEmployeeRoleField.value || '').trim();
            if (roleVal === '') {
                showFormErrorToast('Role is required for employees with a linked user account.');
                return;
            }
        }

        const formData = new FormData(editEmployeeForm);
        formData.set('_method', 'PUT');

        try {
            const response = await fetch(editEmployeeForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                if (response.status === 422) {
                    const emailErrors = data?.errors?.email;
                    if (isDuplicateEmailServerError(emailErrors)) {
                        showEditEmployeeEmailExistsAlert('This email already exists.');
                        return;
                    }
                    if (emailErrors) {
                        const emailMsg = Array.isArray(emailErrors) ? emailErrors[0] : emailErrors;
                        if (emailMsg) {
                            showEditEmployeeEmailExistsAlert(String(emailMsg));
                            return;
                        }
                    }
                }
                return;
            }

            closeEditEmployeeModal();
            await loadEmployees();
            showItemSuccessToast(data?.message || 'Employee updated successfully');
        } catch (error) {
            // silent fail
        }
    }

    if (editEmployeeForm) {
        editEmployeeForm.addEventListener('submit', submitEditEmployeeForm);
    }

    if (employeeManagementTableBody) {
        employeeManagementTableBody.addEventListener('click', function (event) {
            const editButton = event.target.closest('.employee-edit');
            if (editButton) {
                event.preventDefault();
                openEditEmployeeModalFromButton(editButton);
                return;
            }

            const deleteButton = event.target.closest('.employee-delete');
            if (deleteButton) {
                event.preventDefault();
                const form = deleteButton.closest('.employee-delete-form');
                if (!form) {
                    return;
                }
                openDeleteModal(form, 'employee');
            }
        });
    }

    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function () {
            performDelete();
        });
    }

    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', function () {
            closeDeleteModal();
        });
    }

    if (deleteConfirmModal) {
        deleteConfirmModal.addEventListener('click', function (event) {
            if (event.target === deleteConfirmModal) {
                closeDeleteModal();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (window.location.hash === '#gatepass-history') {
            showCoordinatorGatepassHistorySection();
        } else if (window.location.hash === '#gatepass-request') {
            showCoordinatorGatepassRequestSection();
        } else if (window.location.hash === '#employee-management') {
            showEmployeeManagementSection();
        } else if (window.location.hash === '#inventory-portal') {
            showInventoryPortalSection();
        } else {
            showDashboardSection();
        }
        setTodayDate();

        refreshInventoryPortalTableView(1);
        applyEmployeeManagementPagination(1);

        const loginSuccessToast = document.getElementById('loginSuccessToast');
        if (loginSuccessToast) {
            setTimeout(function () {
                loginSuccessToast.classList.add('show-login-toast');
            }, 150);
        }

        @if ($errors->any())
            openModal();
            showFormErrorToast('Please fix the highlighted fields and try again.');
        @endif
    });
</script>

</body>
</html>