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
                    <a href="#" class="flex items-center gap-4 bg-[#47698f] rounded-2xl px-5 py-5 text-[18px] font-semibold">
                        <i class="fa-regular fa-file-lines text-[22px]"></i>
                        <span>Gate Pass Request</span>
                    </a>

                    <a href="#" class="flex items-center gap-4 px-5 py-4 text-[18px] font-semibold text-white/90 hover:bg-white/10 rounded-2xl transition">
                        <i class="fa-solid fa-clock-rotate-left text-[22px]"></i>
                        <span>Request History</span>
                    </a>
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
                    <h2 class="text-[40px] font-bold text-black leading-none">Dashboard</h2>
                    <p class="text-[20px] text-[#3e5573] mt-2">Welcome back, John Doe</p>
                </div>

                <div class="flex items-center gap-4">
                    <button class="bg-[#f6b400] hover:bg-[#e6a800] text-[#003b95] font-semibold text-[16px] px-8 py-3 rounded-2xl flex items-center gap-3 transition">
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

                <!-- Stats -->
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
            </section>
        </main>
    </div>

    <!-- Floating Help Button -->
    <button class="fixed bottom-4 right-4 w-[42px] h-[42px] rounded-full bg-[#2f2f2f] text-white shadow-lg flex items-center justify-center text-[20px]">
        ?
    </button>

</body>
</html>