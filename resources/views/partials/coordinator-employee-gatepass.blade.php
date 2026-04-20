{{-- Embedded employee gatepass UI for coordinator (same API routes as employee dashboard) --}}
<div id="gatepassEmployeePanel" class="hidden">
            <div class="mb-6 flex justify-end">
                <button
                    id="newRequestBtn"
                    type="button"
                    onclick="openRequestModal()"
                    class="hidden inline-flex bg-[#f6b400] hover:bg-[#e6a800] text-[#003b95] font-semibold text-[14px] px-5 py-2.5 rounded-2xl items-center gap-2 transition whitespace-nowrap"
                    aria-hidden="true"
                >
                    <i class="fa-solid fa-plus text-[16px]"></i>
                    <span>New Request</span>
                </button>
            </div>
<!-- DASHBOARD SECTION -->
            <div id="gatepassEmployeeDashboardSection" class="flex flex-col">
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
            <div id="gatepassEmployeeHistorySection" class="hidden">
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
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-white-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
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
                                placeholder="Enter Remarks (Optional)"
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-white-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
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
                                Selected Equipment ({{ ($equipment ?? collect())->count() }} items) <span class="text-red-500">*</span>
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
    <div id="gatepassQrModal" class="fixed inset-0 bg-black/55 z-50 hidden items-center justify-center p-3 sm:p-4">
        <div class="w-full max-w-[520px] sm:max-w-[560px] lg:max-w-[620px] bg-white rounded-[18px] shadow-2xl overflow-hidden border border-gray-200 max-h-[calc(100svh-1.5rem)] sm:max-h-[calc(100svh-2rem)] flex flex-col">
            <div class="flex items-center justify-center px-5 sm:px-7 py-4 sm:py-6 border-b border-gray-200 shrink-0">
                <h2 class="text-[20px] sm:text-[24px] lg:text-[26px] font-bold text-[#003b95]">Gate Pass QR Code</h2>
            </div>

            <div class="px-5 sm:px-7 py-6 sm:py-8 overflow-y-auto">
                <div class="flex flex-col items-center gap-5 sm:gap-8">
                    <div
                        id="gatepassQrCodeContainer"
                        class="w-full min-h-[220px] sm:min-h-[260px] lg:min-h-[300px] flex items-center justify-center rounded-2xl border border-dashed border-gray-200 bg-[#fbfcfe] px-4 py-6"
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

            <div class="border-t border-gray-200 px-5 sm:px-7 py-4 sm:py-6 shrink-0">
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 sm:items-stretch sm:justify-between">
                    <button
                        type="button"
                        id="gatepassQrDownloadBtn"
                        disabled
                        class="w-full sm:flex-1 flex items-center justify-center h-[48px] sm:h-[52px] rounded-xl bg-[#f6b400] hover:bg-[#e6a800] text-[#003b95] text-[15px] sm:text-[16px] font-semibold transition whitespace-nowrap px-5 sm:px-6 leading-none disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        Download QR Code
                    </button>

                    <button
                        type="button"
                        id="gatepassQrCloseBtnBottom"
                        class="w-full sm:flex-1 flex items-center justify-center h-[48px] sm:h-[52px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[15px] sm:text-[16px] font-semibold transition whitespace-nowrap px-5 sm:px-6 leading-none"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    