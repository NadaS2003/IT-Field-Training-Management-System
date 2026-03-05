@extends('layouts.admin')
@section('content')
    <main class="flex-1 bg-[#f8fafc] min-h-screen  text-right" dir="rtl">

        <header class="flex justify-between items-start mb-10 px-2">
            <div class="text-right">
                <h1 class="text-2xl font-black text-gray-800 tracking-tight ">إدارة الحضور والغياب</h1>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">عرض وإحصائيات سجلات الدوام اليومي للطلاب المتدربين في الشركات.</p>
            </div>
            <form action="{{ route('admin.attendance.export') }}" method="GET">
                <button type="submit" class="bg-white text-gray-700 border border-white px-6 py-3.5 rounded-2xl shadow-[0_10px_25px_rgba(0,0,0,0.03)] hover:shadow-[0_15px_30px_rgba(0,0,0,0.06)] hover:-translate-y-0.5 transition-all flex items-center gap-3 font-black text-[10px] uppercase tracking-widest">
                    <i class="fas fa-download text-blue-500 text-lg"></i> تصدير التقارير
                </button>
            </form>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">إجمالي الطلاب</span>
                    <span class="text-3xl font-black text-gray-800 tracking-tighter ">{{\App\Models\Student::count()}}</span>
                </div>
                <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-blue-100 transition-colors">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">سجلات الحضور</span>
                    <span class="text-3xl font-black text-green-600 tracking-tighter ">{{\App\Models\Attendance::where('status','حاضر')->count()}}</span>
                </div>
                <div class="w-14 h-14 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-green-100 transition-colors">
                    <i class="far fa-check-circle text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">سجلات الغياب</span>
                    <span class="text-3xl font-black text-red-500 tracking-tighter ">{{\App\Models\Attendance::where('status','غائب')->count()}}</span>
                </div>
                <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-red-100 transition-colors">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">بيئات التدريب</span>
                    <span class="text-3xl font-black text-orange-400 tracking-tighter ">{{\App\Models\Company::count()}}</span>
                </div>
                <div class="w-14 h-14 bg-orange-50 text-orange-400 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-orange-100 transition-colors">
                    <i class="far fa-building text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-white mb-8">
            <div class="relative group">
                <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-500 transition-colors"></i>
                <form action="{{ route('admin.audienceManagement') }}" method="GET">
                    <input type="text" name="search" value="{{ request()->input('search') }}"
                           class="w-full bg-gray-50/50 pr-14 pl-6 py-4 rounded-2xl border border-gray-100 text-xs font-bold text-gray-700 shadow-inner focus:ring-4 focus:ring-blue-50/50 outline-none transition-all"
                           placeholder="ابحث عن اسم الطالب أو اسم الشركة...">
                </form>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                        <th class="px-8 py-7">الطالب المتدرب</th>
                        <th class="px-8 py-7">الشركة المستضيفة</th>
                        <th class="px-8 py-7 text-center">أيام الحضور</th>
                        <th class="px-8 py-7 text-center">أيام الغياب</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($attendanceDataPaginator as $attendance)
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="px-8 py-7">
                            <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors text-base">
                                {{ $attendance['student']->full_name ?? 'غير موجود' }}
                            </span>
                            </td>
                            <td class="px-8 py-7">
                                @php
                                    $acceptedApp = $attendance['student']->applications->firstWhere(fn($a) => $a->status == 'مقبول' && $a->admin_approval == 1);
                                @endphp
                                <span class="text-xs font-bold text-gray-500  underline decoration-blue-100 decoration-2 underline-offset-4">
                                {{ $acceptedApp && $acceptedApp->company ? $acceptedApp->company->company_name : 'لا توجد شركة' }}
                            </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                            <span class="bg-green-50 text-green-600 px-5 py-2 rounded-xl text-sm font-black shadow-inner border border-green-100/50 inline-flex items-center gap-2 ">
                                {{ $attendance['present_days'] ?? 0 }} <span class="text-[9px] uppercase tracking-tighter">يوم</span>
                            </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @php $absentCount = $attendance['absent_days'] ?? 0; @endphp
                                <span class="{{ $absentCount > 3 ? 'bg-red-50 text-red-600 border-red-100' : 'bg-gray-50 text-gray-400 border-gray-100' }} px-5 py-2 rounded-xl text-sm font-black shadow-inner border inline-flex items-center gap-2 ">
                                {{ $absentCount }} <span class="text-[9px] uppercase tracking-tighter">أيام</span>
                            </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-inner text-gray-200 text-3xl">
                                    <i class="fas fa-calendar-times"></i>
                                </div>
                                <p class="text-gray-400 font-black ">لا توجد بيانات حضور مسجلة حالياً.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 border-t border-gray-50 flex justify-between items-center bg-white">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]"> عرض <span class="text-gray-800 ">{{ $attendanceDataPaginator->count() }}</span> من أصل <span class="text-gray-800 ">{{ $attendanceDataPaginator->total() }}</span> طالب</p>
                @if($attendanceDataPaginator->hasPages())
                    <div class="bg-gray-50/50 px-4 py-1 rounded-2xl shadow-inner border border-gray-100">
                        {{ $attendanceDataPaginator->links('vendor.pagination.simple-tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
