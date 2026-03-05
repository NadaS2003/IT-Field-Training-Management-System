@extends('layouts.admin')
@section('content')
    <main class="flex-1 bg-[#f8fafc] min-h-screen" dir="rtl">

        <header class="mb-10 flex justify-between items-start px-2">
            <div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight ">نظرة عامة على التدريب</h2>
                <p class="text-gray-500 mt-2 font-medium text-sm">مرحباً بك مجدداً، إليك ملخص أداء المنصة وإحصائيات اليوم.</p>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex flex-col items-end gap-4 transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] hover:-translate-y-1 group">
                <div class="w-14 h-14 bg-orange-50 text-orange-400 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-orange-100 transition-colors">
                    <i class="far fa-user text-2xl"></i>
                </div>
                <span class="text-gray-400 text-[11px] font-black uppercase tracking-widest text-right w-full">إجمالي المشرفين</span>
                <span class="text-4xl font-black text-gray-800 tracking-tighter text-right w-full ">
                {{ $supervisorsCount }}
            </span>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex flex-col items-end gap-4 transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] hover:-translate-y-1 group">
                <div class="w-14 h-14 bg-purple-50 text-purple-400 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-purple-100 transition-colors">
                    <i class="fas fa-mouse-pointer text-2xl"></i>
                </div>
                <span class="text-gray-400 text-[11px] font-black uppercase tracking-widest text-right w-full">فرص التدريب النشطة</span>
                <span class="text-4xl font-black text-gray-800 tracking-tighter text-right w-full ">
                {{ $opportunitiesCount }}
            </span>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex flex-col items-end gap-4 transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] hover:-translate-y-1 group">
                <div class="w-14 h-14 bg-blue-50 text-blue-400 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-blue-100 transition-colors">
                    <i class="far fa-building text-2xl"></i>
                </div>
                <span class="text-gray-400 text-[11px] font-black uppercase tracking-widest text-right w-full">الشركات الشريكة</span>
                <span class="text-4xl font-black text-gray-800 tracking-tighter text-right w-full ">
                {{ $companiesCount }}
            </span>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex flex-col items-end gap-4 transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] hover:-translate-y-1 group">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-blue-100 transition-colors">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </div>
                <span class="text-gray-400 text-[11px] font-black uppercase tracking-widest text-right w-full">إجمالي طلاب الجامعة</span>
                <span class="text-4xl font-black text-gray-800 tracking-tighter text-right w-full ">
              {{ $studentsCount }}
            </span>
            </div>

        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white">
                <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                    <span class="w-2 h-7 bg-blue-600 rounded-full"></span> أحدث طلبات التدريب
                </h3>
                <a href="{{ route('admin.trainingRequests') }}" class="text-blue-600 text-xs font-black uppercase tracking-widest hover:underline transition-all">عرض سجل الطلبات</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                        <th class="px-8 py-6">الطالب</th>
                        <th class="px-8 py-6">التخصص</th>
                        <th class="px-8 py-6">التاريخ</th>
                        <th class="px-8 py-6 text-center">الحالة</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($recentApplications as $application)
                        <tr class="hover:bg-gray-50/40 transition-colors group cursor-pointer">
                            <td class="px-8 py-7">
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors">
                                {{ $application->student->full_name }}
                            </span>
                                    <span class="text-[10px] text-gray-400 font-black mt-1 uppercase tracking-tight">
                                {{ $application->student->user->email ?? 'N/A' }}
                            </span>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                        <span class="text-[11px] font-black text-gray-400 uppercase tracking-tight">
                            {{ $application->student->major ?? 'غير محدد' }}
                        </span>
                            </td>
                            <td class="px-8 py-7">
                                <span class="text-xs font-bold text-gray-500 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100 shadow-inner">
                            {{ $application->created_at->diffForHumans() }}
                        </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @php
                                    $statusStyles = match($application->status) {
                                        'مقبول', 'accepted' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'border' => 'border-green-100', 'dot' => ''],
                                        'تحت المراجعة', 'pending' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'border' => 'border-orange-100', 'dot' => 'animate-pulse'],
                                        'مرفوض', 'rejected' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-100', 'dot' => ''],
                                        default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-100', 'dot' => ''],
                                    };
                                @endphp

                                <span class="{{ $statusStyles['bg'] }} {{ $statusStyles['text'] }} {{ $statusStyles['border'] }} px-5 py-1.5 rounded-xl text-[10px] font-black shadow-sm border inline-flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-current {{ $statusStyles['dot'] }}"></span>
                            {{ $application->status }}
                        </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-400 font-bold italic">
                                لا توجد طلبات تدريب حديثة.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50/20 border-t border-gray-50 text-center">
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em]">
                    آخر تحديث للبيانات: {{ now()->translatedFormat('h:i a') }}
                </p>
            </div>
        </div>
    </main>
@endsection
