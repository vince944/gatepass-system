                @php
                    $cwsEmbedMode = ($coordinatorWorkspaceEmbedMode ?? 'coordinator') === 'admin';
                    $inventoryPortalFormAction = $inventoryPortalFormAction ?? route('admin.coordinator.index');
                    $inventorySearchInputName = $inventorySearchInputName ?? 'search';
                @endphp
                <!-- DASHBOARD SECTION -->
                <div id="dashboardSection" @class(['hidden' => $cwsEmbedMode])>
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
                                    placeholder="Search by owner, property number, or description..."
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
                                                data-inventory-id="{{ e((string) ($movement['inventory_id'] ?? '')) }}"
                                                data-prop-no="{{ e($movement['prop_no'] ?? '') }}"
                                                data-description="{{ e($movement['description'] ?? '') }}"
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
                                id="itemsTrackerPagination"
                                class="hidden flex flex-wrap items-center justify-end gap-2 border-b border-gray-200 px-6 py-4"
                                aria-label="Items tracker pagination"
                            ></div>

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

                            <form method="GET" action="{{ $inventoryPortalFormAction }}">
                                @php
                                    $inventoryEmployeeList = collect($employees ?? []);
                                    $inventorySortedEmployees = $inventoryEmployeeList
                                        ->sortBy(function ($emp) {
                                            return mb_strtolower(trim((string) ($emp->employee_name ?? '')));
                                        })
                                        ->values();
                                    $inventoryEmployeesByLetter = $inventorySortedEmployees->groupBy(function ($emp) {
                                        $name = trim((string) ($emp->employee_name ?? ''));
                                        if ($name === '') {
                                            return '#';
                                        }

                                        $firstChar = mb_substr($name, 0, 1);

                                        return \Illuminate\Support\Str::upper($firstChar);
                                    });
                                    $selectedEmployeeName = trim((string) ($selectedEmployee?->employee_name ?? ''));
                                @endphp
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-6">
                                    <div>
                                        <label class="block text-[14px] font-semibold text-black mb-2" for="employeeSelectDisplay">Employee Name</label>
                                        <button
                                            id="openEmployeePickerModal"
                                            type="button"
                                            class="group flex h-[42px] w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 text-left text-[14px] text-black transition hover:border-[#003b95]/40 focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                            aria-haspopup="dialog"
                                            aria-controls="employeePickerModal"
                                        >
                                            <input
                                                id="employeeSelectDisplay"
                                                type="text"
                                                value="{{ $selectedEmployeeName }}"
                                                placeholder="Select employee"
                                                class="w-full cursor-pointer bg-transparent pr-3 text-[14px] text-black placeholder:text-[#98a2b3] focus:outline-none"
                                                readonly
                                            >
                                            <i class="fa-solid fa-chevron-down text-[12px] text-[#667085] transition group-hover:text-[#003b95]"></i>
                                        </button>
                                        <select
                                            id="employeeSelect"
                                            class="hidden"
                                            aria-hidden="true"
                                            tabindex="-1"
                                        >
                                            @foreach($inventorySortedEmployees as $employee)
                                                <option value="{{ $employee->employee_id }}" @selected($employee->employee_id === $selectedEmployeeId)>
                                                    {{ $employee->employee_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="employeeIdHiddenInput" name="employee_id" value="{{ $selectedEmployeeId }}">
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

                    <div id="employeePickerModal" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/45 px-4 py-6">
                        <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl">
                            <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                                <h4 class="text-[18px] font-semibold text-[#111827]">Select Employee</h4>
                                <button id="closeEmployeePickerModal" type="button" class="text-[20px] text-[#98a2b3] transition hover:text-black" aria-label="Close employee picker">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div class="px-5 py-4">
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[#667085]">
                                        <i class="fa-solid fa-magnifying-glass text-[14px]"></i>
                                    </span>
                                    <input
                                        id="employeePickerSearchInput"
                                        type="text"
                                        placeholder="Search employee name..."
                                        autocomplete="off"
                                        class="h-[42px] w-full rounded-xl border border-gray-300 bg-white pl-10 pr-4 text-[14px] text-black placeholder:text-[#98a2b3] focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                                    >
                                </div>
                            </div>
                            <div id="employeePickerList" class="max-h-[360px] overflow-y-auto border-t border-gray-100 px-2 py-2">
                                @forelse($inventoryEmployeesByLetter as $letter => $letterEmployees)
                                    <div class="employee-picker-group py-1" data-letter-group="{{ $letter }}">
                                        <div class="px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-[#003b95]/80">{{ $letter }}</div>
                                        @foreach($letterEmployees as $employee)
                                            <button
                                                type="button"
                                                class="employee-picker-item flex w-full items-center rounded-lg px-3 py-2.5 text-left text-[14px] text-[#111827] transition hover:bg-[#003b95]/8"
                                                data-employee-id="{{ $employee->employee_id }}"
                                                data-employee-name="{{ $employee->employee_name }}"
                                            >
                                                {{ $employee->employee_name }}
                                            </button>
                                        @endforeach
                                    </div>
                                @empty
                                    <p class="px-3 py-6 text-center text-[14px] text-[#98a2b3]">No employees available.</p>
                                @endforelse
                                <p id="employeePickerNoResults" class="hidden px-3 py-6 text-center text-[14px] text-[#98a2b3]">No matching employee found.</p>
                            </div>
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
                                            id="inventoryPortalSearchInput"
                                            type="text"
                                            name="{{ $inventorySearchInputName }}"
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
                                                        @if($cwsEmbedMode)
                                                            <input type="hidden" name="workspace_context" value="admin">
                                                            <input type="hidden" name="{{ $inventorySearchInputName }}" value="{{ request($inventorySearchInputName) }}">
                                                        @endif
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

