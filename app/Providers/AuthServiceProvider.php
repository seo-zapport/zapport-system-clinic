<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        // 'App\User_role' => 'App\Policies\UserRolePolicy',
        'App\Employee' => 'App\Policies\EmployeePolicy',
        'App\Employee' => 'App\Policies\DashboardPolicy',
        'App\Post'     => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        $gate->define('isAdmin', function($user){
            foreach ($user->roles as $role) {
                return $role->role == 'admin';
            }
        });

        $gate->define('isHr', function($user){
            foreach ($user->roles as $role) {
                return $role->role == 'hr';
            }
        });

        $gate->define('isDoctor', function($user){
            foreach ($user->roles as $role) {
                return $role->role == 'doctor';
            }
        });

        $gate->define('isNurse', function($user){
            foreach ($user->roles as $role) {
                return $role->role == 'nurse';
            }
        });

        $gate->define('isBanned', function($user){
            foreach ($user->roles as $role) {
                return $role->role == 'banned';
            }
        });

        $gate->define('isEmployee', function($user){
            foreach ($user->roles as $role) {
                return $role->role == 'employee';
            }
        });

    }
}
