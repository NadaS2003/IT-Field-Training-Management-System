@extends('layouts.supervisor')
@section('content')
    <main class="p-8 bg-[#f8fafc] min-h-screen text-right " dir="rtl">
        <div class="mb-8 px-2">
            <h1 class="text-3xl font-black text-gray-800 mb-2 tracking-tight ">إدارة شؤون الطلاب</h1>
            <p class="text-gray-500 font-medium text-sm">يمكنك استعراض وتعديل بيانات الطلاب ومتابعة حالة تدريبهم بدقة واحترافية.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white">
                <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                    <span class="w-2 h-7 bg-blue-600 rounded-full"></span> قائمة الطلاب المسجلين
                </h3>
            </div>

            @if($students->isEmpty())
                <div class="p-24 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-inner">
                        <i class="fas fa-user-slash text-gray-200 text-3xl opacity-50"></i>
                    </div>
                    <p class="text-gray-400 font-black ">لا يوجد طلاب مسجلون حالياً في النظام.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                        <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                            <th class="px-8 py-6">اسم الطالب</th>
                            <th class="px-8 py-6">الرقم الجامعي</th>
                            <th class="px-8 py-6">التخصص</th>
                            <th class="px-8 py-6 text-center">حالة التدريب</th>
                            <th class="px-8 py-6 text-left">إجراءات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        @foreach($students as $student)
                            <tr class="hover:bg-gray-50/40 transition-colors group">
                                <td class="px-8 py-7">
                                    <div class="flex flex-col">
                                        <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors">{{ $student->full_name }}</span>
                                        <span class="text-[10px] text-gray-400 font-black  mt-1">{{ $student->user->email ?? 'no-email@university.edu.sa' }}</span>
                                    </div>
                                </td>

                                <td class="px-8 py-7">
                                    <span class="text-sm font-bold text-gray-500 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100  shadow-sm">{{ $student->university_id }}</span>
                                </td>

                                <td class="px-8 py-7">
                                    <span class="text-[11px] font-black text-gray-400 uppercase tracking-tight ">{{ $student->major }}</span>
                                </td>

                                <td class="px-8 py-7 text-center">
                                    @php
                                        $status = $student->training_status;
                                        $style = match($status) {
                                            'completed', 'مكتمل' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'border' => 'border-green-100', 'label' => 'مكتمل'],
                                            'started', 'بدأ', 'قيد التدريب' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'border' => 'border-orange-100', 'label' => 'قيد التدريب'],
                                            default => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-100', 'label' => 'لم يبدأ'],
                                        };
                                    @endphp
                                    <span class="{{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }} px-4 py-1.5 rounded-xl text-[10px] font-black shadow-sm border inline-flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current @if($status != 'completed') animate-pulse @endif"></span>
                                    {{ $style['label'] }}
                                </span>
                                </td>

                                <td class="px-8 py-7 text-left">
                                    <a href="{{ route('supervisor.studentDetails', ['id' => $student->id]) }}"
                                       class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-100 text-gray-400 hover:text-blue-600 hover:border-blue-100 hover:shadow-sm transition-all shadow-inner active:scale-90">
                                        <i class="far fa-eye text-sm"></i>
                                    </a>
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
    </main>
@endsection
