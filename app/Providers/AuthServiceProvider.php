<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
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
            return Config::get('app.frontend_url')."?verification_url=".urldecode($verificationUrl);
        });
    }
}
