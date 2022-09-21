<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Administrator;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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

        // new gate here
        // Gate::define('administrator', function(Administrator $administrator){

        //     $user = \Illuminate\Support\Facades\Auth::guard('administrator')->user()->administrator_name;

        //     return $user === 'admin';
        // });

    }
}
