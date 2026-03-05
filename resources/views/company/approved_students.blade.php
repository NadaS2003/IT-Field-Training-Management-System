{{--@extends('layouts.company')--}}

{{--@section('content')--}}
{{--    <div class="mt-6">--}}
{{--        <div class="flex flex-col items-center px-3 py-2">--}}
{{--             <h2 class="text-xl font-bold mb-4">الطلاب المقبولون في الشركة والمعتمدون من الإدارة</h2>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="mt-5 mr-5 ml-8 mb-6">--}}
{{--        <table class="w-full table table-bordered rounded">--}}
{{--            <thead>--}}
{{--            <tr >--}}
{{--                <th class="px-4 py-2 border w-1/3 text-right">اسم الطالب</th>--}}
{{--                <th class="px-4 py-2 border w-1/4 text-right">الفرصة التدريبية</th>--}}
{{--                <th class="px-4 py-2 border w-1/4 text-right">تاريخ القبول</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @forelse($approvedStudents as $student)--}}
{{--                <tr>--}}
{{--                    <td class="px-4 py-2 border text-right">{{ $student->student->full_name}}</td>--}}
{{--                    <td class="px-4 py-2 border text-right">{{ $student->internship->title }}</td>--}}
{{--                    <td class="px-4 py-2 border text-right">{{ $student->updated_at->format('Y-m-d') }}</td>--}}
{{--                </tr>--}}
{{--            @empty--}}
{{--                <tr>--}}
{{--                    <td colspan="3" class="px-4 py-2 border text-center text-gray-500">--}}
{{--                        لا يوجد طلاب مقبولون حتى الآن.--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforelse--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--@endsection--}}
@extends('layouts.company')

@section('content')
    <main class="flex-1 p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        {{-- هيدر الصفحة بنفس الحجم الكبير والبروز --}}
        <div class="mb-10 text-right px-2 animate-in fade-in slide-in-from-top-4 duration-500">
            <h1 class="text-3xl font-black text-gray-800 mb-2 tracking-tight">الطلاب المعتمدون</h1>
            <p class="text-[11px] text-gray-400 font-black uppercase tracking-[0.2em]">قائمة المتدربين الذين تم اعتمادهم نهائياً في النظام</p>
        </div>

        {{-- الجدول بستايل البطاقة البارزة (الزوايا 2.5rem والظل العميق) --}}
        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden animate-in fade-in zoom-in duration-500">

            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white">
                <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                    <span class="w-2 h-7 bg-green-500 rounded-full shadow-sm"></span> سجل القبول النهائي
                </h3>
                <div class="w-12 h-12 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center text-xl shadow-inner border border-green-100/50">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.15em] bg-gray-50/30">
                        <th class="px-8 py-6 text-right">اسم الطالب المتدرب</th>
                        <th class="px-8 py-6 text-center">الفرصة التدريبية</th>
                        <th class="px-8 py-6 text-center">تاريخ الاعتماد النهائي</th>
                        <th class="px-6 py-6 text-center">الحالة</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($approvedStudents as $student)
                        <tr class="hover:bg-gray-50/40 transition-all group">
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center gap-4">
                                    {{-- أيقونة الحرف بستايل بارز --}}
                                    <div class="w-11 h-11 bg-blue-50 text-[#0076df] rounded-[1rem] flex items-center justify-center font-black text-sm shadow-sm border border-blue-100/50 group-hover:scale-110 transition-transform">
                                        {{ mb_substr($student->student->full_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-black text-gray-800 text-sm group-hover:text-[#0076df] transition-colors leading-tight">
                                            {{ $student->student->full_name }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 font-bold mt-1 tracking-tight">
                                            {{ $student->student->major }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-center">
                            <span class="text-xs font-bold text-gray-500 bg-gray-100/50 px-4 py-2 rounded-xl border border-white shadow-sm">
                                {{ $student->internship->title }}
                            </span>
                            </td>

                            <td class="px-8 py-6 text-center">
                                <div class="text-xs font-black text-blue-500">
                                    <i class="far fa-calendar-alt ml-1 opacity-70"></i>
                                    {{ $student->updated_at->translatedFormat('d F Y') }}
                                </div>
                            </td>

                            <td class="px-8 py-6 text-center">
                            <span class="px-5 py-2 rounded-full text-[10px] font-black bg-green-50 text-green-600 border border-green-100 shadow-sm inline-flex items-center gap-2">
                                <i class="fas fa-check-double text-[9px]"></i>
                                معتمد نهائياً
                            </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mb-4 shadow-inner">
                                        <i class="fas fa-user-slash text-3xl text-gray-200"></i>
                                    </div>
                                    <p class="text-gray-400 font-black text-sm">لا يوجد طلاب مقبولون حتى الآن.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>@endsection
