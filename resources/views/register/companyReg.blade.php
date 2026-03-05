<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'نظام التدريب الميداني')</title>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Tajawal', sans-serif;}
    </style>

</head>
<body class="bg-white min-h-screen">

<header class="p-6 flex justify-between items-center max-w-7xl mx-auto">
    <div class="flex items-center gap-3">
        <div class="bg-[#0076df] p-2 rounded-xl shadow-lg shadow-blue-100">
            <i class="fas fa-graduation-cap text-white text-xl"></i>
        </div>
        <div class="text-right">
            <h1 class="text-[#0076df] font-black text-xl  leading-none">نظام التدريب الميداني</h1>
            <p class="text-gray-400 text-[16px]   tracking-tighter">Field Training System</p>
        </div>

    </div>
</header>

<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="text-start mb-12">
        <h2 class="text-4xl font-black text-[#0076df] mb-2 ">إنشاء حساب جديد</h2>
        <p class="text-gray-400 font-bold  text-sm">الرجاء إدخال بياناتك للانضمام إلى بوابة الشركات</p>
    </div>

    <form method="POST" action="{{ route('register.company') }}" class="space-y-12">
        @csrf
        <input type="hidden" name="role" value="company">

        <section class="space-y-6">
            <div class="flex items-center gap-2 text-[#0076df] font-black  mb-4">
                <i class="fas fa-building text-sm"></i>
                <h3>بيانات الشركة الأساسية</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">الاسم الشركة</label>
                    <div class="relative">
                        <input type="text" name="name" placeholder="مثال: أوبيرا" value="{{ old('name') }}"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all ">
                        <i class="far fa-building absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                    @error('name') <p class="text-red-500 text-[10px] mt-1 mr-2 ">{{ $message }}</p> @enderror
                </div>

                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">رقم الهاتف</label>
                    <div class="relative">
                        <input type="text" name="phone_number" placeholder="+966 5x xxx xxxx" value="{{ old('phone_number') }}"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12  text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all ">
                        <i class="fas fa-phone-alt absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                    @error('phone_number') <p class="text-red-500 text-[10px] mt-1 mr-2 ">{{ $message }}</p> @enderror
                </div>

                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">الموقع الإلكتروني</label>
                    <div class="relative">
                        <input type="text" name="website" placeholder="www.company.com" value="{{ old('website') }}"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12  text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all ">
                        <i class="fas fa-globe absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                    @error('website') <p class="text-red-500 text-[10px] mt-1 mr-2 ">{{ $message }}</p> @enderror
                </div>

                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">العنوان</label>
                    <div class="relative">
                        <input type="text" name="location" placeholder="الرمال - شارع الوحدة" value="{{ old('location') }}"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all ">
                        <i class="fas fa-map-marker-alt absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                    @error('location') <p class="text-red-500 text-[10px] mt-1 mr-2 ">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="relative">
                <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">الوصف</label>
                <div class="relative">
                        <textarea name="description" rows="4" placeholder="مثال: شركة رائدة في تكنولوجيا المعلومات"
                                  class="w-full bg-gray-50 border border-gray-100 rounded-3xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all  resize-none">{{ old('description') }}</textarea>
                    <i class="far fa-comment-dots absolute right-5 top-6 text-gray-300"></i>
                </div>
                @error('description') <p class="text-red-500 text-[10px] mt-1 mr-2 ">{{ $message }}</p> @enderror
            </div>
        </section>

        <section class="space-y-6">
            <div class="flex items-center gap-2 text-[#0076df] font-black  mb-4">
                <i class="fas fa-lock text-sm"></i>
                <h3>بيانات الحساب</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">البريد الإلكتروني</label>
                    <div class="relative">
                        <input type="email" name="email" placeholder="example@university.edu.sa" value="{{ old('email') }}"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all ">
                        <i class="far fa-envelope absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                    @error('email') <p class="text-red-500 text-[10px] mt-1 mr-2 ">{{ $message }}</p> @enderror
                </div>

                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">كلمة المرور</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="••••••••"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all ">
                        <i class="fas fa-lock absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 text-[11px]"></i>
                    </div>
                    @error('password') <p class="text-red-500 text-[10px] mt-1 mr-2 ">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-start gap-3 mt-8">
                <input type="checkbox" required class="w-5 h-5 border-gray-200 rounded-full text-[#0076df] focus:ring-0 cursor-pointer">

                <label class="text-[11px] font-bold text-gray-400  cursor-pointer">
                    أوافق على <a href="#" class="text-[#0076df] underline decoration-blue-200">شروط الاستخدام</a> و <a href="#" class="text-[#0076df] underline decoration-blue-200">سياسة الخصوصية</a>
                </label>
            </div>
        </section>

        <div class="text-center pt-6">
            <button type="submit" class="w-full bg-[#0076df] text-white py-5 rounded-[2.2rem] text-sm font-black  shadow-2xl shadow-blue-100 hover:bg-blue-700 transition-all flex items-center justify-center gap-3">
                إنشاء حساب جديد <i class="fas fa-user-plus text-xs"></i>
            </button>
            <div class="mt-8">
                <span class="text-gray-300 text-xs  font-bold">أو</span>
                <br>
                <a href="{{ route('login') }}" class="text-[#0076df] font-black text-xs  hover:underline mt-4 inline-block">لديك حساب بالفعل؟ سجل دخولك الآن</a>
            </div>
        </div>
    </form>
</div>

</body>
</html>
