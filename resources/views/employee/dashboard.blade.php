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

    <div class="flex flex-col md:flex-row min-h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-full md:w-72 lg:w-80 bg-[#173a6b] text-white flex flex-col justify-between shrink-0 md:min-h-screen">
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
        <main class="flex-1 min-w-0 flex flex-col">

            <!-- Top Header -->
            <header class="bg-[#f3f3f3] border-b border-black/10 px-4 sm:px-6 lg:px-8 py-6 sm:py-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div class="min-w-0">
                    <h2 id="pageTitle" class="text-[30px] sm:text-[40px] font-bold text-black leading-none break-words">Dashboard</h2>
                    <p class="text-[16px] sm:text-[20px] text-[#3e5573] mt-2 break-words">Welcome back, {{ $employeeFullName ?? auth()->user()?->name }}</p>
                </div>

                <div class="flex flex-wrap items-center gap-4 sm:justify-end">
                    <button
                        id="newRequestBtn"
                        type="button"
                        onclick="openRequestModal()"
                        class="bg-[#f6b400] hover:bg-[#e6a800] text-[#003b95] font-semibold text-[16px] px-6 sm:px-8 py-3 rounded-2xl flex items-center gap-3 transition whitespace-nowrap">
                        <i class="fa-solid fa-plus text-[18px]"></i>
                        <span>New Request</span>
                    </button>

                    <button onclick="openProfileModal()" class="w-[50px] h-[50px] rounded-full bg-[#003b95] text-white flex items-center justify-center text-[24px]">
                        <i class="fa-regular fa-user"></i>
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <section class="w-full max-w-full min-w-0 px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
            <!-- DASHBOARD SECTION -->
            <div id="dashboardSection">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-7">
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

                <div class="flex flex-wrap items-center gap-4 mb-7">
                    <div class="flex items-center gap-3 text-[#003b95] font-semibold text-[18px]">
                        <i class="fa-solid fa-filter text-[22px]"></i>
                        <span>Filter by Status:</span>
                    </div>

                    <button class="px-5 py-2.5 rounded-2xl bg-[#003b95] text-white text-[16px] font-semibold whitespace-nowrap">
                        All
                    </button>

                    <button class="px-5 py-2.5 rounded-2xl border border-[#f5b000] text-[#f5b000] bg-white text-[16px] font-semibold whitespace-nowrap">
                        Pending
                    </button>

                    <button class="px-5 py-2.5 rounded-2xl border border-[#00b84f] text-[#00b84f] bg-white text-[16px] font-semibold whitespace-nowrap">
                        Approved
                    </button>

                    <button class="px-5 py-2.5 rounded-2xl border border-[#2962ff] text-[#2962ff] bg-white text-[16px] font-semibold whitespace-nowrap">
                        Returned
                    </button>
                </div>

                <div class="bg-white rounded-[22px] border border-black/10 min-h-[330px] px-5 sm:px-8 py-8">
                    <h3 class="text-[22px] font-semibold text-[#003b95] mb-2">My Requests</h3>
                    <p class="text-[18px] text-[#6b7280] mb-10">2 requests found</p>

                    <div class="h-[180px] flex items-center justify-center border border-dashed border-gray-300 rounded-2xl">
                        <p class="text-gray-400 text-[18px]">Dynamic request list will be placed here</p>
                    </div>
                </div>
            </div>

            <!-- HISTORY SECTION -->
            <div id="historySection" class="hidden">
                <div class="bg-white rounded-[20px] border border-gray-200 overflow-hidden">

                    <div class="px-5 sm:px-8 py-6 border-b border-gray-200">
                        <h3 class="text-[22px] font-semibold text-[#003b95]">Request History</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="grid min-w-[720px] grid-cols-12 px-5 sm:px-8 py-5 border-b border-gray-200 text-[15px] font-semibold text-[#425b78] uppercase tracking-wide">
                            <div class="col-span-2 whitespace-nowrap">Gate Pass No.</div>
                            <div class="col-span-6">Equipment</div>
                            <div class="col-span-2 whitespace-nowrap">Date</div>
                            <div class="col-span-2 whitespace-nowrap">Status</div>
                        </div>
                    </div>

                    <div id="historyList"></div>

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
        <div class="w-full max-w-[1280px] bg-white rounded-[18px] shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[26px] font-bold text-[#003b95]">New Gate Pass Request</h2>
                <button type="button" onclick="closeRequestModal()" class="text-[#98a2b3] hover:text-black text-[28px] leading-none">
                    ×
                </button>
            </div>

            <!-- Body -->
            <div class="px-7 py-6 max-h-[78vh] overflow-y-auto">
                <form class="space-y-6">

                    <!-- Top Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Gate Pass No.
                            </label>
                            <p class="text-[13px] text-[#667085] mb-2">(Auto-generated)</p>
                            <input
                                type="text"
                                value="GP-2026-XXX"
                                disabled
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-gray-400 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Name
                            </label>
                            <p class="text-[13px] text-[#667085] mb-2">(Current User)</p>
                            <input
                                type="text"
                                value="{{ $employeeFullName ?? auth()->user()?->name }}"
                                disabled
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-gray-400 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Request Date
                            </label>
                            <p class="text-[13px] text-[#667085] mb-2">(Auto-filled)</p>
                            <input
                                type="date"
                                value="2026-03-13"
                                class="w-full h-[46px] rounded-xl border border-blue-200 bg-[#f8fbff] px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Center/Office
                            </label>
                            <p class="text-[13px] text-[#667085] mb-2">(Auto-filled)</p>
                            <input
                                type="text"
                                value="{{ $employee?->center }}"
                                disabled
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-gray-400 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Estimated Return Date <span class="text-red-500">*</span>
                            </label>
                            <p class="text-[13px] text-transparent mb-2">.</p>
                            <input
                                type="date"
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-[14px] font-semibold text-[#243b5a] mb-1">
                                Purpose <span class="text-red-500">*</span>
                            </label>
                            <p class="text-[13px] text-transparent mb-2">.</p>
                            <input
                                type="text"
                                placeholder="Enter purpose..."
                                class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                        </div>
                    </div>

                    <!-- Destination + Equipment Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-[1fr_1fr_auto] gap-6 items-end">
                        <div>
                            <label class="block text-[16px] font-semibold text-[#243b5a] mb-3">
                                The items will be brought to <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                placeholder="Enter destination..."
                                class="w-full h-[48px] rounded-xl border border-gray-300 bg-white px-4 text-[16px] text-black placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-[16px] font-semibold text-[#243b5a] mb-3">
                                Selected Equipment ({{ ($equipment ?? collect())->count() }} items)
                            </label>
                            <select name="inventory_id" class="w-full h-[48px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-[#667085] focus:outline-none focus:ring-1 focus:ring-blue-500">
                                <option value="" selected>Select Equipment</option>
                                @foreach (($equipment ?? collect()) as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->current_prop_no ? $item->current_prop_no.' - ' : '' }}{{ $item->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button
                                type="button"
                                class="h-[48px] w-full md:w-auto px-7 rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold flex items-center justify-center gap-3 transition whitespace-nowrap">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add</span>
                            </button>
                        </div>
                    </div>

                    <!-- Empty Equipment Box -->
                    <div class="border border-gray-200 rounded-2xl bg-[#fbfcfe] h-[155px] flex items-center justify-center text-[18px] text-[#98a2b3]">
                        No equipment selected
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 pt-7 flex justify-end gap-4">
                        <button
                            type="button"
                            onclick="closeRequestModal()"
                            class="px-6 sm:px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[16px] font-semibold text-black hover:bg-gray-50 transition whitespace-nowrap">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-6 sm:px-10 h-[46px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold transition whitespace-nowrap">
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="fixed inset-0 bg-black/45 z-50 hidden items-center justify-center px-4 py-6">
        <div class="w-full max-w-[1100px] bg-white rounded-[18px] shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-7 py-6 border-b border-gray-200">
                <h2 class="text-[26px] font-bold text-[#003b95]">User Profile</h2>
                <button type="button" onclick="closeProfileModal()" class="text-[#98a2b3] hover:text-black text-[28px] leading-none">
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
                                    value="{{ $employeeFullName ?? auth()->user()?->name }}"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Center/Office
                                </label>
                                <input
                                    type="text"
                                    value="{{ $employee?->center }}"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-[14px] font-semibold text-[#243b5a] mb-3">
                                    Email Address
                                </label>
                                <input
                                    type="email"
                                    value="{{ auth()->user()?->email }}"
                                    class="w-full h-[46px] rounded-xl border border-gray-200 bg-gray-100 px-4 text-[16px] text-black focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
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
                            onclick="closeProfileModal()"
                            class="px-6 sm:px-10 h-[46px] rounded-xl border border-gray-300 bg-white text-[16px] font-semibold text-black hover:bg-gray-50 transition whitespace-nowrap">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-6 sm:px-10 h-[46px] rounded-xl bg-[#003b95] hover:bg-[#002d73] text-white text-[16px] font-semibold transition whitespace-nowrap">
                            Update Profile
                        </button>
                    </div>
                </form>
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
            const requestModal = document.getElementById('requestModal');
            const profileModal = document.getElementById('profileModal');

            if (requestModal && e.target === requestModal) {
                closeRequestModal();
            }

            if (profileModal && e.target === profileModal) {
                closeProfileModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            showDashboardSection();
        });

        function openProfileModal() {
            const modal = document.getElementById('profileModal');
            if (!modal) return;

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
    </script>

</body>

</html>