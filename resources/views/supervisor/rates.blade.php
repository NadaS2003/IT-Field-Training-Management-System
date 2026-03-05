@extends('layouts.supervisor')
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
    <main class="p-8 bg-[#f8fafc] min-h-screen text-right " dir="rtl">

        <div class="flex justify-between items-center mb-10 px-2">
            <div class="text-right">
                <h1 class="text-3xl font-black text-gray-800 tracking-tight">سجل التقييمات</h1>
                <p class="text-gray-500 font-medium text-sm mt-1">إدارة النتائج النهائية واعتماد سجلات أداء الطلاب بدقة واحترافية.</p>
            </div>
            <div class="flex gap-4">
                <button onclick="openModal()" class="bg-[#0076df] text-white px-6 py-3.5 rounded-xl text-xs font-black shadow-[0_10px_25px_rgba(0,118,223,0.2)] flex items-center gap-2 hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95">
                    <i class="fas fa-plus text-[10px]"></i> إضافة تقييم
                </button>
                <button onclick="window.location='{{ route('supervisor.export.evaluations') }}'" class="bg-white text-gray-700 border border-white px-6 py-3.5 rounded-xl text-xs font-black shadow-[0_10px_30px_rgba(0,0,0,0.03)] flex items-center gap-2 hover:bg-gray-50 transition-all border border-gray-100/50">
                    <i class="fas fa-download text-[10px]"></i> تصدير التقرير
                </button>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white">
                <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                    <span class="w-2 h-7 bg-blue-600 rounded-full"></span> تفاصيل تقييم المتدربين
                </h3>
            </div>

            @if($students->isEmpty())
                <div class="p-24 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-inner">
                        <i class="fas fa-clipboard-list text-gray-200 text-3xl opacity-50"></i>
                    </div>
                    <p class="text-gray-400 font-black ">لا يوجد سجلات تقييم حالياً في النظام.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                        <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                            <th class="px-8 py-6">اسم الطالب</th>
                            <th class="px-8 py-6 text-right">جهة التدريب</th>
                            <th class="px-8 py-6 text-center">تاريخ التقييم</th>
                            <th class="px-8 py-6 text-left">نتيجة التقييم</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        @foreach($students as $student)
                            @php
                                $evaluation = $student->evaluations->first();
                                $finalStatus = $evaluation->final_evaluation ?? 'pending';
                            @endphp
                            <tr class="hover:bg-gray-50/40 transition-colors group">
                                <td class="px-8 py-7">
                                    <div class="flex flex-col">
                                        <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors">{{ $student->full_name }}</span>
                                        <span class="text-[10px] text-gray-400 font-black mt-1">ID: {{ $student->university_id }}</span>
                                    </div>
                                </td>

                                <td class="px-8 py-7">
                                <span class="text-sm font-bold text-gray-500 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100 shadow-sm">
                                    {{ $student->applications->where('status', 'مقبول')->first()->company->company_name ?? 'غير محدد' }}
                                </span>
                                </td>

                                <td class="px-8 py-7 text-center">
                                <span class="text-[11px] font-black text-gray-400 uppercase tracking-tight ">
                                    {{ $evaluation ? $evaluation->updated_at->translatedFormat('d M Y') : '-' }}
                                </span>
                                </td>

                                <td class="px-8 py-7 text-left">
                                    @if($finalStatus == 'pass')
                                        <span class="bg-green-50 text-green-600 border-green-100 px-4 py-1.5 rounded-xl text-[10px] font-black shadow-sm border inline-flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span> ناجح
                                    </span>
                                    @elseif($finalStatus == 'fail')
                                        <span class="bg-red-50 text-red-600 border-red-100 px-4 py-1.5 rounded-xl text-[10px] font-black shadow-sm border inline-flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span> راسب
                                    </span>
                                    @else
                                        <span class="bg-orange-50 text-orange-600 border-orange-100 px-4 py-1.5 rounded-xl text-[10px] font-black shadow-sm border inline-flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span> قيد المراجعة
                                    </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-8 bg-white border-t border-gray-50 flex items-center justify-between">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                        عرض <span class="text-gray-800 ">{{ $students->count() }}</span> من أصل <span class="text-gray-800 ">{{ $students->total() }}</span> طالب
                    </p>
                    @if($students->hasPages())
                        <div class="bg-gray-50/50 px-4 py-1 rounded-2xl shadow-inner border border-gray-100">
                            {{ $students->links('vendor.pagination.simple-tailwind') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

            <div id="evaluationModal" class="fixed inset-0 flex items-center justify-center bg-gray-900/40 backdrop-blur-md hidden z-50">
                <div class="bg-white rounded-[3rem] shadow-[0_30px_70px_rgba(0,0,0,0.2)] w-[450px] relative text-right overflow-hidden border border-white transition-all transform scale-100" dir="rtl">

                    <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-white">
                        <h3 class="text-lg font-black text-gray-800 flex items-center gap-3 ">
                            <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span> اعتماد النتيجة النهائية
                        </h3>
                        <button onclick="closeModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:text-red-500 transition-all shadow-inner border border-gray-100 active:scale-90">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>

                    <form action="{{ route('supervisor.rates.store') }}" method="POST" class="p-7">
                        @csrf

                        <div class="group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 mr-2 ">اختر المتدرب من القائمة</label>
                            <div class="relative bg-gray-50/50 p-5 rounded-[2rem] border border-gray-100 shadow-inner hover:bg-white hover:border-blue-100 transition-all cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-md border border-white overflow-hidden ring-4 ring-white/50">
                                        <i class="fas fa-user-graduate text-blue-500 text-lg"></i>
                                    </div>
                                    <div class="flex-1 flex flex-col relative">
                                        <div class="absolute left-0 top-1/2 -translate-y-1/2 text-blue-300 group-hover:text-blue-500 transition-colors">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>

                                        <select name="student_id" id="student_select"
                                                class="bg-transparent text-sm font-black text-gray-800 outline-none cursor-pointer appearance-none w-full pr-1"
                                                onchange="updateStudentInfo()">
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" data-uni="{{ $student->university_id }}">{{ $student->full_name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="uni_id_display" class="text-[9px] text-blue-500 font-black  mt-0.5">ID: {{ $students->first()->university_id ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 mr-2 ">النتيجة النهائية</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer group">
                                    <input type="radio" name="final_evaluation" value="pass" class="hidden peer" checked>
                                    <div class="flex flex-col items-center justify-center gap-2 p-5 rounded-[2.5rem] border-2 border-gray-50 bg-white text-gray-300 font-black transition-all peer-checked:border-green-500 peer-checked:text-green-600 peer-checked:bg-green-50/30 peer-checked:shadow-[0_10px_25px_rgba(34,197,94,0.1)] group-hover:bg-gray-50 shadow-sm border border-white">
                                        <i class="fas fa-check-circle text-xl"></i>
                                        <span class="text-xs">ناجح</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="final_evaluation" value="fail" class="hidden peer">
                                    <div class="flex flex-col items-center justify-center gap-2 p-5 rounded-[2.5rem] border-2 border-gray-50 bg-white text-gray-300 font-black transition-all peer-checked:border-red-500 peer-checked:text-red-600 peer-checked:bg-red-50/30 peer-checked:shadow-[0_10px_25px_rgba(239,68,68,0.1)] group-hover:bg-gray-50 shadow-sm border border-white">
                                        <i class="fas fa-times-circle text-xl"></i>
                                        <span class="text-xs">راسب</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-4">
                            <button type="submit" class="flex-1 bg-[#0076df] text-white py-5 rounded-2xl text-xs font-black shadow-[0_12px_25px_rgba(0,118,223,0.3)] hover:bg-blue-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-2 active:scale-95">
                                إعتماد الدرجة <i class="fas fa-paper-plane text-[9px]"></i>
                            </button>
                            <button type="button" onclick="closeModal()" class="px-6 py-5 rounded-2xl bg-gray-50 text-gray-400 text-xs font-black hover:bg-gray-100 transition-all shadow-inner border border-gray-100">
                                إلغاء
                            </button>
                        </div>
                    </form>
                </div>
            </div>    </main>    <script>
        function openModal() {
            const modal = document.getElementById('evaluationModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal() {
            const modal = document.getElementById('evaluationModal');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('evaluationModal');
            if (event.target === modal) {
                closeModal();
            }
        });

        function updateStudentInfo() {
            const select = document.getElementById('student_select');
            const display = document.getElementById('uni_id_display');
            const selectedOption = select.options[select.selectedIndex];
            display.innerText = "الرقم الجامعي: " + selectedOption.getAttribute('data-uni');
        }
    </script>
@endsection
