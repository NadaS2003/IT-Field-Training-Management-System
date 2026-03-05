@extends('layouts.student')
@section('title', 'استكشف الفرص')
@section('content')
    <div class="p-8 bg-[#f8fafc] min-h-screen" dir="rtl">
        <div class="mb-8 text-right px-2">
            <h1 class="text-2xl font-black text-gray-800">استكشف الفرص</h1>
            <p class="text-gray-500 text-sm ">اكتشف أفضل فرص التدريب التعاوني لمسيرتك المهنية</p>
        </div>

        <div class="bg-white p-5 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white mb-10">
            <form method="GET" action="{{ route('student.showTraining') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5 text-right">
                    <label class="block text-[10px] font-bold text-gray-400 mb-2 mr-2 uppercase">البحث</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="w-full bg-gray-50 border-none rounded-xl py-2.5 pr-10 pl-4 text-sm focus:ring-2 focus:ring-blue-500 shadow-inner"
                               placeholder="المسمى أو الشركة...">
                        <i class="fas fa-search absolute top-3 right-4 text-gray-400 group-focus-within:text-blue-500"></i>
                    </div>
                </div>

                <div class="md:col-span-3 text-right">
                    <label class="block text-[10px] font-bold text-gray-400 mb-2 mr-2 uppercase">الشركة</label>
                    <select name="company" class="w-full bg-gray-50 border-none rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-500 shadow-inner">
                        <option value="">جميع الشركات</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 text-right">
                    <label class="block text-[10px] font-bold text-gray-400 mb-2 mr-2 uppercase">المدة</label>
                    <select name="duration" class="w-full bg-gray-50 border-none rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-500 shadow-inner">
                        <option value="">أي مدة</option>
                        @foreach(['1', '2', '3', '4', '6'] as $mon)
                            <option value="{{ $mon }}" {{ request('duration') == $mon ? 'selected' : '' }}>{{ $mon }} أشهر</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-2.5 rounded-xl hover:bg-blue-700 transition shadow-md shadow-blue-100">
                        تصفية
                    </button>
                </div>
            </form>
        </div>

        <div class="flex items-center gap-3 mb-8 px-2">
        <span class="text-blue-600 font-black bg-blue-50 px-3 py-1 rounded-lg text-[10px] shadow-sm ">
            {{ $internships->count() }} فرصة متاحة
        </span>
            <h3 class="text-lg font-bold text-gray-800">أحدث الفرص</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($internships as $internship)
                <div class="bg-white rounded-[1.8rem] p-5 shadow-[0_8px_20px_rgba(0,0,0,0.02)] border border-white hover:shadow-[0_15px_30px_rgba(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">

                    <div class="mb-4">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center overflow-hidden shadow-sm border border-gray-50 p-1">
                            @if($internship->company->logo)
                                <img src="{{ asset('storage/' . $internship->company->logo) }}" class="w-full h-full object-contain rounded-xl">
                            @else
                                <div class="w-full h-full bg-slate-800 flex items-center justify-center text-white text-lg font-black rounded-xl">
                                    {{ substr($internship->company->company_name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4 h-16 flex flex-col justify-center">
                        <h4 class="text-sm font-black text-gray-800 mb-1 leading-tight group-hover:text-blue-600 transition line-clamp-2 px-1">
                            {{ $internship->title }}
                        </h4>
                        <p class="text-[10px] text-gray-400 font-bold ">{{ $internship->company->company_name }}</p>
                    </div>

                    <div class="w-full border-t border-gray-50 pt-4 mb-5 space-y-2">
                        <div class="flex items-center justify-center gap-2 text-[10px] text-gray-400 font-bold">
                            <i class="fas fa-map-marker-alt text-blue-400 opacity-60"></i>
                            <span class="truncate">{{$internship->company->location}}</span>
                        </div>
                        <div class="flex items-center justify-center gap-2 text-[10px] text-gray-400 font-bold">
                            <i class="far fa-clock text-blue-400 opacity-60"></i>
                            <span>{{ $internship->duration }} أشهر</span>
                        </div>
                    </div>

                    <a href="{{ route('student.opportunityDetails', $internship->id) }}"
                       class="w-full bg-[#007bff] text-white py-2 rounded-xl text-[10px] font-black hover:bg-blue-700 shadow-sm transition-all active:scale-95">
                        تقدم الآن
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-[2rem] border-2 border-dashed border-gray-100">
                    <p class="text-gray-400 font-bold">لا توجد نتائج مطابقة</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 flex justify-center">
            <div class="bg-white px-4 py-3 rounded-2xl shadow-sm border border-white">
                <div>
                    {{ $internships->links('vendor.pagination.simple-tailwind') }}
                </div>
            </div>
        </div>
    </div>
@endsection
