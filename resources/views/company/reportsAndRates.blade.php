@extends('layouts.company')
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

        {{-- تنبيه النجاح: بظل أخضر خفيف --}}
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
    <main class="flex-1 p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        {{-- هيدر الصفحة --}}
        <div class="flex justify-between items-end mb-10 animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="text-right">
                <h1 class="text-3xl font-black text-gray-800 tracking-tight">سجلات أداء المتدربين</h1>
                <p class="text-[11px] text-gray-400 font-black uppercase tracking-[0.2em] mt-1">متابعة دقيقة للتقييمات الأسبوعية، الحضور، والكتيبات</p>
            </div>
            <div class="flex gap-3">
                <button onclick="openModal('choiceModal')" class="bg-[#0076df] text-white px-8 py-3 rounded-2xl font-black shadow-xl shadow-blue-100 flex items-center gap-2 text-xs transition hover:bg-blue-700 hover:-translate-y-1">
                    <i class="fas fa-plus-circle"></i> إضافة تقييمات
                </button>
                <button onclick="openModal('uploadModal')" class="bg-blue-50 text-blue-600 px-8 py-3 rounded-2xl font-black flex items-center gap-2 text-xs transition hover:bg-blue-100 border border-blue-100 shadow-sm">
                    <i class="fas fa-file-upload"></i> رفع الكتاب
                </button>
                <button onclick="openModal('exportChoiceModal')" class="bg-white border border-gray-100 text-gray-500 px-8 py-3 rounded-2xl font-black flex items-center gap-2 text-xs transition hover:bg-gray-50 shadow-sm">
                    <i class="fas fa-download"></i> تصدير التقارير
                </button>
            </div>
        </div>

        {{-- عرض سجلات الطلاب --}}
        <div class="space-y-8">
            @forelse($students as $student)
                <div class="bg-white rounded-[2.5rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white flex items-start justify-between relative overflow-hidden group hover:shadow-lg transition-all">
                    <div class="flex-1">
                        <div class="flex items-center gap-5 mb-10">
                            <div class="w-16 h-16 bg-blue-50 text-[#0076df] rounded-[1.5rem] flex items-center justify-center shadow-inner border border-blue-100/50">
                                <i class="far fa-user text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-800 mb-1 leading-tight">{{ $student->full_name }}</h3>
                                <span class="text-[10px] bg-gray-50 text-[#0076df] px-4 py-1.5 rounded-xl font-black border border-gray-100 uppercase">{{ $student->major }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                            <div class="space-y-6">
                                <div class="flex items-center gap-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span> التقييمات الأسبوعية
                                </div>
                                <div class="flex gap-4">
                                    @foreach($weeks as $week)
                                        @php $eval = $evaluations->where('student_id', $student->id)->where('week_name', $week)->first(); @endphp
                                        <div class="flex-1 p-5 rounded-[1.5rem] border transition-all cursor-pointer shadow-sm {{ $eval ? 'bg-blue-50 border-blue-100' : 'bg-gray-50 border-gray-100 opacity-50' }}">
                                            <p class="text-[10px] font-black text-gray-400 mb-2">{{ $week }}</p>
                                            <p class="text-lg font-black text-[#0076df]">{{ $eval->evaluation ?? '—' }}<span class="text-[10px] text-gray-400">/10</span></p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="flex items-center gap-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">
                                    <i class="far fa-calendar-check text-green-500"></i> الحضور (آخر 10 أيام)
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    @php $studentAtt = $attendanceData->where('student_id', $student->id)->take(10); @endphp
                                    @foreach($studentAtt as $att)
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-[11px] font-black shadow-sm {{ $att->status == 'حاضر' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                            {{ $loop->iteration }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pr-10 border-r border-gray-100 flex flex-col justify-center items-end h-full">
                        @php
                            $studentEval = \App\Models\Evaluation::query()
                                ->where('student_id', $student->id)
                                ->whereNotNull('evaluation_letter')
                                ->first();
                        @endphp

                        @if($studentEval)
                            <a href="{{ asset('storage/' . $studentEval->evaluation_letter) }}"
                               target="_blank"
                               class="flex items-center gap-4 bg-gray-50/50 hover:bg-blue-50/50 px-5 py-3 rounded-2xl border border-gray-100 hover:border-blue-100 transition-all group/btn no-underline">

                                <div class="text-right">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tight mb-0">كتاب التدريب</p>
                                    <p class="text-xs font-bold text-gray-600 group-hover:text-blue-600 transition-colors">عرض الملف</p>
                                </div>

                                <div class="w-9 h-9 bg-white rounded-xl flex items-center justify-center text-gray-400 group-hover:text-blue-500 shadow-sm border border-gray-50 transition-all">
                                    @if(Str::endsWith($studentEval->evaluation_letter, '.pdf'))
                                        <i class="far fa-file-pdf text-lg"></i>
                                    @else
                                        <i class="far fa-file-word text-lg"></i>
                                    @endif
                                </div>
                            </a>
                        @else
                            <div class="flex items-center gap-3 opacity-40 select-none">
                                <span class="text-[10px] font-medium text-gray-400 ">بانتظار رفع الكتاب</span>
                                <div class="w-8 h-8 rounded-lg border border-dashed border-gray-300 flex items-center justify-center text-gray-300">
                                    <i class="fas fa-minus text-[10px]"></i>
                                </div>
                            </div>
                        @endif
                    </div>                </div>
            @empty
                {{-- حالة الفراغ --}}
            @endforelse
        </div>
    </main>

    {{-- ============================== الـ MODALS (الفورمات) ============================== --}}

    {{-- 1. Modal الاختيار الأول --}}
    <div id="choiceModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/60 backdrop-blur-md hidden p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-[500px] overflow-hidden border border-white text-right animate-in zoom-in-95 duration-300" dir="rtl">
            <div class="bg-[#0076df] p-8 text-white text-center">
                <h3 class="text-xl font-black ">ماذا تريد أن تضيف اليوم؟</h3>
            </div>
            <div class="p-10 grid grid-cols-2 gap-6">
                <button onclick="closeModal('choiceModal'); openModal('attendanceModal')" class="flex flex-col items-center gap-5 p-8 rounded-[2rem] border-2 border-gray-50 bg-gray-50 hover:border-blue-200 hover:bg-blue-50 transition-all group">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-check text-[#0076df] text-2xl"></i>
                    </div>
                    <span class="text-sm font-black text-gray-700">الحضور والغياب</span>
                </button>
                <button onclick="closeModal('choiceModal'); openModal('evaluationModal')" class="flex flex-col items-center gap-5 p-8 rounded-[2rem] border-2 border-gray-50 bg-white hover:border-blue-200 hover:bg-blue-50 transition-all group shadow-sm">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-star text-[#0076df] text-2xl"></i>
                    </div>
                    <span class="text-sm font-black text-gray-700">التقييم الأسبوعي</span>
                </button>
            </div>
            <div class="bg-gray-50 p-6 text-center">
                <button onclick="closeModal('choiceModal')" class="text-xs font-black text-gray-400 hover:text-red-500 transition-colors">إلغاء الأمر</button>
            </div>
        </div>
    </div>

    {{-- 2. فورم الحضور والغياب --}}
    <div id="attendanceModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-900/60 backdrop-blur-md hidden p-4">
        <div class="bg-white rounded-[2.5rem] shadow-[0_30px_70px_rgba(0,0,0,0.2)] w-full max-w-[600px] overflow-hidden border border-white transition-all text-right animate-in zoom-in-95 duration-300" dir="rtl">
            <div class="bg-[#0076df] p-10 flex justify-between items-center text-white relative">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-white/10 rounded-[1.5rem] flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-user-check text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-black tracking-tight">إضافة الحضور والغياب</h3>
                </div>
                <button onclick="closeModal('attendanceModal')" class="text-3xl font-light hover:opacity-70 transition-opacity">×</button>
            </div>

            <form action="{{ route('attendance.store') }}" method="POST" class="p-10 space-y-10">
                @csrf
                <div class="grid grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-gray-800 mr-2 uppercase tracking-wider">اسم المتدرب</label>
                        <select name="student_id" class="w-full bg-gray-50 border border-gray-100 rounded-[1.2rem] p-4 text-sm font-black text-gray-700 focus:ring-4 focus:ring-blue-100 outline-none transition shadow-inner" required>
                            <option value="" hidden>اختر من القائمة...</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-gray-800 mr-2 uppercase tracking-wider">التاريخ الفعلي</label>
                        <input type="date" name="attendance_date" class="w-full bg-gray-50 border border-gray-100 rounded-[1.2rem] p-4 text-sm font-black text-gray-700 focus:ring-4 focus:ring-blue-100 outline-none transition shadow-inner" required>
                    </div>
                </div>

                <div class="space-y-5">
                    <label class="text-[11px] font-black text-gray-800 mr-2 uppercase tracking-wider">الحالة اليومية</label>
                    <div class="flex p-2 bg-gray-50 rounded-[1.5rem] border border-gray-100 gap-3 shadow-inner">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="attendance_status" value="حاضر" class="hidden peer" checked>
                            <div class="py-4 text-center rounded-[1.2rem] text-xs font-black transition-all peer-checked:bg-[#0076df] peer-checked:text-white text-gray-400 group-hover:bg-gray-100">حاضر (Present)</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="attendance_status" value="غائب" class="hidden peer">
                            <div class="py-4 text-center rounded-[1.2rem] text-xs font-black transition-all peer-checked:bg-red-500 peer-checked:text-white text-gray-400 group-hover:bg-gray-100">غائب (Absent)</div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-6">
                    <button type="submit" class="bg-[#0076df] text-white px-12 py-4 rounded-[1.5rem] font-black shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all hover:-translate-y-1">اعتماد السجل</button>
                    <button type="button" onclick="closeModal('attendanceModal')" class="text-gray-400 font-black hover:text-red-500 transition-colors">إلغاء</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 3. فورم التقييم الأسبوعي --}}
    <div id="evaluationModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-900/60 backdrop-blur-md hidden p-4">
        <div class="bg-white rounded-[2.5rem] shadow-[0_30px_70px_rgba(0,0,0,0.2)] w-full max-w-[650px] overflow-hidden border border-white transition-all text-right animate-in zoom-in-95 duration-300" dir="rtl">

            <div class="bg-[#0076df] p-10 flex justify-between items-center text-white">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-white/20 rounded-[1.5rem] flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                        <i class="fas fa-star text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-black tracking-tight">التقييم الأسبوعي</h3>
                </div>
                <button onclick="closeModal('evaluationModal')" class="text-3xl font-light hover:opacity-70 transition-opacity">×</button>
            </div>

            <form action="{{ route('weekly_evaluations.store') }}" method="POST" class="p-10 space-y-8" onsubmit="return validateWeekSelection()">
                @csrf

                <div class="space-y-3">
                    <label class="text-[11px] font-black text-gray-800 mr-2 uppercase">اسم المتدرب</label>
                    <select name="student_id" class="w-full bg-gray-50 border border-gray-100 rounded-[1.2rem] p-4 text-sm font-black text-gray-700 shadow-inner outline-none focus:ring-4 focus:ring-blue-50" required>
                        <option value="" hidden>اختر المتدرب...</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-gray-800 mr-2 uppercase">الأسبوع الدراسي</label>
                        <select id="weekSelect" name="week_name" onchange="toggleWeekInput()" class="w-full bg-gray-50 border border-gray-100 rounded-[1.2rem] p-4 text-sm font-black text-gray-700 shadow-inner outline-none focus:ring-4 focus:ring-blue-50" required>
                            <option value="" hidden>اختر الأسبوع...</option>
                            @foreach($weeks as $week)
                                <option value="{{ $week }}">{{ $week }}</option>
                            @endforeach
                            <option value="new" class="text-blue-600 font-bold">+ إضافة أسبوع جديد...</option>
                        </select>
                    </div>

                    <div id="newWeekDiv" class="space-y-3 hidden animate-in fade-in slide-in-from-right-2">
                        <label class="text-[11px] font-black text-blue-600 mr-2 uppercase italic">أدخل اسم الأسبوع الجديد</label>
                        <input type="text" id="newWeekInput" name="new_week_name" placeholder="مثلاً: الأسبوع الخامس" class="w-full bg-blue-50 border border-blue-100 rounded-[1.2rem] p-4 text-sm font-black text-blue-700 placeholder-blue-300 shadow-inner outline-none focus:ring-4 focus:ring-blue-100">
                    </div>
                </div>

                <div class="space-y-6">
                    <label class="text-[11px] font-black text-gray-800 mr-2 uppercase">درجة التقييم (من 10)</label>
                    <div class="flex justify-between items-center bg-gray-50 p-6 rounded-[2rem] border border-gray-100 shadow-inner">
                        @for ($i = 1; $i <= 10; $i++)
                            <label class="relative group">
                                <input type="radio" name="evaluation" value="{{ $i }}" class="hidden peer" required @if($i == 8) checked @endif>
                                <div class="w-10 h-10 flex items-center justify-center rounded-xl text-[11px] font-black cursor-pointer transition-all text-gray-400 bg-white border border-gray-100 shadow-sm peer-checked:bg-[#0076df] peer-checked:text-white peer-checked:scale-125 peer-checked:shadow-xl hover:border-blue-300">
                                    {{ $i }}
                                </div>
                            </label>
                        @endfor
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4">
                    <button type="submit" class="bg-[#0076df] text-white px-12 py-4 rounded-[1.5rem] font-black shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all hover:-translate-y-1">حفظ التقييم</button>
                    <button type="button" onclick="closeModal('evaluationModal')" class="text-gray-400 font-black hover:text-red-500 text-sm transition-colors">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
    {{-- 4. فورم رفع الكتاب (Upload) --}}
    <div id="uploadModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-900/60 backdrop-blur-md hidden p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-[550px] overflow-hidden border border-white text-right animate-in zoom-in-95 duration-300" dir="rtl">
            <div class="bg-[#0076df] p-8 flex justify-between items-center text-white">
                <h3 class="text-xl font-black">رفع كتاب التدريب</h3>
                <button onclick="closeModal('uploadModal')" class="text-3xl">×</button>
            </div>
            <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
                @csrf
                <div class="space-y-3">
                    <label class="text-[11px] font-black text-gray-800 mr-2">اختر المتدرب</label>
                    <select name="student_id" class="w-full bg-gray-50 border border-gray-100 rounded-[1.2rem] p-4 text-sm font-black text-gray-700 shadow-inner" required>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-3">
                    <label class="text-[11px] font-black text-gray-800 mr-2">الملف (PDF)</label>
                    <div class="border-2 border-dashed border-blue-100 rounded-[2rem] bg-gray-50 p-10 text-center relative group">
                        <input type="file" name="training_book" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required onchange="updateFileName(this)">
                        <div id="uploadPlaceholder">
                            <i class="fas fa-file-upload text-3xl text-blue-200 mb-2"></i>
                            <p class="text-[10px] font-black text-gray-400">انقر للرفع</p>
                        </div>
                        <div id="fileNameDisplay" class="hidden text-blue-600 font-black text-xs">
                            <span id="nameText"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#0076df] text-white py-4 rounded-[1.5rem] font-black">تأكيد الرفع</button>
            </form>
        </div>
    </div>
    {{-- 5. Modal تصدير التقارير (Excel) --}}
    <div id="exportChoiceModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-900/60 backdrop-blur-md hidden p-4">
        <div class="bg-white rounded-[2.5rem] shadow-[0_30px_70px_rgba(0,0,0,0.2)] w-full max-w-[500px] overflow-hidden border border-white text-right animate-in zoom-in-95 duration-300" dir="rtl">

            <div class="bg-[#10b981] p-10 text-white text-center relative">
                <div class="w-16 h-16 bg-white/20 rounded-[1.5rem] flex items-center justify-center backdrop-blur-sm border border-white/20 mx-auto mb-4">
                    <i class="fas fa-file-excel text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black tracking-tight">تصدير التقارير الذكية</h3>
                <p class="text-[10px] font-bold opacity-70 uppercase tracking-widest mt-1">اختر نوع الملف المراد تحميله الآن</p>
                <button onclick="closeModal('exportChoiceModal')" class="absolute top-5 left-5 text-2xl font-light hover:opacity-70">×</button>
            </div>

            <div class="p-10 grid grid-cols-1 gap-4">
                {{-- خيار حضور وغياب --}}
                <a href="{{ route('attendance.export') }}" onclick="closeModal('exportChoiceModal')"
                   class="flex items-center justify-between p-6 rounded-[1.5rem] border-2 border-gray-50 bg-gray-50 hover:border-green-200 hover:bg-green-50 transition-all group no-underline">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm text-green-600 group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <div>
                            <span class="text-sm font-black text-gray-800 block">تقرير الحضور والغياب</span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase ">Attendance Report (Excel)</span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-left text-gray-300 group-hover:translate-x-[-5px] transition-transform"></i>
                </a>

                {{-- خيار التقييمات --}}
                <a href="{{ route('export.evaluations') }}" onclick="closeModal('exportChoiceModal')"
                   class="flex items-center justify-between p-6 rounded-[1.5rem] border-2 border-gray-50 bg-white hover:border-blue-200 hover:bg-blue-50 transition-all group no-underline shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center shadow-sm text-[#0076df] group-hover:scale-110 transition-transform">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <div>
                            <span class="text-sm font-black text-gray-800 block">تقرير التقييمات الأسبوعية</span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase ">Evaluations Report (Excel)</span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-left text-gray-300 group-hover:translate-x-[-5px] transition-transform"></i>
                </a>
            </div>

            <div class="bg-gray-50 p-6 text-center border-t border-gray-100">
                <button onclick="closeModal('exportChoiceModal')" class="text-xs font-black text-gray-400 hover:text-red-500 transition-colors">إلغاء الأمر</button>
            </div>
        </div>
    </div>
    <script>
        function toggleWeekInput() {
            let weekSelect = document.getElementById('weekSelect');
            let newWeekDiv = document.getElementById('newWeekDiv');
            let newWeekInput = document.getElementById('newWeekInput');

            if (weekSelect.value === "new") {
                newWeekDiv.classList.remove("hidden");
                newWeekInput.focus();
                newWeekInput.setAttribute("required", "true");
            } else {
                newWeekDiv.classList.add("hidden");
                newWeekInput.removeAttribute("required");
                newWeekInput.value = "";
            }
        }

        function validateWeekSelection() {
            let weekSelect = document.getElementById('weekSelect');
            let newWeekInput = document.getElementById('newWeekInput');

            if (weekSelect.value === "new" && newWeekInput.value.trim() === "") {
                alert("يرجى إدخال اسم الأسبوع الجديد.");
                return false;
            }
            return true;
        }
    </script>
    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function updateFileName(input) {
            const placeholder = document.getElementById('uploadPlaceholder');
            const display = document.getElementById('fileNameDisplay');
            const nameText = document.getElementById('nameText');

            if (input.files && input.files[0]) {
                const fileSize = input.files[0].size / 1024 / 1024; // MB
                if (fileSize > 2) {
                    alert('حجم الملف كبير جداً! الحد الأقصى 2 ميجابايت.');
                    input.value = '';
                    return;
                }

                placeholder.classList.add('hidden');
                display.classList.remove('hidden');
                nameText.innerText = input.files[0].name;
            }
        }

        function resetUpload(event) {
            event.preventDefault();
            event.stopPropagation();
            const input = document.querySelector('input[name="training_book"]');
            const placeholder = document.getElementById('uploadPlaceholder');
            const display = document.getElementById('fileNameDisplay');

            input.value = '';
            display.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
        setTimeout(() => {
            const toast = document.getElementById('success-toast');
            if (toast) {
                toast.classList.add('fade-out');
                setTimeout(() => toast.remove(), 500);
            }
        }, 5000);
    </script>
@endsection
