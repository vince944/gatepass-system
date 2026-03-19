<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gatepass</title>
    @vite('resources/css/app.css')
    <style>
        @keyframes success-pop {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-success-pop {
            animation: success-pop 0.5s ease-out;
        }
        @keyframes toast-slide-in {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes toast-slide-out {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-20px); }
        }
        .toast-enter {
            animation: toast-slide-in 0.35s ease-out forwards;
        }
        .toast-exit {
            animation: toast-slide-out 0.3s ease-in forwards;
        }
    </style>
</head>
<body class="bg-[#173a6b] min-h-screen">

    <!-- Toast container: center top -->
    <div id="toastContainer" class="fixed top-4 left-1/2 -translate-x-1/2 z-[100] flex flex-col gap-2 pointer-events-none" aria-live="polite"></div>

    <!-- Header -->
    <div class="w-full border-b border-white/10 px-6 md:px-8 py-5 flex items-center gap-4">
        <div class="flex items-center justify-center shrink-0">
            <img src="{{ asset('images/dap_logo.png') }}" alt="DAP Logo"
                 class="w-14 h-14 md:w-16 md:h-16 object-contain">
        </div>

        <div>
            <h1 class="text-white text-[22px] md:text-[34px] font-bold leading-tight">
                Gate Pass Scanner
            </h1>
            <p class="text-white/70 text-[14px] md:text-[18px]">
                Security Gate Pass System
            </p>
        </div>
    </div>

    <!-- Main Card -->
    <div class="flex items-center justify-center px-4 py-10 md:py-16">
        <div class="w-full max-w-[620px] bg-[#efefef] rounded-[28px] shadow-2xl px-8 md:px-12 py-10 text-center">

            <!-- Default View -->
            <div id="defaultView">
                <div class="mx-auto w-[150px] h-[150px] md:w-[180px] md:h-[180px] bg-[#21466f] rounded-[30px] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 md:w-24 md:h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3H5a2 2 0 0 0-2 2v2m16-4h-2m2 0a2 2 0 0 1 2 2v2M3 17v2a2 2 0 0 0 2 2h2m12-4v2a2 2 0 0 1-2 2h-2M9 9h.01M15 9h.01M9 15h.01M15 15h.01M11 11h2v2h-2z"/>
                    </svg>
                </div>

                <h2 class="mt-8 text-[#173a6b] text-[40px] md:text-[48px] font-bold leading-tight">
                    Scan QR Code
                </h2>

                <p class="mt-4 text-[#173a6b]/80 text-[18px] md:text-[22px] leading-relaxed">
                    Position the QR code within the frame to scan
                </p>
            </div>

            <!-- Camera View -->
            <div id="cameraView" class="hidden">
                <div class="relative w-full">
                    <div id="reader" class="w-full h-[320px] md:h-[420px] rounded-[20px] overflow-hidden bg-black border-4 border-[#173a6b]"></div>
                    <!-- Success animation overlay -->
                    <div id="successOverlay" class="absolute inset-0 w-full h-[320px] md:h-[420px] rounded-[20px] bg-green-500/90 flex items-center justify-center opacity-0 scale-95 pointer-events-none transition-all duration-300 z-20" aria-hidden="true">
                        <div class="flex flex-col items-center gap-3 text-white">
                            <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-white/30 flex items-center justify-center animate-success-pop">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 md:w-14 md:h-14 text-white drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-xl md:text-2xl font-bold drop-shadow">Scan Successful</span>
                        </div>
                    </div>
                </div>

                <p class="mt-5 text-[#173a6b] text-[16px] md:text-[20px]">
                    Camera is now open. Point it at the QR code.
                </p>
            </div>

            <!-- Error -->
            <div id="errorBox" class="hidden mt-5 p-4 rounded-xl bg-red-100 border border-red-300 text-left">
                <p id="errorText" class="text-red-800 font-medium"></p>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex flex-col gap-4">
                <button id="startScanBtn"
                    class="w-full bg-[#f6bf1e] hover:bg-[#e0ac13] text-[#0f3b78] font-bold text-[22px] py-4 rounded-[18px] transition">
                    Start Scanning
                </button>

                <button id="stopScanBtn"
                    class="hidden w-full bg-[#173a6b] hover:bg-[#123154] text-white font-bold text-[20px] py-4 rounded-[18px] transition">
                    Stop Camera
                </button>
            </div>
        </div>
    </div>

    <!-- Scan Result Modal -->
    <div id="scanModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-[#173a6b] px-6 py-4 flex items-center justify-between">
                <div>
                    <h3 class="text-white text-2xl font-bold">Gate Pass Details</h3>
                    <p class="text-white/70 text-sm">Scanned QR code information</p>
                </div>
                <button id="closeScanModal" class="text-white text-3xl leading-none hover:text-gray-200">
                    &times;
                </button>
            </div>

            <div class="p-6 max-h-[80vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-100 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Gatepass No</p>
                        <p id="modalGatepassNo" class="text-lg font-semibold text-[#173a6b]"></p>
                    </div>

                    <div class="bg-gray-100 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Status</p>
                        <p id="modalStatus" class="text-lg font-semibold"></p>
                    </div>

                    <div class="bg-gray-100 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Request Date</p>
                        <p id="modalRequestDate" class="text-lg font-semibold text-[#173a6b]"></p>
                    </div>

                    <div class="bg-gray-100 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Requester Name</p>
                        <p id="modalRequesterName" class="text-lg font-semibold text-[#173a6b]"></p>
                    </div>

                    <div class="bg-gray-100 rounded-xl p-4 md:col-span-2">
                        <p class="text-xs text-gray-500 mb-1">
                            <span id="modalLogLabel">Time In</span>
                            <span class="text-gray-400">•</span>
                            <span id="modalLogDatetime" class="text-gray-600"></span>
                        </p>
                        <p id="modalLogTypeHint" class="text-lg font-semibold text-[#173a6b]"></p>
                    </div>

                    <div class="bg-gray-100 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Center</p>
                        <p id="modalCenter" class="text-lg font-semibold text-[#173a6b]"></p>
                    </div>

                    <div class="bg-gray-100 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Purpose</p>
                        <p id="modalPurpose" class="text-lg font-semibold text-[#173a6b]"></p>
                    </div>

                    <div class="bg-gray-100 rounded-xl p-4 md:col-span-2">
                        <p class="text-xs text-gray-500 mb-1">Destination</p>
                        <p id="modalDestination" class="text-lg font-semibold text-[#173a6b]"></p>
                    </div>

                    <div class="bg-gray-100 rounded-xl p-4 md:col-span-2">
                        <p class="text-xs text-gray-500 mb-1">Remarks</p>
                        <p id="modalRemarks" class="text-lg font-semibold text-[#173a6b]"></p>
                    </div>
                </div>

                <div class="mt-6">
                    <h4 class="text-[#173a6b] text-xl font-bold mb-3">Items</h4>

                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-[#173a6b] text-white">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">Property Number</th>
                                    <th class="px-4 py-3 font-semibold">Description</th>
                                    <th class="px-4 py-3 font-semibold">Serial No</th>
                                    <th class="px-4 py-3 font-semibold">Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="modalItemsTable" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <label class="flex items-center gap-3 select-none">
                        <input id="confirmGatepassCheckbox" type="checkbox"
                               class="h-5 w-5 rounded border-gray-300 text-[#173a6b] focus:ring-[#173a6b]" />
                        <span class="text-sm text-gray-700">
                            I confirm that the gatepass and items are verified.
                        </span>
                    </label>

                    <div class="flex justify-end gap-3">
                        <button id="approveGatepassBtn" disabled
                                class="bg-gray-300 text-gray-600 font-bold px-6 py-3 rounded-xl transition opacity-70 cursor-not-allowed">
                            Approve
                        </button>

                        <button id="closeScanModalFooter"
                                class="bg-[#173a6b] hover:bg-[#123154] text-white font-semibold px-6 py-3 rounded-xl transition">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        let qrScanner = null;
        let scanning = false;
        let lastScannedText = null;

        const defaultView = document.getElementById('defaultView');
        const cameraView = document.getElementById('cameraView');
        const startBtn = document.getElementById('startScanBtn');
        const stopBtn = document.getElementById('stopScanBtn');
        const errorBox = document.getElementById('errorBox');
        const errorText = document.getElementById('errorText');

        const scanModal = document.getElementById('scanModal');
        const closeScanModal = document.getElementById('closeScanModal');
        const closeScanModalFooter = document.getElementById('closeScanModalFooter');
        const successOverlay = document.getElementById('successOverlay');

        const confirmGatepassCheckbox = document.getElementById('confirmGatepassCheckbox');
        const approveGatepassBtn = document.getElementById('approveGatepassBtn');

        let currentGatepassNo = null;
        let nextLogType = null;
        let savedCameraId = null;

        function showError(message) {
            errorBox.classList.remove('hidden');
            errorText.textContent = message;
        }

        function hideError() {
            errorBox.classList.add('hidden');
            errorText.textContent = '';
        }

        /**
         * Reusable toast notification.
         * @param {string} message - Toast message
         * @param {'success'|'error'} type - success = green accent, error = red accent
         */
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            const isSuccess = type === 'success';
            const accentClass = isSuccess ? 'border-l-green-500' : 'border-l-red-500';
            toast.className = `toast-enter bg-white shadow-lg rounded-xl px-5 py-4 border-l-4 ${accentClass} max-w-[90vw] sm:max-w-md`;
            toast.setAttribute('role', 'alert');
            toast.textContent = message || (isSuccess ? 'Done' : 'Something went wrong.');
            container.appendChild(toast);

            const duration = 3000;
            const exitDuration = 300;

            const removeToast = () => {
                toast.classList.remove('toast-enter');
                toast.classList.add('toast-exit');
                setTimeout(() => toast.remove(), exitDuration);
            };

            setTimeout(removeToast, duration);
        }

        function showSuccessAnimation() {
            successOverlay.classList.remove('opacity-0', 'scale-95');
            successOverlay.classList.add('opacity-100', 'scale-100');
        }

        function hideSuccessOverlay() {
            successOverlay.classList.add('opacity-0', 'scale-95');
            successOverlay.classList.remove('opacity-100', 'scale-100');
        }

        function openModal() {
            scanModal.classList.remove('hidden');
            scanModal.classList.add('flex');
        }

        async function closeModal() {
            scanModal.classList.add('hidden');
            scanModal.classList.remove('flex');
            hideSuccessOverlay();
            if (scanning) {
                await restartScanner();
            }
        }

        async function restartScanner() {
            if (!qrScanner || !scanning) return;
            try {
                await qrScanner.stop();
                await qrScanner.clear();
            } catch (e) {
                console.error(e);
            }
            scanning = false;
            lastScannedText = null;
            qrScanner = null;
            if (savedCameraId) {
                await new Promise(r => setTimeout(r, 300));
                await startScannerWithCamera(savedCameraId);
            }
        }

        async function startScannerWithCamera(cameraId) {
            hideError();
            try {
                qrScanner = new Html5Qrcode("reader");
                await qrScanner.start(
                    cameraId,
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    async (decodedText) => {
                        if (decodedText === lastScannedText) return;
                        lastScannedText = decodedText;

                        try {
                            const parsedData = JSON.parse(decodedText);
                            showSuccessAnimation();
                            setTimeout(() => {
                                hideSuccessOverlay();
                                fillModal(parsedData);
                                openModal();
                            }, 700);
                        } catch (e) {
                            showError("Scanned QR code is not valid.");
                            lastScannedText = null;
                            console.error(e);
                        }
                    },
                    () => {}
                );
                scanning = true;
            } catch (error) {
                console.error(error);
                showError("Camera failed to open. Please allow camera permission and use localhost or HTTPS.");
            }
        }

        function csrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
        }

        function logTypeToLabel(type) {
            const upper = String(type ?? '').toUpperCase();
            if (upper === 'INCOMING') {
                return 'Time In';
            }

            if (upper === 'OUTGOING') {
                return 'Time Out';
            }

            return 'Time In';
        }

        function setApprovalEnabled(enabled) {
            approveGatepassBtn.disabled = !enabled;

            if (enabled) {
                approveGatepassBtn.classList.remove('bg-gray-300', 'text-gray-600', 'opacity-70', 'cursor-not-allowed');
                approveGatepassBtn.classList.add('bg-[#f6bf1e]', 'text-[#0f3b78]', 'hover:bg-[#e0ac13]');
            } else {
                approveGatepassBtn.classList.add('bg-gray-300', 'text-gray-600', 'opacity-70', 'cursor-not-allowed');
                approveGatepassBtn.classList.remove('bg-[#f6bf1e]', 'text-[#0f3b78]', 'hover:bg-[#e0ac13]');
            }
        }

        function resetApprovalControls() {
            confirmGatepassCheckbox.checked = false;
            setApprovalEnabled(false);
            approveGatepassBtn.dataset.submitted = '0';
        }

        async function refreshNextLogInfo(gatepassNo) {
            const labelEl = document.getElementById('modalLogLabel');
            const datetimeEl = document.getElementById('modalLogDatetime');
            const hintEl = document.getElementById('modalLogTypeHint');

            labelEl.textContent = 'Time In';
            datetimeEl.textContent = '';
            hintEl.textContent = '';
            nextLogType = null;

            try {
                const url = `/guard/gatepass-logs/next?gatepass_no=${encodeURIComponent(gatepassNo)}`;
                const res = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                });

                if (!res.ok) {
                    throw new Error('Failed to fetch next log type');
                }

                const data = await res.json();
                nextLogType = data.log_type ?? null;

                labelEl.textContent = logTypeToLabel(nextLogType);
                datetimeEl.textContent = data.log_datetime ?? '';
                hintEl.textContent = String(nextLogType ?? '').toUpperCase();
            } catch (e) {
                console.error(e);
                labelEl.textContent = 'Time In';
                datetimeEl.textContent = new Date().toLocaleString();
                hintEl.textContent = '';
            }
        }

        function setStatusStyle(status) {
            const statusEl = document.getElementById('modalStatus');
            statusEl.textContent = status ?? 'N/A';

            statusEl.className = 'text-lg font-semibold';

            const lowerStatus = (status || '').toLowerCase();

            if (lowerStatus === 'approved') {
                statusEl.classList.add('text-green-600');
            } else if (lowerStatus === 'pending') {
                statusEl.classList.add('text-yellow-600');
            } else if (lowerStatus === 'rejected') {
                statusEl.classList.add('text-red-600');
            } else {
                statusEl.classList.add('text-[#173a6b]');
            }
        }

        function fillModal(data) {
            currentGatepassNo = data.gatepass_no || null;
            document.getElementById('modalGatepassNo').textContent = data.gatepass_no || 'N/A';
            setStatusStyle(data.status);
            document.getElementById('modalRequestDate').textContent = data.request_date || 'N/A';
            document.getElementById('modalRequesterName').textContent = data.requester_name || 'N/A';
            document.getElementById('modalCenter').textContent = data.center || 'N/A';
            document.getElementById('modalPurpose').textContent = data.purpose || 'N/A';
            document.getElementById('modalDestination').textContent = data.destination || 'N/A';
            document.getElementById('modalRemarks').textContent = data.remarks || 'N/A';

            const itemsTable = document.getElementById('modalItemsTable');
            itemsTable.innerHTML = '';

            if (Array.isArray(data.items) && data.items.length > 0) {
                data.items.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-3">${item.property_number || 'N/A'}</td>
                        <td class="px-4 py-3">${item.description || 'N/A'}</td>
                        <td class="px-4 py-3">${item.serial_no || 'N/A'}</td>
                        <td class="px-4 py-3">${item.item_remarks || 'N/A'}</td>
                    `;
                    itemsTable.appendChild(row);
                });
            } else {
                itemsTable.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                            No items found
                        </td>
                    </tr>
                `;
            }

            resetApprovalControls();
            if (currentGatepassNo) {
                refreshNextLogInfo(currentGatepassNo);
            }
        }

        async function startScanner() {
            hideError();

            if (scanning) return;

            try {
                defaultView.classList.add('hidden');
                cameraView.classList.remove('hidden');
                stopBtn.classList.remove('hidden');

                const cameras = await Html5Qrcode.getCameras();

                if (!cameras || cameras.length === 0) {
                    showError("No camera detected on this device.");
                    defaultView.classList.remove('hidden');
                    cameraView.classList.add('hidden');
                    stopBtn.classList.add('hidden');
                    return;
                }

                const backCamera = cameras.find(cam =>
                    cam.label.toLowerCase().includes("back") ||
                    cam.label.toLowerCase().includes("rear")
                );

                savedCameraId = backCamera ? backCamera.id : cameras[0].id;
                await startScannerWithCamera(savedCameraId);
            } catch (error) {
                console.error(error);
                showError("Camera failed to open. Please allow camera permission and use localhost or HTTPS.");

                defaultView.classList.remove('hidden');
                cameraView.classList.add('hidden');
                stopBtn.classList.add('hidden');
            }
        }

        async function stopScanner() {
            if (qrScanner && scanning) {
                try {
                    await qrScanner.stop();
                    await qrScanner.clear();
                } catch (error) {
                    console.error(error);
                }
            }

            scanning = false;
            lastScannedText = null;
            cameraView.classList.add('hidden');
            defaultView.classList.remove('hidden');
            stopBtn.classList.add('hidden');
        }

        startBtn.addEventListener('click', startScanner);
        stopBtn.addEventListener('click', stopScanner);
        closeScanModal.addEventListener('click', closeModal);
        closeScanModalFooter.addEventListener('click', closeModal);

        confirmGatepassCheckbox.addEventListener('change', (e) => {
            setApprovalEnabled(Boolean(e.target.checked) && approveGatepassBtn.dataset.submitted !== '1');
        });

        approveGatepassBtn.addEventListener('click', async () => {
            if (approveGatepassBtn.disabled) {
                return;
            }

            if (!currentGatepassNo) {
                showToast('Gatepass number is missing.', 'error');
                return;
            }

            if (approveGatepassBtn.dataset.submitted === '1') {
                return;
            }

            approveGatepassBtn.dataset.submitted = '1';
            setApprovalEnabled(false);

            try {
                const res = await fetch('/guard/gatepass-logs', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken(),
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        gatepass_no: currentGatepassNo,
                    }),
                });

                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    const msg = data?.message || 'Failed to record log.';
                    throw new Error(msg);
                }

                showToast(data?.message || 'Recorded successfully', 'success');

                await refreshNextLogInfo(currentGatepassNo);
                closeModal();
            } catch (e) {
                console.error(e);
                approveGatepassBtn.dataset.submitted = '0';
                setApprovalEnabled(confirmGatepassCheckbox.checked);
                showToast(e?.message || 'Something went wrong.', 'error');
            }
        });

        scanModal.addEventListener('click', function (e) {
            if (e.target === scanModal) {
                closeModal();
            }
        });
    </script>
</body>
</html>