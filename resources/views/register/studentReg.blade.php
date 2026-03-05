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
        <p class="text-gray-400 font-bold  text-sm">الرجاء إدخال بياناتك للانضمام إلى بوابة الطلاب</p>
    </div>

    <form method="POST" action="{{ route('register.student') }}" enctype="multipart/form-data" class="space-y-12">
        @csrf
        <input type="hidden" name="role" value="student">

        <section>
            <div class="flex items-center gap-2 text-[#0076df] font-black  mb-6">
                <i class="far fa-user"></i>
                <h3>المعلومات الشخصية</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">الاسم الكامل</label>
                    <div class="relative">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="مثال: محمد أحمد"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all  placeholder-gray-300">
                        <i class="far fa-user absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                </div>
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">رقم الهاتف</label>
                    <div class="relative">
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="+966 5x xxx xxxx"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12   text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all  placeholder-gray-300">
                        <i class="fas fa-phone-alt absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="flex items-center gap-2 text-[#0076df] font-black  mb-6">
                <i class="fas fa-university"></i>
                <h3>المعلومات الأكاديمية</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">الرقم الجامعي</label>
                    <div class="relative">
                        <input type="text" name="university_id" placeholder="441000000"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all  placeholder-gray-300">
                        <i class="fas fa-hashtag absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 text-[10px]"></i>
                    </div>
                </div>
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">المعدل التراكمي (GPA)</label>
                    <div class="relative">
                        <input type="text" name="gpa" placeholder="88.5"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all  placeholder-gray-300">
                        <i class="far fa-star absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                </div>
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">التخصص</label>
                    <input type="text" name="major" placeholder="تطوير برمجيات"  class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all  placeholder-gray-300">

                </div>
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">السنة الدراسية</label>
                    <input type="number" name="academic_year" placeholder="3"  class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all  placeholder-gray-300">
                </div>
            </div>

            <div class="mt-8">
                <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">السيرة الذاتية (CV)</label>
                <div class="border-2 border-dashed border-blue-100 rounded-[2.5rem] bg-gray-50/30 p-12 text-center group hover:border-[#0076df] transition-all cursor-pointer relative">
                    <input type="file" name="cv_file" class="absolute inset-0 opacity-0 cursor-pointer">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-sm text-[#0076df]">
                            <i class="fas fa-cloud-upload-alt text-2xl"></i>
                        </div>
                        <p class="text-xs font-black text-gray-500 ">قم بسحب وإفلات السيرة الذاتية هنا</p>
                        <span class="text-[9px] text-gray-300 font-bold ">أو اضغط لتصفح الملفات (PDF OR DOC)</span>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="flex items-center gap-2 text-[#0076df] font-black italic mb-6">
                <i class="fas fa-shield-alt"></i>
                <h3>بيانات الحساب</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">البريد الجامعي</label>
                    <div class="relative">
                        <input type="email" name="email" placeholder="example@university.edu.sa"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all  placeholder-gray-300">
                        <i class="far fa-envelope absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                </div>
                <div class="relative">
                    <label class="block text-[10px] font-black text-gray-800 mb-2 mr-4 ">كلمة المرور</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="••••••••"
                               class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pr-12 text-xs font-bold focus:ring-2 focus:ring-blue-100 outline-none transition-all  placeholder-gray-300">
                        <i class="fas fa-lock absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 text-[11px]"></i>
                    </div>
                </div>
            </div>

            <div class="flex items-start justify-start gap-3 mt-10">
                <input type="checkbox" required class="w-5 h-5 border-gray-200 rounded-full text-[#0076df] focus:ring-0 cursor-pointer">
                <label class="text-[11px] font-bold text-gray-400 ">
                    أوافق على <a href="#" class="text-[#0076df] underline decoration-blue-200">شروط الاستخدام</a> و <a href="#" class="text-[#0076df] underline decoration-blue-200">سياسة الخصوصية</a>
                </label>
            </div>
        </section>

        <div class="pt-4 text-center">
            <button type="submit" class="w-full bg-[#0076df] text-white py-5 rounded-[2rem] text-sm font-black  shadow-2xl shadow-blue-100 hover:bg-blue-700 transition-all flex items-center justify-center gap-3">
                <i class="fas fa-user-plus text-xs"></i> إنشاء حساب جديد
            </button>
            <div class="mt-8">
                <span class="text-gray-300 text-xs  font-bold ">أو</span>
                <br>
                <a href="{{ route('login') }}" class="text-[#0076df] font-black text-xs  hover:underline mt-4 inline-block">لديك حساب بالفعل؟ سجل دخولك الآن</a>
            </div>
        </div>
    </form>
</div>

</body>
</html>
