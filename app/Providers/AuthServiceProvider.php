<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('register-user', function ($email = null) {
            if (Setting::get('allow_user_registration') === true) {
                if (isset($email) && Setting::get('restrict_user_email_domain') === true) {
                    list($emailUser, $emailDomain) = explode('@', $email, 2);

                    if (isset($emailDomain) && strlen($emailDomain) > 0) {
                        $domains = Setting::get('allowed_user_email_domains');

                        if (is_array($domains) && count($domains) > 0 && in_array($email, $domains)) {
                            return Response::allow();
                        }
                    }
                } else {
                    return Response::allow();
                }
            }

            return Response::deny(__('auth.registration_not_available'));
        });
    }
}
