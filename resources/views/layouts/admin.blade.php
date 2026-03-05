<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة التدريب - لوحة التحكم</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/supervisor.css')}}">
    <style>
        body { font-family: 'Tajawal', sans-serif; background-color: #F8FAFC; }

        .nav-item-active {
            background-color: #1d4ed8 !important; /* Blue-700 */
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }
        .sub-item-active {
            background-color: #eff6ff !important; /* Blue-50 */
            color: #1d4ed8 !important;
            font-weight: 700;
        }

        .submenu-transition { transition: max-height 0.3s ease-out; overflow: hidden; }
        .rotate-180 { transform: rotate(180deg); }
        .hidden-submenu { display: none; }
    </style>
</head>
<body class="antialiased">

<div class="flex min-h-screen">

    <aside class="w-64 bg-white border-l border-gray-100 flex flex-col">
        <div class="p-6 flex items-center gap-3 mb-6">
            <div class="bg-blue-600 w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-lg">
                <i class="fa-solid fa-graduation-cap text-lg"></i>
            </div>
            <div>
                <h2 class="text-blue-600 font-bold text-xl leading-none">بوابة التدريب</h2>
                <span class="text-[10px] text-gray-400 uppercase tracking-widest">نظام التدريب الميداني</span>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" onclick="handleNavClick(this)" class="nav-item flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl transition {{ request()->routeIs('admin.dashboard')  ? 'nav-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                <i class="fas fa-home ml-3 "></i>
                <span class="text-sm font-medium">الرئيسية</span>
            </a>

            <div class="space-y-1">
                <button onclick="toggleSubmenu(this)" class="nav-item w-full flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl transition">
                    <i class="fas fa-users ml-3"></i>
                    <span class="text-sm font-medium">إدارة المستخدمين</span>
                    <i class="fas fa-chevron-down mr-auto text-[10px] opacity-80 submenu-arrow transition-transform"></i>
                </button>

                <div id="usersSubmenu" class="hidden-submenu relative mt-2 mr-6 space-y-1">
                    <div class="absolute right-[-24px] top-0 bottom-0 w-[2px] bg-blue-100 rounded-full"></div>

                    <a href="{{ route('admin.studentsManagement') }}" onclick="handleSubClick(this)" class="sub-item flex items-center px-4 py-3 text-gray-400 hover:text-blue-600 rounded-l-full transition-all {{ request()->routeIs('admin.studentsManagement')  ? 'sub-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                        <i class="fas fa-user-graduate ml-2 text-sm"></i>
                        <span class="text-sm font-medium">إدارة الطلبة</span>
                    </a>

                    <a href="{{ route('admin.companiesManagement') }}" onclick="handleSubClick(this)" class="sub-item flex items-center px-4 py-3 text-gray-400 hover:text-blue-600 rounded-l-full transition-all {{ request()->routeIs('admin.companiesManagement')  ? 'sub-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                        <i class="fas fa-building ml-2 text-sm"></i>
                        <span class="text-sm font-medium">إدارة الشركات</span>
                    </a>

                    <a href="{{ route('admin.supervisorsManagement') }}" onclick="handleSubClick(this)" class="sub-item flex items-center px-4 py-3 text-gray-400 hover:text-blue-600 rounded-l-full transition-all {{ request()->routeIs('admin.supervisorsManagement')  ? 'sub-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                        <i class="fas fa-user-shield ml-2 text-sm"></i>
                        <span class="text-sm font-medium">إدارة المشرفين</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.opportunitiesManagement') }}" onclick="handleNavClick(this)" class="nav-item flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl transition {{ request()->routeIs('admin.opportunitiesManagement')  ? 'nav-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                <i class="fas fa-briefcase ml-3 "></i>
                <span class="text-sm font-medium">إدارة الفرص التدريبية</span>
            </a>
            <a href="{{ route('admin.trainingRequests') }}" onclick="handleNavClick(this)" class="nav-item flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl transition {{ request()->routeIs('admin.trainingRequests')  ? 'nav-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                <i class="fas fa-clipboard-list ml-3 "></i>
                <span class="text-sm font-medium">إدارة طلبات التدريب</span>
            </a>
            <a href="{{ route('admin.studentsRate') }}" onclick="handleNavClick(this)" class="nav-item flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl transition {{ request()->routeIs('admin.studentsRate')  ? 'nav-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                <i class="fas fa-star ml-3 "></i>
                <span class="text-sm font-medium">إدارة تقييم الطلاب</span>
            </a>
            <a href="{{ route('admin.trainingBooks') }}" onclick="handleNavClick(this)" class="nav-item flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl transition {{ request()->routeIs('admin.trainingBooks')  ? 'nav-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                <i class="fas fa-book ml-3 "></i>
                <span class="text-sm font-medium">إدارة الكتب التدريبية</span>
            </a>
            <a href="{{ route('admin.audienceManagement') }}" onclick="handleNavClick(this)" class="nav-item flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl transition {{ request()->routeIs('admin.audienceManagement')  ? 'nav-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                <i class="fas fa-clipboard-check ml-3 "></i>
                <span class="text-sm font-medium">إدارة الحضور والغياب</span>
            </a>
            <a href="{{ route('admin.studentsData') }}" onclick="handleNavClick(this)" class="nav-item flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl transition {{ request()->routeIs('admin.studentsData')  ? 'nav-item-active' : 'text-gray-600 hover:bg-gray-50'}}">
                <i class="fas fa-user-graduate ml-3 "></i>
                <span class="text-sm font-medium">الطلاب المتدربين</span>
            </a>

        </nav>


        <div class="relative px-4 mb-4">
            <button type="button" id="userMenuButton" class="w-full p-4 bg-blue-50 rounded-2xl flex items-center gap-3 border border-blue-100 hover:bg-blue-100 transition-all cursor-pointer focus:outline-none">

                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=007bff&color=fff&bold=true"
                     alt="{{ auth()->user()->name }}"
                     class="w-10 h-10 rounded-full border-2 border-white shadow-sm pointer-events-none">

                <div class="text-right flex-1 pointer-events-none">
                    <h4 class="text-sm font-bold text-blue-900 leading-none">
                        {{ auth()->user()->name }}
                    </h4>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ auth()->user()->role == 'admin' ? 'مسؤول النظام' : 'مستخدم' }}
                    </p>
                </div>

                <i class="fas fa-chevron-up text-blue-300 text-xs transition-transform" id="userMenuArrow"></i>
            </button>

            <div id="logoutDropdown" class="absolute bottom-full left-4 right-4 mb-2 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden hidden transform transition-all duration-200 opacity-0 scale-95">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between px-4 py-4 text-red-600 hover:bg-red-50 transition-colors text-sm font-bold">
                        <span>تسجيل الخروج</span>
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col">
        <header class="w-full h-14 bg-white border-b border-gray-100 flex justify-end items-center px-10 sticky top-0 z-10 shadow-sm">
            <div class="relative mr-4" id="notifContainer">
                <button id="notifButton" class="relative p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all duration-300 focus:outline-none">
                    <i class="fa-regular fa-bell text-2xl"></i>
                    <span id="notifBadge"
                          class="absolute top-1.5 right-1.5 w-3 h-3 bg-red-500 rounded-full border-2 border-white {{ $notifications->whereNull('read_at')->count() > 0 ? '' : 'hidden' }}">
                        {{ $notifications->whereNull('read_at')->count() }}
                    </span>
                </button>

                <div id="notifDropdown" class="absolute left-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hidden transform opacity-0 scale-95 transition-all duration-200 z-50">
                    <div class="p-4 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                        <h4 class="font-bold text-gray-800 text-sm ">الإشعارات</h4>
                        @if($notifications->whereNull('read_at')->count() > 0)
                            <button id="markAsRead" class="text-xs text-blue-600 hover:underline font-black ">تحديد الكل كمقروء</button>
                        @endif
                    </div>

                    <div class="max-h-[400px] overflow-y-auto custom-scrollbar" id="notificationsContainer">
                        @forelse($notifications as $notification)
                            <div class="notification-item p-4 border-b border-gray-50 hover:bg-blue-50/30 transition-colors relative {{ is_null($notification->read_at) ? 'unread bg-blue-50/10' : '' }}" data-id="{{ $notification->id }}">
                                <div class="flex gap-3">
                                    <div class="icon-box w-10 h-10 {{ is_null($notification->read_at) ? 'bg-blue-600' : 'bg-gray-100' }} rounded-full flex items-center justify-center flex-shrink-0 transition-colors">
                                        <i class="fas fa-envelope-open text-xs {{ is_null($notification->read_at) ? 'text-white' : 'text-gray-400' }}"></i>
                                    </div>

                                    <div class="flex-1">
                                        <p class="notification-text text-sm {{ is_null($notification->read_at) ? 'text-gray-900 font-black ' : 'text-gray-600 font-medium' }} leading-snug mb-1">
                                            {{ $notification->data['message'] ?? 'إشعار جديد' }}
                                        </p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-[10px] text-gray-400 font-bold ">
                                                <i class="far fa-clock ml-1"></i>{{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if(is_null($notification->read_at))
                                    <div class="unread-dot absolute top-4 left-4 w-2 h-2 bg-blue-600 rounded-full"></div>
                                @endif
                            </div>
                        @empty
                            <div class="p-10 text-center text-gray-400  font-bold">لا توجد إشعارات حالياً</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </header>
        <div class="p-8">
            @yield('content')
        </div>
    </main>
</div>

<script>
    function handleNavClick(element) {
        clearAllActive();
        element.classList.add('nav-item-active');
    }

    function handleSubClick(element) {
        document.querySelectorAll('.sub-item').forEach(item => {
            item.classList.remove('sub-item-active');
        });
        element.classList.add('sub-item-active');

        const parentBtn = element.closest('.space-y-1').querySelector('button');
        handleNavClick(parentBtn);
    }

    function toggleSubmenu(button) {
        const submenu = document.getElementById('usersSubmenu');
        const arrow = button.querySelector('.submenu-arrow');

        const isHidden = submenu.style.display === "none" || submenu.style.display === "";

        if (isHidden) {
            submenu.style.display = "block";
            arrow.classList.add('rotate-180');
            handleNavClick(button);
        } else {
            submenu.style.display = "none";
            arrow.classList.remove('rotate-180');
        }
    }

    function clearAllActive() {
        document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('nav-item-active'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('userMenuButton');
        const dropdown = document.getElementById('logoutDropdown');
        const arrow = document.getElementById('userMenuArrow');

        button.addEventListener('click', function(e) {
            e.stopPropagation();

            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                setTimeout(() => {
                    dropdown.classList.remove('opacity-0', 'scale-95');
                    dropdown.classList.add('opacity-100', 'scale-100');
                }, 10);
                arrow.style.transform = 'rotate(180deg)';
            } else {
                hideDropdown();
            }
        });

        document.addEventListener('click', function(event) {
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                hideDropdown();
            }
        });

        function hideDropdown() {
            dropdown.classList.add('opacity-0', 'scale-95');
            dropdown.classList.remove('opacity-100', 'scale-100');
            arrow.style.transform = 'rotate(0deg)';
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }
    });
    document.addEventListener("DOMContentLoaded", function () {
        const notifButton = document.getElementById("notifButton");
        const notifDropdown = document.getElementById("notifDropdown");
        const markAsReadButton = document.getElementById('markAsRead');
        const notifBadge = document.getElementById("notifBadge");

        notifButton.addEventListener("click", function (event) {
            event.stopPropagation();
            const isHidden = notifDropdown.classList.contains('hidden');
            if (isHidden) {
                notifDropdown.classList.remove('hidden');
                setTimeout(() => {
                    notifDropdown.classList.remove('opacity-0', 'scale-95');
                    notifDropdown.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                hideDropdown();
            }
        });

        document.addEventListener("click", function (e) {
            if (!document.getElementById('notifContainer').contains(e.target)) {
                hideDropdown();
            }
        });

        function hideDropdown() {
            notifDropdown.classList.add('opacity-0', 'scale-95');
            notifDropdown.classList.remove('opacity-100', 'scale-100');
            setTimeout(() => notifDropdown.classList.add('hidden'), 200);
        }

        if (markAsReadButton) {
            markAsReadButton.addEventListener('click', function () {
                const unreadElements = document.querySelectorAll('.notification-item.unread');
                const ids = Array.from(unreadElements).map(el => el.getAttribute('data-id'));

                if (ids.length === 0) return;

                fetch("{{ route('notifications.markAllRead') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ notifications: ids })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if(notifBadge) notifBadge.classList.add('hidden');

                            unreadElements.forEach(item => {
                                item.classList.remove('unread', 'bg-blue-50/10');
                                const dot = item.querySelector('.unread-dot');
                                if(dot) dot.remove();

                                const text = item.querySelector('.notification-text');
                                if(text) text.classList.replace('text-gray-900', 'text-gray-600');
                                if(text) text.classList.remove('font-black', 'italic');
                            });

                            markAsReadButton.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    });
</script>

</body>
</html>
