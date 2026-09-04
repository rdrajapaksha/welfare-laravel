<?php

namespace App\Providers;

use App\Models\Election;
use App\Support\Dictionary;
use App\Support\Nav;
use App\Support\SiteContent;
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
        View::composer('*', function ($view): void {
            if ($view->offsetExists('d')) {
                return;
            }

            $dictionary = Dictionary::all();
            $hasOpenElection = Election::open()->exists();

            $view->with([
                'd' => $dictionary,
                'locale' => app()->getLocale(),
                'siteNav' => Nav::main($dictionary),
                'footerNav' => Nav::footer($dictionary),
                'memberNav' => Nav::member($dictionary, $hasOpenElection),
                'adminNav' => Nav::admin($dictionary),
                'site' => SiteContent::identity(),
                'hasOpenElection' => $hasOpenElection,
            ]);
        });
    }
}
