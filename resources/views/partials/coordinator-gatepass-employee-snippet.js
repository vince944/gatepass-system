(function () {
const coordinatorGpNavRequest = document.getElementById('navGatepassRequest');
        const coordinatorGpNavHistory = document.getElementById('navGatepassHistory');

        const coordinatorGpDashboardSection = document.getElementById('gatepassEmployeeDashboardSection');
        const coordinatorGpHistorySection = document.getElementById('gatepassEmployeeHistorySection');

        const pageTitle = document.getElementById('pageTitle');
        const newRequestBtn = document.getElementById('newRequestBtn');

        const employeeGatepassForm = document.getElementById('employeeGatepassForm');
        const employeeEquipmentSelect = document.getElementById('employeeEquipmentSelect');
        const employeeAddEquipmentBtn = document.getElementById('employeeAddEquipmentBtn');
        const employeeSelectedEquipmentBody = document.getElementById('employeeSelectedEquipmentBody');
        const employeeNoEquipmentRow = document.getElementById('employeeNoEquipmentRow');
        const employeeGatepassModalTitle = document.querySelector('#requestModal h2');
        const employeeGatepassSubmitBtn = document.querySelector('#employeeGatepassForm button[type="submit"]');
        const employeePurposeInput = document.getElementById('employeePurpose');
        const employeeRemarksInput = document.getElementById('employeeRemarks');
        const employeeDestinationInput = document.getElementById('employeeDestination');
        const employeeGatepassNoInput = document.getElementById('employeeGatepassNo');
        const employeeResubmitGatepassNoInput = document.getElementById('employeeResubmitGatepassNo');
        const employeeRequestDateInput = document.querySelector('#employeeGatepassForm input[type="date"]');
        const employeeResubmitCache = new Map();
        const EMPLOYEE_DASHBOARD_PAGE_SIZE = 5;
        const EMPLOYEE_DASHBOARD_MAX_VISIBLE_PAGES = 3;
        let employeeDashboardRows = [];
        let employeeDashboardCurrentPage = 1;
        const EMPLOYEE_HISTORY_PAGE_SIZE = 5;
        const EMPLOYEE_HISTORY_MAX_VISIBLE_PAGES = 3;
        let employeeHistoryRows = [];
        let employeeHistoryCurrentPage = 1;

        /** Background refresh so admin status or data changes appear without a full page reload. */
        const EMPLOYEE_DASHBOARD_POLL_MS = 3000;
        let __employeeDashboardPollTimer = null;
        let __employeeDashboardPollInFlight = false;
        window.__employeeOpenRequestDetailsGatepassNo = null;

        function employeeEmbedGatepassUiActive() {
            const p = document.getElementById('gatepassEmployeePanel');
            if (!p) {
                return true;
            }

            return !p.classList.contains('hidden');
        }

        function employeeIsHistorySectionVisible() {
            return coordinatorGpHistorySection && !coordinatorGpHistorySection.classList.contains('hidden');
        }

        async function employeeRefreshForAdminUpdates() {
            if (document.visibilityState === 'hidden' || __employeeDashboardPollInFlight) {
                return;
            }

            if (!employeeEmbedGatepassUiActive()) {
                return;
            }

            __employeeDashboardPollInFlight = true;

            const detailsModal = document.getElementById('requestDetailsModal');
            const detailsOpen = detailsModal && !detailsModal.classList.contains('hidden');
            const openGp = window.__employeeOpenRequestDetailsGatepassNo
                ? String(window.__employeeOpenRequestDetailsGatepassNo).trim()
                : '';

            try {
                if (employeeIsHistorySectionVisible()) {
                    await employeeLoadRequestHistory({ silent: true, preservePage: true });
                } else {
                    await employeeLoadDashboard(window.__employeeDashboardActiveStatus || 'All', {
                        silent: true,
                        preservePage: true,
                    });
                }

                if (detailsOpen && openGp !== '') {
                    await employeeLoadRequestDetails(openGp, { silent: true });
                }
            } finally {
                __employeeDashboardPollInFlight = false;
            }
        }

        function employeeStartDashboardPolling() {
            if (__employeeDashboardPollTimer !== null) {
                return;
            }

            __employeeDashboardPollTimer = window.setInterval(function () {
                employeeRefreshForAdminUpdates();
            }, EMPLOYEE_DASHBOARD_POLL_MS);
        }

        function activateDashboardButton() {
            if (!coordinatorGpNavRequest || !coordinatorGpNavHistory) {
                return;
            }
            coordinatorGpNavRequest.classList.add('bg-[#47698f]', 'text-white');
            coordinatorGpNavRequest.classList.remove('text-white/90', 'hover:bg-white/10');

            coordinatorGpNavHistory.classList.remove('bg-[#47698f]', 'text-white');
            coordinatorGpNavHistory.classList.add('text-white/90', 'hover:bg-white/10');
        }

        function activateHistoryButton() {
            if (!coordinatorGpNavRequest || !coordinatorGpNavHistory) {
                return;
            }
            coordinatorGpNavHistory.classList.add('bg-[#47698f]', 'text-white');
            coordinatorGpNavHistory.classList.remove('text-white/90', 'hover:bg-white/10');

            coordinatorGpNavRequest.classList.remove('bg-[#47698f]', 'text-white');
            coordinatorGpNavRequest.classList.add('text-white/90', 'hover:bg-white/10');
        }

        function coordinatorGpShowMyRequestsPanel() {
            if (!coordinatorGpDashboardSection || !coordinatorGpHistorySection || !pageTitle || !newRequestBtn) {
                return;
            }

            coordinatorGpDashboardSection.classList.remove('hidden');
            coordinatorGpHistorySection.classList.add('hidden');

            pageTitle.textContent = "Dashboard";
            newRequestBtn.classList.remove('hidden');

            activateDashboardButton();

            employeeLoadDashboard(window.__employeeDashboardActiveStatus || 'All', {
                silent: true,
                preservePage: true,
            });
        }

        function coordinatorGpShowHistoryPanel() {
            if (!coordinatorGpDashboardSection || !coordinatorGpHistorySection || !pageTitle || !newRequestBtn) {
                return;
            }

            coordinatorGpDashboardSection.classList.add('hidden');
            coordinatorGpHistorySection.classList.remove('hidden');

            pageTitle.textContent = "Request History";
            newRequestBtn.classList.add('hidden');

            activateHistoryButton();

            employeeLoadRequestHistory();
        }
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
                            coordinatorGpShowMyRequestsPanel();
                        } else if (kind === 'history') {
                            coordinatorGpShowHistoryPanel();
                        }
                        closeMobileSidebar();
                    });
                });
            }
        });


        function openRequestModal(options = {}) {
            const modal = document.getElementById('requestModal');
            const shouldReset = options.reset !== false;
            const form = document.getElementById('employeeGatepassForm');

            if (shouldReset && form) {
                form.reset();
                form.dataset.mode = 'new';
                form.dataset.editGatepassNo = '';
                if (employeeGatepassModalTitle) {
                    employeeGatepassModalTitle.textContent = 'New Gate Pass Request';
                }
                if (employeeGatepassSubmitBtn) {
                    employeeGatepassSubmitBtn.textContent = 'Submit Request';
                }
                if (employeeGatepassNoInput) {
                    employeeGatepassNoInput.value = '';
                }
                if (employeeResubmitGatepassNoInput) {
                    employeeResubmitGatepassNoInput.value = '';
                }
                if (employeeRequestDateInput) {
                    employeeRequestDateInput.value = "{{ date('Y-m-d') }}";
                }
                employeeResetEquipmentTable();
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.classList.add('overflow-hidden');
        }

        function closeRequestModal() {

            const modal = document.getElementById('requestModal');
            if (!modal) {
                return;
            }

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

        function employeeFillSelectedEquipment(equipments) {
            if (!employeeSelectedEquipmentBody || !employeeNoEquipmentRow) {
                return;
            }

            employeeSelectedEquipmentBody.innerHTML = '';
            const rows = Array.isArray(equipments) ? equipments : [];

            if (rows.length === 0) {
                employeeSelectedEquipmentBody.appendChild(employeeNoEquipmentRow);
                return;
            }

            rows.forEach(function (eq, idx) {
                const tr = document.createElement('tr');
                const propNo = String(eq?.prop_no || '').trim();
                const description = String(eq?.description || '').trim();
                const inventoryId = String(eq?.inventory_id || '').trim();

                tr.innerHTML = ''
                    + '<td class="px-5 py-3 align-top text-[14px] text-gray-700">' + (idx + 1) + '</td>'
                    + '<td class="px-5 py-3 align-top text-[14px] text-gray-800 break-words">' + escapeHtml(propNo || '—') + '</td>'
                    + '<td class="px-5 py-3 align-top text-[14px] text-gray-800 break-words">' + escapeHtml(description || '—') + '</td>'
                    + '<td class="px-5 py-3 align-top sm:text-right">'
                    + '  <button type="button" class="inline-flex whitespace-nowrap text-red-500 text-[13px] sm:text-[14px] font-semibold" onclick="employeeRemoveSelectedEquipment(this)">Remove</button>'
                    + (inventoryId ? ('  <input type="hidden" name="inventory_ids[]" value="' + escapeHtml(inventoryId) + '">') : '')
                    + '</td>';

                employeeSelectedEquipmentBody.appendChild(tr);
            });
        }

        function openEditResubmitModal(row) {
            const gatepassNo = String(row?.gatepass_no || '').trim();
            const draft = employeeResubmitCache.get(gatepassNo) || {};
            const purpose = String(draft.purpose ?? row?.purpose ?? '').trim();
            const remarks = String(draft.remarks ?? row?.remarks ?? '').trim();
            const destination = String(draft.destination ?? row?.destination ?? '').trim();
            const requestDate = String(draft.request_date ?? row?.request_date ?? '').trim();
            const equipments = Array.isArray(draft.equipments) && draft.equipments.length
                ? draft.equipments
                : (Array.isArray(row?.equipments) ? row.equipments : []);
            const form = document.getElementById('employeeGatepassForm');

            if (form) {
                form.dataset.mode = 'resubmit';
                form.dataset.editGatepassNo = gatepassNo;
            }

            if (employeeGatepassModalTitle) {
                employeeGatepassModalTitle.textContent = 'Edit & Resubmit Gate Pass Request';
            }
            if (employeeGatepassSubmitBtn) {
                employeeGatepassSubmitBtn.textContent = 'Resubmit Request';
            }
            if (employeeGatepassNoInput) {
                employeeGatepassNoInput.value = gatepassNo || '';
            }
            if (employeeResubmitGatepassNoInput) {
                employeeResubmitGatepassNoInput.value = gatepassNo || '';
            }
            if (employeeRequestDateInput && requestDate) {
                employeeRequestDateInput.value = requestDate;
            }
            if (employeePurposeInput) {
                employeePurposeInput.value = purpose;
            }
            if (employeeRemarksInput) {
                employeeRemarksInput.value = remarks;
            }
            if (employeeDestinationInput) {
                employeeDestinationInput.value = destination;
            }

            employeeFillSelectedEquipment(equipments);
            openRequestModal({ reset: false });
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
            if (window.location.hash === '#request-history') {
                coordinatorGpShowHistoryPanel();
                employeeLoadDashboard('All', { silent: true, preservePage: true });
            } else {
                coordinatorGpShowMyRequestsPanel();
            }

            employeeWireDashboardFilters();

            employeeStartDashboardPolling();
            document.addEventListener('visibilitychange', function () {
                if (document.visibilityState === 'visible') {
                    employeeRefreshForAdminUpdates();
                }
            });

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
                        + '<td class="px-5 py-3 align-top text-[14px] text-gray-700">' + index + '</td>'
                        + '<td class="px-5 py-3 align-top text-[14px] text-gray-800 break-words">' + propNo + '</td>'
                        + '<td class="px-5 py-3 align-top text-[14px] text-gray-800 break-words">' + description + '</td>'
                        + '<td class="px-5 py-3 align-top sm:text-right">'
                        + '  <button type="button" class="inline-flex whitespace-nowrap text-red-500 text-[13px] sm:text-[14px] font-semibold" onclick="employeeRemoveSelectedEquipment(this)">Remove</button>'
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
                    const resubmitGatepassNo = String(form?.dataset?.editGatepassNo || '').trim();
                    if (resubmitGatepassNo) {
                        formData.set('resubmit_gatepass_no', resubmitGatepassNo);
                    } else {
                        formData.delete('resubmit_gatepass_no');
                    }

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

            const employeeHistoryPrevBtn = document.getElementById('employeeHistoryPrevBtn');
            const employeeHistoryNextBtn = document.getElementById('employeeHistoryNextBtn');
            const employeeDashboardPrevBtn = document.getElementById('employeeDashboardPrevBtn');
            const employeeDashboardNextBtn = document.getElementById('employeeDashboardNextBtn');
            if (employeeHistoryPrevBtn) {
                employeeHistoryPrevBtn.addEventListener('click', function () {
                    renderEmployeeHistoryPage(employeeHistoryCurrentPage - 1);
                });
            }
            if (employeeHistoryNextBtn) {
                employeeHistoryNextBtn.addEventListener('click', function () {
                    renderEmployeeHistoryPage(employeeHistoryCurrentPage + 1);
                });
            }
            if (employeeDashboardPrevBtn) {
                employeeDashboardPrevBtn.addEventListener('click', function () {
                    renderEmployeeDashboardPage(employeeDashboardCurrentPage - 1);
                });
            }
            if (employeeDashboardNextBtn) {
                employeeDashboardNextBtn.addEventListener('click', function () {
                    renderEmployeeDashboardPage(employeeDashboardCurrentPage + 1);
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

        async function employeeLoadDashboard(status, opts = {}) {
            const silent = opts.silent === true;
            const preservePage = opts.preservePage === true;
            const prevPage = employeeDashboardCurrentPage;

            const totalEl = document.getElementById('employeeTotalRequestsCount');
            const pendingEl = document.getElementById('employeePendingRequestsCount');
            const approvedEl = document.getElementById('employeeApprovedRequestsCount');
            const activeOutsideEl = document.getElementById('employeeActiveOutsideCount');
            const foundEl = document.getElementById('employeeDashboardRequestsFound');
            const emptyEl = document.getElementById('employeeDashboardEmpty');
            const listEl = document.getElementById('employeeDashboardList');
            const paginationWrap = document.getElementById('employeeDashboardPagination');

            if (!totalEl || !pendingEl || !approvedEl || !activeOutsideEl || !foundEl || !emptyEl || !listEl || !paginationWrap) {
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
                employeeDashboardRows = rows;

                if (preservePage) {
                    const lastPage = Math.max(1, Math.ceil(rows.length / EMPLOYEE_DASHBOARD_PAGE_SIZE));
                    employeeDashboardCurrentPage = Math.min(Math.max(1, prevPage), lastPage);
                } else {
                    employeeDashboardCurrentPage = 1;
                }

                totalEl.textContent = String(counts.total ?? 0);
                pendingEl.textContent = String(counts.pending ?? 0);
                approvedEl.textContent = String(counts.approved ?? 0);
                activeOutsideEl.textContent = String(counts.active_outside ?? 0);

                foundEl.textContent = rows.length + ' requests found';

                listEl.innerHTML = '';

                if (!rows.length) {
                    emptyEl.classList.remove('hidden');
                    listEl.classList.add('hidden');
                    paginationWrap.classList.add('hidden');
                    return;
                }

                emptyEl.classList.add('hidden');
                listEl.classList.remove('hidden');
                renderEmployeeDashboardPage(employeeDashboardCurrentPage);
            } catch (e) {
                if (!silent) {
                    employeeShowToast('Failed to load dashboard. Please refresh.', 'error');
                }
            }
        }

        function renderEmployeeDashboardPage(page) {
            const listEl = document.getElementById('employeeDashboardList');
            const emptyEl = document.getElementById('employeeDashboardEmpty');
            const paginationWrap = document.getElementById('employeeDashboardPagination');
            const prevBtn = document.getElementById('employeeDashboardPrevBtn');
            const nextBtn = document.getElementById('employeeDashboardNextBtn');
            const pageNumbers = document.getElementById('employeeDashboardPageNumbers');

            if (!listEl || !emptyEl || !paginationWrap || !prevBtn || !nextBtn || !pageNumbers) {
                return;
            }

            const totalRows = employeeDashboardRows.length;
            if (!totalRows) {
                listEl.innerHTML = '';
                emptyEl.classList.remove('hidden');
                paginationWrap.classList.add('hidden');
                return;
            }

            const lastPage = Math.max(1, Math.ceil(totalRows / EMPLOYEE_DASHBOARD_PAGE_SIZE));
            employeeDashboardCurrentPage = Math.min(Math.max(1, Number(page) || 1), lastPage);
            const offset = (employeeDashboardCurrentPage - 1) * EMPLOYEE_DASHBOARD_PAGE_SIZE;
            const rows = employeeDashboardRows.slice(offset, offset + EMPLOYEE_DASHBOARD_PAGE_SIZE);
            listEl.innerHTML = '';
            emptyEl.classList.add('hidden');

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
                    const rejectionReason = (row.rejection_reason || '').toString().trim();
                    const showRejectionReason = statusTextLower === 'resubmit' && rejectionReason !== '';

                    const card = document.createElement('div');
                    card.className = 'border border-gray-200 rounded-2xl bg-white px-5 py-5 mb-4 cursor-pointer hover:shadow-md hover:border-[#003b95]/30 transition';
                    card.setAttribute('role', 'button');
                    card.setAttribute('tabindex', '0');
                    card.setAttribute('aria-label', 'View request details');
                    const gatepassNo = (row.gatepass_no || '').toString();
                    const showQrButton = (statusTextLower === 'approved'
                        || statusTextLower === 'incoming partial'
                        || statusTextLower === 'returned') && gatepassNo;
                    const showEditResubmitButton = statusTextLower === 'resubmit' && gatepassNo;
                    const qrButtonHtml = showQrButton
                        ? '<button type="button" data-qr-gatepass-no="' + escapeHtml(gatepassNo) + '" aria-label="Show Gate Pass QR Code" class="w-[36px] h-[36px] rounded-full border border-[#00b84f]/30 bg-white text-[#00b84f] flex items-center justify-center text-[16px] hover:bg-[#e8fff0] transition">' +
                            '<i class="fa-solid fa-qrcode"></i>' +
                          '</button>'
                        : '';
                    const editResubmitButtonHtml = showEditResubmitButton
                        ? '<button type="button" data-edit-resubmit-gatepass-no="' + escapeHtml(gatepassNo) + '" aria-label="Edit and Resubmit Request" class="h-[36px] rounded-xl border border-[#003b95]/20 bg-white px-3 text-[12px] font-semibold text-[#003b95] hover:bg-[#eef5ff] transition">Edit &amp; Resubmit</button>'
                        : '';

                    card.innerHTML = ''
                        + '<div class="flex items-start justify-between gap-4">'
                        + '  <div class="min-w-0">'
                        + '    <div class="text-[16px] font-semibold text-[#003b95]">' + escapeHtml(row.gatepass_no || '') + '</div>'
                        + '    <div class="text-[14px] text-[#425b78] mt-1">Date: ' + escapeHtml(row.request_date || '') + '</div>'
                        + '    <div class="text-[14px] text-gray-700 mt-2 break-words">' + escapeHtml(itemsText) + '</div>'
                        + (showRejectionReason
                            ? '    <div class="mt-3 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-[13px] text-rose-800"><span class="font-semibold">Rejection Reason:</span> ' + escapeHtml(rejectionReason) + '</div>'
                            : '')
                        + '  </div>'
                        + '  <div class="shrink-0 flex flex-col items-end gap-2">'
                        + '    <div class="flex items-center gap-2">'
                        + '      <span class="inline-flex items-center px-4 py-2 rounded-full text-[13px] font-semibold ' + badgeClass + '">' + escapeHtml(statusText) + '</span>'
                        + editResubmitButtonHtml
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

                    if (showEditResubmitButton) {
                        const editBtn = card.querySelector('button[data-edit-resubmit-gatepass-no]');
                        if (editBtn) {
                            editBtn.addEventListener('click', function (ev) {
                                ev.stopPropagation();
                                openEditResubmitModal(row);
                            });
                        }
                    }

                    listEl.appendChild(card);
                }

            paginationWrap.classList.toggle('hidden', totalRows <= EMPLOYEE_DASHBOARD_PAGE_SIZE);
            prevBtn.disabled = employeeDashboardCurrentPage <= 1;
            nextBtn.disabled = employeeDashboardCurrentPage >= lastPage;

            pageNumbers.innerHTML = '';
            let startPage = Math.max(1, employeeDashboardCurrentPage - 1);
            let endPage = Math.min(lastPage, startPage + EMPLOYEE_DASHBOARD_MAX_VISIBLE_PAGES - 1);
            startPage = Math.max(1, endPage - EMPLOYEE_DASHBOARD_MAX_VISIBLE_PAGES + 1);

            for (let p = startPage; p <= endPage; p += 1) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = String(p);
                btn.className = 'h-[38px] min-w-[38px] px-3 rounded-xl border text-[14px] font-semibold transition';
                if (p === employeeDashboardCurrentPage) {
                    btn.classList.add('bg-[#003b95]', 'text-white', 'border-[#003b95]');
                } else {
                    btn.classList.add('bg-white', 'text-[#425b78]', 'border-gray-300', 'hover:bg-gray-50');
                }
                btn.addEventListener('click', function () {
                    renderEmployeeDashboardPage(p);
                });
                pageNumbers.appendChild(btn);
            }
        }

        async function employeeLoadRequestHistory(opts = {}) {
            const silent = opts.silent === true;
            const preservePage = opts.preservePage === true;
            const prevPage = employeeHistoryCurrentPage;

            const historyList = document.getElementById('historyList');
            const emptyHistory = document.getElementById('emptyHistory');
            const paginationWrap = document.getElementById('employeeHistoryPagination');

            if (!historyList || !emptyHistory || !paginationWrap) {
                return;
            }

            historyList.innerHTML = '';
            emptyHistory.classList.add('hidden');
            paginationWrap.classList.add('hidden');

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
                employeeHistoryRows = Array.isArray(rows) ? rows : [];

                if (preservePage) {
                    const lastPage = Math.max(1, Math.ceil(employeeHistoryRows.length / EMPLOYEE_HISTORY_PAGE_SIZE));
                    employeeHistoryCurrentPage = Math.min(Math.max(1, prevPage), lastPage);
                } else {
                    employeeHistoryCurrentPage = 1;
                }

                if (!employeeHistoryRows.length) {
                    emptyHistory.classList.remove('hidden');
                    return;
                }

                renderEmployeeHistoryPage(employeeHistoryCurrentPage);
            } catch (e) {
                emptyHistory.classList.remove('hidden');
                if (!silent) {
                    employeeShowToast('Failed to load request history. Please refresh.', 'error');
                }
            }
        }

        function renderEmployeeHistoryPage(page) {
            const historyList = document.getElementById('historyList');
            const emptyHistory = document.getElementById('emptyHistory');
            const paginationWrap = document.getElementById('employeeHistoryPagination');
            const prevBtn = document.getElementById('employeeHistoryPrevBtn');
            const nextBtn = document.getElementById('employeeHistoryNextBtn');
            const pageNumbers = document.getElementById('employeeHistoryPageNumbers');

            if (!historyList || !emptyHistory || !paginationWrap || !prevBtn || !nextBtn || !pageNumbers) {
                return;
            }

            const totalRows = employeeHistoryRows.length;
            if (!totalRows) {
                historyList.innerHTML = '';
                emptyHistory.classList.remove('hidden');
                paginationWrap.classList.add('hidden');
                return;
            }

            const lastPage = Math.max(1, Math.ceil(totalRows / EMPLOYEE_HISTORY_PAGE_SIZE));
            employeeHistoryCurrentPage = Math.min(Math.max(1, Number(page) || 1), lastPage);
            const offset = (employeeHistoryCurrentPage - 1) * EMPLOYEE_HISTORY_PAGE_SIZE;
            const rows = employeeHistoryRows.slice(offset, offset + EMPLOYEE_HISTORY_PAGE_SIZE);

            historyList.innerHTML = '';
            emptyHistory.classList.add('hidden');

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

            paginationWrap.classList.toggle('hidden', totalRows <= EMPLOYEE_HISTORY_PAGE_SIZE);
            prevBtn.disabled = employeeHistoryCurrentPage <= 1;
            nextBtn.disabled = employeeHistoryCurrentPage >= lastPage;

            pageNumbers.innerHTML = '';
            let startPage = Math.max(1, employeeHistoryCurrentPage - 1);
            let endPage = Math.min(lastPage, startPage + EMPLOYEE_HISTORY_MAX_VISIBLE_PAGES - 1);
            startPage = Math.max(1, endPage - EMPLOYEE_HISTORY_MAX_VISIBLE_PAGES + 1);

            for (let p = startPage; p <= endPage; p += 1) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = String(p);
                btn.className = 'h-[38px] min-w-[38px] px-3 rounded-xl border text-[14px] font-semibold transition';
                if (p === employeeHistoryCurrentPage) {
                    btn.classList.add('bg-[#003b95]', 'text-white', 'border-[#003b95]');
                } else {
                    btn.classList.add('bg-white', 'text-[#425b78]', 'border-gray-300', 'hover:bg-gray-50');
                }
                btn.addEventListener('click', function () {
                    renderEmployeeHistoryPage(p);
                });
                pageNumbers.appendChild(btn);
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
            if (statusLower === 'resubmit') {
                return 'bg-rose-100 text-rose-800 border border-rose-200';
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

            window.__employeeOpenRequestDetailsGatepassNo = gatepassNo != null ? String(gatepassNo) : null;

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

            window.__employeeOpenRequestDetailsGatepassNo = null;

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
                    + '  class="w-full h-auto mx-auto max-w-[220px] sm:max-w-[260px] lg:max-w-[320px]" '
                    + '  loading="eager"'
                    + '/>';
            } else {
                qrContainerEl.innerHTML = ''
                    + '<img '
                    + '  src="' + escapeHtml(savedQrUrl) + '" '
                    + '  alt="Gate Pass QR Code" '
                    + '  class="w-full h-auto mx-auto max-w-[220px] sm:max-w-[260px] lg:max-w-[320px]" '
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

        async function employeeLoadRequestDetails(gatepassNo, opts = {}) {
            const silent = opts.silent === true;

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
            const rejectionReasonWrapEl = document.getElementById('requestDetailsRejectionReasonWrap');
            const rejectionReasonEl = document.getElementById('requestDetailsRejectionReason');

            if (!loadingEl || !errorEl || !bodyEl || !gatepassNoEl || !statusBadgeEl || !itemsEl || !requestDateEl || !purposeEl || !destinationEl || !remarksEl || !rejectionReasonWrapEl || !rejectionReasonEl) {
                return;
            }

            if (!silent) {
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
                rejectionReasonEl.textContent = '—';
                rejectionReasonWrapEl.classList.add('hidden');
            }

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
                if (data.gatepass_no) {
                    employeeResubmitCache.set(String(data.gatepass_no), {
                        request_date: data.request_date || '',
                        purpose: data.purpose || '',
                        destination: data.destination || '',
                        remarks: data.remarks || '',
                        equipments: Array.isArray(data.items)
                            ? data.items.map(function (item) {
                                return {
                                    inventory_id: item.inventory_id,
                                    prop_no: item.prop_no,
                                    description: item.description,
                                };
                            })
                            : [],
                    });
                }
                const rejectionReason = String(data.rejection_reason || '').trim();
                if (statusText.toLowerCase() === 'resubmit' && rejectionReason !== '') {
                    rejectionReasonEl.textContent = rejectionReason;
                    rejectionReasonWrapEl.classList.remove('hidden');
                } else {
                    rejectionReasonEl.textContent = '—';
                    rejectionReasonWrapEl.classList.add('hidden');
                }

                loadingEl.classList.add('hidden');
                bodyEl.classList.remove('hidden');
            } catch (e) {
                loadingEl.classList.add('hidden');
                if (!silent) {
                    errorEl.classList.remove('hidden');
                    bodyEl.classList.add('hidden');
                }
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

        window.openRequestModal = openRequestModal;
        window.closeRequestModal = closeRequestModal;
        window.openProfileModal = openProfileModal;
        window.closeProfileModal = closeProfileModal;
        window.coordinatorGpShowMyRequestsPanel = coordinatorGpShowMyRequestsPanel;
        window.coordinatorGpShowHistoryPanel = coordinatorGpShowHistoryPanel;
        window.employeeRemoveSelectedEquipment = employeeRemoveSelectedEquipment;
        window.coordinatorGatepassLazyInit = function () {
            if (window.__coordinatorGatepassLazyInited) {
                return;
            }
            window.__coordinatorGatepassLazyInited = true;
            employeeLoadDashboard('All');
        };

})();
