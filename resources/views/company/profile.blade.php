@extends('layouts.company')
@section('title', 'تعديل ملف الشركة')
@section('content')
    <style>
        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }
        .animate-progress {
            animation: progress 5s linear forwards;
        }
        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
    <div class="fixed top-8 left-8 z-[100] flex flex-col gap-4 w-85 text-right">
        {{-- تنبيه الأخطاء: بظل أحمر خفيف وحواف ناعمة --}}
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
        <form action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex justify-between items-center mb-10 px-2">
                <div class="text-right">
                    <h1 class="text-2xl font-black text-gray-800 mb-2">تعديل ملف الشركة</h1>
                    <p class="text-sm text-gray-400 font-bold ">أبقِ بيانات مؤسستك محدثة لضمان تواصل فعال مع المتدربين</p>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-10 py-3.5 rounded-2xl font-black shadow-xl shadow-blue-100/50 hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95 text-sm">حفظ التعديلات</button>
                    <a href="{{ url()->previous() }}" class="bg-white text-gray-400 px-10 py-3.5 rounded-2xl flex items-center justify-center font-black border border-white shadow-sm hover:bg-gray-50 transition-all text-sm">إلغاء</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="max-w-4xl mx-auto mb-6 bg-red-50 border border-red-100 text-red-500 p-5 rounded-[2rem] font-black text-xs animate-pulse">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="max-w-4xl mx-auto space-y-8">

                <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_15px_45px_rgba(0,0,0,0.02)] border border-white">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner border border-blue-100/30">
                            <i class="far fa-building text-xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-800">بيانات الشركة الأساسية</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">اسم الشركة</label>
                            <input type="text" name="company_name" value="{{ $company->company_name ?? '' }}"
                                   class="w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 transition-all outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50">
                        </div>

                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">رقم الهاتف الرسمي</label>
                            <input type="text" dir="ltr" name="phone_number" value="{{ $company->phone_number ?? '' }}"
                                   class="w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 text-right transition-all outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50">
                        </div>

                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">العنوان الفعلي</label>
                            <input type="text" name="location" value="{{ $company->location ?? '' }}"
                                   class="w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 transition-all outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50">
                        </div>

                        <div>
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">الموقع الإلكتروني</label>
                            <input type="text" dir="ltr" name="website" value="{{ $company->website ?? '' }}"
                                   class="w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 text-right transition-all outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">وصف الشركة</label>
                            <textarea name="description" rows="5"
                                      class="w-full bg-gray-50/50 border border-gray-100 p-6 rounded-[2rem] text-sm font-black text-gray-700 leading-relaxed transition-all outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 resize-none">{{ $company->description ?? '' }}</textarea>
                        </div>
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
                            <input type="email" dir="ltr" name="email" value="{{ $company->user->email ?? '' }}"
                                   class="w-full bg-gray-100/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-400 cursor-not-allowed outline-none text-right" readonly>
                        </div>
                        <div class="relative">
                            <label class="block text-[11px] text-gray-400 font-black mb-3 mr-1 uppercase tracking-widest">كلمة المرور الجديدة</label>
                            <input type="password" name="password" placeholder="اتركه فارغاً للحفاظ عليها"
                                   class="w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl text-sm font-black text-gray-700 outline-none transition-all focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50">
                            <i class="far fa-eye absolute left-5 bottom-5 text-gray-300 hover:text-blue-500 cursor-pointer transition-colors"></i>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </main>
@endsection
