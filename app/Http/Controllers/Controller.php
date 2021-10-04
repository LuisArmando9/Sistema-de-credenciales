<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Database\Seeders\RoleSeeder;
use App\Providers\RouteServiceProvider;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected function redirectTo()
    {
        if(Auth::user()->hasRole(RoleSeeder::ROLE_ADMIN)){
            return RouteServiceProvider::HOME_ADMIN;
        }
        return RouteServiceProvider::HOME_USER;
    }
}
