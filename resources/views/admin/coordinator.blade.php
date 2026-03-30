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
<body class="bg-[#f5f5f5] min-h-screen font-sans">

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


    <div class="flex flex-col md:flex-row min-h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-full md:w-72 lg:w-80 bg-[#173a6b] text-white flex flex-col shrink-0 md:min-h-screen">

            <!-- Top Section -->
            <div>
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
            <div class="mt-auto px-8 py-10 border-t border-white/10">
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
        <main class="flex-1 min-w-0 flex flex-col">

            <!-- Header -->
            <header class="bg-[#f5f5f5] border-b border-black/10 px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between sm:gap-6">
                    <div class="min-w-0">
                        <h2 id="pageTitle" class="text-[22px] md:text-[24px] font-bold text-black leading-none break-words">Dashboard</h2>
                        <p id="pageSubtitle" class="text-[14px] text-[#556b86] mt-2 break-words">List of Inventory</p>
                    </div>

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
            </header>

            <!-- Content -->
            <section class="w-full max-w-full min-w-0 px-4 sm:px-6 lg:px-8 py-7">

                <!-- DASHBOARD SECTION -->
                <div id="dashboardSection">
                    <!-- Stat Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                        <button id="cardAccountable" type="button"
                            class="stat-card text-left bg-white border-2 border-[#2f73ff] rounded-[18px] px-6 py-6 min-h-[200px] transition">
                            <p class="text-[16px] text-[#556b86] mb-3">Accountable</p>
                            <h3 class="text-[28px] font-semibold text-black leading-none mb-10">{{ $accountableCount }}</h3>
                            <p class="text-[14px] text-[#556b86] mb-2">Equipment items</p>
                            <p class="text-[14px] text-[#1f54ff] font-medium">Click to view →</p>
                        </button>

                        <button id="cardUnaccountable" type="button"
                            class="stat-card text-left bg-white border border-gray-200 rounded-[18px] px-6 py-6 min-h-[200px] transition hover:border-[#2f73ff]">
                            <p class="text-[16px] text-[#556b86] mb-3">Unaccountable</p>
                            <h3 class="text-[28px] font-semibold text-black leading-none mb-10">{{ $unaccountableCount }}</h3>
                            <p class="text-[14px] text-[#556b86] mb-2">Equipment items</p>
                            <p class="text-[14px] text-[#ff5a00] font-medium">Click to view →</p>
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
                                <h3 id="tableTitle" class="text-[17px] font-semibold text-black">Accountable Equipment</h3>
                                <p id="tableDescription" class="text-[14px] text-[#667085] mt-1">Showing 0 accountable items</p>
                            </div>
                            <button id="addEquipmentFromDashboard" type="button"
                                class="flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 rounded-xl bg-[#f6b400] hover:bg-[#e5a900] text-[#003b95] font-semibold text-[14px] transition whitespace-nowrap">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Equipment</span>
                            </button>
                        </div>

                        <div class="px-6">
                            <div class="overflow-x-auto rounded-2xl">
                                <table class="w-full min-w-[900px]">
                                    <thead>
                                        <tr class="bg-[#003b95] text-white text-left">
                                            <th class="px-4 py-4 text-[14px] font-semibold">#</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Property Number</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Description</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Assigned Employee</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tbodyAccountable" class="hidden">
                                        @foreach($dashboardAccountableItems as $index => $item)
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

                                    <tbody id="tbodyUnaccountable" class="hidden">
                                        @foreach($dashboardUnaccountableItems as $index => $item)
                                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} text-[14px] text-[#111827]">
                                                <td class="px-4 py-3 align-top">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3 align-top">{{ $item->prop_no }}</td>
                                                <td class="px-4 py-3 align-top">{{ $item->description }}</td>
                                                <td class="px-4 py-3 align-top"></td>
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
                                id="emptyState"
                                class="py-12 text-center text-[#98a2b3] text-[15px] border-b border-gray-200 {{ $accountableCount > 0 ? 'hidden' : '' }}"
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
                                        <label class="block text-[14px] font-semibold text-black mb-2">Empl. Status</label>
                                        <input
                                            id="employeeStatusField"
                                            type="text"
                                            value="{{ $selectedEmployee?->empl_status ?? '' }}"
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

                                <div class="w-full md:w-64">
                                    <label class="block text-[14px] font-semibold text-black mb-2">Accountability Filter</label>
                                    <select
                                        id="accountabilityFilter"
                                        class="w-full h-[42px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none"
                                    >
                                        <option value="all">All</option>
                                        <option value="accountable" selected>Accountable</option>
                                        <option value="unaccountable">Unaccountable</option>
                                    </select>
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
                                        <th class="w-36 px-3 py-2 text-xs font-semibold whitespace-nowrap">Assigned Employee</th>
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
                                            <td class="px-3 py-2 align-top whitespace-nowrap truncate" title="{{ $selectedEmployee?->employee_name ?? $selectedEmployeeId }}">
                                                {{ $selectedEmployee?->employee_name ?? $selectedEmployeeId }}
                                            </td>
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
                                            <td colspan="9" class="px-4 py-6 text-center text-[14px] text-[#98a2b3]">
                                                No inventory items available for the selected employee.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

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
                                        <th class="px-4 py-4 text-[14px] font-semibold">Empl. Status</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Created At</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Updated At</th>
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
                                        <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} text-[14px] text-[#111827]">
                                            <td class="px-4 py-3 align-top">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 align-top">{{ $employeeRecord->employee_id }}</td>
                                            <td class="px-4 py-3 align-top">{{ $employeeRecord->employee_name }}</td>
                                            <td class="px-4 py-3 align-top">{{ $employeeRecord->center }}</td>
                                            <td class="px-4 py-3 align-top">{{ $employeeRecord->empl_status }}</td>
                                            <td class="px-4 py-3 align-top">{{ $formatEmployeeTimestamp($employeeRecord->created_at) }}</td>
                                            <td class="px-4 py-3 align-top">{{ $formatEmployeeTimestamp($employeeRecord->updated_at) }}</td>
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
                                                        data-empl-status="{{ $employeeRecord->empl_status }}"
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
                                            <td colspan="8" class="px-4 py-6 text-center text-[14px] text-[#98a2b3]">
                                                No employees available.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                </div>

                                <!-- Description / Specification -->
                                <div>
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
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
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
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
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
                    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">
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
                                    <label class="block text-[14px] font-semibold text-black mb-2">Empl. Status</label>
                                    <input id="editEmployeeStatusField" type="text" name="empl_status" class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20" required>
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
                <div id="addEmployeeModal" class="fixed inset-0 z-50 hidden bg-black/40 px-4 py-4 sm:px-6 sm:py-6">
                    <div class="flex min-h-full items-center justify-center">
                        <div class="w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl max-h-[90vh] flex flex-col">
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
                                                <label class="mb-2 block text-sm font-semibold text-black">Employee Status</label>
                                                <select
                                                    id="addEmployeeStatusField"
                                                    name="empl_status"
                                                    class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                                >
                                                    <option value="active" selected>Active</option>
                                                    <option value="inactive">Inactive</option>
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
                                </div>

                                <!-- Account Code -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Account Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="rca_acctcode" id="editAccountCodeField" placeholder="Enter account code"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                </div>

                                <!-- Serial Number -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        Serial Number
                                    </label>
                                    <input type="text" name="serialno" id="editSerialNumberField" placeholder="Enter serial number"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
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
                                <div class="md:col-span-2">
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

    <script>
    const navDashboard = document.getElementById('navDashboard');
    const navInventoryPortal = document.getElementById('navInventoryPortal');
    const navEmployeeManagement = document.getElementById('navEmployeeManagement');

    const dashboardSection = document.getElementById('dashboardSection');
    const inventoryPortalSection = document.getElementById('inventoryPortalSection');
    const employeeManagementSection = document.getElementById('employeeManagementSection');

    const pageTitle = document.getElementById('pageTitle');
    const pageSubtitle = document.getElementById('pageSubtitle');

    const cardAccountable = document.getElementById('cardAccountable');
    const cardUnaccountable = document.getElementById('cardUnaccountable');
    const cardTotal = document.getElementById('cardTotal');

    const tableTitle = document.getElementById('tableTitle');
    const tableDescription = document.getElementById('tableDescription');
    const tableFooterText = document.getElementById('tableFooterText');
    const emptyState = document.getElementById('emptyState');

    const tbodyAccountable = document.getElementById('tbodyAccountable');
    const tbodyUnaccountable = document.getElementById('tbodyUnaccountable');
    const tbodyTotal = document.getElementById('tbodyTotal');

    const employeeSelect = document.getElementById('employeeSelect');
    const searchInput = document.querySelector('input[name="search"]');
    const employeeStatusField = document.getElementById('employeeStatusField');
    const employeeNumberField = document.getElementById('employeeNumberField');
    const employeeCenterField = document.getElementById('employeeCenterField');
    const inventoryPortalTableBody = document.getElementById('inventoryPortalTableBody');
    const accountabilityFilter = document.getElementById('accountabilityFilter');

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
    const editEmployeeStatusField = document.getElementById('editEmployeeStatusField');
    const openAddEmployeeModalBtn = document.getElementById('openAddEmployeeModal');
    const addEmployeeModal = document.getElementById('addEmployeeModal');
    const addEmployeeForm = document.getElementById('addEmployeeForm');
    const closeAddEmployeeModalBtn = document.getElementById('closeAddEmployeeModal');
    const cancelAddEmployeeModalBtn = document.getElementById('cancelAddEmployeeModal');

    const csrfToken = '{{ csrf_token() }}';

    const dashboardCounts = {
        accountable: {{ $accountableCount }},
        unaccountable: {{ $unaccountableCount }},
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
        [cardAccountable, cardUnaccountable, cardTotal].forEach(card => {
            card.classList.remove('border-2', 'border-[#2f73ff]');
            card.classList.add('border', 'border-gray-200');
        });
    }

    function hideAllTables() {
        tbodyAccountable.classList.add('hidden');
        tbodyUnaccountable.classList.add('hidden');
        tbodyTotal.classList.add('hidden');
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

    function showDashboardSection() {
        dashboardSection.classList.remove('hidden');
        inventoryPortalSection.classList.add('hidden');
        employeeManagementSection.classList.add('hidden');

        pageTitle.textContent = 'Dashboard';
        pageSubtitle.textContent = 'List of Inventory';

        if (openAddItemModal) {
            openAddItemModal.classList.add('hidden');
        }

        activateSidebar(navDashboard, [navDashboard, navInventoryPortal, navEmployeeManagement]);
        showAccountable();
        if (window.location.hash !== '#dashboard') {
            window.history.replaceState(null, '', '#dashboard');
        }
    }

    function showInventoryPortalSection() {
        dashboardSection.classList.add('hidden');
        inventoryPortalSection.classList.remove('hidden');
        employeeManagementSection.classList.add('hidden');

        pageTitle.textContent = 'Inventory Portal';
        pageSubtitle.textContent = 'Manage all equipment inventory';

        if (openAddItemModal) {
            openAddItemModal.classList.remove('hidden');
        }

        activateSidebar(navInventoryPortal, [navDashboard, navInventoryPortal, navEmployeeManagement]);
        if (window.location.hash !== '#inventory-portal') {
            window.history.replaceState(null, '', '#inventory-portal');
        }
    }

    function showEmployeeManagementSection() {
        dashboardSection.classList.add('hidden');
        inventoryPortalSection.classList.add('hidden');
        employeeManagementSection.classList.remove('hidden');

        pageTitle.textContent = 'Employee Management';
        pageSubtitle.textContent = 'Manage employee records';

        if (openAddItemModal) {
            openAddItemModal.classList.add('hidden');
        }

        activateSidebar(navEmployeeManagement, [navDashboard, navInventoryPortal, navEmployeeManagement]);
        if (window.location.hash !== '#employee-management') {
            window.history.replaceState(null, '', '#employee-management');
        }

        loadEmployees();
    }

    function showAccountable() {
        resetCards();
        hideAllTables();

        cardAccountable.classList.remove('border', 'border-gray-200');
        cardAccountable.classList.add('border-2', 'border-[#2f73ff]');
        tbodyAccountable.classList.remove('hidden');

        tableTitle.textContent = 'Accountable Equipment';
        tableDescription.textContent = `Showing ${dashboardCounts.accountable} accountable item(s)`;
        setFooterText(`Showing ${dashboardCounts.accountable} item(s)`);

        if (dashboardCounts.accountable > 0) {
            emptyState.classList.add('hidden');
        } else {
            showEmptyState('No accountable equipment available yet.');
        }
    }

    function showUnaccountable() {
        resetCards();
        hideAllTables();

        cardUnaccountable.classList.remove('border', 'border-gray-200');
        cardUnaccountable.classList.add('border-2', 'border-[#2f73ff]');
        tbodyUnaccountable.classList.remove('hidden');

        tableTitle.textContent = 'Unaccountable Equipment';
        tableDescription.textContent = `Showing ${dashboardCounts.unaccountable} unaccountable item(s)`;
        setFooterText(`Showing ${dashboardCounts.unaccountable} item(s)`);

        if (dashboardCounts.unaccountable > 0) {
            emptyState.classList.add('hidden');
        } else {
            showEmptyState('No unaccountable equipment available yet.');
        }
    }

    function showTotal() {
        resetCards();
        hideAllTables();

        cardTotal.classList.remove('border', 'border-gray-200');
        cardTotal.classList.add('border-2', 'border-[#2f73ff]');
        tbodyTotal.classList.remove('hidden');

        tableTitle.textContent = 'Total Inventory Items';
        tableDescription.textContent = `Showing ${dashboardCounts.total} total item(s)`;
        setFooterText(`Showing ${dashboardCounts.total} item(s)`);

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

    function renderEmployeeRows(employees) {
        if (!employeeManagementTableBody) {
            return;
        }

        employeeManagementTableBody.innerHTML = '';

        if (!employees || employees.length === 0) {
            employeeManagementTableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-[14px] text-[#98a2b3]">
                        No employees available.
                    </td>
                </tr>
            `;
            return;
        }

        employees.forEach((employeeRecord, index) => {
            const row = document.createElement('tr');
            row.className = `${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'} text-[14px] text-[#111827]`;
            row.innerHTML = `
                <td class="px-4 py-3 align-top">${index + 1}</td>
                <td class="px-4 py-3 align-top">${employeeRecord.employee_id ?? ''}</td>
                <td class="px-4 py-3 align-top">${employeeRecord.employee_name ?? ''}</td>
                <td class="px-4 py-3 align-top">${employeeRecord.center ?? ''}</td>
                <td class="px-4 py-3 align-top">${employeeRecord.empl_status ?? ''}</td>
                <td class="px-4 py-3 align-top">${formatEmployeeTimestamp(employeeRecord.created_at)}</td>
                <td class="px-4 py-3 align-top">${formatEmployeeTimestamp(employeeRecord.updated_at)}</td>
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
                            data-empl-status="${employeeRecord.empl_status ?? ''}"
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

            if (employeeStatusField) {
                employeeStatusField.value = data.selectedEmployee?.empl_status ?? '';
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
                        <td colspan="9" class="px-4 py-6 text-center text-[14px] text-[#98a2b3]">
                            ${hasSearch ? 'No records found.' : 'No inventory items available for the selected employee.'}
                        </td>
                    </tr>
                `;
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
                        ${data.selectedEmployee?.employee_name ?? data.selectedEmployeeId ?? ''}
                    </td>
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
        } catch (e) {
            // fail silently for now
        }
    }

    function openModal() {
        if (!addItemModal) return;
        addItemModal.classList.remove('hidden');
        addItemModal.classList.add('flex');
        setTodayDate();
    }

    function closeModal() {
        if (!addItemModal) return;
        addItemModal.classList.add('hidden');
        addItemModal.classList.remove('flex');

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

        editItemModal.classList.remove('hidden');
        editItemModal.classList.add('flex');
    }

    function closeEditModal() {
        if (!editItemModal) {
            return;
        }
        editItemModal.classList.add('hidden');
        editItemModal.classList.remove('flex');
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

            if (!response.ok) {
                if (response.status === 422) {
                    showFormErrorToast('Please fix the highlighted fields and try again.');
                }
                return;
            }

            addItemForm.reset();
            closeModal();
            await loadEmployeeInventory();
            showItemSuccessToast('Equipment added successfully');
        } catch (error) {
            // silent fail for now
        }
    }

    if (addItemForm) {
        addItemForm.addEventListener('submit', submitAddItemForm);
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

            const data = response.ok ? await response.json().catch(() => ({})) : await response.json().catch(() => ({}));

            if (!response.ok) {
                const message = data?.message || (response.status === 422 ? 'Please fix the highlighted fields and try again.' : 'Update failed. Please try again.');
                showFormErrorToast(message);
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
    }

    navDashboard.addEventListener('click', showDashboardSection);
    navInventoryPortal.addEventListener('click', showInventoryPortalSection);
    if (navEmployeeManagement) {
        navEmployeeManagement.addEventListener('click', showEmployeeManagementSection);
    }

    cardAccountable.addEventListener('click', showAccountable);
    cardUnaccountable.addEventListener('click', showUnaccountable);
    cardTotal.addEventListener('click', showTotal);

    const addEquipmentFromDashboard = document.getElementById('addEquipmentFromDashboard');

    if (openAddItemModal) {
        openAddItemModal.addEventListener('click', openModal);
    }

    if (addEquipmentFromDashboard) {
        addEquipmentFromDashboard.addEventListener('click', function () {
            showInventoryPortalSection();
            openModal();
        });
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
        if (!inventoryPortalTableBody || !accountabilityFilter) {
            return;
        }

        const filter = accountabilityFilter.value;
        const rows = inventoryPortalTableBody.querySelectorAll('tr');

        rows.forEach((row) => {
            const rowAccountability = row.getAttribute('data-accountability') || 'accountable';

            if (filter === 'all') {
                row.classList.remove('hidden');
            } else if (filter === 'accountable') {
                if (rowAccountability === 'accountable') {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            } else if (filter === 'unaccountable') {
                if (rowAccountability === 'unaccountable') {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            }
        });
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
        if (editEmployeeStatusField) {
            editEmployeeStatusField.value = button.getAttribute('data-empl-status') || '';
        }

        editEmployeeModal.classList.remove('hidden');
    }

    function closeEditEmployeeModal() {
        if (!editEmployeeModal) {
            return;
        }
        editEmployeeModal.classList.add('hidden');
    }

    function openAddEmployeeModal() {
        if (!addEmployeeModal) {
            return;
        }
        addEmployeeModal.classList.remove('hidden');
    }

    function closeAddEmployeeModal() {
        if (!addEmployeeModal) {
            return;
        }
        addEmployeeModal.classList.add('hidden');
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
        const emplStatus = addEmployeeForm.querySelector('[name="empl_status"]')?.value;

        if (isBlank(name) || isBlank(email) || isBlank(role) || isBlank(center) || isBlank(emplStatus)) {
            showFormErrorToast('Please complete all required fields before adding employee.');
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
                    if (emailErrors) {
                        const emailMessage = Array.isArray(emailErrors) ? emailErrors[0] : emailErrors;
                        const emailText = String(emailMessage ?? '');
                        const isDuplicateEmail = emailText.length > 0 && /already\s+(been\s+)?(taken|registered)|email\s+has\s+already|already registered/i.test(emailText);
                        if (isDuplicateEmail) {
                            window.alert(emailText);
                            return;
                        }
                    }
                }
                showFormErrorToast(message);
                return;
            }

            addEmployeeForm.reset();
            const statusField = addEmployeeForm.querySelector('[name="empl_status"]');
            if (statusField) {
                statusField.value = 'active';
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

            if (!response.ok) {
                return;
            }

            closeEditEmployeeModal();
            await loadEmployees();
            showItemSuccessToast('Employee updated successfully');
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
        if (window.location.hash === '#employee-management') {
            showEmployeeManagementSection();
        } else if (window.location.hash === '#inventory-portal') {
            showInventoryPortalSection();
        } else {
            showDashboardSection();
        }
        setTodayDate();

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