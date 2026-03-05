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
            <h1 class="text-2xl font-black text-gray-800 tracking-tight ">بيانات الطلبة المتدربين</h1>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">إدارة وتتبع مسار الطلاب الأكاديمي والمهني وتعيين المشرفين.</p>
        </header>

        <div class="bg-white p-5 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-white mb-8 flex flex-wrap md:flex-nowrap gap-5 items-center">
            <div class="relative flex-1 group">
                <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-500 transition-colors"></i>
                <form id="search-form" action="{{ route('admin.studentsData') }}" method="GET">
                    <input type="text" name="student_name" value="{{ request('student_name') }}"
                           class="w-full bg-gray-50/50 pr-14 pl-6 py-4 rounded-2xl border border-gray-100 text-xs font-bold text-gray-700 shadow-inner focus:ring-4 focus:ring-blue-50/50 outline-none transition-all"
                           placeholder="ابحث عن اسم الطالب أو الرقم الجامعي...">
                </form>
            </div>

            <button onclick="openModal()" class="bg-[#0076df] text-white px-8 py-4 rounded-2xl font-black text-xs shadow-[0_12px_25px_rgba(0,118,223,0.2)] hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95 flex items-center gap-3">
                <i class="fas fa-user-plus text-sm"></i> تعيين مشرف أكاديمي
            </button>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                        <th class="px-8 py-7">الطالب</th>
                        <th class="px-8 py-7 text-center">الرقم الجامعي</th>
                        <th class="px-8 py-7">التخصص / الفرصة</th>
                        <th class="px-8 py-7">جهة التدريب</th>
                        <th class="px-8 py-7 text-center">المشرف الأكاديمي</th>
                        <th class="px-8 py-7 text-left">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($studentsData as $student)
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="px-8 py-7">
                                <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors text-base">{{ $student->student_name }}</span>
                            </td>
                            <td class="px-8 py-7 text-center">
                            <span class="text-[10px] font-black text-gray-400 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100 shadow-inner ">
                                441029{{ $loop->index + 300 }}
                            </span>
                            </td>
                            <td class="px-8 py-7">
                            <span class="text-xs font-bold text-gray-600  underline decoration-blue-100 decoration-2 underline-offset-4">
                                {{ $student->internship_title }}
                            </span>
                            </td>
                            <td class="px-8 py-7">
                            <span class="text-[10px] font-black text-purple-600 bg-purple-50 px-3 py-1.5 rounded-xl border border-purple-100 shadow-sm">
                                {{ $student->company_name }}
                            </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @if($student->supervisor_name)
                                    <div class="flex flex-col items-center">
                                        <span class="text-xs font-black text-gray-700 ">{{ $student->supervisor_name }}</span>
                                        <span class="text-[8px] text-green-500 font-black uppercase mt-1">مُعيّن نشط</span>
                                    </div>
                                @else
                                    <span class="text-[10px] font-black text-gray-300 ">بانتظار التعيين</span>
                                @endif
                            </td>
                            <td class="px-8 py-7 text-left">
                                @if($student->supervisor_name)
                                    <button onclick="openModal()" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-100 text-gray-400 rounded-xl shadow-inner hover:text-blue-500 hover:border-blue-100 transition-all active:scale-90">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                @else
                                    <button onclick="openModal()" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl text-[10px] font-black hover:bg-blue-600 hover:text-white transition-all shadow-sm active:scale-95 border border-blue-100">
                                        <i class="fas fa-plus-circle ml-1"></i> إضافة مشرف
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-24 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-inner text-gray-200 text-3xl">
                                    <i class="fas fa-user-slash"></i>
                                </div>
                                <p class="text-gray-400 font-black ">لا توجد بيانات طلاب مطابقة للبحث.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 border-t border-gray-50 flex justify-between items-center bg-white">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]"> عرض <span class="text-gray-800 ">{{ $studentsData->count() }}</span> من أصل <span class="text-gray-800 ">{{ $studentsData->total() }}</span> طالب</p>

                @if($studentsData->hasPages())
                    <div class="bg-gray-50/50 px-4 py-1 rounded-2xl shadow-inner border border-gray-100">
                        {{ $studentsData->links('vendor.pagination.simple-tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </main>

    <div id="evaluationModal" class="fixed inset-0 flex items-center justify-center bg-gray-900/40 backdrop-blur-md hidden z-50 p-4">
        <div class="bg-white p-10 rounded-[3rem] shadow-[0_30px_80px_rgba(0,0,0,0.2)] w-full max-w-[500px] relative border border-white animate-in fade-in zoom-in duration-300">
            <button onclick="closeModal()" class="absolute top-8 left-8 w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 rounded-full hover:bg-red-50 hover:text-red-500 transition-all shadow-inner">
                <i class="fas fa-times text-sm"></i>
            </button>

            <div class="text-center mb-10">
                <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <i class="fas fa-user-tie text-3xl"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-800 ">تعيين <span class="text-blue-600">مشرف أكاديمي</span></h3>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">قم باختيار الطالب والمشرف المسؤول عنه</p>
            </div>

            <form action="{{ route('assign-supervisor') }}" method="POST" class="space-y-6">
                @csrf
                <div class="text-right">
                    <label class="block text-[10px] font-black text-gray-400 mb-3 uppercase tracking-widest mr-2  tracking-widest">اختر الطالب</label>
                    <select name="student_id" class="w-full bg-gray-50/50 px-6 py-4 rounded-2xl border border-gray-100 text-xs font-bold text-gray-700 shadow-inner outline-none focus:ring-4 focus:ring-blue-50/50 transition-all appearance-none cursor-pointer">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-right">
                    <label class="block text-[10px] font-black text-gray-400 mb-3 uppercase tracking-widest mr-2  tracking-widest">اختر المشرف</label>
                    <select name="supervisor_id" class="w-full bg-gray-50/50 px-6 py-4 rounded-2xl border border-gray-100 text-xs font-bold text-gray-700 shadow-inner outline-none focus:ring-4 focus:ring-blue-50/50 transition-all appearance-none cursor-pointer">
                        @foreach($supervisors as $supervisor)
                            <option value="{{ $supervisor->id }}">{{ $supervisor->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#0076df] text-white py-5 rounded-[2rem] font-black text-sm shadow-[0_15px_30px_rgba(0,118,223,0.3)] hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 mt-4 uppercase tracking-widest">
                    حفظ بيانات التعيين
                </button>
            </form>
        </div>
    </div>
    <script>
        function openModal() {
            document.getElementById("evaluationModal").classList.remove("hidden");
        }
        function closeModal() {
            document.getElementById("evaluationModal").classList.add("hidden");
        }
    </script>
@endsection
