@extends('layouts.supervisor')
@section('content')
    <style>
        .flip-card { background-color: transparent; perspective: 1000px; height: 350px; }
        .flip-card-inner { position: relative; width: 100%; height: 100%; text-align: center; transition: transform 0.6s; transform-style: preserve-3d; }
        .flip-card.flipped .flip-card-inner { transform: rotateY(180deg); }
        .flip-card-front, .flip-card-back { position: absolute; width: 100%; height: 100%; -webkit-backface-visibility: hidden; backface-visibility: hidden; border-radius: 2rem; }
        .flip-card-back { transform: rotateY(180deg); background-color: white; border: 1px solid #f0f0f0; display: flex; flex-direction: column; }
    </style>
    <main class="p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        <div class="mb-10 text-start">
            <h1 class="text-3xl font-black text-gray-800 ">إدارة الشركات</h1>
            <p class="text-sm text-gray-400 font-bold  mt-2">استعرض وقم بإدارة كافة جهات التدريب المعتمدة في النظام</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($companies as $company)
                <div class="flip-card" id="card-{{ $company->id }}">
                    <div class="flip-card-inner">

                        <div class="flip-card-front bg-white p-6 shadow-sm border border-gray-50 flex flex-col justify-between items-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100 shadow-inner">
                                <i class="fas fa-building text-gray-300 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-black text-[#0076df]  ">{{ $company->company_name }}</h3>
                            <p class="text-[10px] text-gray-400 font-bold  mb-4 flex items-center gap-1">
                                <i class="fas fa-map-marker-alt text-[8px]"></i> {{ $company->location }}
                            </p>
                            <div class="w-full space-y-2 mb-6">
                                <div class="flex items-center justify-start gap-2 text-gray-500"><i class="far fa-envelope text-xs"></i><span class="text-[13px] font-bold ">{{ $company->user->email }}</span></div>
                                <div class="flex items-center justify-start gap-2 text-gray-500"><i class="fas fa-phone-alt text-xs"></i><span class="text-[13px] font-bold ">{{ $company->phone_number }}</span></div>
                            </div>
                            <button onclick="toggleFlip({{ $company->id }})" class="w-full bg-[#0076df] text-white py-3 rounded-xl text-xs font-black  flex items-center justify-center gap-2 hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                                عرض الطلاب <i class="fas fa-arrow-left text-[10px]"></i>
                            </button>
                        </div>

                        <div class="flip-card-back p-6 shadow-xl text-right">
                            <div class="flex items-center justify-between mb-4 border-b pb-2">
                                <h4 class="text-sm font-black text-gray-800 ">الطلاب المعتمدون</h4>
                                <button onclick="toggleFlip({{ $company->id }})" class="text-gray-400 hover:text-red-500 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="flex-1 overflow-y-auto space-y-3 pr-1 custom-scrollbar">
                                @php
                                    $approvedStudents = collect($companyStudents[$company->id] ?? [])->filter(function($item) {
                                        return ($item['status'] ?? '') === 'مقبول' && ($item['admin_approval'] ?? 0) == 1;
                                    });
                                @endphp

                                @forelse($approvedStudents as $studentData)
                                    @php
                                        $student = $studentData['student'];
                                        $evaluation = $student->evaluations->where('company_id', $company->id)->first();
                                        $hasBook = $evaluation && !empty($evaluation->evaluation_letter);
                                    @endphp

                                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex flex-col gap-1 hover:border-blue-200 transition-colors">
                                        <span class="text-[11px] font-black text-gray-700">{{ $student->full_name }}</span>

                                        @if($hasBook)
                                            <a href="{{ asset('storage/' . $evaluation->evaluation_letter) }}"
                                               target="_blank" class="text-[9px] font-bold text-blue-600 flex items-center gap-1 hover:underline">
                                                <i class="fas fa-file-pdf"></i> تحميل كتاب التدريب (جاهز)
                                            </a>
                                        @else
                                            <span class="text-[9px] font-bold text-red-400 flex items-center gap-1 ">
                                                    <i class="fas fa-clock"></i> لم يتم رفع الكتاب بعد
                                            </span>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center mt-12">
                                        <i class="fas fa-user-clock text-gray-200 text-4xl mb-2"></i>
                                        <p class="text-[10px] text-gray-400 font-bold italic">لا يوجد طلاب مقبولون نهائياً لهذه الشركة</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($companies->hasPages())
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2">
                {{-- زر السابق --}}
                @if ($companies->onFirstPage())
                    <span class="relative inline-flex items-center px-3 py-2 text-gray-400 bg-gray-50 border border-gray-200 cursor-default rounded-xl transition">
                <i class="fas fa-chevron-right text-xs"></i>
            </span>
                @else
                    <a href="{{ $companies->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-blue-600 bg-white border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-200 transition-all active:scale-90 shadow-sm">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                @endif

                {{-- أرقام الصفحات --}}
                <div class="hidden md:flex gap-2">
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 text-gray-400 bg-white border border-gray-100 rounded-xl cursor-default">
                        {{ $element }}
                    </span>
                        @endif

                        {{-- مصفوفة الروابط --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-xl shadow-md z-10">
                                {{ $page }}
                            </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-blue-600 transition-all shadow-sm">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- زر التالي --}}
                @if ($companies->hasMorePages())
                    <a href="{{ $companies->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-blue-600 bg-white border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-200 transition-all active:scale-90 shadow-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                @else
                    <span class="relative inline-flex items-center px-3 py-2 text-gray-400 bg-gray-50 border border-gray-200 cursor-default rounded-xl transition">
                <i class="fas fa-chevron-left text-xs"></i>
            </span>
                @endif
            </nav>
        @endif

        @if($companies->isEmpty())
            <div class="p-20 text-center">
                <i class="fas fa-city text-gray-100 text-7xl mb-4"></i>
                <p class="text-gray-400 font-bold italic">لا توجد شركات مسجلة في النظام حالياً</p>
            </div>
        @endif
    </main>
    <script>
        function toggleFlip(companyId) {
            const card = document.getElementById('card-' + companyId);
            card.classList.toggle('flipped');
        }
    </script>
@endsection
