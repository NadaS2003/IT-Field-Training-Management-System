@extends('layouts.student')
@section('title', 'تعديل الملف الشخصي')

@section('content')
    <style>
        @keyframes slideIn {
            from { transform: translateX(-120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }
        .animate-slide-in {
            animation: slideIn 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }
        .animate-progress {
            animation: progress 4s linear forwards;
        }
        .custom-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background-color: white;
        }
    </style>

    <div class="fixed top-8 left-8 z-[100] flex flex-col gap-4 w-85 text-right">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="bg-white border-l-4 border-red-500 shadow-[0_15px_40px_rgba(239,68,68,0.1)] rounded-[1.5rem] p-5 flex items-center animate-slide-in relative overflow-hidden group border border-white">
                    <div class="bg-red-50 p-3 rounded-2xl ml-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] text-red-400 font-black uppercase tracking-widest mb-0.5">خطأ في التحديث</p>
                        <p class="text-sm text-gray-700 font-black leading-snug">{{ $error }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-gray-300 hover:text-red-500 transition-colors mr-3">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endforeach
        @endif

        @if (session('success'))
            <div id="success-toast" class="bg-white border-l-4 border-green-500 shadow-[0_15px_40px_rgba(34,197,94,0.1)] rounded-[1.5rem] p-5 flex items-center animate-slide-in relative overflow-hidden border border-white">
                <div class="bg-green-50 p-3 rounded-2xl ml-4">
                    <i class="fas fa-check-double text-green-500 text-lg"></i>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] text-green-400 font-black uppercase tracking-widest mb-0.5">نجاح العملية</p>
                    <p class="text-sm text-gray-700 font-black leading-snug">{{ session('success') }}</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 bg-green-500 animate-progress"></div>
            </div>
        @endif
    </div>

    <main class="flex-1 p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">
        <form action="{{ route('student.Profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex justify-between items-center mb-10 px-2">
                <div class="text-right">
                    <h1 class="text-2xl font-black text-gray-800 mb-2">الملف الشخصي</h1>
                    <p class="text-sm text-gray-400 font-bold ">أبقِ معلوماتك محدثة لزيادة فرص قبولك في التدريب</p>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-10 py-3.5 rounded-2xl font-black shadow-xl shadow-blue-100/50 hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95 text-sm">حفظ التعديلات</button>
                    <button type="button" class="bg-white text-gray-400 px-10 py-3.5 rounded-2xl font-black border border-white shadow-sm hover:bg-gray-50 transition-all text-sm">إلغاء</button>
                </div>
            </div>

            <div class="max-w-4xl mx-auto space-y-8">

                <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_15px_45px_rgba(0,0,0,0.02)] border border-white">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner border border-blue-100/30">
                            <i class="far fa-user text-xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-800">المعلومات الأساسية</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">الاسم الكامل</label>
                            <input type="text" name="full_name" value="{{ $student->full_name }}"
                                   class="custom-input w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">رقم الجوال</label>
                            <input type="text" dir="ltr" name="phone_number" value="{{ $student->phone_number }}"
                                   class="custom-input w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 text-right transition-all outline-none">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_15px_45px_rgba(0,0,0,0.02)] border border-white">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner border border-indigo-100/30">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-800">المسار الأكاديمي</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">الرقم الجامعي</label>
                            <input type="text" name="university_id" value="{{ $student->university_id }}"
                                   class="custom-input w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">التخصص الحالي</label>
                            <input type="text" name="major" value="{{ $student->major }}"
                                   class="custom-input w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">المعدل التراكمي (GPA)</label>
                            <input type="text" name="gpa" value="{{ $student->gpa }}"
                                   class="custom-input w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">السنة الدراسية</label>
                            <input type="text" name="academic_year" value="{{ $student->academic_year }}"
                                   class="custom-input w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_15px_45px_rgba(0,0,0,0.02)] border border-white">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner border border-emerald-100/30">
                            <i class="fas fa-file-contract text-xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-800">الملفات المهنية</h3>
                    </div>

                    <div class="border-4 border-dashed border-gray-50 rounded-[2.5rem] p-12 text-center bg-gray-50/30 group hover:bg-white hover:border-blue-100 transition-all duration-500 shadow-inner">
                        <div class="w-16 h-16 bg-white shadow-xl rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-cloud-arrow-up text-2xl text-blue-500"></i>
                        </div>
                        <h4 class="text-lg font-black text-gray-800 mb-2">تحديث السيرة الذاتية</h4>
                        <p class="text-xs text-gray-400 font-bold mb-8 italic">يفضل أن يكون الملف بصيغة PDF لضمان وضوح التنسيق</p>

                        <input type="file" name="cv_file" id="cv_upload" class="hidden">
                        <label for="cv_upload" class="cursor-pointer px-10 py-3.5 bg-white border border-gray-200 rounded-2xl text-xs font-black text-blue-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm inline-block active:scale-95">
                            <i class="fas fa-plus ml-2"></i> اختيار ملف جديد
                        </label>

                        @if($student->cv_file)
                            <div class="mt-8 p-4 bg-white rounded-2xl border border-gray-100 inline-flex items-center gap-3 shadow-sm">
                                <i class="fas fa-file-pdf text-red-500 text-lg"></i>
                                <span class="text-[11px] text-gray-500 font-black">الملف الحالي:</span>
                                <a href="#" class="text-[11px] text-blue-500 font-black underline truncate max-w-[150px]">{{ basename($student->cv_file) }}</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_15px_45px_rgba(0,0,0,0.02)] border border-white">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center shadow-inner border border-red-100/30">
                            <i class="fas fa-shield-alt text-xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-800">أمان الحساب</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ $student->user->email }}"
                                   class="w-full bg-gray-100/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-400 cursor-not-allowed outline-none" readonly>
                        </div>
                        <div class="relative">
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">كلمة المرور الجديدة</label>
                            <input type="password" name="password" placeholder="اتركه فارغاً للحفاظ عليها"
                                   class="custom-input w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 outline-none transition-all">
                            <i class="far fa-eye absolute left-5 bottom-5 text-gray-300 hover:text-blue-500 cursor-pointer transition-colors"></i>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successToast = document.getElementById('success-toast');
        if (successToast) {
            setTimeout(() => {
                successToast.style.transition = "all 0.5s ease";
                successToast.style.opacity = "0";
                successToast.style.transform = "translateX(-20px)";
                setTimeout(() => successToast.remove(), 500);
            }, 4000);
        }
    });
</script>
@endsection
