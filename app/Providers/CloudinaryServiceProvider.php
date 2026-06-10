<?php

namespace App\Providers;

use App\Support\CloudinaryStorage;
use Illuminate\Support\ServiceProvider;

class CloudinaryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CloudinaryStorage::class);
    }
}
