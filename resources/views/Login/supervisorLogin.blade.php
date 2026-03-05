@extends('layouts.app')

@section('title', 'تسجيل الدخول للمشرف')

@section('content')
    <div class="main-wrapper">
        <div class="image-side">
            <img src="{{ asset('assets/img/login-bg.png') }}" alt="Background">
            <div class="blue-overlay"></div>
        </div>

        <div class="form-side">
            <div class="login-box">
                <div class="brand-header">
                    <div class="brand-logo">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="brand-title">
                        <h2>نظام التدريب الميداني</h2>
                        <p>Field Training System</p>
                    </div>
                </div>

                <div class="welcome-section">
                    <h1>مرحباً بك مجدداً</h1>
                    <p>الرجاء إدخال بياناتك للوصول إلى بوابة التدريب</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role" value="supervisor">

                    <div class="input-field">
                        <label>البريد الإلكتروني</label>
                        <div class="input-control">
                            <input type="email" name="email" placeholder="مثال: example@gmail.com" required autofocus>
                            <i class="far fa-user"></i>
                        </div>
                    </div>

                    <div class="input-field">
                        <label>كلمة المرور</label>
                        <div class="input-control">
                            <input type="password" name="password" id="password" required>
                            <i class="fas fa-lock"></i>
                            <i class="far fa-eye show-pass"></i>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">
                        تسجيل الدخول <i class="fas fa-sign-in-alt"></i>
                    </button>

                    <div class="separator"><span>أو</span></div>

                    <a href="#" class="register-btn">
                        <i class="fas fa-user-plus"></i> إنشاء حساب جديد
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
