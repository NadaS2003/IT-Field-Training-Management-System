@extends('layouts.admin')
@section('content')
    <main class="flex-1 bg-[#f8fafc] min-h-screen  text-right" dir="rtl">

        <header class="mb-10 px-2">
            <h1 class="text-2xl font-black text-gray-800 tracking-tight ">إدارة الكتب التدريبية</h1>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">مرحباً بك، يمكنك مراجعة ورفع الكتب والتقارير التدريبية النهائية للطلاب.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">إجمالي المتدربين</span>
                    <span class="text-3xl font-black text-gray-800 tracking-tighter ">{{ \App\Models\Student::count() }}</span>
                </div>
                <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-blue-100 transition-colors">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">كتب تم تسليمها</span>
                    <span class="text-3xl font-black text-green-600 tracking-tighter ">{{ \App\Models\Evaluation::whereNotNull('evaluation_letter')->where('evaluation_letter', '!=', '')->count()}}</span>
                </div>
                <div class="w-14 h-14 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-green-100 transition-colors">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">كتب متبقية</span>
                    <span class="text-3xl font-black text-red-500 tracking-tighter ">{{ \App\Models\Student::count() - \App\Models\Evaluation::whereNotNull('evaluation_letter')->count() }}</span>
                </div>
                <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-red-100 transition-colors">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-white mb-8 flex items-center gap-5">

            <div class="relative">
                <button id="filterButton" class="px-6 h-14 bg-white border border-gray-100 text-gray-500 rounded-2xl hover:bg-gray-50 flex items-center justify-center gap-3 transition-all shadow-inner active:scale-95 group">
                    <i class="fas fa-sliders-h text-xs group-hover:text-blue-600"></i>
                    <span class="text-xs font-black">تصفية</span>
                </button>

                <div id="filterMenu" class="hidden absolute top-full mt-4 right-0 bg-white border border-white rounded-[2.5rem] p-8 shadow-[0_30px_70px_rgba(0,0,0,0.15)] w-80 z-50 transition-all transform origin-top-right">
                    <form method="GET" action="{{ route('admin.trainingBooks') }}" class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 mb-3 uppercase tracking-widest mr-2 ">فرز حسب الشركة</label>
                            <select name="company" class="w-full bg-gray-50/50 px-5 py-3.5 rounded-2xl border border-gray-100 text-xs font-bold text-gray-700 shadow-inner outline-none focus:ring-4 focus:ring-blue-50/50 transition-all cursor-pointer appearance-none">
                                <option value="">كل الشركات</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->company_name }}" {{ request('company') == $company->company_name ? 'selected' : '' }}>{{ $company->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-[#0076df] text-white py-4 rounded-2xl font-black shadow-[0_12px_25px_rgba(0,118,223,0.3)] hover:bg-blue-700 transition-all text-xs active:scale-95">تطبيق الفلتر</button>
                    </form>
                </div>
            </div>

            <div class="relative flex-1 group">
                <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-500 transition-colors"></i>
                <form method="GET" action="{{ route('admin.trainingBooks') }}">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full bg-gray-50/50 pr-14 pl-6 py-4 rounded-2xl border border-gray-100 text-xs font-bold text-gray-700 shadow-inner focus:ring-4 focus:ring-blue-50/50 outline-none transition-all"
                           placeholder="ابحث عن اسم المتدرب أو الرقم الجامعي...">
                </form>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                        <th class="px-8 py-7">المتدرب</th>
                        <th class="px-8 py-7">الرقم الجامعي</th>
                        <th class="px-8 py-7">الفرصة التدريبية</th>
                        <th class="px-8 py-7 text-center">حالة الكتاب</th>
                        <th class="px-8 py-7 text-left">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($students as $evaluation)
                        @php
                            $acceptedApp = $evaluation->applications->firstWhere(fn($a) => $a->status == 'مقبول' && $a->admin_approval == 1);
                            $hasFile = $evaluation->evaluations->isNotEmpty() && $evaluation->evaluations->first()->evaluation_letter;
                        @endphp
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="px-8 py-7">
                                <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors">{{ $evaluation->full_name }}</span>
                            </td>
                            <td class="px-8 py-7 font-bold text-gray-500  text-xs">
                                <span class="bg-gray-50 px-3 py-1 rounded-lg border border-gray-100 shadow-inner">{{ $evaluation->university_id }}</span>
                            </td>
                            <td class="px-8 py-7">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-gray-600">{{ $acceptedApp->internship->title ?? 'غير محدد' }}</span>
                                    <span class="text-[9px] text-gray-400 font-black mt-1 uppercase">{{ $acceptedApp->company->company_name ?? 'بدون شركة' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @if($hasFile)
                                    <span class="bg-green-50 text-green-600 px-4 py-1.5 rounded-xl text-[10px] font-black border border-green-100 shadow-sm inline-flex items-center gap-2 ">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> تم الرفع
                                </span>
                                @else
                                    <span class="bg-orange-50 text-orange-500 px-4 py-1.5 rounded-xl text-[10px] font-black border border-orange-100 shadow-sm inline-flex items-center gap-2 ">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span> مطلوب
                                </span>
                                @endif
                            </td>
                            <td class="px-8 py-7 text-left">
                                @if($hasFile)
                                    {{-- زر التحميل في حال وجود الملف --}}
                                    <a href="{{ url('storage/' . $evaluation->evaluations->first()->evaluation_letter) }}" target="_blank"
                                       class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-100 text-blue-500 hover:bg-blue-50 transition-all shadow-inner active:scale-90 inline-flex"
                                       title="تحميل الكتاب">
                                        <i class="fas fa-download text-sm"></i>
                                    </a>
                                @else
                                    {{-- النص البديل في حال عدم وجود الملف --}}
                                    <span class="flex items-center text-gray-400 text-xs font-medium bg-gray-50 px-3 py-2 rounded-lg border border-dashed border-gray-200">
                                        <i class="fas fa-info-circle ml-2"></i>
                                        لم يتم رفع الكتاب بعد
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-inner text-gray-200 text-3xl">
                                    <i class="fas fa-book"></i>
                                </div>
                                <p class="text-gray-400 font-black ">لا توجد بيانات متاحة حالياً.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 border-t border-gray-50 flex justify-between items-center bg-white">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]"> عرض <span class="text-gray-800 ">{{ $students->count() }}</span> من أصل <span class="text-gray-800 ">{{ $students->total() }}</span> طالب</p>
                @if($students->hasPages())
                    <div class="bg-gray-50/50 px-4 py-1 rounded-2xl shadow-inner border border-gray-100">
                        {{ $students->links('vendor.pagination.simple-tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </main>
    <script>

        document.getElementById('filterButton').addEventListener('click', function (e) {
            e.stopPropagation();
            document.getElementById('filterMenu').classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            let filterMenu = document.getElementById('filterMenu');
            if (!filterMenu.contains(event.target)) {
                filterMenu.classList.add('hidden');
            }
        });
    </script>
@endsection
