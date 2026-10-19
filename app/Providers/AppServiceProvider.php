<?php

namespace App\Providers;

use App\Models\CmsCard;
use App\Models\CmsFooter;
use App\Models\CmsHeader;
use App\Models\SiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
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
        try {
            $siteSettings = null;
            $headerItems = collect();
            $footerItems = collect();
            $heroSlides = collect();
            $featureCards = collect();
            $serviceCards = collect();
            $testimonialCards = collect();

            if (Schema::hasTable('site_settings')) {
                $siteSettings = SiteSetting::first();
            }

            if (Schema::hasTable('cms_header')) {
                $headerItems = CmsHeader::where('is_visible', true)
                    ->orderBy('order')
                    ->get();
            }

            if (Schema::hasTable('cms_footers')) {
                $footerItems = CmsFooter::where('is_visible', true)
                    ->orderBy('order')
                    ->get();
            }

            if (Schema::hasTable('cms_cards')) {
                $heroSlides = CmsCard::where('section', 'hero')
                    ->where('type', 'slide')
                    ->where('is_visible', true)
                    ->orderBy('order')
                    ->get();

                $featureCards = CmsCard::where('section', 'features')
                    ->where('is_visible', true)
                    ->orderBy('order')
                    ->get();

                $serviceCards = CmsCard::where('section', 'services')
                    ->where('is_visible', true)
                    ->orderBy('order')
                    ->get();

                $testimonialCards = CmsCard::where('section', 'testimonials')
                    ->where('is_visible', true)
                    ->orderBy('order')
                    ->get();
            }

            View::share(compact(
                'siteSettings',
                'headerItems',
                'footerItems',
                'heroSlides',
                'featureCards',
                'serviceCards',
                'testimonialCards'
            ));
        } catch (QueryException $exception) {
            View::share('siteSettings', null);
            View::share('headerItems', collect());
            View::share('footerItems', collect());
            View::share('heroSlides', collect());
            View::share('featureCards', collect());
            View::share('serviceCards', collect());
            View::share('testimonialCards', collect());
        }
    }
}
