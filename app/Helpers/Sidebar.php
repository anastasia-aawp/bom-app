<?php

namespace App\Helpers;

use Idev\EasyAdmin\app\Helpers\Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Sidebar
{

  public function generate()
  {    
    $menus = $this->menus();

    $arrMenu = [];
    foreach ($menus as $key => $menu) {
      // $menu['visibility'] = in_array($menu['key'].".index", $permission['list_access']);
      $menu['url'] = (Route::has($menu['key'].".index")) ? route($menu['key'].".index") : "#";
      $menu['base_key'] = $menu['key'];
      $menu['key'] = $menu['key'].".index";

      $arrMenu[] = $menu;
    }
    return $arrMenu;
  }


  public function menus(){
    $role = "admin";
    if(config('idev.enable_role',true)){
      $role = Auth::user()->role->name;
    }
    return
      [
        //MVC Mst Material
        [
          'name' => 'Mst Material',
          'icon' => 'ti ti-menu',
          'key' => 'mst-material',
          'base_key' => 'mst-material',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        //MVC Mst Product
        [
          'name' => 'Mst Product',
          'icon' => 'ti ti-menu',
          'key' => 'mst-product',
          'base_key' => 'mst-product',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        //MVC Stock Material
        [
          'name' => 'Stock Material',
          'icon' => 'ti ti-menu',
          'key' => 'stock-material',
          'base_key' => 'stock-material',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        //MVC Trans Product
        [
          'name' => 'Trans Product',
          'icon' => 'ti ti-menu',
          'key' => 'trans-product',
          'base_key' => 'trans-product',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Dashboard',
          'icon' => 'ti ti-dashboard',
          'key' => 'dashboard',
          'base_key' => 'dashboard',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Role',
          'icon' => 'ti ti-key',
          'key' => 'role',
          'base_key' => 'role',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'User',
          'icon' => 'ti ti-users',
          'key' => 'user',
          'base_key' => 'user',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],
      ];
  }


  public function defaultAllAccess($exclude = []) {
    return ['list', 'create','show', 'edit', 'delete','import-excel-default', 'export-excel-default','export-pdf-default'];
  }

}
