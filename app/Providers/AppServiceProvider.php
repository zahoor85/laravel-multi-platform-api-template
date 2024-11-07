<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
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
        // Custom password reset URL
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            // Return the password reset URL with token and email parameter
            return Config::get('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        // Custom email verification URL
        VerifyEmail::createUrlUsing(function ($notifiable) {
            // Create a signed URL for email verification with expiration time
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify', // Route name for verification
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)), // Expiration time
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()), // Hash the email
                ]
            );

            // Return the verification URL with the frontend URL
            return Config::get('app.frontend_url')."?verification_url=".$verificationUrl;
        });
    }
}
