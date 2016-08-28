<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        self::getMenus(MENUTYPE1, 'topmenu');
        self::getMenus(MENUTYPE2, 'sidemenu');
        self::getMenus(MENUTYPE3, 'bottommenu');
        self::getMenus(MENUTYPE4, 'topgamemenu');
        self::getMenus(MENUTYPE5, 'serimenu');
        self::getMenus(MENUTYPE6, 'tagmenu');
    }

    private function getMenus($type, $name)
    {
        $menu = DB::table('menus')
            ->where('status', ACTIVE)
            ->where('type', $type)
            ->orderByRaw(DB::raw("position = '0', position"))
            ->orderBy('name')
            ->get();
        view()->share($name, $menu);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
