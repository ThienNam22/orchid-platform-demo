<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        // Viec them permission nay khong thay no thay doi o dau
        $permissions = ItemPermission::group(__('Car'))

            ->addPermission('platform.system.car.edit', 'Access to edit Car')
            ->addPermission('platform.system.car.list', 'Access to List Car');

        $dashboard->registerPermissions($permissions);
    }
}
