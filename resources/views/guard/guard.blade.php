<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gatepass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        @keyframes modal-scale-in {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-animate-in {
            animation: modal-scale-in 0.2s ease-out;
        }

        /* QR scanner sizing fix: keep a centered square frame on mobile */
        .reader-wrapper {
            aspect-ratio: 1 / 1;
        }

        #reader {
            height: 100%;
            position: relative;
        }

        #reader video,
        #reader canvas {
            position: absolute;
            inset: 0;
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        @media (min-width: 768px) {
            .reader-wrapper {
                aspect-ratio: auto;
                height: 420px;
            }
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
                <div class="reader-wrapper relative w-full">
                    <div id="reader" class="w-full h-full rounded-[20px] overflow-hidden bg-black border-4 border-[#173a6b]"></div>
                    <!-- Success animation overlay -->
                    <div id="successOverlay" class="absolute inset-0 w-full rounded-[20px] bg-green-500/90 flex items-center justify-center opacity-0 scale-95 pointer-events-none transition-all duration-150 z-20" aria-hidden="true">
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
                                    <th class="px-4 py-3 font-semibold">Item status</th>
                                </tr>
                            </thead>
                            <tbody id="modalItemsTable" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-4">
                    <label id="confirmGatepassRow" class="flex items-start gap-3 select-none">
                        <input id="confirmGatepassCheckbox" type="checkbox"
                               class="h-5 w-5 mt-0.5 rounded border-gray-300 text-[#173a6b] focus:ring-[#173a6b]" />
                        <span class="text-sm text-gray-700 text-left">
                            I confirm that the gatepass and items match verification (complete return for incoming, or valid outgoing scan).
                        </span>
                    </label>
                    <label id="confirmMissingItemsRow" class="hidden flex items-start gap-3 select-none">
                        <input id="confirmMissingItemsCheckbox" type="checkbox"
                               class="h-5 w-5 mt-0.5 rounded border-gray-300 text-amber-600 focus:ring-amber-500" />
                        <span class="text-sm text-gray-700 text-left">
                            I confirm that some items are missing/not yet returned, and this partial return is correct.
                        </span>
                    </label>
                    <label id="confirmCompleteItemsRow" class="hidden flex items-start gap-3 select-none">
                        <input id="confirmCompleteItemsCheckbox" type="checkbox"
                               class="h-5 w-5 mt-0.5 rounded border-gray-300 text-green-600 focus:ring-green-500" />
                        <span class="text-sm text-gray-700 text-left">
                            All items have been returned
                        </span>
                    </label>

                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:justify-end">
                        <button id="partialReturnBtn" type="button"
                                class="hidden w-full sm:w-auto order-1 bg-amber-500 hover:bg-amber-600 text-[#0f3b78] font-bold px-6 py-3 rounded-xl transition">
                            Partial return / missing item
                        </button>
                        <button id="completeReturnBtn" type="button"
                                class="hidden w-full sm:w-auto order-1 bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-xl transition">
                            Complete return
                        </button>
                        <button id="approveGatepassBtn" type="button" disabled
                                class="order-2 w-full sm:w-auto bg-gray-300 text-gray-600 font-bold px-6 py-3 rounded-xl transition opacity-70 cursor-not-allowed">
                            Approve
                        </button>
                        <button id="rejectGatepassBtn" type="button"
                                class="hidden order-3 w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                            Reject
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Log type picker modal -->
    <div id="logTypePickerModal" class="fixed inset-0 z-[55] hidden items-center justify-center bg-black/50 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-[#173a6b] px-6 py-4">
                <h3 class="text-white text-xl font-bold">Select log type</h3>
                <p class="text-white/70 text-sm">Choose how to record this scanned gate pass.</p>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-500 mb-4">
                    Gatepass No: <span id="logTypePickerGatepassNo" class="font-semibold text-[#173a6b]">N/A</span>
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <button id="pickOutgoingBtn" type="button"
                            class="w-full bg-[#f6bf1e] hover:bg-[#e0ac13] text-[#0f3b78] font-bold px-6 py-3 rounded-xl transition">
                        Outgoing
                    </button>
                    <button id="pickIncomingBtn" type="button"
                            class="w-full bg-[#173a6b] hover:bg-[#123154] text-white font-bold px-6 py-3 rounded-xl transition">
                        Incoming
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Partial return / missing item -->
    <div id="partialReturnModal" class="fixed inset-0 z-[65] hidden items-center justify-center bg-black/50 px-4 modal-animate-in">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col modal-animate-in">
            <div class="bg-[#173a6b] px-6 py-4 flex items-center justify-between shrink-0">
                <div>
                    <h3 class="text-white text-xl font-bold">Partial return / missing item</h3>
                    <p class="text-white/70 text-sm">Mark which items were not returned. Other listed items are recorded as returned.</p>
                </div>
                <button type="button" id="closePartialReturnModal" class="text-white text-3xl leading-none hover:text-gray-200">
                    &times;
                </button>
            </div>

            <div class="p-6 overflow-y-auto flex-1">
                <p id="partialReturnModalGatepassNo" class="text-sm text-gray-500 mb-4"></p>

                <div id="partialReturnModalError" class="hidden mb-4 p-3 rounded-xl bg-red-100 border border-red-200 text-red-700 text-sm">
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-[#173a6b] text-white">
                            <tr>
                                <th class="px-4 py-3 font-semibold min-w-[7rem]">Not yet returned</th>
                                <th class="px-4 py-3 font-semibold">Property Number</th>
                                <th class="px-4 py-3 font-semibold">Description</th>
                                <th class="px-4 py-3 font-semibold">Serial No</th>
                                <th class="px-4 py-3 font-semibold">Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="partialReturnModalItemsTable" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>

                <p id="partialReturnModalNoItems" class="hidden mt-4 text-gray-500 text-center">No items found for this gatepass.</p>

                <div class="mt-6">
                    <label for="partialReturnRemarks" class="block text-sm font-medium text-gray-700 mb-2">Guard remarks (optional)</label>
                    <textarea id="partialReturnRemarks" rows="3"
                              class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-800 focus:ring-2 focus:ring-[#173a6b] focus:border-[#173a6b]"
                              placeholder="Notes about this inspection"></textarea>
                </div>

                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                    <button type="button" id="partialReturnModalCancelBtn"
                            class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-xl transition">
                        Cancel
                    </button>
                    <button type="button" id="partialReturnModalConfirmBtn"
                            class="w-full sm:w-auto bg-amber-500 hover:bg-amber-600 text-[#0f3b78] font-bold px-6 py-3 rounded-xl transition">
                        Confirm partial return
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Complete return -->
    <div id="completeReturnModal" class="fixed inset-0 z-[65] hidden items-center justify-center bg-black/50 px-4 modal-animate-in">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col modal-animate-in">
            <div class="bg-[#173a6b] px-6 py-4 flex items-center justify-between shrink-0">
                <div>
                    <h3 class="text-white text-xl font-bold">Complete return</h3>
                    <p class="text-white/70 text-sm">Confirm that all listed items are already returned for this gatepass.</p>
                </div>
                <button type="button" id="closeCompleteReturnModal" class="text-white text-3xl leading-none hover:text-gray-200">
                    &times;
                </button>
            </div>

            <div class="p-6 overflow-y-auto flex-1">
                <p id="completeReturnModalGatepassNo" class="text-sm text-gray-500 mb-4"></p>

                <div id="completeReturnModalError" class="hidden mb-4 p-3 rounded-xl bg-red-100 border border-red-200 text-red-700 text-sm">
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-[#173a6b] text-white">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Property Number</th>
                                <th class="px-4 py-3 font-semibold">Description</th>
                                <th class="px-4 py-3 font-semibold">Serial No</th>
                                <th class="px-4 py-3 font-semibold">Remarks</th>
                                <th class="px-4 py-3 font-semibold">Item status</th>
                            </tr>
                        </thead>
                        <tbody id="completeReturnModalItemsTable" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>

                <p id="completeReturnModalNoItems" class="hidden mt-4 text-gray-500 text-center">No items found for this gatepass.</p>

                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                    <button type="button" id="completeReturnModalCancelBtn"
                            class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-xl transition">
                        Cancel
                    </button>
                    <button type="button" id="completeReturnModalConfirmBtn"
                            class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-xl transition">
                        Confirm complete return
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/50 px-4 modal-animate-in">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden modal-animate-in">
            <div class="bg-[#173a6b] px-6 py-4 flex items-center justify-between">
                <div>
                    <h3 class="text-white text-xl font-bold">Reject gate pass</h3>
                    <p class="text-white/70 text-sm">Use for invalid, suspicious, or failed verification cases only.</p>
                </div>
                <button type="button" id="closeRejectModal" class="text-white text-3xl leading-none hover:text-gray-200">
                    &times;
                </button>
            </div>

            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <p id="rejectModalGatepassNo" class="text-sm text-gray-500 mb-4"></p>

                <div id="rejectModalError" class="hidden mb-4 p-3 rounded-xl bg-red-100 border border-red-200 text-red-700 text-sm">
                </div>

                <label for="rejectReasonInput" class="block text-sm font-medium text-gray-700 mb-2">Rejection reason <span class="text-red-600">*</span></label>
                <textarea id="rejectReasonInput" rows="5"
                          class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-800 focus:ring-2 focus:ring-[#173a6b] focus:border-[#173a6b]"
                          placeholder="Describe why this gatepass is being rejected"></textarea>

                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                    <button type="button" id="rejectModalCancelBtn"
                            class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-xl transition">
                        Cancel
                    </button>
                    <button type="button" id="rejectModalConfirmBtn"
                            class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                        Confirm reject
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        let qrScanner = null;
        let scanning = false;
        let lastScannedText = null;
        /** True after a valid QR is accepted until the camera scan session is restarted or stopped. */
        let scanPipelineBusy = false;
        let successOverlayHideTimer = null;

        const defaultView = document.getElementById('defaultView');
        const cameraView = document.getElementById('cameraView');
        const startBtn = document.getElementById('startScanBtn');
        const stopBtn = document.getElementById('stopScanBtn');
        const errorBox = document.getElementById('errorBox');
        const errorText = document.getElementById('errorText');

        const scanModal = document.getElementById('scanModal');
        const closeScanModal = document.getElementById('closeScanModal');
        const successOverlay = document.getElementById('successOverlay');
        const logTypePickerModal = document.getElementById('logTypePickerModal');
        const logTypePickerGatepassNo = document.getElementById('logTypePickerGatepassNo');
        const pickOutgoingBtn = document.getElementById('pickOutgoingBtn');
        const pickIncomingBtn = document.getElementById('pickIncomingBtn');

        const confirmGatepassCheckbox = document.getElementById('confirmGatepassCheckbox');
        const confirmGatepassRow = document.getElementById('confirmGatepassRow');
        const confirmMissingItemsCheckbox = document.getElementById('confirmMissingItemsCheckbox');
        const confirmMissingItemsRow = document.getElementById('confirmMissingItemsRow');
        const confirmCompleteItemsCheckbox = document.getElementById('confirmCompleteItemsCheckbox');
        const confirmCompleteItemsRow = document.getElementById('confirmCompleteItemsRow');
        const approveGatepassBtn = document.getElementById('approveGatepassBtn');
        const rejectGatepassBtn = document.getElementById('rejectGatepassBtn');
        const partialReturnBtn = document.getElementById('partialReturnBtn');
        const completeReturnBtn = document.getElementById('completeReturnBtn');

        const partialReturnModal = document.getElementById('partialReturnModal');
        const closePartialReturnModal = document.getElementById('closePartialReturnModal');
        const partialReturnModalCancelBtn = document.getElementById('partialReturnModalCancelBtn');
        const partialReturnModalConfirmBtn = document.getElementById('partialReturnModalConfirmBtn');
        const partialReturnModalItemsTable = document.getElementById('partialReturnModalItemsTable');
        const partialReturnModalNoItems = document.getElementById('partialReturnModalNoItems');
        const partialReturnModalError = document.getElementById('partialReturnModalError');
        const partialReturnModalGatepassNo = document.getElementById('partialReturnModalGatepassNo');
        const partialReturnRemarks = document.getElementById('partialReturnRemarks');
        const completeReturnModal = document.getElementById('completeReturnModal');
        const closeCompleteReturnModal = document.getElementById('closeCompleteReturnModal');
        const completeReturnModalCancelBtn = document.getElementById('completeReturnModalCancelBtn');
        const completeReturnModalConfirmBtn = document.getElementById('completeReturnModalConfirmBtn');
        const completeReturnModalItemsTable = document.getElementById('completeReturnModalItemsTable');
        const completeReturnModalNoItems = document.getElementById('completeReturnModalNoItems');
        const completeReturnModalError = document.getElementById('completeReturnModalError');
        const completeReturnModalGatepassNo = document.getElementById('completeReturnModalGatepassNo');

        const rejectModal = document.getElementById('rejectModal');
        const closeRejectModal = document.getElementById('closeRejectModal');
        const rejectModalCancelBtn = document.getElementById('rejectModalCancelBtn');
        const rejectModalConfirmBtn = document.getElementById('rejectModalConfirmBtn');
        const rejectModalError = document.getElementById('rejectModalError');
        const rejectModalGatepassNo = document.getElementById('rejectModalGatepassNo');
        const rejectReasonInput = document.getElementById('rejectReasonInput');

        let currentGatepassNo = null;
        let selectedLogType = null;
        let currentGatepassStatus = null;
        let savedCameraId = null;
        let lastQrPayload = null;
        let requiresMissingItemsConfirmation = false;
        let isCompletingPartialReturn = false;

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

        function clearSuccessOverlayTimer() {
            if (successOverlayHideTimer !== null) {
                clearTimeout(successOverlayHideTimer);
                successOverlayHideTimer = null;
            }
        }

        function showSuccessAnimation() {
            clearSuccessOverlayTimer();
            successOverlay.classList.remove('opacity-0', 'scale-95');
            successOverlay.classList.add('opacity-100', 'scale-100');
        }

        function hideSuccessOverlay() {
            successOverlay.classList.add('opacity-0', 'scale-95');
            successOverlay.classList.remove('opacity-100', 'scale-100');
        }

        function scheduleHideSuccessOverlay(delayMs) {
            clearSuccessOverlayTimer();
            successOverlayHideTimer = window.setTimeout(() => {
                successOverlayHideTimer = null;
                hideSuccessOverlay();
            }, delayMs);
        }

        function releaseScanPipeline() {
            scanPipelineBusy = false;
        }

        function openModal() {
            scanModal.classList.remove('hidden');
            scanModal.classList.add('flex');
        }

        function openLogTypePicker(gatepassNo) {
            logTypePickerGatepassNo.textContent = gatepassNo || 'N/A';
            logTypePickerModal.classList.remove('hidden');
            logTypePickerModal.classList.add('flex');
        }

        function closeLogTypePicker() {
            logTypePickerModal.classList.add('hidden');
            logTypePickerModal.classList.remove('flex');
        }

        async function closeModal() {
            scanModal.classList.add('hidden');
            scanModal.classList.remove('flex');
            closeLogTypePicker();
            clearSuccessOverlayTimer();
            hideSuccessOverlay();
            if (scanning) {
                await restartScanner();
            }
        }

        async function restartScanner() {
            if (!qrScanner || !scanning) {
                releaseScanPipeline();
                lastScannedText = null;
                return;
            }
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
                await new Promise(r => setTimeout(r, 80));
                await startScannerWithCamera(savedCameraId);
            }
            releaseScanPipeline();
        }

        async function startScannerWithCamera(cameraId) {
            hideError();
            try {
                qrScanner = new Html5Qrcode("reader");

                const readerEl = document.getElementById('reader');
                const visibleSide = readerEl
                    ? Math.min(readerEl.clientWidth || 0, readerEl.clientHeight || 0)
                    : 250;
                const qrSide = Math.max(150, Math.min(250, Math.floor(visibleSide * 0.62)));

                await qrScanner.start(
                    cameraId,
                    {
                        fps: 15,
                        qrbox: { width: qrSide, height: qrSide },
                    },
                    async (decodedText) => {
                        if (scanPipelineBusy || decodedText === lastScannedText) {
                            return;
                        }

                        lastScannedText = decodedText;

                        try {
                            const parsedData = JSON.parse(decodedText);
                            scanPipelineBusy = true;

                            if (qrScanner && typeof qrScanner.pause === 'function') {
                                try {
                                    await qrScanner.pause(true);
                                } catch (pauseErr) {
                                    console.error(pauseErr);
                                }
                            }

                            lastQrPayload = parsedData;
                            currentGatepassNo = parsedData.gatepass_no || null;
                            selectedLogType = null;
                            openLogTypePicker(currentGatepassNo);
                            showSuccessAnimation();
                            scheduleHideSuccessOverlay(200);
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
                releaseScanPipeline();
                lastScannedText = null;
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

        function setMainConfirmationDisabled(disabled) {
            confirmGatepassCheckbox.disabled = disabled;
            confirmGatepassCheckbox.setAttribute('aria-disabled', disabled ? 'true' : 'false');

            if (disabled) {
                confirmGatepassCheckbox.classList.add('cursor-not-allowed', 'opacity-60');
            } else {
                confirmGatepassCheckbox.classList.remove('cursor-not-allowed', 'opacity-60');
            }
        }

        function setMissingConfirmationDisabled(disabled) {
            confirmMissingItemsCheckbox.disabled = disabled;
            confirmMissingItemsCheckbox.setAttribute('aria-disabled', disabled ? 'true' : 'false');

            if (disabled) {
                confirmMissingItemsCheckbox.classList.add('cursor-not-allowed', 'opacity-60');
            } else {
                confirmMissingItemsCheckbox.classList.remove('cursor-not-allowed', 'opacity-60');
            }
        }

        function isIncomingPartialStatus() {
            return String(currentGatepassStatus ?? '').toLowerCase() === 'incoming partial';
        }

        function applyPartialApprovalMode(isPartial) {
            requiresMissingItemsConfirmation = false;
            isCompletingPartialReturn = isPartial;
            const isIncomingSelection = String(selectedLogType ?? '').toUpperCase() === 'INCOMING';

            confirmGatepassCheckbox.checked = false;
            confirmMissingItemsCheckbox.checked = false;
            confirmCompleteItemsCheckbox.checked = false;

            if (isPartial) {
                confirmGatepassRow.classList.add('hidden');
                confirmMissingItemsRow.classList.add('hidden');
                confirmCompleteItemsRow.classList.toggle('hidden', !isIncomingSelection);
                setMainConfirmationDisabled(true);
                setMissingConfirmationDisabled(true);
                setApprovalEnabled(false);
                return;
            }

            confirmGatepassRow.classList.remove('hidden');
            confirmMissingItemsRow.classList.add('hidden');
            confirmCompleteItemsRow.classList.add('hidden');
            setMainConfirmationDisabled(false);
            setMissingConfirmationDisabled(false);
            setApprovalEnabled(confirmGatepassCheckbox.checked);
        }

        function resetApprovalControls() {
            confirmGatepassCheckbox.checked = false;
            confirmMissingItemsCheckbox.checked = false;
            confirmCompleteItemsCheckbox.checked = false;
            applyPartialApprovalMode(false);
            approveGatepassBtn.dataset.submitted = '0';
        }

        function refreshSelectedLogInfo() {
            const labelEl = document.getElementById('modalLogLabel');
            const datetimeEl = document.getElementById('modalLogDatetime');
            const hintEl = document.getElementById('modalLogTypeHint');

            labelEl.textContent = logTypeToLabel(selectedLogType);
            datetimeEl.textContent = new Date().toLocaleString();
            hintEl.textContent = String(selectedLogType ?? '').toUpperCase();
            updatePartialReturnButtonVisibility();
        }

        function setStatusStyle(status) {
            const statusEl = document.getElementById('modalStatus');
            statusEl.textContent = status ?? 'N/A';
            currentGatepassStatus = status ?? null;

            statusEl.className = 'text-lg font-semibold';

            const lowerStatus = (status || '').toLowerCase();

            if (lowerStatus === 'approved') {
                statusEl.classList.add('text-green-600');
            } else if (lowerStatus === 'pending') {
                statusEl.classList.add('text-yellow-600');
            } else if (lowerStatus === 'rejected') {
                statusEl.classList.add('text-red-600');
            } else if (lowerStatus === 'incoming partial') {
                statusEl.classList.add('text-amber-600');
            } else if (lowerStatus.startsWith('returned')) {
                statusEl.classList.add('text-blue-600');
            } else {
                statusEl.classList.add('text-[#173a6b]');
            }
        }

        function updatePartialReturnButtonVisibility() {
            const upper = String(selectedLogType ?? '').toUpperCase();
            const isPartial = isIncomingPartialStatus();
            if (!partialReturnBtn) {
                return;
            }
            partialReturnBtn.textContent = 'Partial return / missing item';
            if (isPartial) {
                partialReturnBtn.classList.add('hidden');
                completeReturnBtn.classList.add('hidden');
            } else if (upper === 'INCOMING') {
                partialReturnBtn.classList.remove('hidden');
                completeReturnBtn.classList.add('hidden');
            } else if (upper === 'PARTIAL') {
                partialReturnBtn.classList.add('hidden');
                completeReturnBtn.classList.add('hidden');
            } else {
                partialReturnBtn.classList.add('hidden');
                completeReturnBtn.classList.add('hidden');
            }
        }

        function itemStatusBadgeHtml(itemStatus) {
            if (itemStatus === null || itemStatus === undefined || String(itemStatus).trim() === '') {
                return '';
            }

            const s = String(itemStatus).toLowerCase();
            let label = 'Pending return';
            let cls = 'bg-gray-100 text-gray-800';
            if (s === 'returned') {
                label = 'Returned';
                cls = 'bg-green-100 text-green-800';
            } else if (s === 'missing') {
                label = 'Not yet returned';
                cls = 'bg-amber-100 text-amber-900';
            }
            return `<span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold ${cls}">${label}</span>`;
        }

        function renderGatepassItemsRows(items) {
            const itemsTable = document.getElementById('modalItemsTable');
            itemsTable.innerHTML = '';

            if (!Array.isArray(items) || items.length === 0) {
                itemsTable.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            No items found
                        </td>
                    </tr>
                `;
                return;
            }

            items.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'align-top';
                row.innerHTML = `
                    <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(String(item.property_number ?? 'N/A'))}</td>
                    <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(String(item.description ?? 'N/A'))}</td>
                    <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(String(item.serial_no ?? 'N/A'))}</td>
                    <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(String(item.remarks ?? 'N/A'))}</td>
                    <td class="px-4 py-3">${itemStatusBadgeHtml(item.item_status)}</td>
                `;
                itemsTable.appendChild(row);
            });
        }

        function renderQrFallbackItems(data) {
            const items = Array.isArray(data.items) ? data.items : [];
            const mapped = items.map(item => ({
                property_number: item.property_number ?? 'N/A',
                description: item.description ?? item.item_description ?? 'N/A',
                serial_no: item.serial_no ?? item.serial_number ?? 'N/A',
                remarks: item.item_remarks ?? 'N/A',
                item_status: item.item_status ?? null,
            }));
            renderGatepassItemsRows(mapped);
        }

        /**
         * @param {string} gatepassNo
         * @param {Object} [options]
         * @param {boolean} [options.showLoadingRow] defaults to true when omitted
         */
        async function refreshGatepassItemsFromServer(gatepassNo, options = {}) {
            const showLoadingRow = options.showLoadingRow !== false;
            const itemsTable = document.getElementById('modalItemsTable');
            if (showLoadingRow) {
                itemsTable.innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Loading items…</td>
                </tr>
            `;
            }

            try {
                const res = await fetch(`/guard/gatepass-items?gatepass_no=${encodeURIComponent(gatepassNo)}`, {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin',
                });
                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    throw new Error(data?.message || 'Failed to load items');
                }

                setStatusStyle(data.gatepass_status);
                applyPartialApprovalMode(isIncomingPartialStatus());
                renderGatepassItemsRows(data.items || []);
            } catch (e) {
                console.error(e);
                if (lastQrPayload) {
                    renderQrFallbackItems(lastQrPayload);
                } else {
                    itemsTable.innerHTML = `
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-red-500">Could not load items from the server.</td>
                        </tr>
                    `;
                }
            }
        }

        function fillModal(data) {
            lastQrPayload = data;
            currentGatepassNo = data.gatepass_no || null;
            document.getElementById('modalGatepassNo').textContent = data.gatepass_no || 'N/A';
            setStatusStyle(data.status);
            document.getElementById('modalRequestDate').textContent = data.request_date || 'N/A';
            document.getElementById('modalRequesterName').textContent = data.requester_name || 'N/A';
            document.getElementById('modalCenter').textContent = data.center || data.center_office || 'N/A';
            document.getElementById('modalPurpose').textContent = data.purpose || 'N/A';
            document.getElementById('modalDestination').textContent = data.destination || 'N/A';
            document.getElementById('modalRemarks').textContent = data.remarks || 'N/A';

            resetApprovalControls();

            if (currentGatepassNo) {
                refreshSelectedLogInfo();
                renderQrFallbackItems(data);
                void refreshGatepassItemsFromServer(currentGatepassNo, { showLoadingRow: false });
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
            clearSuccessOverlayTimer();
            hideSuccessOverlay();
            releaseScanPipeline();
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
            closeLogTypePicker();
        }

        startBtn.addEventListener('click', startScanner);
        stopBtn.addEventListener('click', stopScanner);
        closeScanModal.addEventListener('click', closeModal);

        confirmGatepassCheckbox.addEventListener('change', (e) => {
            if (approveGatepassBtn.dataset.submitted === '1' || requiresMissingItemsConfirmation) {
                return;
            }
            setApprovalEnabled(Boolean(e.target.checked));
        });

        confirmMissingItemsCheckbox.addEventListener('change', (e) => {
            if (approveGatepassBtn.dataset.submitted === '1') {
                return;
            }
            if (!requiresMissingItemsConfirmation) {
                setApprovalEnabled(confirmGatepassCheckbox.checked);
                return;
            }
            if (isCompletingPartialReturn) {
                return;
            }
            setApprovalEnabled(Boolean(e.target.checked));
        });

        confirmCompleteItemsCheckbox.addEventListener('change', (e) => {
            if (approveGatepassBtn.dataset.submitted === '1' || !isCompletingPartialReturn) {
                return;
            }
            setApprovalEnabled(Boolean(e.target.checked));
        });

        approveGatepassBtn.addEventListener('click', async () => {
            if (approveGatepassBtn.disabled) {
                return;
            }

            if (!currentGatepassNo) {
                showToast('Gatepass number is missing.', 'error');
                return;
            }

            if (!selectedLogType) {
                showToast('Please select a log type first.', 'error');
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
                        log_type: selectedLogType,
                        complete_partial: isCompletingPartialReturn,
                    }),
                });

                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    const msg = data?.message || 'Failed to record log.';
                    throw new Error(msg);
                }

                showToast(data?.message || 'Recorded successfully', 'success');

                refreshSelectedLogInfo();
                await refreshGatepassItemsFromServer(currentGatepassNo, { showLoadingRow: false });
                closeModal();
            } catch (e) {
                console.error(e);
                approveGatepassBtn.dataset.submitted = '0';
                if (requiresMissingItemsConfirmation) {
                    setApprovalEnabled(confirmMissingItemsCheckbox.checked);
                } else {
                    setApprovalEnabled(confirmGatepassCheckbox.checked);
                }
                showToast(e?.message || 'Something went wrong.', 'error');
            }
        });

        scanModal.addEventListener('click', function (e) {
            if (e.target === scanModal) {
                closeModal();
            }
        });

        function openRejectModal() {
            if (!currentGatepassNo) {
                showToast('No gatepass selected.', 'error');
                return;
            }
            rejectModalGatepassNo.textContent = 'Gatepass No: ' + currentGatepassNo;
            rejectModalError.classList.add('hidden');
            if (rejectReasonInput) {
                rejectReasonInput.value = '';
            }
            rejectModal.classList.remove('hidden');
            rejectModal.classList.add('flex');
        }

        function closeRejectModalFn() {
            rejectModal.classList.add('hidden');
            rejectModal.classList.remove('flex');
        }

        async function fetchPartialReturnModalItems() {
            partialReturnModalItemsTable.innerHTML = '';
            partialReturnModalNoItems.classList.add('hidden');
            partialReturnModalError.classList.add('hidden');

            try {
                const res = await fetch(`/guard/gatepass-items?gatepass_no=${encodeURIComponent(currentGatepassNo)}`, {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin',
                });
                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    partialReturnModalItemsTable.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-red-500">Failed to load items.</td></tr>';
                    partialReturnModalConfirmBtn.disabled = true;
                    return;
                }

                const items = data.items || [];
                if (items.length === 0) {
                    partialReturnModalNoItems.classList.remove('hidden');
                    partialReturnModalConfirmBtn.disabled = true;
                    return;
                }

                partialReturnModalConfirmBtn.disabled = false;
                partialReturnModalItemsTable.innerHTML = items.map(item => `
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <input type="checkbox" name="partial_missing_item" value="${item.gatepass_item_id}"
                                   aria-label="Mark as not yet returned"
                                   class="h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500"/>
                        </td>
                        <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(item.property_number || 'N/A')}</td>
                        <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(item.description || 'N/A')}</td>
                        <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(item.serial_no || 'N/A')}</td>
                        <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(item.remarks || 'N/A')}</td>
                    </tr>
                `).join('');
            } catch (e) {
                console.error(e);
                partialReturnModalItemsTable.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-red-500">Failed to load items.</td></tr>';
                partialReturnModalConfirmBtn.disabled = true;
            }
        }

        function openPartialReturnModal() {
            if (!currentGatepassNo) {
                showToast('No gatepass selected.', 'error');
                return;
            }
            const upper = String(selectedLogType ?? '').toUpperCase();
            if (upper !== 'INCOMING') {
                showToast('Partial return is only available for an incoming return scan.', 'error');
                return;
            }
            partialReturnModalGatepassNo.textContent = 'Gatepass No: ' + currentGatepassNo;
            partialReturnModalError.classList.add('hidden');
            if (partialReturnRemarks) {
                partialReturnRemarks.value = '';
            }
            partialReturnModal.classList.remove('hidden');
            partialReturnModal.classList.add('flex');
            void fetchPartialReturnModalItems();
        }

        function closePartialReturnModalFn() {
            partialReturnModal.classList.add('hidden');
            partialReturnModal.classList.remove('flex');
        }

        async function fetchCompleteReturnModalItems() {
            completeReturnModalItemsTable.innerHTML = '';
            completeReturnModalNoItems.classList.add('hidden');
            completeReturnModalError.classList.add('hidden');

            try {
                const res = await fetch(`/guard/gatepass-items?gatepass_no=${encodeURIComponent(currentGatepassNo)}`, {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin',
                });
                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    completeReturnModalItemsTable.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-red-500">Failed to load items.</td></tr>';
                    completeReturnModalConfirmBtn.disabled = true;
                    return;
                }

                const items = data.items || [];
                if (items.length === 0) {
                    completeReturnModalNoItems.classList.remove('hidden');
                    completeReturnModalConfirmBtn.disabled = true;
                    return;
                }

                completeReturnModalConfirmBtn.disabled = false;
                completeReturnModalItemsTable.innerHTML = items.map(item => `
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(item.property_number || 'N/A')}</td>
                        <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(item.description || 'N/A')}</td>
                        <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(item.serial_no || 'N/A')}</td>
                        <td class="px-4 py-3 text-[#173a6b]">${escapeHtml(item.remarks || 'N/A')}</td>
                        <td class="px-4 py-3">${itemStatusBadgeHtml(item.item_status)}</td>
                    </tr>
                `).join('');
            } catch (e) {
                console.error(e);
                completeReturnModalItemsTable.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-red-500">Failed to load items.</td></tr>';
                completeReturnModalConfirmBtn.disabled = true;
            }
        }

        function openCompleteReturnModal() {
            if (!currentGatepassNo) {
                showToast('No gatepass selected.', 'error');
                return;
            }
            if (String(currentGatepassStatus ?? '').toLowerCase() !== 'incoming partial') {
                showToast('Complete return is only available for partial gatepasses.', 'error');
                return;
            }

            completeReturnModalGatepassNo.textContent = 'Gatepass No: ' + currentGatepassNo;
            completeReturnModalError.classList.add('hidden');
            completeReturnModal.classList.remove('hidden');
            completeReturnModal.classList.add('flex');
            void fetchCompleteReturnModalItems();
        }

        function closeCompleteReturnModalFn() {
            completeReturnModal.classList.add('hidden');
            completeReturnModal.classList.remove('flex');
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        partialReturnBtn.addEventListener('click', openPartialReturnModal);
        completeReturnBtn.addEventListener('click', openCompleteReturnModal);
        closePartialReturnModal.addEventListener('click', closePartialReturnModalFn);
        partialReturnModalCancelBtn.addEventListener('click', closePartialReturnModalFn);
        closeCompleteReturnModal.addEventListener('click', closeCompleteReturnModalFn);
        completeReturnModalCancelBtn.addEventListener('click', closeCompleteReturnModalFn);

        partialReturnModal.addEventListener('click', function (e) {
            if (e.target === partialReturnModal) {
                closePartialReturnModalFn();
            }
        });

        completeReturnModal.addEventListener('click', function (e) {
            if (e.target === completeReturnModal) {
                closeCompleteReturnModalFn();
            }
        });

        pickOutgoingBtn.addEventListener('click', () => {
            if (!lastQrPayload) {
                showToast('No scanned gatepass found.', 'error');
                return;
            }

            selectedLogType = 'OUTGOING';
            closeLogTypePicker();
            fillModal(lastQrPayload);
            openModal();
        });

        pickIncomingBtn.addEventListener('click', () => {
            if (!lastQrPayload) {
                showToast('No scanned gatepass found.', 'error');
                return;
            }

            selectedLogType = 'INCOMING';
            closeLogTypePicker();
            fillModal(lastQrPayload);
            openModal();
        });

        partialReturnModalConfirmBtn.addEventListener('click', async () => {
            const checked = Array.from(document.querySelectorAll('#partialReturnModal input[name="partial_missing_item"]:checked'))
                .map(el => parseInt(el.value, 10))
                .filter(n => !isNaN(n));

            if (checked.length === 0) {
                partialReturnModalError.textContent = 'Please select the item(s) that were not returned.';
                partialReturnModalError.classList.remove('hidden');
                return;
            }

            partialReturnModalError.classList.add('hidden');
            partialReturnModalConfirmBtn.disabled = true;

            try {
                const res = await fetch('/guard/gatepass-partial-return', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken(),
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        gatepass_no: currentGatepassNo,
                        missing_item_ids: checked,
                        remarks: partialReturnRemarks ? partialReturnRemarks.value : '',
                    }),
                });

                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    throw new Error(data?.message || 'Failed to record partial return.');
                }

                showToast(data?.message || 'Partial return recorded.', 'success');
                closePartialReturnModalFn();
                await closeModal();
            } catch (e) {
                showToast(e?.message || 'Something went wrong.', 'error');
            } finally {
                partialReturnModalConfirmBtn.disabled = false;
            }
        });

        completeReturnModalConfirmBtn.addEventListener('click', () => {
            isCompletingPartialReturn = true;
            confirmMissingItemsCheckbox.checked = false;
            setMissingConfirmationDisabled(true);
            confirmCompleteItemsCheckbox.checked = false;
            confirmCompleteItemsRow.classList.remove('hidden');
            setApprovalEnabled(false);
            closeCompleteReturnModalFn();
        });

        rejectGatepassBtn.addEventListener('click', openRejectModal);
        closeRejectModal.addEventListener('click', closeRejectModalFn);
        rejectModalCancelBtn.addEventListener('click', closeRejectModalFn);

        rejectModal.addEventListener('click', function (e) {
            if (e.target === rejectModal) {
                closeRejectModalFn();
            }
        });

        rejectModalConfirmBtn.addEventListener('click', async () => {
            const reason = rejectReasonInput ? String(rejectReasonInput.value).trim() : '';

            if (!reason) {
                rejectModalError.textContent = 'Please enter a rejection reason.';
                rejectModalError.classList.remove('hidden');
                return;
            }

            rejectModalError.classList.add('hidden');
            rejectModalConfirmBtn.disabled = true;

            try {
                const res = await fetch('/guard/gatepass-reject', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken(),
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        gatepass_no: currentGatepassNo,
                        rejection_reason: reason,
                    }),
                });

                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    throw new Error(data?.message || 'Failed to reject gatepass.');
                }

                showToast(data?.message || 'Gatepass rejected successfully.', 'success');
                closeRejectModalFn();
                closeModal();
            } catch (e) {
                showToast(e?.message || 'Something went wrong.', 'error');
            } finally {
                rejectModalConfirmBtn.disabled = false;
            }
        });
    </script>
</body>
</html>