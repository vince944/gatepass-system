<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Coordinator Dashboard</title>
    @vite('resources/css/app.css')
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


    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-[248px] bg-[#173a6b] text-white flex flex-col">

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
        <main class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="bg-[#f5f5f5] border-b border-black/10 px-8 py-6">
                <h2 id="pageTitle" class="text-[22px] md:text-[24px] font-bold text-black leading-none">Dashboard</h2>
                <p id="pageSubtitle" class="text-[14px] text-[#556b86] mt-2">List of Inventory</p>
            </header>

            <!-- Content -->
            <section class="px-8 py-7">

                <!-- DASHBOARD SECTION -->
                <div id="dashboardSection">
                    <!-- Stat Cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
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
                        <div class="flex items-start justify-between px-6 py-6">
                            <div>
                                <h3 id="tableTitle" class="text-[17px] font-semibold text-black">Accountable Equipment</h3>
                                <p id="tableDescription" class="text-[14px] text-[#667085] mt-1">Showing 0 accountable items</p>
                            </div>
                        </div>

                        <div class="px-6">
                            <div class="overflow-x-auto">
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
                                                <td class="px-4 py-3 align-top">{{ $item->propno }}</td>
                                                <td class="px-4 py-3 align-top">{{ $item->description }}</td>
                                                <td class="px-4 py-3 align-top">{{ $item->accountableEmployee?->employee_name ?? '' }}</td>
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
                                                <td class="px-4 py-3 align-top">{{ $item->propno }}</td>
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
                                                <td class="px-4 py-3 align-top">{{ $item->propno }}</td>
                                                <td class="px-4 py-3 align-top">{{ $item->description }}</td>
                                                <td class="px-4 py-3 align-top">{{ $item->accountableEmployee?->employee_name ?? '' }}</td>
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
                            <h3 class="text-[18px] font-bold text-black uppercase mb-7">Asset Inventory Management</h3>

                            <form method="GET" action="{{ route('admin.coordinator.index') }}">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-6 gap-y-5 mb-6">
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
                                        <label class="block text-[14px] font-semibold text-black mb-2">Separation Date</label>
                                        <input
                                            type="text"
                                            value="N/A"
                                            class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-[#667085] focus:outline-none"
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

                                    <div>
                                        <label class="block text-[14px] font-semibold text-black mb-2">Separation Mode</label>
                                        <input
                                            type="text"
                                            value="N/A"
                                            class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-[#667085] focus:outline-none"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="mb-5">
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
                            </form>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <div>
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

                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Actions</label>
                                    <button id="openAddItemModal" type="button" class="w-full h-[42px] rounded-xl bg-[#f6b400] hover:bg-[#e5a900] text-[#003b95] font-semibold text-[16px] flex items-center justify-center gap-3 transition">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>Add Item</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-[18px] overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[1300px]">
                                <thead>
                                    <tr class="bg-[#003b95] text-white text-left">
                                        <th class="px-4 py-4 text-[14px] font-semibold">#</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Property Number</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Account Code</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Serial Number</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Description / Specification</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Assigned Employee</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Unit Price</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Status</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="inventoryPortalTableBody">
                                    @forelse($items as $index => $item)
                                        <tr
                                            class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} text-[14px] text-[#111827]"
                                            data-accountability="accountable"
                                        >
                                            <td class="px-4 py-3 align-top">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 align-top">{{ $item->propno }}</td>
                                            <td class="px-4 py-3 align-top">{{ $item->rca_acctcode }}</td>
                                            <td class="px-4 py-3 align-top">{{ $item->serialno }}</td>
                                            <td class="px-4 py-3 align-top">{{ $item->description }}</td>
                                            <td class="px-4 py-3 align-top">
                                                {{ $selectedEmployee?->employee_name ?? $selectedEmployeeId }}
                                            </td>
                                            <td class="px-4 py-3 align-top">
                                                {{ $item->unitcost !== null ? number_format($item->unitcost, 2) : '' }}
                                            </td>
                                            @php
                                                $portalStatusLabel = match ($item->status) {
                                                    'A' => 'Active',
                                                    'I' => 'In Use',
                                                    'D' => 'Defective/Disposed',
                                                    default => $item->status,
                                                };
                                            @endphp
                                            <td class="px-4 py-3 align-top">{{ $portalStatusLabel }}</td>
                                            <td class="px-4 py-3 align-top">
                                                <div class="flex items-center gap-2">
                                                    <button
                                                        type="button"
                                                        class="inventory-see-more px-2.5 py-1 rounded-lg border border-gray-300 text-[13px] text-[#003b95] hover:bg-gray-50 transition"
                                                        data-pn-old="{{ $item->propno_old }}"
                                                        data-pn-code-old="{{ $item->old_code }}"
                                                        data-mrr="{{ $item->mrrno }}"
                                                        data-center="{{ $item->accountableEmployee?->center ?? $selectedEmployee?->center ?? '' }}"
                                                        data-accountability="Accountable"
                                                        data-end-user="N/A"
                                                        title="See more details"
                                                    >
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.coordinator.items.destroy', $item->propno) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="employee_id" value="{{ $selectedEmployeeId }}">
                                                        <button
                                                            type="submit"
                                                            class="px-2 py-1 rounded-lg border border-red-300 text-[13px] text-red-600 hover:bg-red-50 transition"
                                                            onclick="return confirm('Are you sure you want to delete this equipment?');"
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

                                <!-- PN old -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        PN (old)
                                    </label>
                                    <input type="text" name="pn_old" placeholder="Enter old PN"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
                                </div>

                                <!-- PN Code old -->
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">
                                        PN Code (old)
                                    </label>
                                    <input type="text" name="pn_code_old" placeholder="Enter old PN code"
                                        class="w-full h-[44px] rounded-xl border border-gray-300 bg-[#f8f8f8] px-4 text-[14px] text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20">
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
                                <div class="md:col-span-2">
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
                    <div class="grid grid-cols-[140px,1fr] items-center gap-3">
                        <span class="font-semibold text-[#4b5563]">PN (old):</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between">
                            <span id="seeMorePnOld" class="text-[13px] text-[#111827]">N/A</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[140px,1fr] items-center gap-3">
                        <span class="font-semibold text-[#4b5563]">PN Code (old):</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between">
                            <span id="seeMorePnCodeOld" class="text-[13px] text-[#111827]">N/A</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[140px,1fr] items-center gap-3">
                        <span class="font-semibold text-[#4b5563]">MRR:</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between">
                            <span id="seeMoreMrr" class="text-[13px] text-[#111827]">N/A</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[140px,1fr] items-center gap-3">
                        <span class="font-semibold text-[#4b5563]">Center:</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between">
                            <span id="seeMoreCenter" class="text-[13px] text-[#111827]">N/A</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[140px,1fr] items-center gap-3">
                        <span class="font-semibold text-[#4b5563]">Accountability:</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between">
                            <span id="seeMoreAccountability" class="text-[13px] text-[#111827]">N/A</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[140px,1fr] items-center gap-3">
                        <span class="font-semibold text-[#4b5563]">End User:</span>
                        <div class="min-h-[32px] rounded-lg bg-[#f3f4f6] px-3 py-1.5 flex items-center justify-between">
                            <span id="seeMoreEndUser" class="text-[13px] text-[#111827]">N/A</span>
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

    <script>
    const navDashboard = document.getElementById('navDashboard');
    const navInventoryPortal = document.getElementById('navInventoryPortal');

    const dashboardSection = document.getElementById('dashboardSection');
    const inventoryPortalSection = document.getElementById('inventoryPortalSection');

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

    const csrfToken = '{{ csrf_token() }}';

    const dashboardCounts = {
        accountable: {{ $accountableCount }},
        unaccountable: {{ $unaccountableCount }},
        total: {{ $totalCount }},
    };

    function activateSidebar(activeBtn, inactiveBtn) {
        activeBtn.classList.add('bg-[#47698f]', 'text-white');
        activeBtn.classList.remove('text-white/90', 'hover:bg-white/10');

        inactiveBtn.classList.remove('bg-[#47698f]', 'text-white');
        inactiveBtn.classList.add('text-white/90', 'hover:bg-white/10');
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

        pageTitle.textContent = 'Dashboard';
        pageSubtitle.textContent = 'List of Inventory';

        activateSidebar(navDashboard, navInventoryPortal);
        showAccountable();
    }

    function showInventoryPortalSection() {
        dashboardSection.classList.add('hidden');
        inventoryPortalSection.classList.remove('hidden');

        pageTitle.textContent = 'Inventory Portal';
        pageSubtitle.textContent = 'Manage all equipment inventory';

        activateSidebar(navInventoryPortal, navDashboard);
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
                inventoryPortalTableBody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-[14px] text-[#98a2b3]">
                            No inventory items available for the selected employee.
                        </td>
                    </tr>
                `;
                return;
            }

            data.items.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = `${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'} text-[14px] text-[#111827]`;
                row.setAttribute('data-accountability', 'accountable');
                row.innerHTML = `
                    <td class="px-4 py-3 align-top">${index + 1}</td>
                    <td class="px-4 py-3 align-top">${item.propno ?? ''}</td>
                    <td class="px-4 py-3 align-top">${item.rca_acctcode ?? ''}</td>
                    <td class="px-4 py-3 align-top">${item.serialno ?? ''}</td>
                    <td class="px-4 py-3 align-top">${item.description ?? ''}</td>
                    <td class="px-4 py-3 align-top">
                        ${data.selectedEmployee?.employee_name ?? data.selectedEmployeeId ?? ''}
                    </td>
                    <td class="px-4 py-3 align-top">
                        ${item.unitcost !== null && item.unitcost !== undefined ? Number(item.unitcost).toFixed(2) : ''}
                    </td>
                    <td class="px-4 py-3 align-top">${statusLabelFromCode(item.status ?? '')}</td>
                    <td class="px-4 py-3 align-top">
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                class="inventory-see-more px-2.5 py-1 rounded-lg border border-gray-300 text-[13px] text-[#003b95] hover:bg-gray-50 transition"
                                data-pn-old="${item.propno_old ?? ''}"
                                data-pn-code-old="${item.old_code ?? ''}"
                                data-mrr="${item.mrrno ?? ''}"
                                data-center="${data.selectedEmployee?.center ?? ''}"
                                data-accountability="Accountable"
                                data-end-user="N/A"
                                title="See more details"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <form method="POST" action="/coordinator/items/${item.propno}">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="employee_id" value="${data.selectedEmployeeId ?? ''}">
                                <button
                                    type="submit"
                                    class="px-2 py-1 rounded-lg border border-red-300 text-[13px] text-red-600 hover:bg-red-50 transition"
                                    onclick="return confirm('Are you sure you want to delete this equipment?');"
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

    if (addItemForm) {
        addItemForm.addEventListener('submit', function (e) {
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
                e.preventDefault();
                openModal();
                showFormErrorToast('Please complete all required fields before adding equipment.');
            }
        });
    }

    navDashboard.addEventListener('click', showDashboardSection);
    navInventoryPortal.addEventListener('click', showInventoryPortalSection);

    cardAccountable.addEventListener('click', showAccountable);
    cardUnaccountable.addEventListener('click', showUnaccountable);
    cardTotal.addEventListener('click', showTotal);

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

    if (employeeSelect) {
        employeeSelect.addEventListener('change', loadEmployeeInventory);
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
    const seeMorePnOld = document.getElementById('seeMorePnOld');
    const seeMorePnCodeOld = document.getElementById('seeMorePnCodeOld');
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

            if (seeMorePnOld) {
                seeMorePnOld.textContent = formatDetail(target.getAttribute('data-pn-old'));
            }
            if (seeMorePnCodeOld) {
                seeMorePnCodeOld.textContent = formatDetail(target.getAttribute('data-pn-code-old'));
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

    document.addEventListener('DOMContentLoaded', function () {
        showDashboardSection();
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