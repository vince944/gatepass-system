    const gatepassEmployeePanel = document.getElementById('gatepassEmployeePanel');
    const navGatepassRequest = document.getElementById('navGatepassRequest');
    const navGatepassHistory = document.getElementById('navGatepassHistory');
    const newRequestBtn = document.getElementById('newRequestBtn');

    const navCoordinatorDashboard = document.getElementById('navCoordinatorDashboard');
    const navInventoryPortal = document.getElementById('navInventoryPortal');
    const navEmployeeManagement = document.getElementById('navEmployeeManagement');

    const sidebarNavAll = [navGatepassRequest, navGatepassHistory, navCoordinatorDashboard, navInventoryPortal, navEmployeeManagement];

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
    const itemsTrackerPaginationEl = document.getElementById('itemsTrackerPagination');

    const tbodyTracker = document.getElementById('tbodyTracker');
    const tbodyTotal = document.getElementById('tbodyTotal');
    const trackerHistoryModal = document.getElementById('trackerHistoryModal');
    const closeTrackerHistoryModal = document.getElementById('closeTrackerHistoryModal');
    const dismissTrackerHistoryModal = document.getElementById('dismissTrackerHistoryModal');
    const trackerHistoryTitle = document.getElementById('trackerHistoryTitle');
    const trackerHistorySubtitle = document.getElementById('trackerHistorySubtitle');
    const incomingHistoryList = document.getElementById('incomingHistoryList');
    const outgoingHistoryList = document.getElementById('outgoingHistoryList');
    const trackerHistoryGatepassModal = document.getElementById('trackerHistoryGatepassModal');
    const closeTrackerHistoryGatepassModalBtn = document.getElementById('closeTrackerHistoryGatepassModal');

    const employeeSelect = document.getElementById('employeeSelect');
    const employeeIdHiddenInput = document.getElementById('employeeIdHiddenInput');
    const employeeSelectDisplay = document.getElementById('employeeSelectDisplay');
    const openEmployeePickerModalBtn = document.getElementById('openEmployeePickerModal');
    const employeePickerModal = document.getElementById('employeePickerModal');
    const closeEmployeePickerModalBtn = document.getElementById('closeEmployeePickerModal');
    const employeePickerSearchInput = document.getElementById('employeePickerSearchInput');
    const employeePickerList = document.getElementById('employeePickerList');
    const employeePickerNoResults = document.getElementById('employeePickerNoResults');
    const searchInput = document.getElementById('inventoryPortalSearchInput');
    const employeeTypeField = document.getElementById('employeeTypeField');
    const employeeNumberField = document.getElementById('employeeNumberField');
    const employeeCenterField = document.getElementById('employeeCenterField');
    const inventoryPortalTableBody = document.getElementById('inventoryPortalTableBody');
    const inventoryPortalPaginationEl = document.getElementById('inventoryPortalPagination');
    const employeeManagementPaginationEl = document.getElementById('employeeManagementPagination');
    const accountabilityFilter = document.getElementById('accountabilityFilter');

    const INVENTORY_PORTAL_PAGE_SIZE = 5;
    const EMPLOYEE_MANAGEMENT_PAGE_SIZE = 5;
    const ITEMS_TRACKER_PAGE_SIZE = 10;
    const TOTAL_ITEMS_PAGE_SIZE = 10;
    let inventoryPortalCurrentPage = 1;
    let employeeManagementCurrentPage = 1;
    let itemsTrackerCurrentPage = 1;
    let totalItemsCurrentPage = 1;

    // Add Item Modal
    const openAddItemModal = document.getElementById('openAddItemModal');
    const addItemModal = document.getElementById('addItemModal');
    const closeAddItemModal = document.getElementById('closeAddItemModal');
    const cancelAddItemModal = document.getElementById('cancelAddItemModal');
    const currentDateField = document.getElementById('currentDateField');
    const addItemForm = document.getElementById('addItemForm');
    const addItemSubmitBtn = document.getElementById('addItemSubmitBtn');
    const addItemProgressWrap = document.getElementById('addItemProgressWrap');
    const addItemProgressBar = document.getElementById('addItemProgressBar');
    const addItemProgressPercent = document.getElementById('addItemProgressPercent');
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
        tracker: {{ collect($dashboardTrackerMovements ?? [])->count() }},
        total: {{ (int) ($totalCount ?? 0) }},
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

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = String(text || '');
        return div.innerHTML;
    }

    function getTrackerHistoryGatepassDetailUrl(gatepassNo) {
        if (!gatepassNo) {
            return '';
        }

        const template = (typeof adminGatepassShowUrlTemplate === 'string' && adminGatepassShowUrlTemplate.trim() !== '')
            ? adminGatepassShowUrlTemplate
            : '';

        if (!template) {
            return '';
        }

        return template.replace('__GP__', encodeURIComponent(String(gatepassNo)));
    }

    function closeTrackerHistoryGatepassDetailsModal() {
        if (!trackerHistoryGatepassModal) {
            return;
        }

        trackerHistoryGatepassModal.classList.add('hidden');
        trackerHistoryGatepassModal.classList.remove('flex');
    }

    function trackerHistorySetText(id, value) {
        const el = document.getElementById(id);
        if (!el) {
            return;
        }

        const text = String(value || '').trim();
        el.textContent = text !== '' ? text : '—';
    }

    async function openTrackerHistoryGatepassDetails(gatepassNo) {
        const detailsUrl = getTrackerHistoryGatepassDetailUrl(gatepassNo);
        if (!trackerHistoryGatepassModal || !detailsUrl) {
            return;
        }

        const loadingEl = document.getElementById('trackerHistoryGatepassLoading');
        const errorEl = document.getElementById('trackerHistoryGatepassError');
        const bodyEl = document.getElementById('trackerHistoryGatepassBody');
        const equipmentEl = document.getElementById('trackerHistoryGatepassEquipment');
        if (!loadingEl || !errorEl || !bodyEl || !equipmentEl) {
            return;
        }

        trackerHistorySetText('trackerHistoryGatepassNo', '—');
        trackerHistorySetText('trackerHistoryGatepassStatus', '—');
        trackerHistorySetText('trackerHistoryGatepassRequester', '—');
        trackerHistorySetText('trackerHistoryGatepassDate', '—');
        trackerHistorySetText('trackerHistoryGatepassPurpose', '—');
        trackerHistorySetText('trackerHistoryGatepassDestination', '—');
        equipmentEl.innerHTML = '';

        loadingEl.classList.remove('hidden');
        errorEl.classList.add('hidden');
        bodyEl.classList.add('hidden');

        trackerHistoryGatepassModal.classList.remove('hidden');
        trackerHistoryGatepassModal.classList.add('flex');

        try {
            const res = await fetch(detailsUrl, { headers: { Accept: 'application/json' } });
            const payload = await res.json().catch(() => ({}));
            if (!res.ok) {
                throw new Error(payload?.message || 'Failed to load gate pass details.');
            }

            const d = payload?.data || {};
            trackerHistorySetText('trackerHistoryGatepassNo', d.gatepass_no || gatepassNo);
            trackerHistorySetText('trackerHistoryGatepassStatus', d.status || '—');
            trackerHistorySetText('trackerHistoryGatepassRequester', d.requester_name || '—');
            trackerHistorySetText('trackerHistoryGatepassDate', d.request_date || '—');
            trackerHistorySetText('trackerHistoryGatepassPurpose', d.purpose || '—');
            trackerHistorySetText('trackerHistoryGatepassDestination', d.destination || '—');

            const items = Array.isArray(d.items) ? d.items : [];
            if (!items.length) {
                equipmentEl.innerHTML = '<li class="text-gray-500">No equipment listed.</li>';
            } else {
                equipmentEl.innerHTML = items.map(function (item) {
                    const propNo = String(item?.prop_no || '').trim();
                    const description = String(item?.description || '').trim();
                    const line = (propNo ? (propNo + ' - ') : '') + (description || 'N/A');
                    return '<li class="rounded-lg border border-gray-200 bg-[#f8fafc] px-3 py-2">' + escapeHtml(line) + '</li>';
                }).join('');
            }

            loadingEl.classList.add('hidden');
            errorEl.classList.add('hidden');
            bodyEl.classList.remove('hidden');
        } catch (e) {
            loadingEl.classList.add('hidden');
            bodyEl.classList.add('hidden');
            errorEl.classList.remove('hidden');
        }
    }

    function renderHistoryLogsList(container, logs, emptyLabel) {
        if (!container) {
            return;
        }

        container.innerHTML = '';
        if (!Array.isArray(logs) || logs.length === 0) {
            const li = createHistoryListItem(emptyLabel);
            container.appendChild(li);
            return;
        }

        logs.forEach((log) => {
            const dt = log?.log_datetime || '—';
            const gp = log?.gatepass_no ? `GP: ${log.gatepass_no}` : '';
            const remarks = log?.remarks ? `Remarks: ${log.remarks}` : '';
            const extra = [gp, remarks].filter(Boolean).join(' • ');
            const gatepassNo = String(log?.gatepass_no || '').trim();
            const detailsUrl = getTrackerHistoryGatepassDetailUrl(gatepassNo);

            const li = document.createElement('li');
            li.className = 'rounded-lg bg-white/80 border border-white px-3 py-2';
            if (detailsUrl) {
                li.classList.add('cursor-pointer', 'hover:bg-white', 'hover:border-[#003b95]/30', 'transition');
                li.innerHTML =
                    `<div class="font-medium">${escapeHtml(dt)}</div>` +
                    (extra ? `<div class="mt-1 text-[11px] text-gray-600">${escapeHtml(extra)}</div>` : '') +
                    '<div class="mt-1 text-[11px] font-semibold text-[#003b95]">Click for request details</div>';
                li.addEventListener('click', function () {
                    openTrackerHistoryGatepassDetails(gatepassNo);
                });
            } else {
                li.innerHTML =
                    `<div class="font-medium">${escapeHtml(dt)}</div>` +
                    (extra ? `<div class="mt-1 text-[11px] text-gray-600">${escapeHtml(extra)}</div>` : '');
            }

            container.appendChild(li);
        });
    }

    const trackerHistoryState = {
        inventoryId: '',
        filters: {
            q: '',
            from: '',
            to: '',
            per_page: 5,
        },
        incoming: { page: 1, hasMore: true, inFlight: false },
        outgoing: { page: 1, hasMore: true, inFlight: false },
    };

    function getTrackerHistoryFiltersFromUI() {
        const q = String(document.getElementById('trackerHistorySearch')?.value || '').trim();
        const from = String(document.getElementById('trackerHistoryFrom')?.value || '').trim();
        const to = String(document.getElementById('trackerHistoryTo')?.value || '').trim();

        return { q, from, to };
    }

    function resetTrackerHistoryPagination() {
        trackerHistoryState.incoming.page = 1;
        trackerHistoryState.outgoing.page = 1;
        trackerHistoryState.incoming.hasMore = true;
        trackerHistoryState.outgoing.hasMore = true;
        trackerHistoryState.incoming.inFlight = false;
        trackerHistoryState.outgoing.inFlight = false;
    }

    function setHistoryControlsDisabled(isDisabled) {
        const ids = [
            'trackerHistoryApplyFiltersBtn',
            'trackerHistoryResetFiltersBtn',
            'incomingHistoryLoadMoreBtn',
            'outgoingHistoryLoadMoreBtn',
        ];

        ids.forEach((id) => {
            const el = document.getElementById(id);
            if (el) el.disabled = Boolean(isDisabled);
        });
    }

    function setHistoryStatus(sectionKey, text) {
        const id = sectionKey === 'incoming' ? 'incomingHistoryStatus' : 'outgoingHistoryStatus';
        const el = document.getElementById(id);
        if (el) el.textContent = text || '';
    }

    function setHistoryMeta(sectionKey, meta) {
        const id = sectionKey === 'incoming' ? 'incomingHistoryMeta' : 'outgoingHistoryMeta';
        const el = document.getElementById(id);
        if (!el) return;

        const total = meta?.total ?? null;
        const shown = meta?.current_page && meta?.per_page
            ? Math.min((meta.current_page * meta.per_page), (meta.total ?? meta.current_page * meta.per_page))
            : null;

        if (total === null) {
            el.textContent = '';
            return;
        }

        el.textContent = shown !== null ? `${shown}/${total}` : `${total}`;
    }

    function buildHistoryUrl(inventoryId, params) {
        const base = "{{ route('admin.items.movement-history', ['inventoryId' => '__INV__']) }}".replace('__INV__', encodeURIComponent(inventoryId));
        const u = new URL(base, window.location.origin);
        Object.entries(params || {}).forEach(([k, v]) => {
            if (v === null || v === undefined) return;
            const s = String(v).trim();
            if (s === '') return;
            u.searchParams.set(k, s);
        });
        return u.toString();
    }

    function fetchHistoryPage(sectionKey, append) {
        const inventoryId = trackerHistoryState.inventoryId;
        if (!inventoryId) return;

        const sec = sectionKey === 'incoming' ? trackerHistoryState.incoming : trackerHistoryState.outgoing;
        const type = sectionKey === 'incoming' ? 'INCOMING' : 'OUTGOING';

        if (sec.inFlight) return;
        if (!sec.hasMore && append) return;

        sec.inFlight = true;
        const loadMoreBtnId = sectionKey === 'incoming' ? 'incomingHistoryLoadMoreBtn' : 'outgoingHistoryLoadMoreBtn';
        const loadMoreBtn = document.getElementById(loadMoreBtnId);
        if (loadMoreBtn) loadMoreBtn.disabled = true;

        setHistoryStatus(sectionKey, 'Loading...');

        const params = {
            type,
            page: sec.page,
            per_page: trackerHistoryState.filters.per_page,
            from: trackerHistoryState.filters.from || '',
            to: trackerHistoryState.filters.to || '',
            q: trackerHistoryState.filters.q || '',
        };

        const url = buildHistoryUrl(inventoryId, params);
        fetch(url, { headers: { Accept: 'application/json' } })
            .then(function (res) {
                return res.json().catch(() => ({})).then((payload) => ({ ok: res.ok, payload }));
            })
            .then(function (result) {
                const payload = result?.payload || {};
                if (!result?.ok) {
                    throw new Error(payload?.message || 'Failed to load history.');
                }

                const logs = Array.isArray(payload?.data?.logs) ? payload.data.logs : [];
                const meta = payload?.data?.meta || {};

                const listEl = sectionKey === 'incoming' ? incomingHistoryList : outgoingHistoryList;
                if (!listEl) return;

                if (!append) {
                    listEl.innerHTML = '';
                }

                if (!append && logs.length === 0) {
                    renderHistoryLogsList(listEl, [], sectionKey === 'incoming' ? 'No incoming history found.' : 'No outgoing history found.');
                } else {
                    // Append rows (already sorted latest-first server-side).
                    const temp = document.createElement('div');
                    // reuse renderer by building list items one-by-one
                    logs.forEach((log) => {
                        const dt = log?.log_datetime || '—';
                        const gp = log?.gatepass_no ? `GP: ${log.gatepass_no}` : '';
                        const remarks = log?.remarks ? `Remarks: ${log.remarks}` : '';
                        const extra = [gp, remarks].filter(Boolean).join(' • ');
                        const gatepassNo = String(log?.gatepass_no || '').trim();
                        const detailsUrl = getTrackerHistoryGatepassDetailUrl(gatepassNo);

                        const li = document.createElement('li');
                        li.className = 'rounded-lg bg-white/80 border border-white px-3 py-2';
                        if (detailsUrl) {
                            li.classList.add('cursor-pointer', 'hover:bg-white', 'hover:border-[#003b95]/30', 'transition');
                            li.innerHTML =
                                `<div class="font-medium">${escapeHtml(dt)}</div>` +
                                (extra ? `<div class="mt-1 text-[11px] text-gray-600">${escapeHtml(extra)}</div>` : '') +
                                '<div class="mt-1 text-[11px] font-semibold text-[#003b95]">Click for request details</div>';
                            li.addEventListener('click', function () {
                                openTrackerHistoryGatepassDetails(gatepassNo);
                            });
                        } else {
                            li.innerHTML =
                                `<div class="font-medium">${escapeHtml(dt)}</div>` +
                                (extra ? `<div class="mt-1 text-[11px] text-gray-600">${escapeHtml(extra)}</div>` : '');
                        }
                        listEl.appendChild(li);
                    });
                }

                const hasMore = Boolean(meta?.has_more);
                sec.hasMore = hasMore;
                setHistoryMeta(sectionKey, meta);

                if (!hasMore) {
                    setHistoryStatus(sectionKey, 'No more records.');
                } else {
                    setHistoryStatus(sectionKey, '');
                }

                if (hasMore) {
                    sec.page += 1;
                }
            })
            .catch(function (e) {
                setHistoryStatus(sectionKey, e?.message || 'Failed to load history.');
            })
            .finally(function () {
                sec.inFlight = false;
                if (loadMoreBtn) {
                    loadMoreBtn.disabled = !sec.hasMore;
                }
            });
    }

    function applyTrackerHistoryFilters() {
        trackerHistoryState.filters = {
            ...trackerHistoryState.filters,
            ...getTrackerHistoryFiltersFromUI(),
        };

        resetTrackerHistoryPagination();
        fetchHistoryPage('incoming', false);
        fetchHistoryPage('outgoing', false);
    }

    function showTrackerHistoryModalFromRow(row) {
        if (!row || !trackerHistoryModal || !trackerHistoryTitle || !trackerHistorySubtitle) {
            return;
        }

        const propNo = String(row.getAttribute('data-prop-no') || '').trim() || 'N/A';
        const description = String(row.getAttribute('data-description') || '').trim() || 'N/A';
        const incomingHistory = parseHistoryData(row, 'data-incoming-history');
        const outgoingHistory = parseHistoryData(row, 'data-outgoing-history');
        const inventoryId = String(row.getAttribute('data-inventory-id') || '').trim();

        trackerHistoryTitle.textContent = `Item Movement History - ${propNo}`;
        trackerHistorySubtitle.textContent = description;

        trackerHistoryState.inventoryId = inventoryId;

        // Render immediately using server-rendered snapshot, then load paginated history.
        renderHistoryList(incomingHistoryList, incomingHistory, 'No incoming history found.');
        renderHistoryList(outgoingHistoryList, outgoingHistory, 'No outgoing history found.');

        trackerHistoryModal.classList.remove('hidden');
        trackerHistoryModal.classList.add('flex');

        if (inventoryId === '') {
            return;
        }

        // Initialize default filters: keep inputs empty; server defaults to last 6 months.
        resetTrackerHistoryPagination();
        const incomingMoreBtn = document.getElementById('incomingHistoryLoadMoreBtn');
        const outgoingMoreBtn = document.getElementById('outgoingHistoryLoadMoreBtn');
        if (incomingMoreBtn) incomingMoreBtn.disabled = false;
        if (outgoingMoreBtn) outgoingMoreBtn.disabled = false;

        applyTrackerHistoryFilters();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const applyBtn = document.getElementById('trackerHistoryApplyFiltersBtn');
        const resetBtn = document.getElementById('trackerHistoryResetFiltersBtn');
        const incomingMoreBtn = document.getElementById('incomingHistoryLoadMoreBtn');
        const outgoingMoreBtn = document.getElementById('outgoingHistoryLoadMoreBtn');

        if (applyBtn) {
            applyBtn.addEventListener('click', function () {
                applyTrackerHistoryFilters();
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                const q = document.getElementById('trackerHistorySearch');
                const from = document.getElementById('trackerHistoryFrom');
                const to = document.getElementById('trackerHistoryTo');

                if (q) q.value = '';
                if (from) from.value = '';
                if (to) to.value = '';

                applyTrackerHistoryFilters();
            });
        }

        if (incomingMoreBtn) {
            incomingMoreBtn.addEventListener('click', function () {
                fetchHistoryPage('incoming', true);
            });
        }

        if (outgoingMoreBtn) {
            outgoingMoreBtn.addEventListener('click', function () {
                fetchHistoryPage('outgoing', true);
            });
        }
    });

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

    function renderItemsTrackerPaginationUI(container, currentPage, totalPages, onPageSelect) {
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

    function applyItemsTrackerFilter(requestedPage) {
        if (!tbodyTracker || !itemsTrackerSearchInput) {
            return;
        }

        if (typeof requestedPage !== 'number' || Number.isNaN(requestedPage)) {
            requestedPage = undefined;
        }

        const rows = Array.from(tbodyTracker.querySelectorAll('tr.tracker-item-row'));
        const totalCount = rows.length;

        if (totalCount === 0) {
            updateTrackerFilterCopy(0, 0, '');

            if (trackerSearchNoResults) {
                trackerSearchNoResults.classList.add('hidden');
            }

            if (itemsTrackerPaginationEl) {
                itemsTrackerPaginationEl.classList.add('hidden');
                itemsTrackerPaginationEl.innerHTML = '';
            }

            return;
        }

        const q = (itemsTrackerSearchInput.value || '').trim().toLowerCase();
        const filteredRows = rows.filter((row) => {
            const prop = (row.getAttribute('data-prop-no') || '').toLowerCase();
            const desc = (row.getAttribute('data-description') || '').toLowerCase();
            const owner = (row.getAttribute('data-owner-name') || '').toLowerCase();
            return q === '' || prop.includes(q) || desc.includes(q) || owner.includes(q);
        });

        const visible = filteredRows.length;
        const totalPages = Math.max(1, Math.ceil(visible / ITEMS_TRACKER_PAGE_SIZE));
        const nextPage = requestedPage !== undefined ? requestedPage : itemsTrackerCurrentPage;
        itemsTrackerCurrentPage = Math.max(1, Math.min(nextPage, totalPages));

        const start = (itemsTrackerCurrentPage - 1) * ITEMS_TRACKER_PAGE_SIZE;
        const rowsForPage = filteredRows.slice(start, start + ITEMS_TRACKER_PAGE_SIZE);
        const pageSet = new Set(rowsForPage);

        let rowNo = 0;
        rows.forEach((row) => {
            const show = pageSet.has(row);
            row.classList.toggle('hidden', !show);
            if (show) {
                rowNo += 1;
                const firstTd = row.querySelector('td:first-child');
                if (firstTd) {
                    firstTd.textContent = String(start + rowNo);
                }
            }
        });

        if (trackerSearchNoResults) {
            trackerSearchNoResults.classList.toggle('hidden', visible !== 0);
        }

        renderItemsTrackerPaginationUI(
            itemsTrackerPaginationEl,
            itemsTrackerCurrentPage,
            totalPages,
            (page) => applyItemsTrackerFilter(page)
        );

        updateTrackerFilterCopy(visible, totalCount, q);
    }

    function applyTotalItemsPagination(requestedPage) {
        if (!tbodyTotal) {
            return;
        }

        const rows = Array.from(tbodyTotal.querySelectorAll('tr'));
        const totalCount = rows.length;
        if (totalCount === 0) {
            if (itemsTrackerPaginationEl) {
                itemsTrackerPaginationEl.classList.add('hidden');
                itemsTrackerPaginationEl.innerHTML = '';
            }

            return;
        }

        const totalPages = Math.max(1, Math.ceil(totalCount / TOTAL_ITEMS_PAGE_SIZE));
        const nextPage = requestedPage !== undefined ? requestedPage : totalItemsCurrentPage;
        totalItemsCurrentPage = Math.max(1, Math.min(nextPage, totalPages));

        const start = (totalItemsCurrentPage - 1) * TOTAL_ITEMS_PAGE_SIZE;
        const rowsForPage = rows.slice(start, start + TOTAL_ITEMS_PAGE_SIZE);
        const pageSet = new Set(rowsForPage);

        let rowNo = 0;
        rows.forEach((row) => {
            const show = pageSet.has(row);
            row.classList.toggle('hidden', !show);
            if (show) {
                rowNo += 1;
                const firstTd = row.querySelector('td:first-child');
                if (firstTd) {
                    firstTd.textContent = String(start + rowNo);
                }
            }
        });

        renderItemsTrackerPaginationUI(
            itemsTrackerPaginationEl,
            totalItemsCurrentPage,
            totalPages,
            (page) => applyTotalItemsPagination(page)
        );
    }

    function showCoordinatorGatepassRequestSection() {
        if (gatepassEmployeePanel) {
            gatepassEmployeePanel.classList.remove('hidden');
        }

        dashboardSection.classList.add('hidden');
        inventoryPortalSection.classList.add('hidden');
        if (employeeManagementSection) employeeManagementSection.classList.add('hidden');

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
        if (employeeManagementSection) employeeManagementSection.classList.add('hidden');

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

    function cwsShowItemsTrackerHome() {
        if (gatepassEmployeePanel) {
            gatepassEmployeePanel.classList.add('hidden');
        }

        dashboardSection.classList.remove('hidden');
        inventoryPortalSection.classList.add('hidden');
        if (employeeManagementSection) employeeManagementSection.classList.add('hidden');

        pageTitle.textContent = 'Items Tracker';
        pageSubtitle.textContent = 'List of Inventory';

        if (newRequestBtn) {
            newRequestBtn.classList.add('hidden');
        }

        if (openAddItemModal) {
            openAddItemModal.classList.add('hidden');
        }

        activateSidebar(navCoordinatorDashboard, sidebarNavAll);
        showTracker();
        if (window.location.hash !== '#tracker') {
            window.history.replaceState(null, '', '#tracker');
        }
    }

    function cwsShowInventoryPortal() {
        if (gatepassEmployeePanel) {
            gatepassEmployeePanel.classList.add('hidden');
        }

        dashboardSection.classList.add('hidden');
        inventoryPortalSection.classList.remove('hidden');
        if (employeeManagementSection) employeeManagementSection.classList.add('hidden');

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
        if (employeeManagementSection) employeeManagementSection.classList.remove('hidden');

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

        itemsTrackerCurrentPage = 1;

        if (trackerSearchNoResults) {
            trackerSearchNoResults.classList.add('hidden');
        }

        if (dashboardCounts.tracker > 0) {
            emptyState.classList.add('hidden');
        } else {
            showEmptyState('No incoming/outgoing movement records available yet.');
        }

        applyItemsTrackerFilter(1);
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

        totalItemsCurrentPage = 1;

        if (trackerSearchNoResults) {
            trackerSearchNoResults.classList.add('hidden');
        }

        applyTotalItemsPagination(1);

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
            params.append(CWS_SEARCH_PARAM, searchInput.value);
        }

        try {
            const response = await fetch(`${CWS_JSON_URL}?${params.toString()}`, {
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
                                ${CWS_EMBED_ADMIN ? `<input type="hidden" name="workspace_context" value="admin"><input type="hidden" name="${CWS_SEARCH_PARAM}" value="${(searchInput && searchInput.value) ? String(searchInput.value).replace(/"/g, '&quot;') : ''}">` : ''}
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
        if (addItemForm) {
            const currentEmployeeId = String(employeeIdHiddenInput?.value || employeeSelect?.value || '').trim();
            const formEmployeeIdInput = addItemForm.querySelector('input[name="employee_id"]');
            if (formEmployeeIdInput && currentEmployeeId !== '') {
                formEmployeeIdInput.value = currentEmployeeId;
            }
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
        resetAddItemProgress();

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
    let addItemProgressTimer = null;
    let addItemProgressValue = 0;

    function resetAddItemProgress() {
        if (addItemProgressTimer) {
            clearInterval(addItemProgressTimer);
            addItemProgressTimer = null;
        }
        addItemProgressValue = 0;
        if (addItemProgressBar) {
            addItemProgressBar.style.width = '0%';
        }
        if (addItemProgressPercent) {
            addItemProgressPercent.textContent = '0%';
        }
        if (addItemProgressWrap) {
            addItemProgressWrap.classList.add('hidden');
        }
        if (addItemSubmitBtn) {
            addItemSubmitBtn.disabled = false;
            addItemSubmitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
        }
    }

    function startAddItemProgress() {
        resetAddItemProgress();
        if (addItemProgressWrap) {
            addItemProgressWrap.classList.remove('hidden');
        }
        if (addItemSubmitBtn) {
            addItemSubmitBtn.disabled = true;
            addItemSubmitBtn.classList.add('opacity-70', 'cursor-not-allowed');
        }

        addItemProgressValue = 8;
        if (addItemProgressBar) {
            addItemProgressBar.style.width = addItemProgressValue + '%';
        }
        if (addItemProgressPercent) {
            addItemProgressPercent.textContent = addItemProgressValue + '%';
        }

        addItemProgressTimer = setInterval(function () {
            if (addItemProgressValue >= 90) {
                return;
            }
            const step = addItemProgressValue < 50 ? 8 : 3;
            addItemProgressValue = Math.min(90, addItemProgressValue + step);
            if (addItemProgressBar) {
                addItemProgressBar.style.width = addItemProgressValue + '%';
            }
            if (addItemProgressPercent) {
                addItemProgressPercent.textContent = addItemProgressValue + '%';
            }
        }, 180);
    }

    async function finishAddItemProgressSuccess() {
        if (addItemProgressTimer) {
            clearInterval(addItemProgressTimer);
            addItemProgressTimer = null;
        }
        addItemProgressValue = 100;
        if (addItemProgressBar) {
            addItemProgressBar.style.width = '100%';
        }
        if (addItemProgressPercent) {
            addItemProgressPercent.textContent = '100%';
        }
        await new Promise((resolve) => setTimeout(resolve, 220));
    }

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
        if (addItemSubmitBtn?.disabled) {
            return;
        }

        const resolvedEmployeeId = String(
            employeeIdHiddenInput?.value
            || employeeSelect?.value
            || addItemForm.querySelector('input[name="employee_id"]')?.value
            || ''
        ).trim();

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
            isBlank(accountability) ||
            isBlank(resolvedEmployeeId)
        ) {
            openModal();
            if (isBlank(resolvedEmployeeId)) {
                showFormErrorToast('Please select an employee before adding equipment.');
            } else {
                showFormErrorToast('Please complete all required fields before adding equipment.');
            }
            resetAddItemProgress();
            return;
        }

        try {
            startAddItemProgress();
            const isDuplicate = await fetchAddItemDuplicateStatus({ forLiveCheck: false });
            if (isDuplicate) {
                openModal({ clearDuplicateState: false });
                showFormErrorToast('This item already exists.');
                resetAddItemProgress();
                return;
            }

            const formData = new FormData(addItemForm);
            formData.set('employee_id', resolvedEmployeeId);

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
                } else {
                    showFormErrorToast(payload?.message || 'Failed to add equipment. Please try again.');
                }
                resetAddItemProgress();
                return;
            }

            await finishAddItemProgressSuccess();
            addItemForm.reset();
            resetAddItemDuplicateState();
            closeModal();
            await loadEmployeeInventory();
            showItemSuccessToast('Equipment added successfully');
        } catch (error) {
            showFormErrorToast('Network error while adding equipment. Please try again.');
            resetAddItemProgress();
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

    if (navCoordinatorDashboard) {
        navCoordinatorDashboard.addEventListener('click', cwsShowItemsTrackerHome);
    }
    if (navInventoryPortal) {
        navInventoryPortal.addEventListener('click', cwsShowInventoryPortal);
    }
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
        itemsTrackerSearchInput.addEventListener('input', () => applyItemsTrackerFilter(1));
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

    if (closeTrackerHistoryGatepassModalBtn) {
        closeTrackerHistoryGatepassModalBtn.addEventListener('click', closeTrackerHistoryGatepassDetailsModal);
    }

    if (trackerHistoryGatepassModal) {
        trackerHistoryGatepassModal.addEventListener('click', function (event) {
            if (event.target === trackerHistoryGatepassModal) {
                closeTrackerHistoryGatepassDetailsModal();
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

    function syncEmployeePickerDisplayFromSelect() {
        if (!employeeSelect) {
            return;
        }

        const selectedOption = employeeSelect.options[employeeSelect.selectedIndex] || null;
        const selectedName = selectedOption ? String(selectedOption.textContent || '').trim() : '';

        if (employeeSelectDisplay) {
            employeeSelectDisplay.value = selectedName;
        }

        if (employeeIdHiddenInput) {
            employeeIdHiddenInput.value = employeeSelect.value || '';
        }

        if (employeePickerList) {
            const pickerItems = employeePickerList.querySelectorAll('.employee-picker-item');
            pickerItems.forEach((item) => {
                const isSelected = String(item.getAttribute('data-employee-id') || '') === String(employeeSelect.value || '');
                item.classList.toggle('bg-[#003b95]/10', isSelected);
                item.classList.toggle('font-semibold', isSelected);
            });
        }
    }

    function closeEmployeePickerModal() {
        if (!employeePickerModal) {
            return;
        }
        employeePickerModal.classList.add('hidden');
        employeePickerModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    function filterEmployeePickerItems() {
        if (!employeePickerList) {
            return;
        }

        const query = String(employeePickerSearchInput?.value || '').trim().toLowerCase();
        const groups = employeePickerList.querySelectorAll('.employee-picker-group');
        let visibleItemCount = 0;

        groups.forEach((group) => {
            const items = group.querySelectorAll('.employee-picker-item');
            let groupVisibleCount = 0;

            items.forEach((item) => {
                const name = String(item.getAttribute('data-employee-name') || '').toLowerCase();
                const visible = query === '' || name.includes(query);
                item.classList.toggle('hidden', !visible);
                if (visible) {
                    groupVisibleCount += 1;
                    visibleItemCount += 1;
                }
            });

            group.classList.toggle('hidden', groupVisibleCount === 0);
        });

        if (employeePickerNoResults) {
            employeePickerNoResults.classList.toggle('hidden', visibleItemCount !== 0);
        }
    }

    function openEmployeePickerModal() {
        if (!employeePickerModal) {
            return;
        }

        employeePickerModal.classList.remove('hidden');
        employeePickerModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');

        if (employeePickerSearchInput) {
            employeePickerSearchInput.value = '';
        }
        filterEmployeePickerItems();
        syncEmployeePickerDisplayFromSelect();

        window.setTimeout(() => {
            employeePickerSearchInput?.focus();
        }, 10);
    }

    if (openEmployeePickerModalBtn) {
        openEmployeePickerModalBtn.addEventListener('click', openEmployeePickerModal);
    }

    if (closeEmployeePickerModalBtn) {
        closeEmployeePickerModalBtn.addEventListener('click', closeEmployeePickerModal);
    }

    if (employeePickerModal) {
        employeePickerModal.addEventListener('click', function (event) {
            if (event.target === employeePickerModal) {
                closeEmployeePickerModal();
            }
        });
    }

    if (employeePickerSearchInput) {
        employeePickerSearchInput.addEventListener('input', filterEmployeePickerItems);
    }

    if (employeePickerList) {
        employeePickerList.addEventListener('click', function (event) {
            const target = event.target.closest('.employee-picker-item');
            if (!target || !employeeSelect) {
                return;
            }

            const employeeId = String(target.getAttribute('data-employee-id') || '');
            const existingOption = employeeSelect.querySelector(`option[value="${employeeId}"]`);
            if (!existingOption) {
                return;
            }

            employeeSelect.value = employeeId;
            employeeSelect.dispatchEvent(new Event('change', { bubbles: true }));
            closeEmployeePickerModal();
        });
    }

    if (employeeSelect) {
        employeeSelect.addEventListener('change', function () {
            syncEmployeePickerDisplayFromSelect();
            loadEmployeeInventory();
        });
        syncEmployeePickerDisplayFromSelect();
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
    let deleteModalCloseTimer = null;

    function openDeleteModal(form, type = 'equipment') {
        pendingDeleteForm = form;
        pendingDeleteType = type;
        if (!deleteConfirmModal || !deleteConfirmCard) {
            return;
        }
        if (deleteModalCloseTimer) {
            clearTimeout(deleteModalCloseTimer);
            deleteModalCloseTimer = null;
        }

        if (confirmDeleteBtn) {
            confirmDeleteBtn.classList.remove('hidden');
            confirmDeleteBtn.textContent = 'Delete';
        }
        if (cancelDeleteBtn) {
            cancelDeleteBtn.textContent = 'Cancel';
        }

        if (deleteConfirmTitle && deleteConfirmMessage) {
            if (type === 'employee') {
                deleteConfirmTitle.textContent = 'Delete employee?';
                deleteConfirmMessage.textContent = 'This will permanently remove the employee record and delete their user account so they can no longer sign in.';
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

    function showDeleteCautionModal(message) {
        if (!deleteConfirmModal || !deleteConfirmCard) {
            window.alert(message);
            return;
        }
        if (deleteModalCloseTimer) {
            clearTimeout(deleteModalCloseTimer);
            deleteModalCloseTimer = null;
        }

        if (deleteConfirmTitle) {
            deleteConfirmTitle.textContent = 'Cannot delete equipment';
        }
        if (deleteConfirmMessage) {
            deleteConfirmMessage.textContent = message;
        }
        if (confirmDeleteBtn) {
            confirmDeleteBtn.classList.add('hidden');
        }
        if (cancelDeleteBtn) {
            cancelDeleteBtn.textContent = 'OK';
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
        if (deleteModalCloseTimer) {
            clearTimeout(deleteModalCloseTimer);
            deleteModalCloseTimer = null;
        }

        deleteConfirmCard.classList.add('opacity-0', 'scale-95');
        deleteConfirmCard.classList.remove('opacity-100', 'scale-100');

        deleteModalCloseTimer = setTimeout(() => {
            deleteConfirmModal.classList.add('hidden');
            deleteConfirmModal.classList.remove('flex');
            deleteModalCloseTimer = null;
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
                showDeleteCautionModal(message);
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

    if (employeeManagementSection) {
        employeeManagementSection.addEventListener('submit', function (event) {
            const form = event.target;
            if (!form || !form.classList || !form.classList.contains('employee-delete-form')) {
                return;
            }
            event.preventDefault();
            openDeleteModal(form, 'employee');
        });
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

    if (typeof CWS_EMBED_ADMIN !== 'undefined' && CWS_EMBED_ADMIN) {
        const adminGatepassOverviewSection = document.getElementById('adminGatepassOverviewSection');
        const itemTrackingSection = document.getElementById('itemTrackingSection');
        const reportsSection = document.getElementById('reportsSection');
        const origCwsItems = cwsShowItemsTrackerHome;
        const origCwsInv = cwsShowInventoryPortal;
        cwsShowItemsTrackerHome = function () {
            if (adminGatepassOverviewSection) {
                adminGatepassOverviewSection.classList.add('hidden');
            }
            if (itemTrackingSection) {
                itemTrackingSection.classList.add('hidden');
            }
            if (reportsSection) {
                reportsSection.classList.add('hidden');
            }
            origCwsItems();
        };
        cwsShowInventoryPortal = function () {
            if (adminGatepassOverviewSection) {
                adminGatepassOverviewSection.classList.add('hidden');
            }
            if (itemTrackingSection) {
                itemTrackingSection.classList.add('hidden');
            }
            if (reportsSection) {
                reportsSection.classList.add('hidden');
            }
            origCwsInv();
        };
        window.cwsShowItemsTrackerHome = cwsShowItemsTrackerHome;
        window.cwsShowInventoryPortal = cwsShowInventoryPortal;
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof CWS_EMBED_ADMIN !== 'undefined' && CWS_EMBED_ADMIN) {
            const params = new URLSearchParams(window.location.search);
            const cw = params.get('cw');
            if (cw === 'inventory') {
                cwsShowInventoryPortal();
            } else if (cw === 'items') {
                cwsShowItemsTrackerHome();
            }
        } else if (window.location.hash === '#gatepass-history') {
            showCoordinatorGatepassHistorySection();
        } else if (window.location.hash === '#gatepass-request') {
            showCoordinatorGatepassRequestSection();
        } else if (window.location.hash === '#tracker') {
            cwsShowItemsTrackerHome();
        } else if (window.location.hash === '#employee-management') {
            showEmployeeManagementSection();
        } else if (window.location.hash === '#inventory-portal') {
            cwsShowInventoryPortal();
        } else {
            cwsShowItemsTrackerHome();
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
