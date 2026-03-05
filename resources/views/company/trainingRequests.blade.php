@extends('layouts.company')
@section('title', 'إدارة طلبات التدريب')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <main class="flex-1 p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        <div class="mb-10 text-right px-2 animate-in fade-in slide-in-from-top-4 duration-500">
            <h1 class="text-3xl font-black text-gray-800 mb-2 tracking-tight">إدارة طلبات التدريب</h1>
            <p class="text-[11px] text-gray-400 font-black uppercase tracking-[0.2em] ">مراجعة وفرز المتقدمين للمسارات التدريبية</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden animate-in fade-in zoom-in duration-500">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white">
                <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                    <span class="w-2 h-7 bg-[#0076df] rounded-full shadow-sm"></span> قائمة المتقدمين الجدد
                </h3>
                <div class="bg-gray-50 px-4 py-2 rounded-2xl border border-gray-100/50">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">إجمالي الطلبات: {{ $applications->total() }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.15em] bg-gray-50/30">
                        <th class="px-8 py-6 text-right">اسم الطالب والبيانات</th>
                        <th class="px-8 py-6 text-center">التخصص الأكاديمي</th>
                        <th class="px-8 py-6 text-center">حالة الطلب</th>
                        <th class="px-8 py-6 text-center">مدة التدريب</th>
                        <th class="px-8 py-6 text-center">تاريخ التقديم</th>
                        <th class="px-8 py-6 text-center">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($applications as $application)
                        <tr class="hover:bg-gray-50/40 transition-all group">
                            <td class="px-8 py-6 text-right">
                                <div class="font-black text-gray-800 text-sm group-hover:text-[#0076df] transition-colors">
                                    {{ $application->student->full_name }}
                                </div>
                                <div class="text-[10px] text-gray-400 font-bold mt-1  tracking-tight">
                                    {{ $application->student->user->email }}
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                            <span class="text-xs font-bold text-gray-500 bg-gray-100/50 px-3 py-1 rounded-lg border border-white shadow-sm">
                                {{ $application->student->major }}
                            </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @php
                                    $statusClasses = [
                                        'مقبول' => 'bg-green-50 text-green-600 border-green-100',
                                        'مرفوض' => 'bg-red-50 text-red-600 border-red-100',
                                        'قيد المراجعة' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'معلق' => 'bg-orange-50 text-orange-500 border-orange-100'
                                    ];
                                    $class = $statusClasses[$application->status] ?? 'bg-gray-50 text-gray-500 border-gray-100';
                                @endphp
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black border shadow-sm {{ $class }}">
                                {{ $application->status }}
                            </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                            <span class="text-xs font-black text-gray-500">
                                {{ $application->internship->duration }}
                            </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex flex-col items-center justify-center gap-1">
                                <span class="text-[11px] font-black text-gray-400 ">
                                    <i class="far fa-calendar-alt ml-1 text-blue-300"></i>
                                    {{ $application->created_at->translatedFormat('d F Y') }}
                                </span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('company.studentDetails', ['id' => $application->student->id]) }}"
                                       target="_blank"
                                       class="px-6 py-2.5 bg-white border border-gray-100 text-[#0076df] rounded-2xl text-[10px] font-black shadow-sm hover:shadow-md hover:-translate-y-0.5 hover:bg-blue-50 transition-all flex items-center justify-center gap-2">
                                        <i class="fas fa-external-link-alt text-[9px]"></i>
                                        <span>عرض الملف الكامل</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mb-4 shadow-inner">
                                        <i class="fas fa-user-clock text-3xl text-gray-200"></i>
                                    </div>
                                    <p class="text-gray-400 font-black text-sm ">لا توجد طلبات تدريبية حالياً.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($applications->hasPages())
            <div class="mt-10 flex justify-center animate-in fade-in duration-700">
                <div class="bg-white px-6 py-3 rounded-[1.5rem] shadow-[0_10px_30px_rgba(0,0,0,0.02)] border border-white">
                    {{ $applications->links('vendor.pagination.simple-tailwind') }}
                </div>
            </div>
        @endif
    </main>
    <script>
        document.querySelectorAll(".details-btn").forEach(button => {
            button.onclick = function() {
                document.getElementById("studentName").innerText = this.dataset.name;
                document.getElementById("studentId").innerText = this.dataset.id;
                document.getElementById("studentMajor").innerText = this.dataset.major;
                document.getElementById("studentGpa").innerText = this.dataset.gpa;
                document.getElementById("cvLink").href = this.dataset.cv;
                document.getElementById("studentModal").classList.remove("hidden");
            }
        });

        function closeModal() {
            document.getElementById("studentModal").classList.add("hidden");
        }
    </script>
@endsection
