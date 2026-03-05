<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

class roleadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->registerSmtAdminRouteAliases();

        if(Auth::check() && auth()->user()->type== '2'){
            return $next($request);
        }
        return redirect('/SMARMANger');

    }

    private function registerSmtAdminRouteAliases()
    {
        $routes = app('router')->getRoutes();
        $aliases = [];

        foreach ($routes as $route) {
            $name = $route->getName();
            if (!$name) {
                continue;
            }

            $uri = $route->uri();
            if (strpos($uri, 'SMT/admin') === 0 && strpos($name, 'admin.') !== 0) {
                $aliases['admin.'.$name] = $route;
            }
        }

        if (empty($aliases)) {
            return;
        }

        $reflection = new ReflectionClass($routes);
        $nameList = $reflection->getProperty('nameList');
        $nameList->setAccessible(true);
        $currentNameList = $nameList->getValue($routes);

        foreach ($aliases as $alias => $route) {
            $currentNameList[$alias] = $route;
        }

        $explicitAliases = [
            'admin.user_delete' => 'user.delete',
            'admin.gradebook.view_grid' => 'admin.gradebook.view_grid_simple',
            'admin.gradebook.edit_class' => 'admin.gradebook.settings',
            'admin.gradebook.edit_subject' => 'admin.gradebook.settings.rooms',
            'admin.gradebook.edit_settings' => 'admin.gradebook.settings.edit',
        ];

        foreach ($explicitAliases as $alias => $targetName) {
            if (isset($currentNameList[$targetName])) {
                $currentNameList[$alias] = $currentNameList[$targetName];
            }
        }

        $nameList->setValue($routes, $currentNameList);
    }
}
