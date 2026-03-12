<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-[#f3f3f3] min-h-screen font-sans">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-[302px] bg-[#173a6b] text-white flex flex-col justify-between">
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

                <!-- Back to Main Menu -->
                <div class="px-8 py-9 border-b border-white/10">
                    <a href="#" class="flex items-center gap-4 text-[18px] font-semibold text-white/90 hover:text-white transition">
                        <i class="fa-solid fa-arrow-left text-[22px]"></i>
                        <span>Back to Main Menu</span>
                    </a>
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
        <main class="flex-1 flex flex-col">

            <!-- Top Header -->
            <header class="bg-[#f3f3f3] border-b border-black/10 px-10 py-7 flex items-start justify-between">
                <div>
                    <h2 id="pageTitle" class="text-[40px] font-bold text-black leading-none">Dashboard</h2>
                    <p class="text-[20px] text-[#3e5573] mt-2">Welcome back, John Doe</p>
                </div>

                <div class="flex items-center gap-4">
                    <button
                        id="newRequestBtn"
                        type="button"
                        onclick="openRequestModal()"
                        class="bg-[#f6b400] hover:bg-[#e6a800] text-[#003b95] font-semibold text-[16px] px-8 py-3 rounded-2xl flex items-center gap-3 transition">
                        <i class="fa-solid fa-plus text-[18px]"></i>
                        <span>New Request</span>
                    </button>

                    <button class="w-[50px] h-[50px] rounded-full bg-[#003b95] text-white flex items-center justify-center text-[24px]">
                        <i class="fa-regular fa-user"></i>
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <section class="px-10 py-10">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-7">
                    <div class="bg-white rounded-[22px] border border-black/10 p-8 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-[5px] h-full bg-[#003b95]"></div>
                        <p class="text-[18px] text-[#556b86] mb-3">Total Requests</p>
                        <h3 class="text-[42px] font-bold text-[#003b95] leading-none">2</h3>
                    </div>

                    <div class="bg-white rounded-[22px] border border-black/10 p-8 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-[5px] h-full bg-[#f5b000]"></div>
                        <p class="text-[18px] text-[#556b86] mb-3">Pending</p>
                        <h3 class="text-[42px] font-bold text-[#f5b000] leading-none">0</h3>
                    </div>

                    <div class="bg-white rounded-[22px] border border-black/10 p-8 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-[5px] h-full bg-[#00b84f]"></div>
                        <p class="text-[18px] text-[#556b86] mb-3">Approved</p>
                        <h3 class="text-[42px] font-bold text-[#00b84f] leading-none">0</h3>
                    </div>

                    <div class="bg-white rounded-[22px] border border-black/10 p-8 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-[5px] h-full bg-[#ff5a00]"></div>
                        <p class="text-[18px] text-[#556b86] mb-3">Active Outside</p>
                        <h3 class="text-[42px] font-bold text-[#ff5a00] leading-none">1</h3>
                    </div>
                </div>

                <!-- Filter -->
                <div class="flex flex-wrap items-center gap-4 mb-7">
                    <div class="flex items-center gap-3 text-[#003b95] font-semibold text-[18px]">
                        <i class="fa-solid fa-filter text-[22px]"></i>
                        <span>Filter by Status:</span>
                    </div>

                    <button class="px-5 py-2.5 rounded-2xl bg-[#003b95] text-white text-[16px] font-semibold">
                        All
                    </button>

                    <button class="px-5 py-2.5 rounded-2xl border border-[#f5b000] text-[#f5b000] bg-white text-[16px] font-semibold">
                        Pending
                    </button>

                    <button class="px-5 py-2.5 rounded-2xl border border-[#00b84f] text-[#00b84f] bg-white text-[16px] font-semibold">
                        Approved
                    </button>

                    <button class="px-5 py-2.5 rounded-2xl border border-[#2962ff] text-[#2962ff] bg-white text-[16px] font-semibold">
                        Returned
                    </button>
                </div>

                <!-- My Requests Card Placeholder -->
                <div class="bg-white rounded-[22px] border border-black/10 min-h-[330px] px-8 py-8">
                    <h3 class="text-[22px] font-semibold text-[#003b95] mb-2">My Requests</h3>
                    <p class="text-[18px] text-[#6b7280] mb-10">2 requests found</p>

                    <!-- Dynamic content will go here later -->
                    <div class="h-[180px] flex items-center justify-center border border-dashed border-gray-300 rounded-2xl">
                        <p class="text-gray-400 text-[18px]">Dynamic request list will be placed here</p>
                    </div>
                </div>

                <!-- HISTORY SECTION -->
                <div id="historySection" class="hidden">
                    <div class="bg-white rounded-[20px] border border-gray-200 overflow-hidden">

                        <div class="px-8 py-6 border-b border-gray-200">
                            <h3 class="text-[22px] font-semibold text-[#003b95]">Request History</h3>
                        </div>

                        <div class="grid grid-cols-12 px-8 py-5 border-b border-gray-200 text-[15px] font-semibold text-[#425b78] uppercase tracking-wide">
                            <div class="col-span-2">Gate Pass No.</div>
                            <div class="col-span-6">Equipment</div>
                            <div class="col-span-2">Date</div>
                            <div class="col-span-2">Status</div>
                        </div>

                        <!-- Dynamic rows will go here later -->
                        <div id="historyList"></div>

                        <!-- Empty state for now -->
                        <div id="emptyHistory" class="py-16 text-center text-gray-400 text-[18px]">
                            No request history yet.
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Floating Help Button -->
    <button class="fixed bottom-4 right-4 w-[42px] h-[42px] rounded-full bg-[#2f2f2f] text-white shadow-lg flex items-center justify-center text-[20px]">
        ?
    </button>

    <!-- New Request Modal -->
    <div id="requestModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[385px] sm:max-w-[420px] bg-white rounded-[10px] shadow-2xl overflow-hidden">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-5 pt-4 pb-2">
                <h2 class="text-[14px] sm:text-[15px] font-semibold text-[#003b95]">New Gate Pass Request</h2>
                <button onclick="closeRequestModal()" class="text-gray-500 hover:text-black text-[18px] leading-none">
                    ×
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-5 pb-4 max-h-[85vh] overflow-y-auto">
                
                <!-- Top Grid -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-[12px] font-medium text-[#2b3d57] mb-1">
                            Gate Pass No. <span class="text-[#9aa8bd]">(Auto-generated)</span>
                        </label>
                        <input type="text" value="GP-2026-XXX" disabled
                            class="w-full h-[34px] rounded-md border border-gray-200 bg-gray-100 px-3 text-[12px] text-gray-400">
                    </div>

                    <div>
                        <label class="block text-[12px] font-medium text-[#2b3d57] mb-1">
                            Request Date <span class="text-[#9aa8bd]">(Auto-filled)</span>
                        </label>
                        <input type="text" value="03/12/2026"
                            class="w-full h-[34px] rounded-md border border-gray-300 bg-white px-3 text-[12px] text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-600">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-[12px] font-medium text-[#2b3d57] mb-1">
                            Estimated Return Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                            class="w-full h-[34px] rounded-md border border-gray-200 bg-gray-100 px-3 text-[12px] text-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-[12px] font-medium text-[#2b3d57] mb-1">
                            Center/Office <span class="text-[#9aa8bd]">(Auto-filled)</span>
                        </label>
                        <input type="text" value="Finance Department" disabled
                            class="w-full h-[34px] rounded-md border border-gray-200 bg-gray-100 px-3 text-[12px] text-gray-400">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-[12px] font-medium text-[#2b3d57] mb-1">
                        Name <span class="text-[#9aa8bd]">(Current User)</span>
                    </label>
                    <input type="text" value="John Doe" disabled
                        class="w-full h-[34px] rounded-md border border-gray-200 bg-gray-100 px-3 text-[12px] text-gray-400">
                </div>

                <div class="mb-3">
                    <label class="block text-[12px] font-medium text-[#2b3d57] mb-1">
                        Purpose <span class="text-red-500">*</span>
                    </label>
                    <input type="text" placeholder="Enter purpose..."
                        class="w-full h-[34px] rounded-md border border-gray-200 bg-gray-100 px-3 text-[12px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600">
                </div>

                <div class="mb-3">
                    <label class="block text-[12px] font-medium text-[#2b3d57] mb-1">
                        The items will be brought to <span class="text-red-500">*</span>
                    </label>
                    <input type="text" placeholder="Enter destination..."
                        class="w-full h-[34px] rounded-md border border-gray-200 bg-gray-100 px-3 text-[12px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600">
                </div>

                <div class="mb-2">
                    <label class="block text-[12px] font-medium text-[#2b3d57] mb-1">
                        Selected Equipment (0 items)
                    </label>

                    <div class="flex gap-2">
                        <select class="flex-1 h-[34px] rounded-md border border-gray-300 bg-white px-3 text-[12px] text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-600">
                            <option>Select Equipment</option>
                            <option>Laptop - Dell</option>
                            <option>Projector - Epson</option>
                            <option>Printer - HP</option>
                        </select>

                        <button type="button" class="h-[34px] px-4 rounded-md bg-[#003b95] text-white text-[12px] font-semibold hover:bg-[#002d73] flex items-center gap-2">
                            <i class="fa-solid fa-plus text-[11px]"></i>
                            Add
                        </button>
                    </div>
                </div>

                <div class="mb-3 border border-gray-200 rounded-md h-[64px] flex items-center justify-center text-[12px] text-gray-400 bg-white">
                    No equipment selected
                </div>

                <div class="mb-3">
                    <label class="block text-[12px] font-medium text-[#2b3d57] mb-1">
                        Remarks
                    </label>
                    <textarea rows="3" placeholder="Enter any additional notes or remarks..."
                        class="w-full rounded-md border border-gray-200 bg-gray-100 px-3 py-2 text-[12px] text-gray-700 placeholder:text-gray-400 resize-none focus:outline-none focus:ring-1 focus:ring-blue-600"></textarea>
                </div>

                <!-- Footer Buttons -->
                <div class="border-t border-gray-200 pt-3 flex gap-2">
                    <button type="button" onclick="closeRequestModal()" class="flex-1 h-[36px] rounded-md border border-gray-300 bg-white text-[12px] font-semibold text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>

                    <button type="button" class="flex-1 h-[36px] rounded-md bg-[#7f99c7] text-white text-[12px] font-semibold hover:bg-[#6f8bbc]">
                        Submit Request
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
        }

        navDashboard.addEventListener('click', showDashboardSection);
        navHistory.addEventListener('click', showHistorySection);


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

        window.addEventListener('click', function(e) {

            const modal = document.getElementById('requestModal');

            if (e.target === modal) {
                closeRequestModal();
            }

        });


        document.addEventListener('DOMContentLoaded', function () {
            showDashboardSection();
        });
    </script>

</body>

</html>