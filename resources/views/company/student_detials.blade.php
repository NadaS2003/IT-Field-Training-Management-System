@extends('layouts.company')
@section('content')
    <main class="p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        <div class="flex justify-between items-center mb-8 px-2">
            <div class="text-right">
                <h1 class="text-2xl font-black text-gray-800 mb-1">تفاصيل طلب التدريب</h1>
                <p class="text-[10px] text-gray-400 font-bold tracking-wide ">مراجعة بيانات المتقدم والملف الأكاديمي</p>
            </div>

            <div id="actionButtonsContainer">
                @if($application->status == 'قيد المراجعة')
                    <div class="flex items-center gap-3">
                        <button id="acceptBtn"
                                class="bg-[#0076df] text-white px-6 py-2.5 rounded-xl font-black shadow-md shadow-blue-100 flex items-center gap-2 text-[14px] transition-all hover:bg-blue-700 hover:-translate-y-0.5 active:scale-95">
                            <i class="fas fa-check-circle"></i> قبول الطلب
                        </button>

                        <button id="rejectBtn"
                                class="bg-white text-red-500 px-6 py-2.5 rounded-xl font-black flex items-center gap-2 text-[14px] transition-all hover:bg-red-50 border border-red-100 shadow-sm">
                            <i class="fas fa-times-circle"></i> رفض
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

            <div class="md:col-span-8 space-y-6">

                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-white flex items-center justify-between group">
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            <div class="w-24 h-24 bg-gray-50 rounded-2xl border-2 border-white shadow-md overflow-hidden flex items-center justify-center">
                                <img src="https://ui-avatars.com/api/?name={{$student->full_name }}&background=0076df&color=fff&bold=true" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <h2 class="text-lg font-black text-gray-800">{{ $student->full_name }}</h2>
                            <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-3 py-1 rounded-lg border border-blue-100/50">
                            {{ $student->major }}
                        </span>
                            <div class="pt-1">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black border {{ $application->status == 'مقبول' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-blue-50 text-blue-600 border-blue-100' }}">
                                {{ $application->status ?? 'قيد المراجعة' }}
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 text-left">
                        <div class="flex items-center gap-3 bg-gray-50/50 p-2.5 px-4 rounded-xl border border-white shadow-inner">
                            <i class="far fa-envelope text-blue-400 text-xs"></i>
                            <span class="text-[14px] font-bold text-gray-600">{{ $student->user->email }}</span>
                        </div>
                        <div class="flex items-center gap-3 bg-gray-50/50 p-2.5 px-4 rounded-xl border border-white shadow-inner">
                            <i class="fas fa-mobile-alt text-gray-400 text-xs"></i>
                            <span class="text-[14px] font-bold text-gray-600 tracking-tight">{{ $student->phone_number }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-white">
                    <h3 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 bg-blue-500 rounded-full"></span> السجل الأكاديمي
                    </h3>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-gray-50/40 p-4 rounded-2xl border border-white text-center">
                            <span class="text-[9px] font-black text-gray-400 block mb-1">الرقم الجامعي</span>
                            <span class="text-xs font-black text-blue-600">{{ $student->university_id }}</span>
                        </div>
                        <div class="bg-gray-50/40 p-4 rounded-2xl border border-white text-center">
                            <span class="text-[9px] font-black text-gray-400 block mb-1">السنة الدراسية</span>
                            <span class="text-xs font-black text-gray-700">{{ $student->academic_year }}</span>
                        </div>
                        <div class="bg-blue-50/30 p-4 rounded-2xl border border-blue-50 text-center">
                            <span class="text-[9px] font-black text-blue-400 block mb-1">المعدل</span>
                            <span class="text-lg font-black text-[#0076df]">{{ $student->gpa }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-4 space-y-6">

                <div class="bg-[#0076df] rounded-[2rem] p-8 shadow-lg shadow-blue-100 text-white relative overflow-hidden">
                    <div class="relative z-10 space-y-4">
                        <h3 class="text-[10px] font-black uppercase tracking-widest opacity-70 ">المسار التدريبي</h3>
                        <h4 class="text-base font-black leading-snug">{{$application->internship->title}}</h4>
                        <div class="pt-4 border-t border-white/10 grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-[9px] opacity-60">التاريخ</p>
                                <p class="text-[10px] font-black">{{$application->internship->start_date}}</p>
                            </div>
                            <div>
                                <p class="text-[9px] opacity-60">المدة</p>
                                <p class="text-[10px] font-black">{{$application->internship->duration}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-white">
                    <h3 class="text-xs font-black text-gray-800 mb-4 ">الملفات المرفقة</h3>
                    <div class="bg-gray-50/50 border border-dashed border-gray-200 rounded-2xl p-4 flex items-center justify-between group hover:bg-white transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-red-500 shadow-sm border border-gray-50">
                                <i class="far fa-file-pdf text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-700 leading-none">السيرة الذاتية</p>
                                <p class="text-[8px] text-gray-400 mt-1 font-bold">PDF • 2.4MB</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $student->cv_file) }}" target="_blank" class="w-8 h-8 flex items-center justify-center bg-white rounded-lg shadow-sm border border-gray-100 text-blue-500 hover:bg-blue-50 transition-all">
                            <i class="fas fa-download text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const acceptBtn = document.getElementById('acceptBtn');
            const rejectBtn = document.getElementById('rejectBtn');
            const applicationId = "{{ $application->id }}";

            async function performUpdate(status) {
                const result = await Swal.fire({
                    title: 'تأكيد الإجراء',
                    text: `هل تريد تغيير حالة الطلب إلى "${status}"؟`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، قم بالتحديث',
                    cancelButtonText: 'إلغاء',
                    confirmButtonColor: status === 'مقبول' ? '#0076df' : '#ef4444',
                });

                if (result.isConfirmed) {
                    try {
                        const response = await axios.post(`/applications/${applicationId}/update-status`, {
                            status: status
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (response.data.success) {
                            Swal.fire('تم بنجاح!', 'تم تحديث حالة الطلب.', 'success');

                            const label = document.getElementById('statusLabel');
                            label.innerText = status;
                            label.className = "inline-block px-4 py-1.5 rounded-full text-[10px] font-black mt-2 border  " +
                                (status === 'مقبول' ? 'bg-green-50 text-green-500 border-green-100' : 'bg-red-50 text-red-500 border-red-100');

                            const buttonsContainer = document.getElementById('actionButtonsContainer');
                            if (buttonsContainer) {
                                buttonsContainer.style.display = 'none';
                            }
                        }
                    } catch (error) {
                        console.error(error);
                        Swal.fire('خطأ!', 'لم يتم التحديث، تأكد من الروابط (Routes)', 'error');
                    }
                }
            }

            if(acceptBtn) acceptBtn.addEventListener('click', () => performUpdate('مقبول'));
            if(rejectBtn) rejectBtn.addEventListener('click', () => performUpdate('مرفوض'));
        });
    </script>
@endsection
