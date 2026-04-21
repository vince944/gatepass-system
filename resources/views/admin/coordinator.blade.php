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

                    <button id="navCoordinatorDashboard" type="button"
                        class="w-full flex items-center gap-4 bg-[#47698f] rounded-2xl px-5 py-4 text-[16px] font-semibold text-left text-white">
                        <i class="fa-solid fa-border-all text-[18px]"></i>
                        <span>Items Tracker</span>
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
                        <h2 id="pageTitle" class="text-[22px] md:text-[24px] font-bold text-black leading-none break-words">Items Tracker</h2>
                        <p id="pageSubtitle" class="text-[14px] text-[#556b86] mt-2 break-words">List of Inventory</p>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
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

                @include('partials.coordinator-employee-gatepass', [
                    'employee' => $gatepassEmployee ?? null,
                    'employeeFullName' => $gatepassEmployeeFullName ?? null,
                    'equipment' => $gatepassEquipment ?? collect(),
                ])

                @include('partials.coordinator-workspace-sections')


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

                                            <div>
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

                                            <div>
                                                <label class="mb-2 block text-sm font-semibold text-black">Role</label>
                                                <input
                                                    id="addEmployeeRoleField"
                                                    type="text"
                                                    name="role"
                                                    placeholder="e.g. employee"
                                                    autocomplete="off"
                                                    class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-black focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                                    required
                                                >
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


            </section>
        </main>
    </div>

    @include('partials.coordinator-workspace-modals')

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
        function openAdminProfileModal() {
            const modal = document.getElementById('adminProfileModal');
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeAdminProfileModal() {
            const modal = document.getElementById('adminProfileModal');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        window.addEventListener('click', function (e) {
            const modal = document.getElementById('adminProfileModal');
            if (!modal) return;
            if (e.target === modal) {
                closeAdminProfileModal();
            }
        });
    </script>


    @include('partials.coordinator-workspace-script')


</body>
</html>
