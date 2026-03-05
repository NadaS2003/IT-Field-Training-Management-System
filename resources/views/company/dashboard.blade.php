@extends('layouts.company')
@section('content')
    <main class="flex-1 p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        <div class="relative bg-gradient-to-l from-[#0076df] to-[#005bb5] rounded-[3rem] p-10 mb-10 shadow-[0_20px_50px_rgba(0,118,223,0.2)] border border-white/20 overflow-hidden flex items-center justify-between text-white group animate-fade-in">
            <div class="absolute top-0 left-0 w-80 h-80 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl group-hover:bg-white/20 transition-all duration-700"></div>

            <div class="relative z-10 flex-1 ml-10">
                <h1 class="text-4xl font-black mb-4 tracking-tight">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h1>
                <p class="text-white/80 leading-relaxed font-medium mb-8 max-w-2xl text-sm ">
                    {{ \Illuminate\Support\Facades\Auth::user()->company->description }}
                </p>
                <div class="flex gap-4">
                <span class="bg-white/20 px-5 py-2 rounded-2xl text-[11px] font-black backdrop-blur-md flex items-center gap-2 border border-white/10 shadow-lg">
                    <i class="fas fa-map-marker-alt text-blue-200"></i> {{ \Illuminate\Support\Facades\Auth::user()->company->location ?? 'الرياض، المملكة العربية السعودية' }}
                </span>
                    <span class="bg-emerald-400/20 px-5 py-2 rounded-2xl text-[11px] font-black backdrop-blur-md border border-emerald-400/20 text-emerald-100 flex items-center gap-2 shadow-lg">
                    <i class="fas fa-check-circle"></i> حساب موثق
                </span>
                </div>
            </div>

            <div class="relative bg-white p-4 rounded-[2.5rem] shadow-2xl w-44 h-44 flex items-center justify-center overflow-hidden border-[8px] border-white/20 transition-transform hover:scale-105 duration-500 shadow-[0_15px_40px_rgba(0,0,0,0.2)]">
                @if(\Illuminate\Support\Facades\Auth::user()->company->logo)
                    <img src="{{ asset('storage/' . \Illuminate\Support\Facades\Auth::user()->company->logo) }}" class="w-full h-full object-contain rounded-2xl">
                @else
                    <img src="{{ asset('assets/img/com.png') }}" class="w-full h-full object-contain">
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-7 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_15px_45px_rgb(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-[11px] text-gray-400 font-black mb-1 uppercase tracking-widest">فرص التدريب</p>
                    <p class="text-4xl font-black text-[#0076df]">{{ $internshipsCount }}</p>
                </div>
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-[1.5rem] flex items-center justify-center shadow-inner">
                    <i class="fas fa-briefcase text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-7 rounded-[2.5rem] shadow-[0_8px_30_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_15px_45px_rgb(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-[11px] text-gray-400 font-black mb-1 uppercase tracking-widest">طلبات مقبولة</p>
                    <p class="text-4xl font-black text-emerald-500">{{ $applicationCount }}</p>
                </div>
                <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-[1.5rem] flex items-center justify-center shadow-inner">
                    <i class="far fa-check-circle text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-7 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_15px_45px_rgb(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-[11px] text-gray-400 font-black mb-1 uppercase tracking-widest">طلبات في الانتظار</p>
                    <p class="text-4xl font-black text-orange-500">{{ $applicationPendingCount }}</p>
                </div>
                <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-[1.5rem] flex items-center justify-center shadow-inner">
                    <i class="far fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-[0_15px_50px_rgba(0,0,0,0.03)] border border-white">
                <div class="mb-10 flex items-center gap-4">
                    <div class="w-2 h-8 bg-blue-600 rounded-full shadow-sm"></div>
                    <div class="text-right">
                        <h3 class="text-xl font-black text-gray-800 tracking-tight">توزيع الطلبات حسب المسار</h3>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1 ">أداء الأقسام التدريبية لهذا الشهر</p>
                    </div>
                </div>
                <div style="height: 320px;" class="bg-gray-50/50 rounded-[2.5rem] p-8 border border-gray-100 shadow-inner">
                    <canvas id="studentsChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[3rem] shadow-[0_15px_50px_rgba(0,0,0,0.03)] border border-white flex flex-col items-center group">
                <div class="w-full mb-10 text-right flex items-center gap-3">
                    <div class="w-2 h-8 bg-emerald-500 rounded-full shadow-sm"></div>
                    <h3 class="text-xl font-black text-gray-800 tracking-tight">مؤشر الانضباط</h3>
                </div>
                @php
                    $present = $attendanceCounts['حاضر'] ?? 0;
                    $absent = $attendanceCounts['غائب'] ?? 0;
                    $total = $present + $absent;
                    $presentPercentage = $total > 0 ? round(($present / $total) * 100) : 0;
                    $absentPercentage = $total > 0 ? round(($absent / $total) * 100) : 0;
                @endphp

                <div class="relative w-full flex justify-center mb-10">
                    <canvas id="attendanceChart" style="max-width: 220px; max-height: 220px;" class="group-hover:scale-105 transition-transform duration-500"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center translate-y-2">
                        <span class="text-4xl font-black text-gray-800 tracking-tighter">{{ $presentPercentage }}%</span>
                        <span class="text-[9px] text-gray-400 font-black uppercase tracking-[0.2em] mt-1 ">نسبة الحضور</span>
                    </div>
                </div>

                <div class="w-full grid grid-cols-2 gap-5 mt-auto">
                    <div class="text-center p-5 bg-blue-50/50 rounded-[1.8rem] border border-blue-100/30 shadow-sm hover:shadow-md transition-shadow">
                        <p class="text-[9px] text-blue-400 font-black mb-2 uppercase tracking-widest">الحاضرين</p>
                        <p class="font-black text-blue-600 text-xl">{{ $presentPercentage }}%</p>
                    </div>
                    <div class="text-center p-5 bg-red-50/50 rounded-[1.8rem] border border-red-100/30 shadow-sm hover:shadow-md transition-shadow">
                        <p class="text-[9px] text-red-400 font-black mb-2 uppercase tracking-widest">المتغيبين</p>
                        <p class="font-black text-red-500 text-xl">{{ $absentPercentage }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx1 = document.getElementById('studentsChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($studentCounts),
                    backgroundColor: '#0076df',
                    borderRadius: 12,
                    barThickness: 35,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: false },
                        ticks: {
                            font: { family: 'Tajawal' },
                            stepSize: 1,
                            precision: 0,
                        } },
                    x: { grid: { display: false }, ticks: { font: { family: 'Tajawal' } } }
                }
            }
        });

        var ctx2 = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['حضور', 'غياب'],
                datasets: [{
                    data: [{{ $present }}, {{ $absent }}],
                    backgroundColor: ['#0076df', '#ef4444'], // أزرق للحضور وأحمر للغياب
                    borderWidth: 0,
                    cutout: '85%'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    </script>
@endsection
