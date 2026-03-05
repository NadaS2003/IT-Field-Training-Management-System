@extends('layouts.admin')
@section('content')
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

    <main class="flex-1 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        @if (session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 p-4 mb-6 rounded-2xl shadow-[0_10px_20px_rgba(0,0,0,0.02)] font-black text-xs flex items-center gap-3 animate-fade-in">
                <i class="fas fa-check-circle text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif

        <header class="mb-10 px-2">
            <h1 class="text-2xl font-black text-gray-800 tracking-tight ">إدارة المشرفين</h1>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">التحكم في بيانات الكادر الأكاديمي المسؤول عن متابعة التدريب الميداني.</p>
        </header>

        <div class="bg-white p-5 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-white mb-8 flex items-center gap-4">
            <form method="GET" action="{{ route('admin.supervisorsManagement') }}" class="relative group flex-1 max-w-md">
                <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-500 transition-colors"></i>
                <input type="text" name="search"
                       value="{{ request()->get('search') }}"
                       class="w-full bg-gray-50/50 pr-14 pl-6 py-4 rounded-2xl border border-gray-100 text-xs font-bold text-gray-700 shadow-inner focus:ring-4 focus:ring-blue-50/50 outline-none transition-all"
                       placeholder="ابحث عن اسم المشرف أو الرقم الوظيفي...">
            </form>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                        <th class="px-8 py-7">المشرف الأكاديمي</th>
                        <th class="px-8 py-7">الرقم الوظيفي</th>
                        <th class="px-8 py-7 text-center">القسم / التخصص</th>
                        <th class="px-8 py-7 text-center">بيانات التواصل</th>
                        <th class="px-8 py-7 text-left">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($supervisors as $supervisor)
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="px-8 py-7">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center shadow-sm border border-blue-100/50 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-user-tie text-blue-500 text-sm"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors">{{ $supervisor->full_name }}</span>
                                        <span class="text-[10px] text-gray-400 font-black  mt-0.5">{{ $supervisor->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                            <span class="text-xs font-bold text-blue-600 bg-blue-50/50 px-3 py-1 rounded-lg border border-blue-100/50 shadow-inner ">
                                #{{ $supervisor->employee_id }}
                            </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-tight bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100">
                                {{ $supervisor->department }}
                            </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                            <span class="text-xs text-gray-500 font-bold  inline-flex items-center gap-2">
                                <i class="fas fa-phone-alt text-[10px] text-gray-300"></i> {{ $supervisor->phone_number }}
                            </span>
                            </td>
                            <td class="px-8 py-7 text-left">
                                <button onclick="openDeleteModal({{ $supervisor->id }})" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-100 text-gray-300 hover:text-red-500 hover:border-red-100 hover:shadow-sm transition-all shadow-inner active:scale-90">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-inner">
                                    <i class="fas fa-user-shield text-gray-200 text-3xl"></i>
                                </div>
                                <p class="text-gray-400 font-black ">لا يوجد مشرفون مسجلون حالياً.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 border-t border-gray-50 flex justify-between items-center bg-white">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]"> عرض <span class="text-gray-800 ">{{ $supervisors->count() }}</span> من أصل <span class="text-gray-800 ">{{ $supervisors->total() }}</span> مشرف</p>

                @if($supervisors->hasPages())
                    <div class="bg-gray-50/50 px-4 py-1 rounded-2xl shadow-inner border border-gray-100">
                        {{ $supervisors->links('vendor.pagination.simple-tailwind') }}
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
            <p class="text-gray-500 mb-8 px-4">لن تتمكن من استعادة بيانات هذا المشرف بعد إتمام هذه العملية.</p>

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
            document.getElementById('deleteForm').action = `/supervisorsManagement/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endsection
