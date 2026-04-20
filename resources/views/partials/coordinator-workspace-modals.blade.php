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
                            @php
                                $inventorySearchInputName = $inventorySearchInputName ?? 'search';
                            @endphp
                            @if(($coordinatorWorkspaceEmbedMode ?? 'coordinator') === 'admin')
                                <input type="hidden" name="workspace_context" value="admin">
                                <input type="hidden" name="{{ $inventorySearchInputName }}" value="{{ request($inventorySearchInputName) }}">
                            @endif
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
                            @if(($coordinatorWorkspaceEmbedMode ?? 'coordinator') === 'admin')
                                <input type="hidden" name="workspace_context" value="admin">
                                <input type="hidden" name="{{ $inventorySearchInputName }}" value="{{ request($inventorySearchInputName) }}">
                            @endif
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
                <div class="mb-5 grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div class="md:col-span-2">
                        <label class="block text-[12px] font-semibold text-gray-700 mb-1">Search (Gate Pass / Remarks)</label>
                        <input
                            id="trackerHistorySearch"
                            type="text"
                            placeholder="Search..."
                            class="w-full h-[40px] rounded-xl border border-gray-200 bg-white px-3 text-[13px] text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                        >
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-gray-700 mb-1">From</label>
                        <input
                            id="trackerHistoryFrom"
                            type="date"
                            class="w-full h-[40px] rounded-xl border border-gray-200 bg-white px-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                        >
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-gray-700 mb-1">To</label>
                        <input
                            id="trackerHistoryTo"
                            type="date"
                            class="w-full h-[40px] rounded-xl border border-gray-200 bg-white px-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#003b95]/20"
                        >
                    </div>
                </div>

                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <p class="text-[12px] text-gray-500">
                        Showing latest records first. Defaults to last 6 months unless you set a date range.
                    </p>
                    <div class="flex items-center gap-2">
                        <button
                            id="trackerHistoryApplyFiltersBtn"
                            type="button"
                            class="px-3 h-[34px] rounded-lg bg-[#003b95] hover:bg-[#002d73] text-white text-[12px] font-semibold transition"
                        >
                            Apply
                        </button>
                        <button
                            id="trackerHistoryResetFiltersBtn"
                            type="button"
                            class="px-3 h-[34px] rounded-lg border border-gray-300 bg-white text-[12px] font-semibold text-gray-800 hover:bg-gray-50 transition"
                        >
                            Reset
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <p class="text-[13px] font-semibold text-emerald-800">Incoming History (Date and Time)</p>
                            <span id="incomingHistoryMeta" class="text-[11px] text-emerald-700"></span>
                        </div>
                        <ul id="incomingHistoryList" class="space-y-2 text-[13px] text-[#14532d] max-h-[260px] overflow-y-auto pr-1"></ul>
                        <div class="mt-3 flex items-center justify-between gap-2">
                            <p id="incomingHistoryStatus" class="text-[12px] text-emerald-700"></p>
                            <button
                                id="incomingHistoryLoadMoreBtn"
                                type="button"
                                class="px-3 h-[34px] rounded-lg bg-white/80 hover:bg-white border border-emerald-200 text-[12px] font-semibold text-emerald-800 transition disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                Load more
                            </button>
                        </div>
                    </div>
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <p class="text-[13px] font-semibold text-amber-800">Outgoing History (Date and Time)</p>
                            <span id="outgoingHistoryMeta" class="text-[11px] text-amber-700"></span>
                        </div>
                        <ul id="outgoingHistoryList" class="space-y-2 text-[13px] text-[#78350f] max-h-[260px] overflow-y-auto pr-1"></ul>
                        <div class="mt-3 flex items-center justify-between gap-2">
                            <p id="outgoingHistoryStatus" class="text-[12px] text-amber-700"></p>
                            <button
                                id="outgoingHistoryLoadMoreBtn"
                                type="button"
                                class="px-3 h-[34px] rounded-lg bg-white/80 hover:bg-white border border-amber-200 text-[12px] font-semibold text-amber-800 transition disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                Load more
                            </button>
                        </div>
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
