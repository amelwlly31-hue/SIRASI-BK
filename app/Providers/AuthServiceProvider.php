<?php

namespace App\Providers;

// use illuminate\support\facades\gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /* the model to policy mappings for the application. @var array<class-string, class-string> */
    protected $policies = [
        // 'app\models\model' => 'app\policies\modelpolicy',
    ];

    /* register any authentication / authorization services. @return void */
    public function boot()
    {
        $this->registerPolicies();

    }
}
