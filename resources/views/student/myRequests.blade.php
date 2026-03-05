@php use App\Models\Application; @endphp
@extends('layouts.student')
@section('title', 'طلباتي')

@section('content')
    <main class="flex-1 p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        <div class="mb-8 px-2">
            <h1 class="text-2xl font-black text-gray-800 mb-2 tracking-tight">طلباتي</h1>
            <p class="text-gray-500 font-medium  text-sm">تابعي حالة طلبات التدريب الميداني والفرص التي تقدمتِ إليها</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] transition-all">
                <div class="text-right">
                    <p class="text-xs text-gray-400 font-bold mb-1">إجمالي الطلبات</p>
                    <p class="text-2xl font-black text-gray-800 leading-none">{{ $applications->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] transition-all">
                <div class="text-right">
                    @php
                        $pendingActionsCount = Application::where('status', 'قيد المراجعة')
                            ->orWhere(function ($query) {
                                $query->where('status', 'مقبول')
                                      ->where('admin_approval', 0);
                            })
                            ->count();
                    @endphp
                    <p class="text-xs text-gray-400 font-bold mb-1">قيد المراجعة</p>
                    <p class="text-2xl font-black text-gray-800 leading-none">{{$pendingActionsCount }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] transition-all">
                <div class="text-right">
                    <p class="text-xs text-gray-400 font-bold mb-1">مقبول</p>
                    <p class="text-2xl font-black text-gray-800 leading-none">{{ $applications->where('status', 'مقبول')->where('admin_approval',1)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] transition-all">
                <div class="text-right">
                    <p class="text-xs text-gray-400 font-bold mb-1">مرفوض</p>
                    <p class="text-2xl font-black text-gray-800 leading-none">{{ $applications->where('status', 'مرفوض')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white">
                <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                    <span class="w-2 h-7 bg-blue-600 rounded-full"></span> الطلبات الأخيرة
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                        <th class="px-8 py-6">مسمى الفرصة</th>
                        <th class="px-8 py-6">الشركة</th>
                        <th class="px-8 py-6 text-center">تاريخ التقديم</th>
                        <th class="px-8 py-6 text-center">حالة الطلب</th>
                        <th class="px-8 py-6 text-center">ملاحظة الإدارة</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($applications as $application)
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="px-8 py-7">
                                <p class="font-black text-gray-800 text-sm group-hover:text-blue-600 transition">{{ $application->internship->title ?? 'لا توجد بيانات' }}</p>
                            </td>

                            <td class="px-8 py-7">
                                <span class="text-sm font-bold text-gray-500 bg-gray-50 px-3 py-1 rounded-lg">{{ $application->company->company_name ?? 'شركة غير معروفة' }}</span>
                            </td>

                            <td class="px-8 py-7 text-center">
                            <span class="text-[11px] font-black text-gray-400 flex items-center justify-center gap-1">
                                <i class="far fa-calendar-alt text-blue-300"></i>
                                {{ $application->created_at ? $application->created_at->translatedFormat('d F Y') : 'لا توجد بيانات' }}
                            </span>
                            </td>

                            <td class="px-8 py-7 text-center">
                                @if ($application->status == 'مقبول')
                                    <span class="px-4 py-1.5 rounded-xl bg-green-50 text-green-600 text-[10px] font-black shadow-sm border border-green-100/50">مقبول</span>
                                @elseif ($application->status == 'مرفوض')
                                    <span class="px-4 py-1.5 rounded-xl bg-red-50 text-red-600 text-[10px] font-black shadow-sm border border-red-100/50">مرفوض</span>
                                @else
                                    <span class="px-4 py-1.5 rounded-xl bg-blue-50 text-blue-600 text-[10px] font-black shadow-sm border border-blue-100/50">قيد المراجعة</span>
                                @endif
                            </td>
                            <td class="px-8 py-7 text-center">
                                @if($application->status == 'مقبول')
                                    @if($application->admin_approval)
                                        <div class="flex items-center justify-center gap-1.5 text-green-500 text-[11px] font-black">
                                            <i class="fas fa-check-double"></i> تمت موافقة الإدارة
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center gap-1.5 text-orange-400 text-[11px] font-black">
                                            <i class="fas fa-user-clock"></i> بانتظار الإدارة
                                        </div>
                                    @endif
                                @else
                                    <span class="text-gray-300 text-[10px] font-bold">--</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-300">
                                    <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mb-4">
                                        <i class="fas fa-folder-open text-3xl opacity-20"></i>
                                    </div>
                                    <p class="font-black text-sm">لا توجد طلبات تدريب حالية</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($applications->hasPages())
                <div class="px-8 py-6 bg-white border-t border-gray-50 flex justify-center">
                    <div class="bg-gray-50/50 px-4 py-1 rounded-2xl shadow-inner border border-gray-100">
                        {{ $applications->links() }}
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
