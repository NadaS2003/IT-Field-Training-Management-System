@extends('layouts.admin')
@section('content')
    <main class="flex-1 bg-[#f8fafc] min-h-screen  text-right" dir="rtl">

        <style>
            @keyframes progress {
                from { width: 100%; }
                to { width: 0%; }
            }
            .animate-progress {
                animation: progress 5s linear forwards;
            }
            .animate-slide-in {
                animation: slideIn 0.5s ease-out forwards;
            }
            @keyframes slideIn {
                from { transform: translateX(-100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        </style>
        <div class="fixed top-8 left-8 z-[100] flex flex-col gap-4 w-85 text-right">
            {{-- تنبيه الأخطاء: بظل أحمر خفيف وحواف ناعمة --}}
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="bg-white border-l-4 border-red-500 shadow-[0_15px_40px_rgba(239,68,68,0.1)] rounded-[1.5rem] p-5 flex items-center animate-slide-in relative overflow-hidden group border border-white">
                        <div class="bg-red-50 p-3 rounded-2xl ml-4">
                            <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] text-red-400 font-black uppercase tracking-widest mb-0.5">خطأ في التحديث</p>
                            <p class="text-sm text-gray-700 font-black leading-snug">{{ $error }}</p>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-gray-300 hover:text-red-500 transition-colors mr-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endforeach
            @endif

            @if (session('success'))
                <div id="success-toast" class="bg-white border-l-4 border-green-500 shadow-[0_15px_40px_rgba(34,197,94,0.1)] rounded-[1.5rem] p-5 flex items-center animate-slide-in relative overflow-hidden border border-white">
                    <div class="bg-green-50 p-3 rounded-2xl ml-4">
                        <i class="fas fa-check-double text-green-500 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] text-green-400 font-black uppercase tracking-widest mb-0.5">نجاح العملية</p>
                        <p class="text-sm text-gray-700 font-black leading-snug">{{ session('success') }}</p>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 bg-green-500 animate-progress"></div>
                </div>
            @endif
        </div>

        <header class="mb-10 px-2">
            <h1 class="text-2xl font-black text-gray-800 tracking-tight ">إدارة الطلبة</h1>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">عرض وإدارة كافة بيانات الطلاب المسجلين في النظام التعليمي بدقة واحترافية.</p>
        </header>

        <div class="bg-white p-5 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-white mb-8 flex items-center gap-5">

            <div class="relative">
                <button id="filterButton" class="px-6 h-14 bg-white border border-gray-100 text-gray-500 rounded-2xl hover:bg-gray-50 flex items-center justify-center gap-3 transition-all shadow-inner active:scale-95 group">
                    <i class="fas fa-sliders-h text-xs group-hover:text-blue-600"></i>
                    <span class="text-xs font-black">تصفية</span>
                </button>

                <div id="filterMenu" class="hidden absolute top-full mt-4 right-0 bg-white border border-white rounded-[2.5rem] p-8 shadow-[0_30px_70px_rgba(0,0,0,0.15)] w-80 z-50 transition-all transform origin-top-right">
                    <form method="GET" action="{{ route('admin.studentsManagement') }}" class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 mb-3 uppercase tracking-widest mr-2 ">التخصص الأكاديمي</label>
                            <select name="major" class="w-full bg-gray-50/50 px-5 py-3.5 rounded-2xl border border-gray-100 text-xs font-bold text-gray-700 shadow-inner focus:ring-4 focus:ring-blue-50/50 outline-none transition-all cursor-pointer">
                                <option value="">كل التخصصات</option>
                                @foreach($majors as $major)
                                    <option value="{{ $major }}" {{ request('major') == $major ? 'selected' : '' }}>{{ $major }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-[#0076df] text-white py-4 rounded-2xl font-black shadow-[0_12px_25px_rgba(0,118,223,0.3)] hover:bg-blue-700 transition-all text-xs active:scale-95">تطبيق الفلتر</button>
                    </form>
                </div>
            </div>

            <div class="relative flex-1 group">
                <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-500 transition-colors"></i>
                <form method="GET" action="{{ route('admin.studentsManagement') }}">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full bg-gray-50/50 pr-14 pl-6 py-4 rounded-2xl border border-gray-100 text-xs font-bold text-gray-700 shadow-inner focus:ring-4 focus:ring-blue-50/50 outline-none transition-all"
                           placeholder="ابحث عن اسم الطالب أو الرقم الجامعي...">
                </form>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                        <th class="px-8 py-7">الطالب</th>
                        <th class="px-8 py-7">الرقم الجامعي</th>
                        <th class="px-8 py-7 text-center">التخصص</th>
                        <th class="px-8 py-7 text-center">المعدل</th>
                        <th class="px-8 py-7 text-center">الجوال</th>
                        <th class="px-8 py-7 text-left">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($students as $student)
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="px-8 py-7">
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors">{{ $student->full_name }}</span>
                                    <span class="text-[10px] text-gray-400 font-black  mt-1">{{ $student->user->email }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                                <span class="text-xs font-bold text-gray-500 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100 shadow-inner ">{{ $student->university_id }}</span>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-tight">{{ $student->major }}</span>
                            </td>
                            <td class="px-8 py-7 text-center">
                            <span class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-xl text-[10px] font-black border border-blue-100 shadow-sm inline-flex items-center gap-1 ">
                                {{ $student->gpa }}%
                            </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <span class="text-xs text-gray-500 font-bold ">{{ $student->phone_number }}</span>
                            </td>
                            <td class="px-8 py-7 text-left">
                                <button onclick="openDeleteModal({{ $student->id }})" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-100 text-gray-300 hover:text-red-500 hover:border-red-100 hover:shadow-sm transition-all shadow-inner active:scale-90">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-24 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-inner">
                                    <i class="fas fa-users-slash text-gray-200 text-3xl"></i>
                                </div>
                                <p class="text-gray-400 font-black ">لا توجد بيانات طلاب متاحة حالياً.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 border-t border-gray-50 flex justify-between items-center bg-white">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]"> عرض <span class="text-gray-800 ">{{ $students->count() }}</span> من أصل <span class="text-gray-800 ">{{ $students->total() }}</span> طالب</p>
                @if($students->hasPages())
                    <div class="bg-gray-50/50 px-4 py-1 rounded-2xl shadow-inner border border-gray-100">
                        {{ $students->links('vendor.pagination.simple-tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </main>

    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm hidden">
        <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md text-center transform transition-all">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">هل أنت متأكد من الحذف؟</h2>
            <p class="text-gray-500 mb-8 px-4">لن تتمكن من استعادة بيانات هذا الطالب بعد إتمام هذه العملية.</p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3 px-4">
                    <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-xl font-bold hover:bg-red-700 transition-colors">تأكيد الحذف</button>
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-200 transition-colors">إلغاء</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(id) {
            document.getElementById('deleteForm').action = `/studentsManagement/${id}`;
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.querySelector('div').classList.replace('scale-95', 'scale-100'), 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.querySelector('div').classList.replace('scale-100', 'scale-95');
            setTimeout(() => modal.classList.add('hidden'), 150);
        }

        document.getElementById('filterButton').addEventListener('click', function (e) {
            e.stopPropagation();
            document.getElementById('filterMenu').classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            let filterMenu = document.getElementById('filterMenu');
            if (!filterMenu.contains(event.target)) {
                filterMenu.classList.add('hidden');
            }
        });
    </script>
@endsection
