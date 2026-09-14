<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\SiteSetting;
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
        if (file_exists(app_path('helpers.php'))) {
            require_once app_path('helpers.php');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Automatically force HTTPS when served through ngrok or HTTPS reverse proxies
        if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || 
            (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'ngrok'))) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share active hierarchical services and site settings with public views
        View::composer(['layouts.app', 'partials.header', 'partials.footer'], function ($view) {
            if (Schema::hasTable('services')) {
                $navServices = Service::parents()
                    ->active()
                    ->ordered()
                    ->with(['children' => function ($q) {
                        $q->active()->ordered();
                    }])
                    ->get();
                $view->with('navServices', $navServices);
            }
        });

        // Track content created by demo users and set 3-minute expiration
        \Illuminate\Support\Facades\Event::listen('eloquent.created: *', function ($eventName, array $data) {
            try {
                if (!empty($data[0]) && is_object($data[0])) {
                    $model = $data[0];
                    if ($model instanceof \App\Models\DemoRecord) {
                        return;
                    }

                    if (auth()->check()) {
                        $user = auth()->user();
                        $isDemo = str_starts_with(strtolower($user->email ?? ''), 'demo') || 
                                  str_contains(strtolower($user->email ?? ''), 'demo');

                        if ($isDemo && $model->getKey()) {
                            if (Schema::hasTable('demo_records')) {
                                \App\Models\DemoRecord::create([
                                    'record_type' => get_class($model),
                                    'record_id' => $model->getKey(),
                                    'user_id' => $user->id,
                                    'expires_at' => now()->addMinutes(3),
                                ]);
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Silently fail if table not available or error occurs
            }
        });
    }
}
