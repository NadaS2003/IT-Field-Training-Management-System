@extends('layouts.supervisor')
@section('content')
    <main class="p-8 bg-[#f8fafc] min-h-screen text-right " dir="rtl">

        <h1 class="text-2xl font-black text-gray-800 mb-8 px-2 tracking-tight ">تفاصيل الطالب</h1>

        <div class="bg-white p-8 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center gap-4 mb-8 hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] transition-all group text-right">

            <div class="w-24 h-24 bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-100 overflow-hidden shadow-inner ring-2 ring-white">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->full_name) }}&background=EBF4FF&color=007bff&bold=true" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl font-black text-gray-800 group-hover:text-blue-600 transition-colors tracking-tight">{{$student->full_name}}</h2>
                <div class="flex items-center gap-4 text-gray-400 font-black text-[11px] uppercase tracking-wider">
                    <span class="flex items-center gap-1"><i class="fas fa-user-graduate text-blue-400"></i> {{$student->major}}</span>
                    <span class="opacity-30">|</span>
                    <span>الرقم الجامعي: <span class="text-gray-600 ">{{$student->university_id}}</span></span>
                    <span class="opacity-30">•</span>
                    <span>السنة الدراسية: <span class="text-gray-600 ">{{$student->academic_year}}</span></span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 text-right">

            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest">تقدم التدريب</h3>
                        <span class="text-blue-600 font-black text-xl  tracking-tighter">{{ $progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden mb-4 shadow-inner border border-gray-50">
                        <div class="bg-[#0076df] h-full rounded-full shadow-md transition-all duration-1000 ease-out"  style="width: {{ $progress }}%"></div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white overflow-hidden text-right">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-sm font-black text-gray-800 flex items-center gap-2 uppercase tracking-widest">
                            <i class="fas fa-tasks text-blue-600"></i>
                            التقييمات الأسبوعية
                        </h3>
                    </div>
                    <table class="w-full text-right border-collapse">
                        <thead>
                        <tr class="text-gray-400 text-[10px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                            <th class="px-4 py-4 pr-6 rounded-r-xl">الأسبوع</th>
                            <th class="px-4 py-4">التاريخ</th>
                            <th class="px-4 py-4 text-left pl-6 rounded-l-xl">الدرجة</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-right">
                        @foreach($weeklyEvaluations as $evaluation)
                            <tr class="hover:bg-gray-50/40 transition-colors group">
                                <td class="px-4 py-5 pr-6 font-black group-hover:text-blue-600 transition-colors text-xs">{{ $evaluation->week_name }}</td>
                                <td class="px-4 py-5 text-gray-400  text-[11px]">2023/11/02</td>
                                <td class="px-4 py-5 text-left pl-6">
                                    <span class="bg-blue-50/50 text-blue-600 px-3 py-1 rounded-lg border border-blue-100 shadow-sm font-black ">{{ $evaluation->evaluation }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6 text-center">
                        <button class="text-[10px] text-gray-400 font-black uppercase tracking-widest hover:text-blue-600 hover:underline transition-all">عرض جميع التقييمات السابقة</button>
                    </div>
                </div>
            </div>

            <div class="space-y-8 text-right">
                <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white grid grid-cols-2 gap-4 text-center">
                    <div class="border-l border-gray-100 p-2 bg-gray-50/30 rounded-2xl shadow-inner">
                        <p class="text-[10px] text-gray-400 font-black mb-1 uppercase tracking-widest">حضور</p>
                        <span class="text-3xl font-black text-green-600  leading-none">{{ $presentCount }}</span>
                    </div>
                    <div class="p-2 bg-gray-50/30 rounded-2xl shadow-inner border border-gray-50">
                        <p class="text-[10px] text-gray-400 font-black mb-1 uppercase tracking-widest">غياب</p>
                        <span class="text-3xl font-black text-red-500  leading-none">{{ $absentCount }}</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white text-right hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] transition-shadow">
                    <h3 class="text-sm font-black text-gray-800 mb-6 flex items-center gap-2 uppercase tracking-widest">
                        <i class="far fa-user text-blue-600"></i>
                        المعلومات الشخصية
                    </h3>
                    <div class="space-y-5">
                        <div class="flex justify-between items-center border-b border-gray-50 pb-3">
                            <span class="text-[9px] text-gray-400 font-black uppercase tracking-widest">البريد الإلكتروني</span>
                            <span class="text-xs font-bold text-gray-700  lowercase bg-gray-50 px-3 py-1 rounded-lg shadow-inner border border-gray-100">{{$student->user->email}}</span>
                        </div>
                        <div class="flex justify-between items-center pb-1">
                            <span class="text-[9px] text-gray-400 font-black uppercase tracking-widest">رقم الجوال</span>
                            <span class="text-xs font-bold text-gray-700  tracking-tight">{{$student->phone_number}}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white text-right hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] transition-shadow">
                    <h3 class="text-sm font-black text-gray-800 mb-6 flex items-center gap-2 uppercase tracking-widest">
                        <i class="fas fa-graduation-cap text-blue-600"></i>
                        السجل الأكاديمي
                    </h3>
                    <div class="space-y-5 text-right">
                        <div class="flex justify-between border-b border-gray-50 pb-3 items-center">
                            <span class="text-[9px] text-gray-400 font-black uppercase tracking-widest">المعدل التراكمي</span>
                            <span class="text-sm font-black text-blue-600  bg-blue-50/50 px-3 py-1 rounded-lg border border-blue-100 shadow-sm">{{$student->gpa}}%</span>
                        </div>
                        @php
                            $status = $student->training_status;
                            $badgeStyle = match($status) {
                                'completed', 'مكتمل' => 'bg-green-50 text-green-600 border-green-100',
                                'started', 'بدأ', 'قيد التدريب' => 'bg-orange-50 text-orange-600 border-orange-100',
                                default => 'bg-red-50 text-red-600 border-red-100',
                            };
                            $statusLabel = match($status) {
                                'completed', 'مكتمل' => 'مكتمل',
                                'started', 'بدأ', 'قيد التدريب' => 'قيد التدريب',
                                default => 'لم يبدأ',
                            };
                        @endphp
                        <div class="flex justify-between border-b border-gray-50 pb-3 items-center">
                            <span class="text-[9px] text-gray-400 font-black uppercase tracking-widest">الشركة</span>
                            <span class="text-xs font-bold text-gray-700  bg-gray-50 px-3 py-1 rounded-lg shadow-inner border border-gray-100">{{$student->applications->first()->company->company_name ?? 'غير محدد'}}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-50 pb-3 items-center">
                            <span class="text-[9px] text-gray-400 font-black uppercase tracking-widest">حالة التدريب</span>
                            <span class="{{ $badgeStyle }} px-4 py-1.5 rounded-xl text-[9px] font-black border shadow-sm uppercase tracking-tighter inline-flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-current @if($status != 'completed') animate-pulse @endif"></span>
                                {{ $statusLabel }}
                        </span>
                        </div>
                        <div class="flex justify-between border-b border-gray-50 pb-3 items-center">
                            <span class="text-[9px] text-gray-400 font-black uppercase tracking-widest">تاريخ البدء</span>
                            <span class="text-xs font-bold text-gray-700  tracking-tight">{{$student->applications->first()->internship->start_date ?? '--'}}</span>
                        </div>
                        <div class="flex justify-between items-center pt-1">
                            <span class="text-[9px] text-gray-400 font-black uppercase tracking-widest">تاريخ الانتهاء</span>
                            <span class="text-xs font-bold text-gray-700  tracking-tight">{{$student->applications->first()->internship->end_date ?? '--'}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
