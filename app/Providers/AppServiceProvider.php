<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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
        // Set default password rules for the application
        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->numbers();
                // Removed mixedCase(), symbols(), and uncompromised() requirements
        });

        // Custom validation message
        Validator::extend('password_format', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9]+$/', $value);
        });

        Validator::replacer('password_format', function ($message, $attribute, $rule, $parameters) {
            return 'Password can only contain letters and numbers.';
        });
    }
}
