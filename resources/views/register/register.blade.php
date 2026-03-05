<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#007bff",
                        "background-light": "#f6f6f8",
                        "background-dark": "#121320",
                    },
                    fontFamily: {
                        "display": ["Tajawal", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Tajawal', sans-serif; background-color: #F8FAFC; }
        .role-card:hover .icon-bounce {
            animation: bounce 0.5s infinite alternate;
        }
        @keyframes bounce {
            from { transform: translateY(0); }
            to { transform: translateY(-5px); }
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex flex-col font-display">

<main class="flex-grow flex flex-col items-center justify-center px-6 py-12">
    <div class="max-w-5xl w-full text-center space-y-4 mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight">أهلاً بك في منصة التدريب</h1>
        <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
            مرحباً بك في منصتنا التعليمية. يرجى اختيار الفئة التي تنتمي إليها لنتمكن من توفير الأدوات المناسبة لرحلتك.        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl">

        <a href="{{url('studentReg')}}" class="role-card group relative flex flex-col items-center p-8 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 hover:border-primary hover:shadow-2xl transition-all duration-300 text-center no-underline">
            <div class="w-20 h-20 mb-6 rounded-2xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fa-solid fa-user-graduate text-3xl icon-bounce"></i>
            </div>
            <h3 class="text-xl font-bold mb-2 text-slate-900 dark:text-white">طالب / طالبة</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">                سجل الآن للوصول إلى الدورات التدريبية، إدارة مهامك، ومتابعة تقدمك الأكاديمي بكل سهولة.
            </p>
            <div class="mt-6 flex items-center gap-2 text-primary font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                <span>ابدأ الآن</span>
                <i class="fa-solid fa-chevron-left text-xs mt-1"></i>
            </div>
        </a>

        <a href="{{url('companyReg')}}" class="role-card group relative flex flex-col items-center p-8 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 hover:border-primary hover:shadow-2xl transition-all duration-300 text-center no-underline">
            <div class="w-20 h-20 mb-6 rounded-2xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fa-solid fa-building-user text-3xl icon-bounce"></i>
            </div>
            <h3 class="text-xl font-bold mb-2 text-slate-900 dark:text-white">جهة التدريب</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">                            ابحث عن أفضل المواهب، أعلن عن فرص تدريبية، وقم بإدارة شراكاتك التعليمية والمهنية.
            </p>
            <div class="mt-6 flex items-center gap-2 text-primary font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                <span>انضم كشريك</span>
                <i class="fa-solid fa-chevron-left text-xs mt-1"></i>
            </div>
        </a>

        <a href="{{url('superReg')}}" class="role-card group relative flex flex-col items-center p-8 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 hover:border-primary hover:shadow-2xl transition-all duration-300 text-center no-underline">
            <div class="w-20 h-20 mb-6 rounded-2xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fa-solid fa-chalkboard-user text-3xl icon-bounce"></i>
            </div>
            <h3 class="text-xl font-bold mb-2 text-slate-900 dark:text-white">مشرف / مشرفة</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">                            لإدارة العمليات التعليمية، متابعة المتدربين، وتقديم التقييمات والإشراف الأكاديمي المتخصص.
            </p>
            <div class="mt-6 flex items-center gap-2 text-primary font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                <span>ابدأ الآن</span>
                <i class="fa-solid fa-chevron-left text-xs mt-1"></i>
            </div>
        </a>
    </div>

    <div class="fixed top-0 right-0 -z-10 w-1/3 h-1/3 bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 -z-10 w-1/4 h-1/4 bg-primary/5 rounded-full blur-[100px] pointer-events-none"></div>
</main>
</body>
</html>
