@extends('layouts.student')
@section('title', 'تفاصيل الفرصة')
@section('content')
    <main class="flex-1 p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        <div class="relative bg-white rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-white overflow-hidden mb-8">
            <div class="h-64 bg-gradient-to-l from-[#3b5998] to-[#6a85b6] w-full relative">
                <img src="{{ asset('storage/internships/' . $internship->image) }}" alt="Cover" class="w-full h-full object-cover opacity-50">
                <div class="absolute inset-0 bg-black/10"></div> {{-- طبقة تباين إضافية --}}
            </div>

            <div class="px-10 pb-8 -mt-16 relative flex justify-between items-end">
                <div class="bg-white p-3 rounded-[2.5rem] shadow-2xl border border-white overflow-hidden w-36 h-36 flex items-center justify-center">
                    @if($internship->company->logo)
                        <img src="{{ asset('storage/' . $internship->company->logo) }}" class="w-full h-full object-contain">
                    @else
                        <i class="fas fa-code text-5xl text-blue-500"></i>
                    @endif
                </div>

                <button id="submitApplication"
                        data-internship="{{ $internship->id }}"
                        data-company="{{ $internship->company_id }}"
                        class="bg-[#007bff] text-white px-10 py-4 rounded-[1.5rem] shadow-xl shadow-blue-200/50 font-black hover:bg-blue-700 transition-all active:scale-95 flex items-center gap-3">
                    <span>تقدم الآن</span>
                    <i class="fas fa-paper-plane text-sm"></i>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_25px_rgba(0,0,0,0.02)] border border-white flex items-center justify-between">
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 font-black mb-1 uppercase tracking-wider">تاريخ البدء</p>
                    <p class="text-sm font-black text-gray-800">{{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50/50 text-blue-500 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="far fa-calendar-alt text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_25px_rgba(0,0,0,0.02)] border border-white flex items-center justify-between">
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 font-black mb-1 uppercase tracking-wider">المدة الزمنية</p>
                    <p class="text-sm font-black text-gray-800">{{ $internship->duration }} شهور</p>
                </div>
                <div class="w-12 h-12 bg-indigo-50/50 text-indigo-500 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="far fa-clock text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_25px_rgba(0,0,0,0.02)] border border-white flex items-center justify-between">
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 font-black mb-1 uppercase tracking-wider">تاريخ الانتهاء</p>
                    <p class="text-sm font-black text-gray-800">{{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50/50 text-green-500 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="far fa-calendar-check text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-[0_8px_25px_rgba(0,0,0,0.02)] border border-white flex items-center justify-between">
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 font-black mb-1 uppercase tracking-wider">موقع التدريب</p>
                    <p class="text-sm font-black text-gray-800">{{ $internship->company->location }}</p>
                </div>
                <div class="w-12 h-12 bg-red-50/50 text-red-500 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-map-marker-alt text-xl"></i>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <div class="flex-1 bg-white p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-2 h-8 bg-blue-600 rounded-full"></div>
                    <h3 class="text-2xl font-black text-gray-800">وصف الفرصة التدريبية</h3>
                </div>

                <div class="text-gray-500 leading-loose font-medium mb-8 text-lg bg-gray-50/30 p-6 rounded-3xl border border-gray-50">
                    {{ $internship->description }}
                </div>
            </div>

            <div class="w-full lg:w-1/3 space-y-8">

                <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center shadow-sm border border-blue-100">
                            <i class="fas fa-address-card text-blue-500 text-xl"></i>
                        </div>
                        <h3 class="font-black text-xl text-gray-800 tracking-tight">بيانات التواصل</h3>
                    </div>

                    <div class="space-y-5">
                        <a href="{{ $internship->company->website }}" target="_blank"
                           class="group flex items-center gap-5 p-5 bg-white rounded-[1.8rem] border border-gray-200 hover:border-blue-400 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                <i class="fas fa-globe text-base"></i>
                            </div>
                            <div class="flex flex-col overflow-hidden text-right">
                                <span class="text-xs text-gray-400 font-black uppercase tracking-widest mb-1">الموقع الإلكتروني</span>
                                <span class="text-sm font-black text-gray-700 truncate group-hover:text-blue-600 transition-colors">{{ $internship->company->website }}</span>
                            </div>
                        </a>

                        <div class="group flex items-center gap-5 p-5 bg-white rounded-[1.8rem] border border-gray-200 hover:border-indigo-400 hover:shadow-xl hover:shadow-indigo-50 transition-all duration-300 cursor-pointer">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                <i class="fas fa-envelope text-base"></i>
                            </div>
                            <div class="flex flex-col text-right">
                                <span class="text-xs text-gray-400 font-black uppercase tracking-widest mb-1">البريد الإلكتروني</span>
                                <span class="text-sm font-black text-gray-700">{{ $internship->company->user->email }}</span>
                            </div>
                        </div>

                        <div class="group flex items-center gap-5 p-5 bg-white rounded-[1.8rem] border border-gray-200 hover:border-emerald-400 hover:shadow-xl hover:shadow-emerald-50 transition-all duration-300 cursor-pointer">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                <i class="fas fa-phone-alt text-base"></i>
                            </div>
                            <div class="flex flex-col text-right">
                                <span class="text-xs text-gray-400 font-black uppercase tracking-widest mb-1">رقم الهاتف</span>
                                <span class="text-sm font-black text-gray-700 tracking-wider" dir="ltr">{{ $internship->company->phone_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- خريطة مصغرة افتراضية --}}
                <div class="bg-white p-4 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white">
                    <div class="rounded-[2rem] overflow-hidden h-48 bg-blue-50 relative border border-gray-100 group">
                        <div class="absolute inset-0 flex items-center justify-center opacity-40 group-hover:scale-110 transition-transform duration-700">
                            <i class="fas fa-map-marked-alt text-6xl text-blue-200"></i>
                        </div>
                        <div class="absolute bottom-4 right-4 bg-white px-4 py-2 rounded-xl shadow-lg text-xs font-black text-gray-700 border border-gray-50">
                            <i class="fas fa-location-arrow text-blue-500 ml-1"></i>
                            {{ $internship->company->location }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        jQuery(document).ready(function($) {

            $(document).on('click', '#submitApplication', function(e) {
                e.preventDefault();

                const internshipId = $(this).attr('data-internship');
                const companyId = $(this).attr('data-company');
                const button = $(this);

                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "سيُعتبر طلبك رسمياً بمجرد الضغط على تأكيد.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    confirmButtonText: 'نعم، قدم الآن',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.prop('disabled', true).addClass('opacity-50').text('جاري التقديم...');

                        $.ajax({
                            url: "{{ route('applications.store') }}",
                            method: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                internship_id: internshipId,
                                company_id: companyId
                            },
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'تم التقديم!',
                                        text: 'تم إرسال طلبك بنجاح.',
                                        icon: 'success',
                                        confirmButtonText: 'موافق'
                                    }).then(() => {
                                        if(data.form_url) {
                                            window.open(data.form_url, '_blank');
                                        }
                                    });
                                } else {
                                    Swal.fire('تنبيه', data.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                Swal.fire('خطأ!', 'حدث خطأ في الخادم، يرجى المحاولة لاحقاً.', 'error');
                            },
                            complete: function() {
                                button.prop('disabled', false).removeClass('opacity-50').html('<i class="fas fa-arrow-left text-sm"></i> <span>تقدم الآن</span>');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
