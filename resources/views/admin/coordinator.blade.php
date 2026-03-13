<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Coordinator Dashboard</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-[#f5f5f5] min-h-screen font-sans">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-[248px] bg-[#173a6b] text-white flex flex-col">

            <!-- Top Section -->
            <div>
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
                    <button id="navDashboard" type="button"
                        class="w-full flex items-center gap-4 bg-[#47698f] rounded-2xl px-5 py-4 text-[16px] font-semibold text-left text-white">
                        <i class="fa-solid fa-border-all text-[18px]"></i>
                        <span>Dashboard</span>
                    </button>

                    <button id="navInventoryPortal" type="button"
                        class="w-full flex items-center gap-4 px-5 py-4 text-[16px] font-semibold text-left text-white/90 hover:bg-white/10 rounded-2xl transition">
                        <i class="fa-solid fa-cube text-[18px]"></i>
                        <span>Inventory Portal</span>
                    </button>
                </nav>
            </div>

            <!-- Logout Bottom -->
            <div class="mt-auto px-8 py-10 border-t border-white/10">
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
        <main class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="bg-[#f5f5f5] border-b border-black/10 px-8 py-6">
                <h2 id="pageTitle" class="text-[22px] md:text-[24px] font-bold text-black leading-none">Dashboard</h2>
                <p id="pageSubtitle" class="text-[14px] text-[#556b86] mt-2">List of Inventory</p>
            </header>

            <!-- Content -->
            <section class="px-8 py-7">

                <!-- DASHBOARD SECTION -->
                <div id="dashboardSection">
                    <!-- Stat Cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <button id="cardAccountable" type="button"
                            class="stat-card text-left bg-white border-2 border-[#2f73ff] rounded-[18px] px-6 py-6 min-h-[200px] transition">
                            <p class="text-[16px] text-[#556b86] mb-3">Accountable</p>
                            <h3 class="text-[28px] font-semibold text-black leading-none mb-10">45</h3>
                            <p class="text-[14px] text-[#556b86] mb-2">Equipment items</p>
                            <p class="text-[14px] text-[#1f54ff] font-medium">Click to view →</p>
                        </button>

                        <button id="cardUnaccountable" type="button"
                            class="stat-card text-left bg-white border border-gray-200 rounded-[18px] px-6 py-6 min-h-[200px] transition hover:border-[#2f73ff]">
                            <p class="text-[16px] text-[#556b86] mb-3">Unaccountable</p>
                            <h3 class="text-[28px] font-semibold text-black leading-none mb-10">23</h3>
                            <p class="text-[14px] text-[#556b86] mb-2">Equipment items</p>
                            <p class="text-[14px] text-[#ff5a00] font-medium">Click to view →</p>
                        </button>

                        <button id="cardTotal" type="button"
                            class="stat-card text-left bg-white border border-gray-200 rounded-[18px] px-6 py-6 min-h-[200px] transition hover:border-[#2f73ff]">
                            <p class="text-[16px] text-[#556b86] mb-3">Total Items</p>
                            <h3 class="text-[28px] font-semibold text-black leading-none mb-10">68</h3>
                            <p class="text-[14px] text-[#556b86] mb-2">In inventory</p>
                            <p class="text-[14px] text-[#00a63e] font-medium">Click to view →</p>
                        </button>
                    </div>

                    <!-- Table Card -->
                    <div class="bg-white border border-gray-200 rounded-[18px] overflow-hidden">
                        <div class="flex items-start justify-between px-6 py-6">
                            <div>
                                <h3 id="tableTitle" class="text-[17px] font-semibold text-black">Accountable Equipment</h3>
                                <p id="tableDescription" class="text-[14px] text-[#667085] mt-1">Showing 0 accountable items</p>
                            </div>

                            <button type="button"
                                class="flex items-center gap-3 border border-gray-300 rounded-xl px-5 py-2.5 text-[14px] font-medium text-black hover:bg-gray-50 transition">
                                <i class="fa-solid fa-xmark text-[16px]"></i>
                                <span>Close</span>
                            </button>
                        </div>

                        <div class="px-6">
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[1100px]">
                                    <thead>
                                        <tr class="bg-[#003b95] text-white text-left">
                                            <th class="px-4 py-4 text-[14px] font-semibold">#</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Property Number</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Description</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Assigned Employee</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Status</th>
                                            <th class="px-4 py-4 text-[14px] font-semibold">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tbodyAccountable" class="hidden">
                                    </tbody>

                                    <tbody id="tbodyUnaccountable" class="hidden">
                                    </tbody>

                                    <tbody id="tbodyTotal" class="hidden">
                                    </tbody>
                                </table>
                            </div>

                            <div id="emptyState" class="py-12 text-center text-[#98a2b3] text-[15px] border-b border-gray-200">
                                No inventory data available yet.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- INVENTORY PORTAL SECTION -->
                <div id="inventoryPortalSection" class="hidden">
                    <div class="bg-white border border-gray-200 rounded-[18px] overflow-hidden mb-6">
                        <div class="px-6 py-6">
                            <h3 class="text-[18px] font-bold text-black uppercase mb-7">Asset Inventory Management</h3>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-6 gap-y-5 mb-6">
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Employee Name</label>
                                    <select class="w-full h-[42px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none">
                                        <option>RAMOS, MICHAEL H.</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Empl. Status</label>
                                    <input type="text" value="COF" class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-[#667085] focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Employee No.</label>
                                    <input type="text" value="204298" class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-black focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Separation Date</label>
                                    <input type="text" value="N/A" class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-[#667085] focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Center</label>
                                    <input type="text" value="ICTD" class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-black focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Separation Mode</label>
                                    <input type="text" value="N/A" class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] text-[#667085] focus:outline-none">
                                </div>
                            </div>

                            <div class="mb-5">
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <input
                                        type="text"
                                        placeholder="Search by property number, description, or serial number..."
                                        class="w-full h-[42px] rounded-xl border border-gray-200 bg-gray-100 pl-11 pr-4 text-[14px] text-[#667085] placeholder:text-[#667085] focus:outline-none"
                                    >
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Accountability Filter</label>
                                    <select class="w-full h-[42px] rounded-xl border border-gray-300 bg-white px-4 text-[14px] text-black focus:outline-none">
                                        <option>All</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[14px] font-semibold text-black mb-2">Actions</label>
                                    <button class="w-full h-[42px] rounded-xl bg-[#f6b400] hover:bg-[#e5a900] text-[#003b95] font-semibold text-[16px] flex items-center justify-center gap-3 transition">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>Add Item</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-[18px] overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[1300px]">
                                <thead>
                                    <tr class="bg-[#003b95] text-white text-left">
                                        <th class="px-4 py-4 text-[14px] font-semibold">#</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Property Number</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Account Code</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Serial Number</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Description / Specification</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Assigned Employee</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Unit Price</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Status</th>
                                        <th class="px-4 py-4 text-[14px] font-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="inventoryPortalTableBody">
                                    {{-- Dynamic rows will go here later --}}
                                </tbody>
                            </table>
                        </div>

                        <div class="py-12 text-center text-[#98a2b3] text-[15px] border-t border-gray-200">
                            No inventory items available yet.
                        </div>
                    </div>
                </div>

            </section>
        </main>
    </div>

    <script>
        const navDashboard = document.getElementById('navDashboard');
        const navInventoryPortal = document.getElementById('navInventoryPortal');

        const dashboardSection = document.getElementById('dashboardSection');
        const inventoryPortalSection = document.getElementById('inventoryPortalSection');

        const pageTitle = document.getElementById('pageTitle');
        const pageSubtitle = document.getElementById('pageSubtitle');

        const cardAccountable = document.getElementById('cardAccountable');
        const cardUnaccountable = document.getElementById('cardUnaccountable');
        const cardTotal = document.getElementById('cardTotal');

        const tableTitle = document.getElementById('tableTitle');
        const tableDescription = document.getElementById('tableDescription');
        const tableFooterText = document.getElementById('tableFooterText');
        const emptyState = document.getElementById('emptyState');

        const tbodyAccountable = document.getElementById('tbodyAccountable');
        const tbodyUnaccountable = document.getElementById('tbodyUnaccountable');
        const tbodyTotal = document.getElementById('tbodyTotal');

        function activateSidebar(activeBtn, inactiveBtn) {
            activeBtn.classList.add('bg-[#47698f]', 'text-white');
            activeBtn.classList.remove('text-white/90', 'hover:bg-white/10');

            inactiveBtn.classList.remove('bg-[#47698f]', 'text-white');
            inactiveBtn.classList.add('text-white/90', 'hover:bg-white/10');
        }

        function resetCards() {
            [cardAccountable, cardUnaccountable, cardTotal].forEach(card => {
                card.classList.remove('border-2', 'border-[#2f73ff]');
                card.classList.add('border', 'border-gray-200');
            });
        }

        function hideAllTables() {
            tbodyAccountable.classList.add('hidden');
            tbodyUnaccountable.classList.add('hidden');
            tbodyTotal.classList.add('hidden');
        }

        function showEmptyState(message = 'No inventory data available yet.') {
            emptyState.textContent = message;
            emptyState.classList.remove('hidden');
        }

        function showDashboardSection() {
            dashboardSection.classList.remove('hidden');
            inventoryPortalSection.classList.add('hidden');

            pageTitle.textContent = 'Dashboard';
            pageSubtitle.textContent = 'List of Inventory';

            activateSidebar(navDashboard, navInventoryPortal);
            showAccountable();
        }

        function showInventoryPortalSection() {
            dashboardSection.classList.add('hidden');
            inventoryPortalSection.classList.remove('hidden');

            pageTitle.textContent = 'Inventory Portal';
            pageSubtitle.textContent = 'Manage all equipment inventory';

            activateSidebar(navInventoryPortal, navDashboard);
        }

        function showAccountable() {
            resetCards();
            hideAllTables();

            cardAccountable.classList.remove('border', 'border-gray-200');
            cardAccountable.classList.add('border-2', 'border-[#2f73ff]');
            tbodyAccountable.classList.remove('hidden');

            tableTitle.textContent = 'Accountable Equipment';
            tableDescription.textContent = 'Showing 0 accountable items';
            tableFooterText.textContent = 'Showing 0 to 0 of 0 items';

            showEmptyState('No accountable equipment available yet.');
        }

        function showUnaccountable() {
            resetCards();
            hideAllTables();

            cardUnaccountable.classList.remove('border', 'border-gray-200');
            cardUnaccountable.classList.add('border-2', 'border-[#2f73ff]');
            tbodyUnaccountable.classList.remove('hidden');

            tableTitle.textContent = 'Unaccountable Equipment';
            tableDescription.textContent = 'Showing 0 unaccountable items';
            tableFooterText.textContent = 'Showing 0 to 0 of 0 items';

            showEmptyState('No unaccountable equipment available yet.');
        }

        function showTotal() {
            resetCards();
            hideAllTables();

            cardTotal.classList.remove('border', 'border-gray-200');
            cardTotal.classList.add('border-2', 'border-[#2f73ff]');
            tbodyTotal.classList.remove('hidden');

            tableTitle.textContent = 'Total Inventory Items';
            tableDescription.textContent = 'Showing 0 total items';
            tableFooterText.textContent = 'Showing 0 to 0 of 0 items';

            showEmptyState('No inventory items available yet.');
        }

        navDashboard.addEventListener('click', showDashboardSection);
        navInventoryPortal.addEventListener('click', showInventoryPortalSection);

        cardAccountable.addEventListener('click', showAccountable);
        cardUnaccountable.addEventListener('click', showUnaccountable);
        cardTotal.addEventListener('click', showTotal);

        document.addEventListener('DOMContentLoaded', function () {
            showDashboardSection();
        });
    </script>

</body>
</html>