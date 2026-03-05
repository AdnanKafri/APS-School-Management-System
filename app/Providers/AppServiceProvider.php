<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Events\RouteMatched;
use ReflectionClass;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->applyAdminRouteAliases();
        $this->app->booted(function () {
            $this->applyAdminRouteAliases();
        });

        Event::listen(RouteMatched::class, function () {
            $this->applyAdminRouteAliases();
        });
    }

    private function applyAdminRouteAliases()
    {
        static $applied = false;
        if ($applied) {
            return;
        }

        $routes = $this->app['router']->getRoutes();
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
        $applied = true;
    }
}
