<?php 
namespace App\Helpers;

class CommonOption
{
	//status
    static function statusArray()
    {
        return array(ACTIVE=>'Kích hoạt', INACTIVE=>'Không kích hoạt');
    }
    static function getStatus($status=ACTIVE)
    {
    	$array = self::statusArray();
        if($status == ACTIVE) {
            return $array[$status];
        } else {
            return '<span style="color: red;">'.$array[$status].'</span>';
        }
    }
    //language
    static function langArray()
    {
        return array(VI=>'Tiếng việt'); //, VI=>'Tiếng việt', EN=>'Tiếng anh'
    }
    static function getLang($lang=VI)
    {
    	$array = self::langArray();
        return $array[$lang];
    }
    //menu
    static function menuTypeArray()
    {
        return array(
            MENUTYPE1=>'Top menu', 
            MENUTYPE2=>'Side menu', 
            MENUTYPE3=>'Bottom menu',
            MENUTYPE4=>'Top game of year menu',
            MENUTYPE5=>'Seri menu',
            MENUTYPE6=>'Tag menu'
        );
    }
    static function getMenuType($menuType=ACTIVE)
    {
        $array = self::menuTypeArray();
        return $array[$menuType];
    }
    //type game
    static function typeGameArray()
    {
        return array(POST=>'Post', GAMEHTML5=>'Game HTML5', GAMEFLASH=>'Game Flash');
    }
    static function getTypeGame($type=GAMEHTML5)
    {
        $array = self::typeGameArray();
        return $array[$type];
    }
    //role admin
    static function roleArray()
    {
        return array(ADMIN=>'Admin'); //, EDITOR=>'Editor'
    }
    static function getRole($roleId=ADMIN)
    {
        $array = self::roleArray();
        return $array[$roleId];
    }
    //screen
    static function screenArray()
    {
        return array(HORIZONTAL=>'Ngang', VERTICAL=>'Dọc');
    }
    static function getScreen($screen=HORIZONTAL)
    {
        $array = self::screenArray();
        return $array[$screen];
    }
    //ad position
    static function adPositionArray()
    {
        return array(
            //all site
            1 => 'Header - PC',
            2 => 'Header - Mobile',
            3 => 'Footer - PC',
            4 => 'Footer - Mobile',
            5 => 'Preroll - PC',
            6 => 'Preroll - Mobile',
            
        );
    }
    static function getAdPosition($adPosition)
    {
        $array = self::adPositionArray();
        return $array[$adPosition];
    }
    //sort by game type
    static function gameSortByArray()
    {
        return array(
            'start_date' => 'Mặc định (Ngày đăng giảm dần)',
            'view' => 'Lượt chơi giảm dần',

        );
    }
    static function getGameSortBy($sortBy)
    {
        $array = self::gameSortByArray();
        return $array[$sortBy];
    }
}