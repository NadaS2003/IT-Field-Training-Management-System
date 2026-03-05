@extends('layouts.admin')
@section('content')
    <main class="flex-1 bg-[#f8fafc] min-h-screen  text-right" dir="rtl">

        <header class="mb-10 px-2">
            <h1 class="text-2xl font-black text-gray-800 tracking-tight ">إدارة الفرص التدريبية</h1>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">يمكنك إضافة وتعديل ومراقبة كافة الفرص التدريبية المتاحة في المنصة.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">إجمالي الفرص</span>
                    <span class="text-3xl font-black text-gray-800 tracking-tighter ">{{ \App\Models\Internship::count()}}</span>
                </div>
                <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-blue-100 transition-colors">
                    <i class="far fa-file-alt text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">فرص نشطة</span>
                    <span class="text-3xl font-black text-green-600 tracking-tighter ">{{ \App\Models\Internship::where('status', 'مفتوحة')->count() }}</span>
                </div>
                <div class="w-14 h-14 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-green-100 transition-colors">
                    <i class="far fa-check-circle text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">مكتملة</span>
                    <span class="text-3xl font-black text-orange-400 tracking-tighter ">{{ \App\Models\Internship::where('status', 'مكتملة')->count() }}</span>
                </div>
                <div class="w-14 h-14 bg-orange-50 text-orange-400 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-orange-100 transition-colors">
                    <i class="far fa-calendar-alt text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">الشركات الشريكة</span>
                    <span class="text-3xl font-black text-purple-600 tracking-tighter ">{{ \App\Models\Company::count() }}</span>
                </div>
                <div class="w-14 h-14 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-purple-100 transition-colors">
                    <i class="far fa-building text-2xl"></i>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.opportunitiesManagement') }}" class="bg-white p-6 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-white mb-8 flex flex-col md:flex-row items-end gap-6">

            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-400 mb-2 mr-2 uppercase tracking-widest ">حالة الفرصة</label>
                    <select name="status" onchange="this.form.submit()" class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl py-3.5 px-4 text-xs font-bold text-gray-700 shadow-inner outline-none focus:ring-4 focus:ring-blue-50/50 transition-all appearance-none cursor-pointer">
                        <option value="">الكل</option>
                        <option value="مفتوحة" {{ request('status') == 'مفتوحة' ? 'selected' : '' }}>مفتوحة</option>
                        <option value="مغلقة" {{ request('status') == 'مغلقة' ? 'selected' : '' }}>مغلقة</option>
                        <option value="مكتملة" {{ request('status') == 'مكتملة' ? 'selected' : '' }}>مكتملة</option>
                    </select>
                </div>

                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-400 mb-2 mr-2 uppercase tracking-widest ">تصنيف الشركة</label>
                    <select name="company_id" onchange="this.form.submit()" class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl py-3.5 px-4 text-xs font-bold text-gray-700 shadow-inner outline-none focus:ring-4 focus:ring-blue-50/50 transition-all appearance-none cursor-pointer">
                        <option value="">جميع الشركات</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="relative group">
                    <label class="block text-[10px] font-black text-gray-400 mb-2 mr-2 uppercase tracking-widest ">البحث السريع</label>
                    <div class="relative">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 text-xs group-focus-within:text-blue-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث عن عنوان الفرصة..."
                               class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl py-3.5 pr-12 pl-4 text-xs font-bold text-gray-700 shadow-inner outline-none focus:ring-4 focus:ring-blue-50/50 transition-all">
                    </div>
                </div>
            </div>

            <button type="submit" class="h-14 w-14 bg-[#0076df] text-white rounded-2xl hover:bg-blue-700 flex items-center justify-center transition shadow-[0_12px_25px_rgba(0,118,223,0.3)] active:scale-95">
                <i class="fas fa-filter text-sm"></i>
            </button>
        </form>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                        <th class="px-8 py-7">الفرصة التدريبية</th>
                        <th class="px-8 py-7">الشركة</th>
                        <th class="px-8 py-7">تاريخ النشر</th>
                        <th class="px-8 py-7">الموعد النهائي</th>
                        <th class="px-8 py-7 text-center">الحالة</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($opportunities as $opportunity)
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="px-8 py-7">
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors text-base">{{$opportunity->title}}</span>
                                    <span class="text-[10px] text-gray-400 font-black  mt-1 line-clamp-1 max-w-xs">{{$opportunity->description}}</span>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                                <span class="text-xs font-bold text-gray-600  underline decoration-blue-100 decoration-2 underline-offset-4">{{$opportunity->company->company_name}}</span>
                            </td>
                            <td class="px-8 py-7">
                                <span class="text-[10px] font-black text-gray-400 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100 shadow-inner ">{{$opportunity->start_date}}</span>
                            </td>
                            <td class="px-8 py-7">
                                <span class="text-[10px] font-black text-red-400 bg-red-50/30 px-3 py-1 rounded-lg border border-red-50 shadow-inner ">{{$opportunity->end_date}}</span>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @php
                                    $statusStyles = match($opportunity->status) {
                                        'مفتوحة' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'border' => 'border-green-100'],
                                        'مغلقة' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-400', 'border' => 'border-gray-200'],
                                        'مكتملة' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-500', 'border' => 'border-orange-100'],
                                        default => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-100'],
                                    };
                                @endphp
                                <span class="{{ $statusStyles['bg'] }} {{ $statusStyles['text'] }} {{ $statusStyles['border'] }} px-5 py-1.5 rounded-xl text-[10px] font-black shadow-sm border inline-flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $opportunity->status }}
                            </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-inner text-gray-200 text-3xl">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <p class="text-gray-400 font-black ">لا توجد فرص تدريبية متاحة حالياً.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 border-t border-gray-50 flex justify-between items-center bg-white">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]"> عرض <span class="text-gray-800 ">{{ $opportunities->count() }}</span> من أصل <span class="text-gray-800 ">{{ $opportunities->total() }}</span> فرصة</p>
                @if($opportunities->hasPages())
                    <div class="bg-gray-50/50 px-4 py-1 rounded-2xl shadow-inner border border-gray-100">
                        {{ $opportunities->links('vendor.pagination.simple-tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
