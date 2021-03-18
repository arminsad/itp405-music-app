<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\User;
use App\Models\Role;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $config = Configuration::where('name', '=', 'maintenance-mode')->first();
        if ($config->name == 'maintenance-mode' && $config->value == true){
            return redirect()->route('maintenance');
        }
        return $next($request);
    }
}
