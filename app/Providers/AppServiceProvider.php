<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        View::composer(['layouts.student', 'layouts.company', 'layouts.admin','layouts.supervisor'], function ($view) {
            $user = Auth::user();
            $notifications = [];

            if ($user) {
                if ($view->getName() === 'layouts.student' && $user->student) {
                    $notifications = $user->student->notifications()->whereNull('read_at')->get();
                } elseif ($view->getName() === 'layouts.company' && $user->company) {
                    $notifications = $user->company->notifications()->whereNull('read_at')->get();
                } elseif ($view->getName() === 'layouts.admin') {
                    $notifications = $user->notifications()->whereNull('read_at')->get();
                }  elseif ($view->getName() === 'layouts.supervisor' && $user->supervisor) {
                    $notifications = $user->supervisor->notifications()->whereNull('read_at')->get();
                }
            }

            $view->with('notifications', $notifications);
        });
    }

}
