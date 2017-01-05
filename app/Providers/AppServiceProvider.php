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
        //head tag code
        view()->share('scriptcode', self::getCode());
        //all menu
        view()->share('topmenu', self::getMenu());
        // self::getMenus(MENUTYPE1, 'topmenu');
        self::getMenus(MENUTYPE2, 'sidemenu');
        self::getMenus(MENUTYPE3, 'bottommenu');
        self::getMenus(MENUTYPE4, 'topgamemenu');
        self::getMenus(MENUTYPE5, 'serimenu');
        self::getMenus(MENUTYPE6, 'tagmenu');
        self::getMenus(MENUTYPE7, 'mobilemenu');
    }

    private function getCode()
    {
        $config = DB::table('configs')->first();
        if(isset($config)) {
            return $config->code;
        } else {
            return '';
        }
    }

    private function getMenus($type, $name)
    {
        $menu = DB::table('menus')
            ->where('type', $type)
            ->where('status', ACTIVE)
            ->orderByRaw(DB::raw("position = '0', position"))
            ->orderBy('name')
            ->get();
        view()->share($name, $menu);
    }

    private function getMenu($type=MENUTYPE1)
    {
        $data = DB::table('menus')
            ->select('id', 'name', 'url', 'parent_id', 'level', 'position')
            ->where('type', $type)
            ->where('status', ACTIVE)
            ->orderByRaw(DB::raw("position = '0', position"))
            ->orderBy('name')
            ->get();
        if($type=MENUTYPE1) {
            $output = '<ul class="dropdown menu" data-dropdown-menu>';
        } else {
            $output = '<ul class="menu">';
        }
        $output .= self::_visit($data, $type);
        $output .= '</ul>';
        return $output;
    }
    private function _visit($data, $type=MENUTYPE1, $parentId=0)
    {
        $output = '';
        $sub = self::_sub($data, $parentId);
        if(count($sub) > 0) {
            foreach($sub as $value) {
                $hasChild = self::_hasChild($value->id);
                $output .= '<li '.checkCurrent(url($value->url)).'><a href="'.url($value->url).'">'.$value->name.'</a>';
                if($hasChild) {
                    $output .= '<ul class="menu">';
                    $output .= self::_visit($data, $type, $value->id);
                    $output .= '</ul></li>';    
                } else {
                    $output .= '</li>';
                }
            }
        }
        return $output;
    }
    private function _sub($data, $parentId)
    {
        $sub = array();
        if(isset($data)) {
            foreach($data as $key => $value) {
                if ($value->parent_id == $parentId) {$sub[$key] = $value;}
            }
        }
        return $sub;
    }
    private function _hasChild($id)
    {
        $data = DB::table('menus')
            ->where('parent_id', $id)
            ->where('status', ACTIVE)
            ->first();
        if($data) {
            return true;
        } else {
            return null;
        }
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
