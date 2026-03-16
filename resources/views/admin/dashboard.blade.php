<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-[#f3f3f3] min-h-screen font-sans">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-[295px] bg-[#173a6b] text-white flex flex-col justify-between">
            <div>
                <!-- Logo / Title -->
                <div class="px-4 py-8 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <img src="/images/dap_logo.png" alt="DAP Logo" class="w-[56px] h-[56px] object-contain rounded-md">
                        <div>
                            <h1 class="text-[19px] font-bold leading-tight">DAP Equipment</h1>
                            <p class="text-[15px] text-white/90 mt-1">Logistics Division</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-3 py-10 space-y-3">
                    <button id="navDashboard" type="button" class="w-full flex items-center gap-4 bg-[#47698f] rounded-2xl px-6 py-4 text-[17px] font-semibold text-left text-white">
                        <i class="fa-solid fa-border-all text-[20px]"></i>
                        <span>Dashboard</span>
                    </button>

                    <button id="navItemTracking" type="button" class="w-full flex items-center gap-4 px-6 py-4 text-[17px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition text-left">
                        <i class="fa-solid fa-cubes-stacked text-[20px]"></i>
                        <span>Item Tracking</span>
                    </button>

                    <button type="button" class="w-full flex items-center gap-4 px-6 py-4 text-[17px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition text-left">
                        <i class="fa-regular fa-file-lines text-[20px]"></i>
                        <span>Reports</span>
                    </button>
                </nav>
            </div>

            <div class="px-6 py-8"></div>
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

            <!-- Header -->
            <header class="bg-[#f3f3f3] border-b border-black/10 px-10 py-7 flex items-start justify-between">
                <div>
                    <h2 id="pageTitle" class="text-[42px] font-bold text-black leading-none">Dashboard</h2>
                    <p id="pageSubtitle" class="text-[18px] text-[#3e5573] mt-2">Manage gate pass requests and approvals</p>
                </div>

                <button onclick="openAdminProfileModal()" class="w-[52px] h-[52px] rounded-full bg-[#003b95] text-white flex items-center justify-center text-[24px]">
                    <i class="fa-regular fa-user"></i>
                </button>
            </header>

            <!-- Content -->
            <section class="px-10 py-10">

                <!-- DASHBOARD SECTION -->
                <div id="dashboardSection">
                    <!-- Stat Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

                        <!-- Pending Approval -->
                        <div class="relative bg-white rounded-[20px] shadow-md px-7 py-7 overflow-hidden min-h-[136px]">
                            <div class="absolute -top-8 -right-8 w-[102px] h-[102px] bg-[#efe7d4] rounded-full"></div>
                            <div class="relative z-10 flex items-end justify-between">
                                <div>
                                    <p class="text-[18px] text-[#3e5573] mb-5">Pending Approval</p>
                                    <h3 class="text-[46px] font-bold text-[#003b95] leading-none">5</h3>
                                </div>
                                <div class="w-[48px] h-[48px] rounded-[14px] bg-[#f6b400] flex items-center justify-center text-white text-[22px]">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Approved -->
                        <div class="relative bg-white rounded-[20px] shadow-md px-7 py-7 overflow-hidden min-h-[136px]">
                            <div class="absolute -top-8 -right-8 w-[102px] h-[102px] bg-[#dce3ef] rounded-full"></div>
                            <div class="relative z-10 flex items-end justify-between">
                                <div>
                                    <p class="text-[18px] text-[#3e5573] mb-5">Approved</p>
                                    <h3 class="text-[46px] font-bold text-[#003b95] leading-none">5</h3>
                                </div>
                                <div class="w-[48px] h-[48px] rounded-[14px] bg-[#003b95] flex items-center justify-center text-white text-[22px]">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Active Outside -->
                        <div class="relative bg-white rounded-[20px] shadow-md px-7 py-7 overflow-hidden min-h-[136px]">
                            <div class="absolute -top-8 -right-8 w-[102px] h-[102px] bg-[#efe7d4] rounded-full"></div>
                            <div class="relative z-10 flex items-end justify-between">
                                <div>
                                    <p class="text-[18px] text-[#3e5573] mb-5">Active Outside</p>
                                    <h3 class="text-[46px] font-bold text-[#003b95] leading-none">5</h3>
                                </div>
                                <div class="w-[48px] h-[48px] rounded-[14px] bg-[#f6b400] flex items-center justify-center text-[#003b95] text-[22px]">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Requests -->
                        <div class="relative bg-white rounded-[20px] shadow-md px-7 py-7 overflow-hidden min-h-[136px]">
                            <div class="absolute -top-8 -right-8 w-[102px] h-[102px] bg-[#dce3ef] rounded-full"></div>
                            <div class="relative z-10 flex items-end justify-between">
                                <div>
                                    <p class="text-[18px] text-[#3e5573] mb-5">Total Requests</p>
                                    <h3 class="text-[46px] font-bold text-[#001d4f] leading-none">16</h3>
                                </div>
                                <div class="w-[48px] h-[48px] rounded-[14px] bg-[#f6b400] flex items-center justify-center text-[#003b95] text-[24px]">
                                    <i class="fa-regular fa-file-lines"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Dashboard Table -->
                    <div class="bg-white border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left px-8 py-6 text-[16px] font-semibold text-[#4b6790] uppercase">Gate Pass No</th>
                                        <th class="text-left px-8 py-6 text-[16px] font-semibold text-[#4b6790] uppercase">Employee</th>
                                        <th class="text-left px-8 py-6 text-[16px] font-semibold text-[#4b6790] uppercase">Center</th>
                                        <th class="text-left px-8 py-6 text-[16px] font-semibold text-[#4b6790] uppercase">Items</th>
                                        <th class="text-left px-8 py-6 text-[16px] font-semibold text-[#4b6790] uppercase">Request Date</th>
                                        <th class="text-left px-8 py-6 text-[16px] font-semibold text-[#4b6790] uppercase">Status</th>
                                        <th class="text-left px-8 py-6 text-[16px] font-semibold text-[#4b6790] uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- Example dynamic row (replace with $data later)

                                    @foreach($data as $request)
                                    <tr class="border-b border-gray-200">
                                        <td class="px-8 py-6">{{ $request->gate_pass_no }}</td>
                                        <td class="px-8 py-6">{{ $request->employee }}</td>
                                        <td class="px-8 py-6">{{ $request->office }}</td>
                                        <td class="px-8 py-6">{{ $request->items }}</td>
                                        <td class="px-8 py-6">{{ $request->request_date }}</td>
                                        <td class="px-8 py-6">
                                            <span class="px-4 py-2 rounded-full bg-gray-200 text-sm">
                                                {{ $request->status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 flex gap-2">
                                            <button class="bg-green-500 text-white px-3 py-2 rounded">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                            <button class="bg-red-500 text-white px-3 py-2 rounded">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach

                                    --}}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ITEM TRACKING SECTION -->
                <div id="itemTrackingSection" class="hidden">
                    <div class="bg-white border border-gray-200 overflow-hidden rounded-[22px]">

                        <!-- Search Bar -->
                        <div class="px-5 py-5 border-b border-gray-200">
                            <div class="relative w-full max-w-[540px]">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input
                                    type="text"
                                    placeholder="Search by Gate Pass No, Item, Serial No, Property No, Employee..."
                                    class="w-full h-[48px] rounded-2xl border border-gray-300 bg-white pl-12 pr-4 text-[16px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
                                >
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[1200px]">
                                <thead>
                                    <tr class="border-b border-gray-200 text-left">
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Gate Pass No</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Item Description</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Serial Number</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Employee</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Office</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Property Number</th>
                                        <th class="px-7 py-5 text-[15px] uppercase tracking-wide font-semibold text-[#556b86]">Status</th>
                                    </tr>
                                </thead>

                                <tbody id="itemTrackingTableBody">
                                    {{-- Dynamic rows will go here later --}}
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State -->
                        <div id="emptyItemTracking" class="py-16 text-center text-gray-400 text-[18px] border-t border-gray-100">
                            No tracked items yet.
                        </div>

                        <!-- Pagination Design -->
                        <div class="flex items-center justify-between px-7 py-5 border-t border-gray-200">
                            <p class="text-[16px] text-[#3e5573]">
                                Showing 0 to 0 of 0 results
                            </p>

                            <div class="flex items-center gap-2">
                                <button class="px-4 py-2 rounded-xl border border-gray-300 text-gray-400 bg-gray-50 text-[16px] font-medium">
                                    Previous
                                </button>

                                <button class="w-[40px] h-[40px] rounded-xl bg-[#020826] text-white text-[16px] font-semibold">
                                    1
                                </button>

                                <button class="w-[40px] h-[40px] rounded-xl border border-gray-300 bg-white text-[16px] font-medium">
                                    2
                                </button>

                                <button class="w-[40px] h-[40px] rounded-xl border border-gray-300 bg-white text-[16px] font-medium">
                                    3
                                </button>

                                <button class="px-4 py-2 rounded-xl border border-gray-300 bg-white text-[16px] font-medium">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </main>
    </div>

    <!-- Admin Profile Modal -->
    <div id="adminProfileModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[1150px] bg-white rounded-[18px] shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[26px] font-bold text-[#003b95]">Admin Profile</h2>
                <button type="button" onclick="closeAdminProfileModal()" class="text-[#98a2b3] hover:text-black text-[28px] leading-none">
                    ×
                </button>
            </div>

            <!-- Body -->
            <div class="px-7 py-6 max-h-[78vh] overflow-y-auto">
                <form class="space-y-8">

                    <!-- Profile Information -->
                    <div>
                        <h3 class="text-[18px] font-semibold text-[#003b95] mb-5">Profile Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Full Name
                                </label>
                                <input
                                    type="text"
                                    value="Admin User"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Center/Office
                                </label>
                                <input
                                    type="text"
                                    value="Logistics Division"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Email Address
                                </label>
                                <input
                                    type="email"
                                    value="admin@dap.com"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Upload Signature -->
                    <div>
                        <h3 class="text-[18px] font-semibold text-[#003b95] mb-5">Upload Signature</h3>

                        <div class="grid grid-cols-1 xl:grid-cols-[380px_1fr] gap-6 items-start">
                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Signature File
                                </label>

                                <label class="w-full min-h-[170px] rounded-2xl border-2 border-dashed border-gray-300 bg-[#fbfcfe] flex flex-col items-center justify-center text-center px-6 cursor-pointer hover:border-[#003b95] transition">
                                    <i class="fa-solid fa-signature text-[32px] text-[#98a2b3] mb-4"></i>
                                    <span class="text-[16px] font-semibold text-[#003b95]">Upload Signature</span>
                                    <span class="text-[13px] text-[#667085] mt-2">PNG, JPG, JPEG</span>
                                    <input type="file" class="hidden" accept=".png,.jpg,.jpeg">
                                </label>
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Signature Preview
                                </label>

                                <div class="w-full min-h-[170px] rounded-2xl border border-gray-200 bg-white flex items-center justify-center text-[#98a2b3] text-[15px]">
                                    No signature uploaded yet.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div>
                        <h3 class="text-[18px] font-semibold text-[#003b95] mb-5">Change Password</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Current Password
                                </label>
                                <input
                                    type="password"
                                    placeholder="Enter current password"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    New Password
                                </label>
                                <input
                                    type="password"
                                    placeholder="Enter new password"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Confirm New Password
                                </label>
                                <input
                                    type="password"
                                    placeholder="Confirm new password"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 pt-7 flex justify-end gap-4">
                        <button
                            type="button"
                            onclick="closeAdminProfileModal()"
                            class="px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[16px] font-semibold text-black hover:bg-gray-50 transition">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-10 h-[46px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold transition">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const navDashboard = document.getElementById('navDashboard');
        const navItemTracking = document.getElementById('navItemTracking');

        const dashboardSection = document.getElementById('dashboardSection');
        const itemTrackingSection = document.getElementById('itemTrackingSection');

        const pageTitle = document.getElementById('pageTitle');
        const pageSubtitle = document.getElementById('pageSubtitle');

        function activateAdminNav(activeButton, inactiveButton) {
            activeButton.classList.add('bg-[#47698f]', 'text-white');
            activeButton.classList.remove('text-white/90', 'hover:bg-white/10');

            inactiveButton.classList.remove('bg-[#47698f]', 'text-white');
            inactiveButton.classList.add('text-white/90', 'hover:bg-white/10');
        }

        function showDashboardSection() {
            dashboardSection.classList.remove('hidden');
            itemTrackingSection.classList.add('hidden');

            pageTitle.textContent = 'Dashboard';
            pageSubtitle.textContent = 'Manage gate pass requests and approvals';

            activateAdminNav(navDashboard, navItemTracking);
        }

        function showItemTrackingSection() {
            dashboardSection.classList.add('hidden');
            itemTrackingSection.classList.remove('hidden');

            pageTitle.textContent = 'Item Tracking';
            pageSubtitle.textContent = 'Track all items with gate passes';

            activateAdminNav(navItemTracking, navDashboard);
        }

        navDashboard.addEventListener('click', showDashboardSection);
        navItemTracking.addEventListener('click', showItemTrackingSection);

        function openAdminProfileModal() {
            const modal = document.getElementById('adminProfileModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeAdminProfileModal() {
            const modal = document.getElementById('adminProfileModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('adminProfileModal');
            if (e.target === modal) {
                closeAdminProfileModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            showDashboardSection();
        });
    </script>

</body>
</html>