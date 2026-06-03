<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Http\Request;
use App\Jobs\ExportPresensiJob;

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
        Request::macro('prefersJsonResponses', function (): bool {
            return $this->expectsJson() || $this->wantsJson();
        });

        Queue::createPayloadUsing(function (array $payload) {
            return array_merge($payload, ['queued_by' => 'attendance-system']);
        });
        
        Queue::route(ExportPresensiJob::class, 'exports');
        //
    }
}
