@extends('layouts.student')
@section('title', 'الصفحة الرئيسية')
@section('content')
    <div class="p-8 min-h-screen bg-[#f8fafc]">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow duration-300 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-gray-500 text-sm font-medium ">الطلبات المرسلة</p>
                    @php
                        $student_id = \App\Models\Student::query()->where('user_id', \Illuminate\Support\Facades\Auth::id())->first()->id;
                    @endphp
                    <h4 class="text-3xl font-bold text-gray-800 tracking-tight">{{ \App\Models\Application::query()->where('student_id',$student_id)->count() }}</h4>
                </div>
                <div class="bg-blue-50 p-4 rounded-2xl">
                    <i class="fas fa-paper-plane text-blue-600 text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow duration-300 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-gray-500 text-sm font-medium ">الفرص المتاحة</p>
                    <h4 class="text-3xl font-bold text-green-600 tracking-tight">{{ \App\Models\Internship::query()->count()}}</h4>
                </div>
                <div class="bg-green-50 p-4 rounded-2xl">
                    <i class="fas fa-briefcase text-green-600 text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow duration-300 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-gray-500 text-sm font-medium ">طلبات مرفوضة</p>
                    <h4 class="text-3xl font-bold text-red-600 tracking-tight">{{ \App\Models\Application::query()->where('student_id',$student_id)->where('status','مرفوض')->count() }}</h4>
                </div>
                <div class="bg-red-50 p-4 rounded-2xl">
                    <i class="fas fa-times-circle text-red-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2 mr-2">
                        <i class="fas fa-chart-line text-blue-600"></i> حالة التدريب الحالية
                    </h3>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white relative overflow-hidden">
                    @if ($internship)
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-xs font-bold whitespace-nowrap shadow-sm">
                                    نشط حالياً
                                </span>
                                <p class="text-gray-600 text-lg font-bold">
                                    {{ $internship->company->company_name ?? 'لا يوجد اسم شركة' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-2xl shadow-inner border border-gray-100">
                                <i class="fas fa-building text-blue-600 text-xl"></i>
                            </div>
                        </div>

                        <div class="text-right mb-8">
                            <h2 class="text-2xl font-black text-gray-800 leading-tight">{{ $internship->title }}</h2>
                        </div>

                        <div class="flex justify-between text-sm text-gray-500 mb-4 bg-gray-50/50 p-4 rounded-2xl border border-gray-100/50">
                            <div class="flex items-center gap-2">
                                <i class="far fa-calendar-alt text-blue-500"></i>
                                تاريخ البدء: <span class="font-bold text-gray-700">{{ $internship->start_date }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="far fa-calendar-check text-red-400"></i>
                                تاريخ الانتهاء: <span class="font-bold text-gray-700">{{ $internship->end_date }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs text-gray-400 font-bold ">تقدم التدريب الميداني</span>
                                <span class="text-xs font-black text-blue-600 ">{{ $progress }}%</span>
                            </div>

                            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden shadow-inner">
                                <div class="bg-[#0076df] h-3 rounded-full shadow-md transition-all duration-1000 ease-out"
                                     style="width: {{ $progress }}%">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-gray-400 font-bold">{{ $statusMessage ?? 'لا يوجد تدريب نشط حالياً' }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 mr-2 ">المشرف الأكاديمي</h3>
                <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white text-center">
                    @if ($supervisor)
                        <div class="relative inline-block mb-4 shadow-xl rounded-[2rem]">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($supervisor->full_name) }}&background=EBF4FF&color=7F9CF5"
                                 class="w-24 h-24 rounded-[2rem] object-cover ring-4 ring-white mx-auto" alt="Supervisor">
                        </div>

                        <h4 class="text-xl font-bold text-gray-800">{{ $supervisor->full_name }}</h4>
                        <p class="text-gray-500 text-sm mb-6">{{ $supervisor->department }}</p>

                        <div class="grid grid-cols-1 gap-3">
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $supervisor->user->email }}&su=استفسار..."
                               target="_blank"  class="flex items-center justify-center gap-2 bg-blue-600 text-white py-4 rounded-2xl text-sm font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition">
                                <i class="far fa-envelope"></i> بريد إلكتروني
                            </a>

                            <button type="button"
                                    onclick="handlePhoneAction('{{ $supervisor->phone_number ?? '' }}', this)"
                                    class="w-full flex items-center justify-center gap-2 border border-gray-100 text-gray-600 py-4 rounded-2xl text-sm font-bold hover:bg-gray-50 transition shadow-sm">
                                <i class="fas fa-phone-alt"></i>
                                <span class="btn-text">اتصال</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-12">
            <div class="flex justify-between items-center mb-6 mr-2">
                <h3 class="text-xl font-bold text-gray-800">فرص مقترحة لك</h3>
                <a href="{{ route('student.showTraining') }}" class="text-blue-500 text-sm hover:underline font-bold">عرض الكل</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($internships as $item)
                    <div class="bg-white p-5 rounded-[2rem] shadow-[0_5px_20px_rgba(0,0,0,0.03)] border border-white hover:shadow-[0_12px_30px_rgba(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300 group">
                        <a href="{{route('student.opportunityDetails', ['id' => $item->id])}}" class="block">
                            <div class="flex justify-between items-start">
                                <div class="bg-gray-50 p-3 rounded-2xl group-hover:bg-blue-50 transition shadow-sm">
                                    <i class="fas fa-laptop-code text-gray-400 group-hover:text-blue-500"></i>
                                </div>
                                <div class="text-right">
                                    <h5 class="font-bold text-gray-800 group-hover:text-blue-600 transition">{{ $item->title }}</h5>
                                    <p class="text-gray-400 text-xs font-medium">{{ $item->company_name }}</p>
                                </div>
                            </div>
                            <div class="mt-6 pt-4 border-t border-gray-50 flex items-center justify-between text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                                <span class="flex items-center gap-1"><i class="fas fa-map-marker-alt"></i>{{$item->company->location}}</span>
                                <span class="flex items-center gap-1"><i class="far fa-clock"></i> دوام كامل</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function handlePhoneAction(phoneNumber, btn) {
            if (!phoneNumber) {
                alert('عذراً، الرقم غير متوفر');
                return;
            }

            navigator.clipboard.writeText(phoneNumber).then(() => {
                Swal.fire({
                    title: 'تم نسخ الرقم بنجاح!',
                    text: "الرقم: " + phoneNumber,
                    icon: 'success',
                    showCancelButton: true,
                    cancelButtonColor: '#6b7280',
                    cancelButtonText: 'إغلاق',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3',
                        cancelButton: 'rounded-xl px-6 py-3'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "tel:" + phoneNumber;
                    }
                });

            }).catch(err => {
                Swal.fire({
                    title: 'رقم التواصل',
                    text: phoneNumber,
                    confirmButtonText: 'حسناً'
                });
            });
        }
    </script>
@endsection
