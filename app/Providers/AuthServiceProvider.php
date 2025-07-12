<?php

namespace App\Providers;

use App\Policies\AdminPolicy;
use App\Policies\ReportPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Report::class => ReportPolicy::class,
    ];

    public function boot(): void
    {
        Gate::define('update-report', [ReportPolicy::class, 'update']);
        Gate::define('delete-report', [ReportPolicy::class, 'delete']);
        Gate::define('isAdmin', [AdminPolicy::class, 'isAdmin']);
    }
}
