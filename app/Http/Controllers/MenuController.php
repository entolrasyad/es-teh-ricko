<?php

namespace App\Http\Controllers;

use App\Models\Menu;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(){
        $menus = Menu::all();

        return view('menus.index', compact('menus'));
    }

    public function test(){
        $menus = Menu::all();

        return view('menus.index', compact('menus'));
    }


}
