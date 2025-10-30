<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        // Set locale and timezone for Senegal (French)
        setlocale(LC_TIME, 'fr_SN.UTF-8', 'fr_FR.UTF-8', 'fr_FR', 'fr.UTF-8');
        Carbon::setLocale(config('app.locale'));

        // Blade directive to format currency in XOF
        Blade::directive('currency', function ($amount) {
            return "<?php echo number_format((int)($amount), 0, ',', ' ') . ' XOF'; ?>";
        });

        // Blade directive to format dates in localized long format
        Blade::directive('datetime', function ($expression) {
            return "<?php echo (\Carbon\Carbon::parse($expression))->locale(config('app.locale'))->isoFormat('LL'); ?>";
        });

        // Share a page-specific background image URL with all views
        View::composer('*', function ($view) {
            $route = optional(request()->route())->getName();

            $map = [
                null => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80',
                'welcome' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80',
                'dashboard' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1600&q=80',
                'products.index' => 'https://images.unsplash.com/photo-1542831371-d531d36971e6?auto=format&fit=crop&w=1600&q=80',
                'products.show' => 'https://images.unsplash.com/photo-1505577058444-a3dab40a5b57?auto=format&fit=crop&w=1600&q=80',
                'equipment.index' => 'https://images.unsplash.com/photo-1500504902414-2f1b1d5d3f2a?auto=format&fit=crop&w=1600&q=80',
                'equipment.show' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1600&q=80',
                'admin.dashboard' => 'https://images.unsplash.com/photo-1526318472351-c75fcf070f8d?auto=format&fit=crop&w=1600&q=80',
                'profile.edit' => 'https://images.unsplash.com/photo-1556157382-97eda2d62296?auto=format&fit=crop&w=1600&q=80',
            ];

            $bg = $map[$route] ?? $map[null];

            $view->with('pageBackground', $bg);
        });
    }
}
