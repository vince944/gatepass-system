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
        let employeeHistoryLoadToken = 0;

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


        function openRequestModal() {
            const modal = document.getElementById('requestModal');
            if (!modal) {
                return;
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
        /* coordinator: gatepass init deferred */
        employeeWireDashboardFilters();
        /* employeeLoadDashboard called when opening Gatepass tab */

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
            const currentLoadToken = ++employeeHistoryLoadToken;

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
                if (currentLoadToken !== employeeHistoryLoadToken) {
                    return;
                }

                if (!rows.length) {
                    emptyHistory.classList.remove('hidden');
                    return;
                }

                historyList.innerHTML = '';
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
