@extends('layouts.supervisor')
@section('content')
    <main class="p-8 bg-[#f8fafc] min-h-screen text-right " dir="rtl">
        <div class="mb-10 text-right px-2">
            <h1 class="text-3xl font-black text-gray-800 ">مرحباً بك، د. أحمد</h1>
            <p class="text-sm text-gray-400 font-bold mt-2">إليك نظرة سريعة على حالة الطلاب والتدريب لهذا اليوم.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex items-center justify-between group">
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-400 uppercase mb-1">إجمالي الطلاب</p>
                    <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{$studentsCount}}</h3>
                </div>
                <div class="bg-blue-50 p-4 rounded-2xl transition-colors group-hover:bg-blue-100">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex items-center justify-between group">
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-400 uppercase mb-1">إجمالي الشركات</p>
                    <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{$companiesCount}}</h3>
                </div>
                <div class="bg-purple-50 p-4 rounded-2xl transition-colors group-hover:bg-purple-100">
                    <i class="fas fa-building text-purple-600 text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex items-center justify-between group">
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-400 uppercase mb-1">التقارير المستلمة</p>
                    <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{$weeksCount}}</h3>
                </div>
                <div class="bg-orange-50 p-4 rounded-2xl transition-colors group-hover:bg-orange-100">
                    <i class="fas fa-file-invoice text-orange-600 text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex items-center justify-between group">
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-400 uppercase mb-1">التقارير المكتملة</p>
                    <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{$trainingBooks}}</h3>
                </div>
                <div class="bg-green-50 p-4 rounded-2xl transition-colors group-hover:bg-green-100">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- 2. توزيع الطلاب: بستايل البطاقة الكبيرة البارزة --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-10">
            <div class="mb-8 flex items-center gap-3">
                <div class="w-1 bg-blue-600 h-6 rounded-full"></div>
                <div>
                    <h3 class="text-xl font-black text-gray-800 ">توزيع الطلاب حسب التخصص</h3>
                    <p class="text-xs text-gray-400 font-bold mt-1">مقارنة بين التخصصات الأكاديمية المختلفة</p>
                </div>
            </div>

            <div class="space-y-6 max-w-4xl">
                @foreach($majorsData as $index => $data)
                    @php
                        $widthPercentage = ($data->total / $maxStudents) * 100;
                        $colors = ['bg-blue-600', 'bg-blue-500', 'bg-blue-400', 'bg-blue-300', 'bg-blue-200'];
                        $currentColor = $colors[$index] ?? 'bg-blue-100';
                    @endphp

                    <div class="flex items-center gap-4 group">
                        <span class="w-32 text-xs font-black text-gray-500 italic">{{ $data->major }}</span>

                        <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden shadow-inner relative">
                            <div class="h-full {{ $currentColor }} rounded-full transition-all duration-1000 shadow-md"
                                 style="width: {{ $widthPercentage }}%"></div>
                        </div>

                        <span class="w-20 text-xs font-black text-gray-800 italic text-left">{{ $data->total }} طالب</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 3. الجدول: بستايل البطاقة العريضة البارزة --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black text-gray-800 text-right">آخر الطلاب المسجلين</h3>
                <span class="text-[10px] font-black text-gray-400 bg-gray-50 px-4 py-1.5 rounded-full border border-gray-100">تحديث تلقائي</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                    <tr class="text-gray-400 text-[10px] font-black uppercase border-b border-gray-50">
                        <th class="pb-5 pr-4 tracking-wider">اسم الطالب</th>
                        <th class="pb-5 tracking-wider">الرقم الجامعي</th>
                        <th class="pb-5 tracking-wider">التخصص</th>
                        <th class="pb-5 tracking-wider">جهة التدريب</th>
                        <th class="pb-5 tracking-wider">الحالة</th>
                        <th class="pb-5 pl-4 text-left tracking-wider">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="text-sm font-bold text-gray-700">
                    @foreach($approvedStudents as $student)
                        <tr class="border-b border-gray-50/50 hover:bg-gray-50/50 transition-all duration-200 group">
                            <td class="py-5 pr-4 group-hover:text-blue-600 transition-colors">{{ $student->full_name }}</td>
                            <td class="py-5 text-gray-500 italic text-xs">{{ $student->university_id }}</td>
                            <td class="py-5 text-gray-500">{{ $student->major }}</td>
                            <td class="py-5">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-building text-[10px] text-gray-300"></i>
                                {{ $student->company_name ?? 'غير محدد' }}
                            </span>
                            </td>
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
                            <td class="py-5">
                            <span class="{{ $badgeStyle }} px-4 py-1.5 rounded-full text-[10px] font-black inline-flex items-center gap-2 border shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $statusLabel }}
                            </span>
                            </td>
                            <td class="py-5 pl-4 text-left">
                                <a href="{{ route('supervisor.studentDetails', $student->id) }}"
                                   class="bg-white border border-gray-200 text-blue-600 px-5 py-2 rounded-xl text-xs font-black hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm inline-block active:scale-95">
                                    عرض الملف
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
