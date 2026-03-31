<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-[#f3f3f3] min-h-screen font-sans overflow-x-hidden">

    <!-- Mobile Sidebar Overlay -->
    <div id="mobileSidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- Mobile Sidebar Drawer -->
    <aside
        id="mobileSidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-[#173a6b] text-white transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden"
        aria-hidden="true"
    >
        <div class="flex h-full flex-col">
            <div class="px-4 py-6 border-b border-white/10 flex items-start justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <img src="/images/dap_logo.png" alt="DAP Logo" class="w-12 h-12 object-contain rounded-md shrink-0">
                    <div class="min-w-0">
                        <h1 class="text-[16px] font-bold leading-tight truncate">Gate Pass Request</h1>
                        <p class="text-[12px] text-white/80 mt-1 truncate">Employee</p>
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

            <nav class="px-3 py-6 space-y-2">
                <button type="button" data-mobile-nav="dashboard" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-semibold text-left text-white hover:bg-white/10 transition">
                    <i class="fa-regular fa-file-lines text-[18px]"></i>
                    <span>Gate Pass Request</span>
                </button>
                <button type="button" data-mobile-nav="history" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-semibold text-left text-white hover:bg-white/10 transition">
                    <i class="fa-solid fa-clock-rotate-left text-[18px]"></i>
                    <span>Request History</span>
                </button>
            </nav>

            <div class="mt-auto px-6 py-6 border-t border-white/10">
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

    <div class="flex flex-col md:flex-row min-h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="hidden lg:flex w-full md:w-72 lg:w-80 bg-[#173a6b] text-white flex-col justify-between shrink-0 md:min-h-screen">
            <div>
                <!-- Logo / System Name -->
                <div class="px-6 py-10 border-b border-white/10">
                    <div class="flex items-start gap-4">
                        <img src="/images/dap_logo.png" alt="DAP Logo" class="w-[54px] h-[54px] object-contain rounded-md">
                        <div>
                            <h1 class="text-[20px] font-bold leading-tight">Gate Pass</h1>
                            <h1 class="text-[20px] font-bold leading-tight">Request</h1>
                            <p class="text-[23px]/none"></p>
                            <p class="text-[24px]/none"></p>
                            <p class="text-[24px]/none"></p>
                            <p class="text-[24px]/none"></p>
                            <p class="text-[24px]/none"></p>
                            <p class="text-[24px]/none"></p>
                            <p class="text-[24px]/none"></p>
                            <p class="text-[24px]/none"></p>
                            <p class="text-[24px]/none"></p>
                            <p class="text-[16px] text-white/90 mt-1">Employee</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-4 py-6 space-y-4">
                    <button
                        type="button"
                        id="navDashboard"
                        class="w-full flex items-center gap-4 bg-[#47698f] rounded-2xl px-5 py-5 text-[18px] font-semibold text-left text-white">
                        <i class="fa-regular fa-file-lines text-[22px]"></i>
                        <span>Gate Pass Request</span>
                    </button>

                    <button
                        type="button"
                        id="navHistory"
                        class="w-full flex items-center gap-4 px-5 py-4 text-[18px] font-semibold text-left text-white/90 hover:bg-white/10 rounded-2xl transition">
                        <i class="fa-solid fa-clock-rotate-left text-[22px]"></i>
                        <span>Request History</span>
                    </button>
                </nav>
            </div>

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

            <!-- Top Header -->
            <header class="bg-[#f3f3f3] border-b border-black/10 px-4 sm:px-6 lg:px-8 py-4 sm:py-7 flex items-center justify-between gap-3">
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
                        <h2 id="pageTitle" class="text-[20px] sm:text-[40px] font-bold text-black leading-none break-words">Dashboard</h2>
                        <p id="employeeWelcomeLine" class="hidden sm:block text-[16px] sm:text-[20px] text-[#3e5573] mt-2 break-words">Welcome back, <span id="employeeWelcomeName">{{ $employeeFullName ?? auth()->user()?->name }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        id="newRequestBtn"
                        type="button"
                        onclick="openRequestModal()"
                        class="bg-[#f6b400] hover:bg-[#e6a800] text-[#003b95] font-semibold text-[14px] sm:text-[16px] px-4 sm:px-8 py-2.5 sm:py-3 rounded-2xl flex items-center gap-3 transition whitespace-nowrap">
                        <i class="fa-solid fa-plus text-[18px]"></i>
                        <span>New Request</span>
                    </button>

                    <button onclick="openProfileModal()" class="w-11 h-11 sm:w-[50px] sm:h-[50px] rounded-xl sm:rounded-full bg-[#003b95] text-white flex items-center justify-center text-[20px] sm:text-[24px]">
                        <i class="fa-regular fa-user"></i>
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <section class="w-full max-w-full min-w-0 px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
            <!-- DASHBOARD SECTION -->
            <div id="dashboardSection" class="flex flex-col">
                <div class="order-3 md:order-1 grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5 mb-7">
                    <div class="bg-white rounded-[18px] sm:rounded-[22px] border border-black/10 p-4 sm:p-6 relative overflow-hidden min-h-[100px] sm:min-h-[120px] flex flex-col justify-between">
                        <div class="absolute top-0 left-0 w-[5px] h-full bg-[#003b95]"></div>
                        <p class="text-[14px] sm:text-[16px] text-[#556b86] mb-2">Total Requests</p>
                        <h3 id="employeeTotalRequestsCount" class="text-[28px] sm:text-[36px] font-bold text-[#003b95] leading-none">0</h3>
                    </div>

                    <div class="bg-white rounded-[18px] sm:rounded-[22px] border border-black/10 p-4 sm:p-6 relative overflow-hidden min-h-[100px] sm:min-h-[120px] flex flex-col justify-between">
                        <div class="absolute top-0 left-0 w-[5px] h-full bg-[#f5b000]"></div>
                        <p class="text-[14px] sm:text-[16px] text-[#556b86] mb-2">Pending</p>
                        <h3 id="employeePendingRequestsCount" class="text-[28px] sm:text-[36px] font-bold text-[#f5b000] leading-none">0</h3>
                    </div>

                    <div class="bg-white rounded-[18px] sm:rounded-[22px] border border-black/10 p-4 sm:p-6 relative overflow-hidden min-h-[100px] sm:min-h-[120px] flex flex-col justify-between">
                        <div class="absolute top-0 left-0 w-[5px] h-full bg-[#00b84f]"></div>
                        <p class="text-[14px] sm:text-[16px] text-[#556b86] mb-2">Approved</p>
                        <h3 id="employeeApprovedRequestsCount" class="text-[28px] sm:text-[36px] font-bold text-[#00b84f] leading-none">0</h3>
                    </div>

                    <div class="bg-white rounded-[18px] sm:rounded-[22px] border border-black/10 p-4 sm:p-6 relative overflow-hidden min-h-[100px] sm:min-h-[120px] flex flex-col justify-between">
                        <div class="absolute top-0 left-0 w-[5px] h-full bg-[#ff5a00]"></div>
                        <p class="text-[14px] sm:text-[16px] text-[#556b86] mb-2">Active Outside</p>
                        <h3 id="employeeActiveOutsideCount" class="text-[28px] sm:text-[36px] font-bold text-[#ff5a00] leading-none">0</h3>
                    </div>
                </div>

                <div class="order-1 md:order-2 flex flex-wrap items-center gap-4 mb-7">
                    <div class="flex items-center gap-3 text-[#003b95] font-semibold text-[18px]">
                        <i class="fa-solid fa-filter text-[22px]"></i>
                        <span>Filter by Status:</span>
                    </div>

                    <button data-employee-status-filter="All" class="px-5 py-2.5 rounded-2xl bg-[#003b95] text-white text-[16px] font-semibold whitespace-nowrap">
                        All
                    </button>

                    <button data-employee-status-filter="Pending" class="px-5 py-2.5 rounded-2xl border border-[#f5b000] text-[#f5b000] bg-white text-[16px] font-semibold whitespace-nowrap">
                        Pending
                    </button>

                    <button data-employee-status-filter="Approved" class="px-5 py-2.5 rounded-2xl border border-[#00b84f] text-[#00b84f] bg-white text-[16px] font-semibold whitespace-nowrap">
                        Approved
                    </button>

                    <button data-employee-status-filter="Returned" class="px-5 py-2.5 rounded-2xl border border-[#2962ff] text-[#2962ff] bg-white text-[16px] font-semibold whitespace-nowrap">
                        Returned
                    </button>
                </div>

                <div class="order-2 md:order-3 bg-white rounded-[22px] border border-black/10 min-h-[330px] px-5 sm:px-8 py-8">
                    <h3 class="text-[22px] font-semibold text-[#003b95] mb-2">My Requests</h3>
                    <p id="employeeDashboardRequestsFound" class="text-[18px] text-[#6b7280] mb-10">0 requests found</p>

                    <div id="employeeDashboardEmpty" class="h-[180px] flex items-center justify-center border border-dashed border-gray-300 rounded-2xl">
                        <p class="text-gray-400 text-[18px]">No requests found.</p>
                    </div>
                    <div id="employeeDashboardList" class="hidden"></div>
                </div>
            </div>

            <!-- HISTORY SECTION -->
            <div id="historySection" class="hidden">
                <div class="bg-white rounded-[20px] border border-gray-200 overflow-hidden">

                    <div class="px-5 sm:px-8 py-6 border-b border-gray-200">
                        <h3 class="text-[22px] font-semibold text-[#003b95]">Request History</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="grid min-w-[720px] grid-cols-12 px-5 sm:px-8 py-5 border-b border-gray-200 text-[15px] font-semibold text-[#425b78] uppercase tracking-wide">
                            <div class="col-span-2 whitespace-nowrap">Gate Pass No.</div>
                            <div class="col-span-6">Equipment</div>
                            <div class="col-span-2 whitespace-nowrap">Date</div>
                            <div class="col-span-2 whitespace-nowrap">Status</div>
                        </div>
                    </div>

                    <div id="historyList"></div>

                    <div id="emptyHistory" class="py-16 text-center text-gray-400 text-[18px]">
                        No request history yet.
                    </div>
                </div>
            </div>

        </section>
        </main>
    </div>

    <!-- Toast Notification -->
    <div
        id="employeeToast"
        class="fixed top-6 right-4 z-[60] transform translate-y-[-20px] opacity-0 pointer-events-none transition-all duration-300"
    >
        <div
            id="employeeToastInner"
            class="max-w-sm rounded-2xl shadow-lg px-5 py-4 text-[15px] font-medium text-white bg-[#003b95] flex items-start gap-3"
        >
            <span id="employeeToastIcon" class="mt-0.5 text-[18px]">!</span>
            <span id="employeeToastMessage">Message</span>
        </div>
    </div>

    <!-- Floating Help Button -->
    <button class="fixed bottom-4 right-4 w-[42px] h-[42px] rounded-full bg-[#2f2f2f] text-white shadow-lg flex items-center justify-center text-[20px]">
        ?
    </button>

    <!-- New Request Modal -->
    <div id="requestModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[1280px] bg-white rounded-[18px] shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[26px] font-bold text-[#003b95]">New Gate Pass Request</h2>
                <button type="button" onclick="closeRequestModal()" class="text-[#98a2b3] hover:text-black text-[28px] leading-none">
                    ×
                </button>
            </div>

            <!-- Body -->
            <div class="px-7 py-6 max-h-[78vh] overflow-y-auto">
                <form
                    id="employeeGatepassForm"
                    class="space-y-6"
                    method="POST"
                    action="{{ route('employee.gatepass-requests.store') }}"
                >
                    @csrf

                    <!-- Top Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Gate Pass No.
                            </label>
                            <p class="text-[13px] text-[#667085] mb-2">(Auto-generated)</p>
                            <input
                                type="text"
                                value=""
                                placeholder="Auto-generated"
                                disabled
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-gray-400 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Name
                            </label>
                            <p class="text-[13px] text-[#667085] mb-2">(Current User)</p>
                            <input
                                id="employeeGatepassDisplayName"
                                type="text"
                                value="{{ $employeeFullName ?? auth()->user()?->name }}"
                                disabled
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-gray-400 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Request Date
                            </label>
                            <p class="text-[13px] text-[#667085] mb-2">(Auto-filled)</p>
                            <input
                                type="date"
                                value="<?php echo date('Y-m-d'); ?>"
                                disabled
                                class="w-full h-[46px] rounded-xl border border-blue-200 bg-[#f8fbff] px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Center/Office
                            </label>
                            <p class="text-[13px] text-[#667085] mb-2">(Auto-filled)</p>
                            <input
                                id="employeeGatepassDisplayCenter"
                                type="text"
                                value="{{ $employee?->center }}"
                                disabled
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-gray-400 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Purpose <span class="text-red-500">*</span>
                            </label>
                            <p class="text-[13px] text-transparent mb-2">.</p>
                            <input
                                id="employeePurpose"
                                name="purpose"
                                type="text"
                                placeholder="Enter purpose..."
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Remarks
                            </label>
                            <p class="text-[13px] text-transparent mb-2">.</p>
                            <input
                                id="employeeRemarks"
                                name="remarks"
                                type="text"
                                placeholder="Enter Remarks(Optional)..."
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                        </div>
                    </div>

                    <!-- Destination + Equipment Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-[1fr_1fr_auto] gap-6 items-end">
                        <div>
                            <label class="block text-[16px] font-semibold text-[#243b5a] mb-3">
                                The items will be brought to <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="employeeDestination"
                                name="destination"
                                type="text"
                                placeholder="Enter destination..."
                                class="w-full h-[48px] rounded-xl border border-gray-300 bg-white px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-[16px] font-semibold text-[#243b5a] mb-3">
                                Selected Equipment ({{ ($equipment ?? collect())->count() }} items)
                            </label>
                            <select
                                id="employeeEquipmentSelect"
                                class="w-full h-[48px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-[#667085] focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                                <option value="" selected>Select Equipment</option>
                                @foreach (($equipment ?? collect()) as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->current_prop_no ? $item->current_prop_no.' - ' : '' }}{{ $item->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button
                                id="employeeAddEquipmentBtn"
                                type="button"
                                class="h-[48px] w-full md:w-auto px-7 rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold flex items-center justify-center gap-3 transition whitespace-nowrap">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add</span>
                            </button>
                        </div>
                    </div>

                    <!-- Selected Equipment Box -->
                    <div class="border border-gray-200 rounded-2xl bg-[#fbfcfe] min-h-[155px]">
                        <table class="w-full text-left">
                            <thead class="border-b border-gray-200 bg-white/60">
                                <tr>
                                    <th class="px-5 py-3 text-[14px] font-semibold text-[#4b6790]">#</th>
                                    <th class="px-5 py-3 text-[14px] font-semibold text-[#4b6790]">Prop No</th>
                                    <th class="px-5 py-3 text-[14px] font-semibold text-[#4b6790]">Description</th>
                                    <th class="px-5 py-3 text-[14px] font-semibold text-[#4b6790] text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody id="employeeSelectedEquipmentBody">
                                <tr id="employeeNoEquipmentRow">
                                    <td colspan="4" class="px-5 py-6 text-center text-[15px] text-[#98a2b3]">
                                        No equipment selected
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 pt-7 flex justify-end gap-4">
                        <button
                            type="button"
                            onclick="closeRequestModal()"
                            class="px-6 sm:px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[16px] font-semibold text-black hover:bg-gray-50 transition whitespace-nowrap">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-6 sm:px-10 h-[46px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold transition whitespace-nowrap">
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[1100px] bg-white rounded-[18px] shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[26px] font-bold text-[#003b95]">User Profile</h2>
                <button type="button" onclick="closeProfileModal()" class="text-[#98a2b3] hover:text-black text-[28px] leading-none">
                    ×
                </button>
            </div>

            <!-- Body -->
            <div class="px-7 py-6 max-h-[78vh] overflow-y-auto">
                <form id="employeeProfileForm" class="space-y-8" method="POST" action="{{ route('employee.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div id="employeeProfileAlertSuccess" class="hidden rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[14px] text-emerald-800"></div>
                    <div id="employeeProfileAlertError" class="hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[14px] text-red-800"></div>

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
                                    value="{{ old('employee_name', $employee?->employee_name ?? '') }}"
                                    required
                                    autocomplete="name"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <p id="profileErrorEmployeeName" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
                            </div>

                            <div>
                                <label for="profileCenter" class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Center/Office
                                </label>
                                <input
                                    id="profileCenter"
                                    name="center"
                                    type="text"
                                    value="{{ old('center', $employee?->center ?? '') }}"
                                    required
                                    autocomplete="organization"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <p id="profileErrorCenter" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
                            </div>

                            <div>
                                <label for="profileEmail" class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Email Address
                                </label>
                                <input
                                    id="profileEmail"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', auth()->user()?->email) }}"
                                    required
                                    autocomplete="email"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <p id="profileErrorEmail" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
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
                                <p id="profileErrorCurrentPassword" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
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
                                <p id="profileErrorPassword" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
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
                                <p id="profileErrorPasswordConfirmation" class="mt-1.5 text-[13px] text-red-600 hidden"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 pt-7 flex flex-col-reverse sm:flex-row sm:justify-end gap-4">
                        <button
                            type="button"
                            onclick="closeProfileModal()"
                            class="px-6 sm:px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[16px] font-semibold text-black hover:bg-gray-50 transition whitespace-nowrap">
                            Cancel
                        </button>

                        <button
                            id="employeeProfileSubmitBtn"
                            type="submit"
                            class="px-6 sm:px-10 h-[46px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold transition whitespace-nowrap disabled:opacity-60 disabled:cursor-not-allowed">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Request Details Modal -->
    <div id="requestDetailsModal" class="fixed inset-0 bg-black/55 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[920px] bg-white rounded-[18px] shadow-2xl overflow-hidden border border-gray-200">
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[26px] font-bold text-[#003b95]">Request Details</h2>
                <button type="button" id="requestDetailsCloseBtn" class="text-[#98a2b3] hover:text-black text-[28px] leading-none">
                    ×
                </button>
            </div>

            <div class="px-7 py-6 max-h-[78vh] overflow-y-auto">
                <div id="requestDetailsLoading" class="py-10 text-center text-[#667085] text-[16px] hidden">
                    Loading request details...
                </div>

                <div id="requestDetailsError" class="py-10 text-center text-red-600 text-[16px] hidden">
                    Failed to load request details. Please try again.
                </div>

                <div id="requestDetailsBody" class="space-y-6 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4">
                            <div class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Gate Pass No.</div>
                            <div id="requestDetailsGatepassNo" class="mt-2 text-[16px] font-semibold text-[#003b95] break-words">—</div>
                        </div>

                        <div class="md:text-right rounded-2xl border border-gray-200 bg-white px-5 py-4">
                            <div class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide">Status</div>
                            <div class="mt-2">
                                <span id="requestDetailsStatusBadge" class="inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    —
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4">
                        <div class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-3">Equipment</div>
                        <div id="requestDetailsItems" class="space-y-3"></div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4">
                        <div class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-4">Request Information</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2">Request Date</div>
                                <div id="requestDetailsRequestDate" class="text-[15px] font-semibold text-[#111827]">—</div>
                            </div>

                            <div>
                                <div class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2">Purpose</div>
                                <div id="requestDetailsPurpose" class="text-[15px] font-semibold text-[#111827] break-words">—</div>
                            </div>

                            <div>
                                <div class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2">Item will be brought to</div>
                                <div id="requestDetailsDestination" class="text-[15px] font-semibold text-[#111827] break-words">—</div>
                            </div>

                            <div>
                                <div class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2">Remarks</div>
                                <div id="requestDetailsRemarks" class="text-[15px] font-semibold text-[#111827] break-words">—</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gate Pass QR Code Modal -->
    <div id="gatepassQrModal" class="fixed inset-0 bg-black/55 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[560px] bg-white rounded-[18px] shadow-2xl overflow-hidden border border-gray-200">
            <div class="flex items-center justify-center px-7 py-6 border-b border-gray-200">
                <h2 class="text-[26px] font-bold text-[#003b95]">Gate Pass QR Code</h2>
            </div>

            <div class="px-7 py-10">
                <div class="flex flex-col items-center gap-8">
                    <div
                        id="gatepassQrCodeContainer"
                        class="w-full min-h-[280px] flex items-center justify-center rounded-2xl border border-dashed border-gray-200 bg-[#fbfcfe] px-4 py-6"
                    >
                        <!-- QR loaded/generate here -->
                    </div>

                    <div class="w-full rounded-2xl border border-gray-200 bg-white px-5 py-4 text-center">
                        <div class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2">
                            Gate Pass Number
                        </div>
                        <div id="gatepassQrGatepassNo" class="text-[18px] md:text-[20px] font-semibold text-[#003b95] break-words leading-snug">
                            —
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 px-7 py-6">
                <div class="flex flex-col sm:flex-row gap-4 sm:items-stretch sm:justify-between">
                    <button
                        type="button"
                        id="gatepassQrDownloadBtn"
                        disabled
                        class="w-full sm:flex-1 flex items-center justify-center h-[52px] rounded-xl bg-[#f6b400] hover:bg-[#e6a800] text-[#003b95] text-[16px] font-semibold transition whitespace-nowrap px-6 leading-none disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        Download QR Code
                    </button>

                    <button
                        type="button"
                        id="gatepassQrCloseBtnBottom"
                        class="w-full sm:flex-1 flex items-center justify-center h-[52px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold transition whitespace-nowrap px-6 leading-none"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>

        const navDashboard = document.getElementById('navDashboard');
        const navHistory = document.getElementById('navHistory');

        const dashboardSection = document.getElementById('dashboardSection');
        const historySection = document.getElementById('historySection');

        const pageTitle = document.getElementById('pageTitle');
        const newRequestBtn = document.getElementById('newRequestBtn');

        const employeeGatepassForm = document.getElementById('employeeGatepassForm');
        const employeeEquipmentSelect = document.getElementById('employeeEquipmentSelect');
        const employeeAddEquipmentBtn = document.getElementById('employeeAddEquipmentBtn');
        const employeeSelectedEquipmentBody = document.getElementById('employeeSelectedEquipmentBody');
        const employeeNoEquipmentRow = document.getElementById('employeeNoEquipmentRow');

        function activateDashboardButton() {
            navDashboard.classList.add('bg-[#47698f]', 'text-white');
            navDashboard.classList.remove('text-white/90', 'hover:bg-white/10');

            navHistory.classList.remove('bg-[#47698f]', 'text-white');
            navHistory.classList.add('text-white/90', 'hover:bg-white/10');
        }

        function activateHistoryButton() {
            navHistory.classList.add('bg-[#47698f]', 'text-white');
            navHistory.classList.remove('text-white/90', 'hover:bg-white/10');

            navDashboard.classList.remove('bg-[#47698f]', 'text-white');
            navDashboard.classList.add('text-white/90', 'hover:bg-white/10');
        }

        function showDashboardSection() {

            dashboardSection.classList.remove('hidden');
            historySection.classList.add('hidden');

            pageTitle.textContent = "Dashboard";
            newRequestBtn.classList.remove('hidden');

            activateDashboardButton();
        }

        function showHistorySection() {

            dashboardSection.classList.add('hidden');
            historySection.classList.remove('hidden');

            pageTitle.textContent = "Request History";
            newRequestBtn.classList.add('hidden');

            activateHistoryButton();

            employeeLoadRequestHistory();
        }

        navDashboard.addEventListener('click', showDashboardSection);
        navHistory.addEventListener('click', showHistorySection);

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
                sidebar.querySelectorAll('button[data-mobile-nav]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        const kind = btn.getAttribute('data-mobile-nav');
                        if (kind === 'dashboard') {
                            showDashboardSection();
                        } else if (kind === 'history') {
                            showHistorySection();
                        }
                        closeMobileSidebar();
                    });
                });
            }
        });


        function openRequestModal() {
            const modal = document.getElementById('requestModal');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.classList.add('overflow-hidden');
        }

        function closeRequestModal() {

            const modal = document.getElementById('requestModal');

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.classList.remove('overflow-hidden');
        }

        function employeeShowToast(message, type) {
            const container = document.getElementById('employeeToast');
            const inner = document.getElementById('employeeToastInner');
            const icon = document.getElementById('employeeToastIcon');
            const text = document.getElementById('employeeToastMessage');

            if (!container || !inner || !icon || !text) {
                alert(message);
                return;
            }

            text.textContent = message;

            if (type === 'success') {
                inner.classList.remove('bg-[#b91c1c]');
                inner.classList.add('bg-[#16a34a]');
                icon.textContent = '✓';
            } else {
                inner.classList.remove('bg-[#16a34a]');
                inner.classList.add('bg-[#b91c1c]');
                icon.textContent = '!';
            }

            container.classList.remove('pointer-events-none');
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';

            clearTimeout(window.__employeeToastTimeout);
            window.__employeeToastTimeout = setTimeout(function () {
                container.style.opacity = '0';
                container.style.transform = 'translateY(-20px)';
                setTimeout(function () {
                    container.classList.add('pointer-events-none');
                }, 300);
            }, 2500);
        }

        function employeeResetEquipmentTable() {
            if (!employeeSelectedEquipmentBody || !employeeNoEquipmentRow) {
                return;
            }

            employeeSelectedEquipmentBody.innerHTML = '';
            employeeSelectedEquipmentBody.appendChild(employeeNoEquipmentRow);
        }

        window.addEventListener('click', function(e) {
            const requestModal = document.getElementById('requestModal');
            const profileModal = document.getElementById('profileModal');
            const requestDetailsModal = document.getElementById('requestDetailsModal');
            const gatepassQrModal = document.getElementById('gatepassQrModal');

            if (requestModal && e.target === requestModal) {
                closeRequestModal();
            }

            if (profileModal && e.target === profileModal) {
                closeProfileModal();
            }

            if (requestDetailsModal && e.target === requestDetailsModal) {
                closeRequestDetailsModal();
            }

            if (gatepassQrModal && e.target === gatepassQrModal) {
                closeGatepassQrModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            showDashboardSection();

            employeeWireDashboardFilters();
            employeeLoadDashboard('All');

            if (employeeAddEquipmentBtn) {
                employeeAddEquipmentBtn.addEventListener('click', function () {
                    if (!employeeEquipmentSelect || !employeeSelectedEquipmentBody || !employeeNoEquipmentRow) {
                        return;
                    }

                    const value = employeeEquipmentSelect.value;
                    const label = employeeEquipmentSelect.options[employeeEquipmentSelect.selectedIndex]?.text || '';

                    if (!value) {
                        return;
                    }

                    // Prevent duplicate items
                    const existingIds = employeeSelectedEquipmentBody.querySelectorAll('input[name="inventory_ids[]"]');
                    for (const input of existingIds) {
                        if (input.value === value) {
                            // Duplicate found, do not add again
                            employeeEquipmentSelect.value = '';
                            return;
                        }
                    }

                    // Parse "PROP_NO - DESCRIPTION" from the selected option text
                    const selectedText = label.trim();
                    const [propNoRaw, descriptionRaw] = selectedText.split(' - ');
                    const propNo = (propNoRaw || '').trim();
                    const description = (descriptionRaw || propNoRaw || '').trim();

                    if (employeeNoEquipmentRow.parentElement === employeeSelectedEquipmentBody) {
                        employeeSelectedEquipmentBody.removeChild(employeeNoEquipmentRow);
                    }

                    const index = employeeSelectedEquipmentBody.children.length + 1;
                    const tr = document.createElement('tr');

                    tr.innerHTML = ''
                        + '<td class="px-5 py-3 text-[14px] text-gray-700">' + index + '</td>'
                        + '<td class="px-5 py-3 text-[14px] text-gray-800">' + propNo + '</td>'
                        + '<td class="px-5 py-3 text-[14px] text-gray-800">' + description + '</td>'
                        + '<td class="px-5 py-3 text-right">'
                        + '  <button type="button" class="text-red-500 text-[14px] font-semibold" onclick="employeeRemoveSelectedEquipment(this)">Remove</button>'
                        + '  <input type="hidden" name="inventory_ids[]" value="' + value + '">'
                        + '</td>';

                    employeeSelectedEquipmentBody.appendChild(tr);
                    employeeEquipmentSelect.value = '';
                });
            }

            employeeWireProfileForm();

            if (employeeGatepassForm) {
                employeeGatepassForm.addEventListener('submit', async function (event) {
                    event.preventDefault();

                    const purposeInput = document.getElementById('employeePurpose');
                    const destinationInput = document.getElementById('employeeDestination');

                    const purpose = purposeInput ? purposeInput.value.trim() : '';
                    const destination = destinationInput ? destinationInput.value.trim() : '';

                    if (!purpose) {
                        employeeShowToast('Purpose is required.', 'error');
                        return;
                    }

                    if (!destination) {
                        employeeShowToast('Destination is required.', 'error');
                        return;
                    }

                    const selectedItems = employeeSelectedEquipmentBody
                        ? employeeSelectedEquipmentBody.querySelectorAll('input[name="inventory_ids[]"]')
                        : [];

                    if (!selectedItems || selectedItems.length === 0) {
                        employeeShowToast('Please add at least one selected item.', 'error');
                        return;
                    }

                    const form = employeeGatepassForm;
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

                        if (!response.ok) {
                            throw new Error('Request failed');
                        }

                        const data = await response.json();

                        employeeShowToast(
                            data.message || 'Gate pass request submitted successfully.',
                            'success'
                        );

                        form.reset();
                        employeeResetEquipmentTable();
                        closeRequestModal();
                        employeeLoadRequestHistory();
                        employeeLoadDashboard(window.__employeeDashboardActiveStatus || 'All');
                    } catch (error) {
                        employeeShowToast('Failed to submit gate pass request. Please try again.', 'error');
                    }
                });
            }

            const requestDetailsCloseBtn = document.getElementById('requestDetailsCloseBtn');
            if (requestDetailsCloseBtn) {
                requestDetailsCloseBtn.addEventListener('click', closeRequestDetailsModal);
            }

            const gatepassQrCloseBtnBottom = document.getElementById('gatepassQrCloseBtnBottom');
            if (gatepassQrCloseBtnBottom) {
                gatepassQrCloseBtnBottom.addEventListener('click', closeGatepassQrModal);
            }

            const gatepassQrDownloadBtn = document.getElementById('gatepassQrDownloadBtn');
            if (gatepassQrDownloadBtn) {
                gatepassQrDownloadBtn.addEventListener('click', async function () {
                    await employeeDownloadGatepassQrCode();
                });
            }
        });

        function employeeWireDashboardFilters() {
            const buttons = document.querySelectorAll('button[data-employee-status-filter]');
            for (const btn of buttons) {
                btn.addEventListener('click', function () {
                    const status = btn.getAttribute('data-employee-status-filter') || 'All';
                    employeeSetActiveDashboardFilter(status);
                    employeeLoadDashboard(status);
                });
            }

            employeeSetActiveDashboardFilter('All');
        }

        function employeeSetActiveDashboardFilter(status) {
            const buttons = document.querySelectorAll('button[data-employee-status-filter]');
            window.__employeeDashboardActiveStatus = status;

            for (const btn of buttons) {
                const btnStatus = btn.getAttribute('data-employee-status-filter') || '';
                const isActive = btnStatus.toLowerCase() === String(status).toLowerCase();

                const statusKey = btnStatus.toLowerCase();
                const palette = {
                    all: { bg: 'bg-[#003b95]', text: 'text-[#003b95]', border: 'border-[#003b95]' },
                    pending: { bg: 'bg-[#f5b000]', text: 'text-[#f5b000]', border: 'border-[#f5b000]' },
                    approved: { bg: 'bg-[#00b84f]', text: 'text-[#00b84f]', border: 'border-[#00b84f]' },
                    returned: { bg: 'bg-[#2962ff]', text: 'text-[#2962ff]', border: 'border-[#2962ff]' },
                };

                const colors = palette[statusKey];
                if (!colors) {
                    continue;
                }

                // reset to outlined state first
                btn.classList.remove('text-white', colors.bg);
                btn.classList.add('bg-white', 'border', colors.border, colors.text);

                if (isActive) {
                    // make it filled
                    btn.classList.remove('bg-white', colors.text);
                    btn.classList.add(colors.bg, 'text-white');
                }
            }
        }

        async function employeeLoadDashboard(status) {
            const totalEl = document.getElementById('employeeTotalRequestsCount');
            const pendingEl = document.getElementById('employeePendingRequestsCount');
            const approvedEl = document.getElementById('employeeApprovedRequestsCount');
            const activeOutsideEl = document.getElementById('employeeActiveOutsideCount');
            const foundEl = document.getElementById('employeeDashboardRequestsFound');
            const emptyEl = document.getElementById('employeeDashboardEmpty');
            const listEl = document.getElementById('employeeDashboardList');

            if (!totalEl || !pendingEl || !approvedEl || !activeOutsideEl || !foundEl || !emptyEl || !listEl) {
                return;
            }

            try {
                const qs = new URLSearchParams();
                if (status && String(status).toLowerCase() !== 'all') {
                    qs.set('status', status);
                }

                const response = await fetch("{{ route('employee.gatepass-requests.dashboard') }}" + (qs.toString() ? ('?' + qs.toString()) : ''), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Failed to load dashboard');
                }

                const json = await response.json();
                const data = (json && json.data) ? json.data : {};
                const counts = data.counts || {};
                const rows = Array.isArray(data.requests) ? data.requests : [];

                totalEl.textContent = String(counts.total ?? 0);
                pendingEl.textContent = String(counts.pending ?? 0);
                approvedEl.textContent = String(counts.approved ?? 0);
                activeOutsideEl.textContent = String(counts.active_outside ?? 0);

                foundEl.textContent = rows.length + ' requests found';

                listEl.innerHTML = '';

                if (!rows.length) {
                    emptyEl.classList.remove('hidden');
                    listEl.classList.add('hidden');
                    return;
                }

                emptyEl.classList.add('hidden');
                listEl.classList.remove('hidden');

                for (const row of rows) {
                    const equipments = Array.isArray(row.equipments) ? row.equipments : [];
                    const itemsText = equipments.length
                        ? equipments.map(function (eq) {
                            const prop = (eq.prop_no || '').toString().trim();
                            const desc = (eq.description || '').toString().trim();
                            const text = (prop ? (prop + ' - ') : '') + (desc || ('Inventory #' + eq.inventory_id));
                            return text;
                        }).join(', ')
                        : 'No items';

                    const statusText = (row.status || '—').toString();
                    const statusTextLower = String(statusText).toLowerCase();
                    const badgeClass = employeeStatusBadgeClass(statusText);

                    const card = document.createElement('div');
                    card.className = 'border border-gray-200 rounded-2xl bg-white px-5 py-5 mb-4 cursor-pointer hover:shadow-md hover:border-[#003b95]/30 transition';
                    card.setAttribute('role', 'button');
                    card.setAttribute('tabindex', '0');
                    card.setAttribute('aria-label', 'View request details');
                    const gatepassNo = (row.gatepass_no || '').toString();
                    const showQrButton = (statusTextLower === 'approved'
                        || statusTextLower === 'incoming partial'
                        || statusTextLower === 'returned') && gatepassNo;
                    const qrButtonHtml = showQrButton
                        ? '<button type="button" data-qr-gatepass-no="' + escapeHtml(gatepassNo) + '" aria-label="Show Gate Pass QR Code" class="w-[36px] h-[36px] rounded-full border border-[#00b84f]/30 bg-white text-[#00b84f] flex items-center justify-center text-[16px] hover:bg-[#e8fff0] transition">' +
                            '<i class="fa-solid fa-qrcode"></i>' +
                          '</button>'
                        : '';

                    card.innerHTML = ''
                        + '<div class="flex items-start justify-between gap-4">'
                        + '  <div class="min-w-0">'
                        + '    <div class="text-[16px] font-semibold text-[#003b95]">' + escapeHtml(row.gatepass_no || '') + '</div>'
                        + '    <div class="text-[14px] text-[#425b78] mt-1">Date: ' + escapeHtml(row.request_date || '') + '</div>'
                        + '    <div class="text-[14px] text-gray-700 mt-2 break-words">' + escapeHtml(itemsText) + '</div>'
                        + '  </div>'
                        + '  <div class="shrink-0 flex flex-col items-end gap-2">'
                        + '    <div class="flex items-center gap-2">'
                        + '      <span class="inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold ' + badgeClass + '">' + escapeHtml(statusText) + '</span>'
                        + qrButtonHtml
                        + '    </div>'
                        + '    <span class="text-[13px] font-semibold text-[#003b95] underline underline-offset-4">View Details</span>'
                        + '  </div>'
                        + '</div>';

                    card.addEventListener('click', function () {
                        if (gatepassNo) {
                            openRequestDetailsModal(gatepassNo);
                        }
                    });

                    card.addEventListener('keydown', function (ev) {
                        const target = ev.target;
                        if (target && target.closest && target.closest('button[data-qr-gatepass-no]')) {
                            return;
                        }

                        if (ev.key === 'Enter' || ev.key === ' ') {
                            ev.preventDefault();
                            if (gatepassNo) {
                                openRequestDetailsModal(gatepassNo);
                            }
                        }
                    });

                    if (showQrButton) {
                        const qrBtn = card.querySelector('button[data-qr-gatepass-no]');
                        if (qrBtn) {
                            qrBtn.addEventListener('click', function (ev) {
                                ev.stopPropagation();
                                openGatepassQrModal(gatepassNo);
                            });
                        }
                    }

                    listEl.appendChild(card);
                }
            } catch (e) {
                employeeShowToast('Failed to load dashboard. Please refresh.', 'error');
            }
        }

        async function employeeLoadRequestHistory() {
            const historyList = document.getElementById('historyList');
            const emptyHistory = document.getElementById('emptyHistory');

            if (!historyList || !emptyHistory) {
                return;
            }

            historyList.innerHTML = '';
            emptyHistory.classList.add('hidden');

            try {
                const response = await fetch("{{ route('employee.gatepass-requests.history') }}", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Failed to load history');
                }

                const json = await response.json();
                const rows = (json && json.data) ? json.data : [];

                if (!rows.length) {
                    emptyHistory.classList.remove('hidden');
                    return;
                }

                for (const row of rows) {
                    const equipments = Array.isArray(row.equipments) ? row.equipments : [];
                    const equipmentsHtml = equipments.length
                        ? equipments.map(function (eq) {
                            const prop = (eq.prop_no || '').toString().trim();
                            const desc = (eq.description || '').toString().trim();
                            const text = (prop ? (prop + ' - ') : '') + (desc || ('Inventory #' + eq.inventory_id));
                            return '<div class="text-[14px] text-[#1f2a37]">' + escapeHtml(text) + '</div>';
                        }).join('')
                        : '<div class="text-[14px] text-gray-400">No items</div>';

                    const status = (row.status || '—').toString();

                    const statusClass = status.toLowerCase() === 'pending'
                        ? 'bg-[#fff7e6] text-[#b45309] border border-[#f5b000]/30'
                        : (status.toLowerCase() === 'approved'
                            ? 'bg-[#e8fff0] text-[#15803d] border border-[#00b84f]/30'
                            : 'bg-gray-100 text-gray-700 border border-gray-200');

                    const wrapper = document.createElement('div');
                    wrapper.className = 'grid min-w-[720px] grid-cols-12 px-5 sm:px-8 py-5 border-b border-gray-200';

                    wrapper.innerHTML = ''
                        + '<div class="col-span-2 whitespace-nowrap text-[15px] font-semibold text-[#003b95]">' + escapeHtml(row.gatepass_no || '') + '</div>'
                        + '<div class="col-span-6 pr-4">' + equipmentsHtml + '</div>'
                        + '<div class="col-span-2 whitespace-nowrap text-[15px] text-[#425b78]">' + escapeHtml(row.request_date || '') + '</div>'
                        + '<div class="col-span-2 whitespace-nowrap">'
                        + '  <span class="inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold ' + statusClass + '">' + escapeHtml(status) + '</span>'
                        + '</div>';

                    historyList.appendChild(wrapper);
                }
            } catch (e) {
                emptyHistory.classList.remove('hidden');
                employeeShowToast('Failed to load request history. Please refresh.', 'error');
            }
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function employeeStatusBadgeClass(statusText) {
            const statusLower = String(statusText || '').toLowerCase();
            if (statusLower === 'pending') {
                return 'bg-[#fff7e6] text-[#b45309] border border-[#f5b000]/30';
            }
            if (statusLower === 'approved') {
                return 'bg-[#e8fff0] text-[#15803d] border border-[#00b84f]/30';
            }
            if (statusLower === 'returned') {
                return 'bg-[#eef5ff] text-[#1d4ed8] border border-[#2962ff]/30';
            }
            if (statusLower === 'incoming partial') {
                return 'bg-[#fffbeb] text-[#b45309] border border-amber-400/40';
            }

            return 'bg-gray-100 text-gray-700 border border-gray-200';
        }

        function openRequestDetailsModal(gatepassNo) {
            const modal = document.getElementById('requestDetailsModal');
            if (!modal) {
                return;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');

            employeeLoadRequestDetails(gatepassNo);
        }

        function closeRequestDetailsModal() {
            const modal = document.getElementById('requestDetailsModal');
            if (!modal) {
                return;
            }

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        async function openGatepassQrModal(gatepassNo) {
            const modal = document.getElementById('gatepassQrModal');
            if (!modal) {
                return;
            }

            const gatepassNoEl = document.getElementById('gatepassQrGatepassNo');
            const qrContainerEl = document.getElementById('gatepassQrCodeContainer');
            const qrDownloadBtn = document.getElementById('gatepassQrDownloadBtn');

            if (!gatepassNoEl || !qrContainerEl) {
                return;
            }

            gatepassNoEl.textContent = gatepassNo || '—';
            window.__gatepassQrDownloadUrl = null;
            window.__gatepassQrPath = null;
            if (qrDownloadBtn) {
                qrDownloadBtn.disabled = true;
            }

            qrContainerEl.innerHTML = '<div class="text-[#667085] text-[14px]">Loading QR...</div>';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');

            await employeeLoadGatepassQr(gatepassNo);
        }

        function closeGatepassQrModal() {
            const modal = document.getElementById('gatepassQrModal');
            if (!modal) {
                return;
            }

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');

            window.__gatepassQrDownloadUrl = null;
            window.__gatepassQrPath = null;
        }

        function renderGatepassQrError(message) {
            const qrContainerEl = document.getElementById('gatepassQrCodeContainer');
            const qrDownloadBtn = document.getElementById('gatepassQrDownloadBtn');

            if (qrDownloadBtn) {
                qrDownloadBtn.disabled = true;
            }

            if (!qrContainerEl) {
                return;
            }

            qrContainerEl.innerHTML = ''
                + '<div class="w-full flex flex-col items-center justify-center text-center gap-2 px-3">'
                + '  <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center">'
                + '    <i class="fa-solid fa-triangle-exclamation text-[20px]"></i>'
                + '  </div>'
                + '  <div class="text-red-600 font-semibold text-[15px]">' + escapeHtml(message || 'Unable to show QR code.') + '</div>'
                + '  <div class="text-[#667085] text-[13px]">Please try again later.</div>'
                + '</div>';
        }

        async function employeeLoadGatepassQr(gatepassNo) {
        const qrContainerEl = document.getElementById('gatepassQrCodeContainer');
        const qrDownloadBtn = document.getElementById('gatepassQrDownloadBtn');

        if (!qrContainerEl) {
            return;
        }

        try {
            const urlTemplate = "{{ route('employee.gatepass-requests.show', ['gatepass_no' => '__GP__']) }}";
            const url = urlTemplate.replace('__GP__', encodeURIComponent(String(gatepassNo || '')));

            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Failed to load gate pass details for QR.');
            }

            const json = await response.json();
            const data = json?.data || {};

            let savedQrUrl = data?.qr_code_url || null;
            const savedQrPath = data?.qr_code_path || null;

            // Fallback: build URL from qr_code_path if qr_code_url is missing
            if (!savedQrUrl && savedQrPath) {
                savedQrUrl = "{{ asset('storage') }}/" + String(savedQrPath).replace(/^\/+/, '');
            }

            if (!savedQrUrl) {
                throw new Error('QR not available for this gate pass.');
            }

            window.__gatepassQrDownloadUrl = savedQrUrl;
            window.__gatepassQrPath = savedQrPath || savedQrUrl;

            if (qrDownloadBtn) {
                qrDownloadBtn.disabled = false;
            }

            const isSvg = String(savedQrUrl).toLowerCase().includes('.svg');

            if (isSvg) {
                qrContainerEl.innerHTML = ''
                    + '<img '
                    + '  src="' + escapeHtml(savedQrUrl) + '" '
                    + '  alt="Gate Pass QR Code" '
                    + '  class="max-w-[260px] w-full h-auto mx-auto" '
                    + '  loading="eager"'
                    + '/>';
            } else {
                qrContainerEl.innerHTML = ''
                    + '<img '
                    + '  src="' + escapeHtml(savedQrUrl) + '" '
                    + '  alt="Gate Pass QR Code" '
                    + '  class="max-w-[260px] w-full h-auto mx-auto" '
                    + '  loading="eager"'
                    + '/>';
            }

            const mediaEl = qrContainerEl.querySelector('img, object');
            if (mediaEl) {
                mediaEl.addEventListener('error', function () {
                    window.__gatepassQrDownloadUrl = null;
                    window.__gatepassQrPath = null;
                    if (qrDownloadBtn) {
                        qrDownloadBtn.disabled = true;
                    }
                    renderGatepassQrError('Unable to display QR code.');
                }, { once: true });
            }
        } catch (e) {
            window.__gatepassQrDownloadUrl = null;
            window.__gatepassQrPath = null;
            renderGatepassQrError('QR not available for this gate pass.');
        }
    }

        
        async function employeeDownloadGatepassQrCode() {
            const downloadUrl = window.__gatepassQrDownloadUrl;
            const storedPath = window.__gatepassQrPath || '';
            const gatepassNoEl = document.getElementById('gatepassQrGatepassNo');
            const gatepassNo = (gatepassNoEl?.textContent || 'gatepass').replace(/[^a-zA-Z0-9_-]+/g, '-');

            if (!downloadUrl) {
                renderGatepassQrError('QR is not ready to download.');
                return;
            }

            try {
                const lowerUrl = String(downloadUrl).toLowerCase();
                const lowerPath = String(storedPath).toLowerCase();
                const isSvg = lowerUrl.includes('.svg') || lowerPath.includes('.svg');

                // If already PNG, download directly as PNG
                if (!isSvg) {
                    const response = await fetch(downloadUrl);
                    if (!response.ok) {
                        throw new Error('Failed to download QR.');
                    }

                    const blob = await response.blob();
                    const objectUrl = URL.createObjectURL(blob);

                    const a = document.createElement('a');
                    a.href = objectUrl;
                    a.download = gatepassNo + '-qr.png';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();

                    URL.revokeObjectURL(objectUrl);
                    return;
                }

                // If SVG, convert to PNG using canvas
                const svgResponse = await fetch(downloadUrl);
                if (!svgResponse.ok) {
                    throw new Error('Failed to fetch SVG QR.');
                }

                const svgText = await svgResponse.text();
                const svgBlob = new Blob([svgText], { type: 'image/svg+xml;charset=utf-8' });
                const svgObjectUrl = URL.createObjectURL(svgBlob);

                const img = new Image();
                img.onload = function () {
                    try {
                        const canvas = document.createElement('canvas');
                        const size = 1000; // bigger size for cleaner PNG
                        canvas.width = size;
                        canvas.height = size;

                        const ctx = canvas.getContext('2d');
                        ctx.fillStyle = '#ffffff';
                        ctx.fillRect(0, 0, size, size);
                        ctx.drawImage(img, 0, 0, size, size);

                        URL.revokeObjectURL(svgObjectUrl);

                        canvas.toBlob(function (pngBlob) {
                            if (!pngBlob) {
                                renderGatepassQrError('Failed to convert QR to PNG.');
                                return;
                            }

                            const pngUrl = URL.createObjectURL(pngBlob);
                            const a = document.createElement('a');
                            a.href = pngUrl;
                            a.download = gatepassNo + '-qr.png';
                            document.body.appendChild(a);
                            a.click();
                            a.remove();

                            URL.revokeObjectURL(pngUrl);
                        }, 'image/png');
                    } catch (err) {
                        renderGatepassQrError('Failed to convert QR to PNG.');
                    }
                };

                img.onerror = function () {
                    URL.revokeObjectURL(svgObjectUrl);
                    renderGatepassQrError('Failed to load SVG QR.');
                };

                img.src = svgObjectUrl;
            } catch (e) {
                renderGatepassQrError('Failed to download QR code.');
            }
        }

        async function employeeLoadRequestDetails(gatepassNo) {
            const loadingEl = document.getElementById('requestDetailsLoading');
            const errorEl = document.getElementById('requestDetailsError');
            const bodyEl = document.getElementById('requestDetailsBody');

            const gatepassNoEl = document.getElementById('requestDetailsGatepassNo');
            const statusBadgeEl = document.getElementById('requestDetailsStatusBadge');
            const itemsEl = document.getElementById('requestDetailsItems');
            const requestDateEl = document.getElementById('requestDetailsRequestDate');
            const purposeEl = document.getElementById('requestDetailsPurpose');
            const destinationEl = document.getElementById('requestDetailsDestination');
            const remarksEl = document.getElementById('requestDetailsRemarks');

            if (!loadingEl || !errorEl || !bodyEl || !gatepassNoEl || !statusBadgeEl || !itemsEl || !requestDateEl || !purposeEl || !destinationEl || !remarksEl) {
                return;
            }

            loadingEl.classList.remove('hidden');
            errorEl.classList.add('hidden');
            bodyEl.classList.add('hidden');

            gatepassNoEl.textContent = '—';
            statusBadgeEl.textContent = '—';
            statusBadgeEl.className = 'inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold bg-gray-100 text-gray-700 border border-gray-200';
            itemsEl.innerHTML = '';
            requestDateEl.textContent = '—';
            purposeEl.textContent = '—';
            destinationEl.textContent = '—';
            remarksEl.textContent = '—';

            try {
                const urlTemplate = "{{ route('employee.gatepass-requests.show', ['gatepass_no' => '__GP__']) }}";
                const url = urlTemplate.replace('__GP__', encodeURIComponent(String(gatepassNo)));

                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Failed to load request details');
                }

                const json = await response.json();
                const data = (json && json.data) ? json.data : null;
                if (!data) {
                    throw new Error('Invalid payload');
                }

                gatepassNoEl.textContent = data.gatepass_no || '—';

                const statusText = (data.status || '—').toString();
                statusBadgeEl.textContent = statusText;
                statusBadgeEl.className = 'inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold ' + employeeStatusBadgeClass(statusText);

                const items = Array.isArray(data.items) ? data.items : [];
                if (!items.length) {
                    itemsEl.innerHTML = '<div class="text-[14px] text-gray-400">No items</div>';
                } else {
                    itemsEl.innerHTML = items.map(function (it) {
                        const order = it.order != null ? it.order : '';
                        const propNo = (it.prop_no || '').toString().trim();
                        const desc = (it.description || '').toString().trim();

                        return ''
                            + '<div class="border border-gray-200 rounded-2xl bg-white px-5 py-4">'
                            + '  <div class="flex items-start justify-between gap-4">'
                            + '    <div class="min-w-0">'
                            + '      <div class="text-[14px] font-semibold text-[#243b5a]">Item ' + escapeHtml(order) + '</div>'
                            + '      <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">'
                            + '        <div>'
                            + '          <div class="text-[12px] font-semibold text-[#667085]">Property Number</div>'
                            + '          <div class="text-[14px] text-[#111827] break-words">' + escapeHtml(propNo || '—') + '</div>'
                            + '        </div>'
                            + '        <div>'
                            + '          <div class="text-[12px] font-semibold text-[#667085]">Description / Item Name</div>'
                            + '          <div class="text-[14px] text-[#111827] break-words">' + escapeHtml(desc || '—') + '</div>'
                            + '        </div>'
                            + '      </div>'
                            + '    </div>'
                            + '  </div>'
                            + '</div>';
                    }).join('');
                }

                requestDateEl.textContent = data.request_date || '—';
                purposeEl.textContent = data.purpose || '—';
                destinationEl.textContent = data.destination || '—';
                remarksEl.textContent = data.remarks || '—';

                loadingEl.classList.add('hidden');
                bodyEl.classList.remove('hidden');
            } catch (e) {
                loadingEl.classList.add('hidden');
                errorEl.classList.remove('hidden');
                bodyEl.classList.add('hidden');
            }
        }

        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') {
                return;
            }

            const requestDetailsModal = document.getElementById('requestDetailsModal');
            if (requestDetailsModal && !requestDetailsModal.classList.contains('hidden')) {
                closeRequestDetailsModal();
            }

            const requestModal = document.getElementById('requestModal');
            if (requestModal && !requestModal.classList.contains('hidden')) {
                closeRequestModal();
            }

            const profileModal = document.getElementById('profileModal');
            if (profileModal && !profileModal.classList.contains('hidden')) {
                closeProfileModal();
            }

            const gatepassQrModal = document.getElementById('gatepassQrModal');
            if (gatepassQrModal && !gatepassQrModal.classList.contains('hidden')) {
                closeGatepassQrModal();
            }
        });

        function employeeRemoveSelectedEquipment(button) {
            const row = button.closest('tr');
            if (!row || !employeeSelectedEquipmentBody || !employeeNoEquipmentRow) {
                return;
            }

            employeeSelectedEquipmentBody.removeChild(row);

            if (employeeSelectedEquipmentBody.children.length === 0) {
                employeeSelectedEquipmentBody.appendChild(employeeNoEquipmentRow);
            } else {
                Array.from(employeeSelectedEquipmentBody.children).forEach(function (tr, idx) {
                    const cell = tr.querySelector('td');
                    if (cell) {
                        cell.textContent = idx + 1;
                    }
                });
            }
        }

        function employeeClearProfileFormMessages() {
            const fieldErrorIds = [
                'profileErrorEmployeeName',
                'profileErrorCenter',
                'profileErrorEmail',
                'profileErrorCurrentPassword',
                'profileErrorPassword',
                'profileErrorPasswordConfirmation',
            ];

            for (const id of fieldErrorIds) {
                const el = document.getElementById(id);
                if (el) {
                    el.textContent = '';
                    el.classList.add('hidden');
                }
            }

            const successEl = document.getElementById('employeeProfileAlertSuccess');
            const errorEl = document.getElementById('employeeProfileAlertError');

            if (successEl) {
                successEl.textContent = '';
                successEl.classList.add('hidden');
            }

            if (errorEl) {
                errorEl.textContent = '';
                errorEl.classList.add('hidden');
            }
        }

        function employeeShowProfileTopError(message) {
            const errorEl = document.getElementById('employeeProfileAlertError');
            const successEl = document.getElementById('employeeProfileAlertSuccess');

            if (successEl) {
                successEl.classList.add('hidden');
            }

            if (errorEl) {
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
            }
        }

        function employeeShowProfileSuccess(message) {
            const successEl = document.getElementById('employeeProfileAlertSuccess');
            const errorEl = document.getElementById('employeeProfileAlertError');

            if (errorEl) {
                errorEl.classList.add('hidden');
            }

            if (successEl) {
                successEl.textContent = message;
                successEl.classList.remove('hidden');
            }
        }

        function employeeShowProfileValidationErrors(errors) {
            if (!errors || typeof errors !== 'object') {
                return;
            }

            const map = {
                employee_name: 'profileErrorEmployeeName',
                center: 'profileErrorCenter',
                email: 'profileErrorEmail',
                current_password: 'profileErrorCurrentPassword',
                password: 'profileErrorPassword',
                password_confirmation: 'profileErrorPasswordConfirmation',
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

        function employeeWireProfileForm() {
            const form = document.getElementById('employeeProfileForm');
            if (!form) {
                return;
            }

            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                employeeClearProfileFormMessages();

                const submitBtn = document.getElementById('employeeProfileSubmitBtn');
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
                        employeeShowProfileValidationErrors(data.errors);
                        employeeShowProfileTopError(data.message || 'Please correct the errors below.');
                        return;
                    }

                    if (!response.ok) {
                        employeeShowProfileTopError(
                            data.message || 'Unable to update profile. Please try again.'
                        );
                        return;
                    }

                    employeeShowProfileSuccess(data.message || 'Profile updated successfully.');
                    employeeShowToast(data.message || 'Profile updated successfully.', 'success');

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

                        const welcomeName = document.getElementById('employeeWelcomeName');
                        if (welcomeName && data.data.employee_name) {
                            welcomeName.textContent = data.data.employee_name;
                        }

                        const gatepassName = document.getElementById('employeeGatepassDisplayName');
                        const gatepassCenter = document.getElementById('employeeGatepassDisplayCenter');

                        if (gatepassName && data.data.employee_name) {
                            gatepassName.value = data.data.employee_name;
                        }
                        if (gatepassCenter && data.data.center != null) {
                            gatepassCenter.value = data.data.center;
                        }
                    }

                    const cur = document.getElementById('profileCurrentPassword');
                    const neu = document.getElementById('profileNewPassword');
                    const conf = document.getElementById('profilePasswordConfirmation');

                    if (cur) {
                        cur.value = '';
                    }
                    if (neu) {
                        neu.value = '';
                    }
                    if (conf) {
                        conf.value = '';
                    }
                } catch (err) {
                    employeeShowProfileTopError('Network error. Please try again.');
                } finally {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                    }
                }
            });
        }

        function openProfileModal() {
            const modal = document.getElementById('profileModal');
            if (!modal) return;

            employeeClearProfileFormMessages();

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.classList.add('overflow-hidden');
        }

        function closeProfileModal() {
            const modal = document.getElementById('profileModal');
            if (!modal) return;

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.classList.remove('overflow-hidden');
        }
    </script>

</body>

</html>