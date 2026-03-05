<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة التدريب - لوحة التحكم</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/supervisor.css')}}">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0076df",
                        "accent": "#ec5b13",
                        "background-light": "#f8f9fc",
                        "background-dark": "#0b0e2b",
                    },
                    fontFamily: {
                        "display": ["Tajawal", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.75rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 transition-colors duration-300">
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
    <!-- Navigation -->
    <header class="sticky top-0 z-50 w-full border-b border-slate-200 dark:border-primary/20 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-[#0076df] p-2 rounded-xl shadow-lg shadow-blue-100">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-primary dark:text-white text-xl font-extrabold tracking-tight">بوابة التدريب الميداني</h1>
                    <p class="text-slate-500 text-xs font-medium">نظام الإدارة الإلكتروني الموحد</p>
                </div>
            </div>
            <div class="flex items-center gap-4">

                <a  href="{{route('loginAll')}}" class="px-5 py-2 text-primary  hover:bg-slate-100 rounded-lg transition-all">
                    تسجيل الدخول
                </a>
                <a href="{{url('registerAll')}}" class="px-5 py-2 text-primary  hover:bg-slate-100 rounded-lg transition-all">
                    إنشاء حساب
                </a>
            </div>
        </div>
    </header>
    <!-- Hero Section -->
    <section class="relative pt-12 pb-24 lg:pt-20 overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 text-center">

            <h1 class="text-4xl lg:text-5xl font-extrabold text-primary dark:text-slate-100 mb-6">نظام إدارة التدريب الميداني</h1>
            <p class="text-xl text-slate-600 dark:text-slate-400 leading-relaxed">
                مرحباً بك في المنصة الموحدة لإدارة كافة متطلبات التدريب الميداني الأكاديمي والمهني للجامعة.
            </p>
        </div>
    </section>
    <section class="py-12 bg-slate-50 dark:bg-background-dark/20 min-h-[600px]">
        <div class="max-w-7xl mx-auto px-6">
            <div >
                <div >
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-primary/20 h-full">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold text-primary dark:text-white flex items-center gap-3">
                                <i class="fas fa-bullhorn text-[#ec5b13]"></i>
                                لوحة الإعلانات والمستجدات
                            </h3>
                            <a class="text-sm font-bold text-primary hover:underline" href="#">أرشيف الإعلانات</a>
                        </div>
                        <div class="space-y-6">
                            <div class="group p-5 rounded-xl border border-slate-100 dark:border-slate-700 hover:border-accent transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="px-3 py-1 bg-orange-100 text-accent text-xs font-bold rounded-full">تنبيه هام</span>
                                    <span class="text-xs text-slate-400">اليوم، ١٠:٠٠ ص</span>
                                </div>
                                <h4 class="font-bold text-lg text-slate-800 dark:text-slate-200 mb-2 group-hover:text-primary transition-colors">تمديد فترة تسليم التقارير النهائية</h4>
                                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                                    تقرر تمديد فترة تسليم التقارير النهائية للفصل الحالي لمدة أسبوع إضافي لتمكين الطلاب من إكمال التقييمات المطلوبة.
                                </p>
                            </div>
                            <div class="group p-5 rounded-xl border border-slate-100 dark:border-slate-700 hover:border-primary transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="px-3 py-1 bg-blue-100 text-primary text-xs font-bold rounded-full">أخبار الجامعة</span>
                                    <span class="text-xs text-slate-400">أمس</span>
                                </div>
                                <h4 class="font-bold text-lg text-slate-800 dark:text-slate-200 mb-2 group-hover:text-primary transition-colors">ورشة عمل حول مهارات التوظيف بعد التدريب</h4>
                                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                                    تعقد عمادة شؤون الطلاب ورشة عمل تفاعلية يوم الثلاثاء القادم لمناقشة كيفية الاستفادة من تجربة التدريب الميداني في بناء السيرة الذاتية.
                                </p>
                            </div>
                            <div class="group p-5 rounded-xl border border-slate-100 dark:border-slate-700 hover:border-primary transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full">تذكير</span>
                                    <span class="text-xs text-slate-400">قبل ٣ أيام</span>
                                </div>
                                <h4 class="font-bold text-lg text-slate-800 dark:text-slate-200 mb-2 group-hover:text-primary transition-colors">تحديث دليل كتابة التقارير الدورية</h4>
                                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                                    يرجى الالتزام بالنموذج المحدث للتقارير الأسبوعية المتوفر في قسم الملفات، حيث لن يتم قبول التقارير بالصيغ القديمة.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white dark:bg-background-dark/90 border-t border-slate-200 dark:border-primary/20 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium flex gap-6">
                    <a class="hover:text-primary" href="#">مركز المساعدة</a>
                    <a class="hover:text-primary" href="#">سياسة الاستخدام</a>
                    <a class="hover:text-primary" href="#">دليل الطالب</a>
                </div>
                <div class="text-slate-400 text-xs text-center md:text-left">
                    حقوق الطبع والنشر © 2024 عمادة شؤون الطلاب - إدارة التدريب الميداني. جميع الحقوق محفوظة.
                </div>
            </div>
        </div>
    </footer>
</div>
</body></html>
