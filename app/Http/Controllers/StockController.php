<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

class StockController extends Controller
{
     public function index()
    {
        $menus = Menu::all();
        return view('stock.index', compact('menus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $old = $menu->stock;
        $menu->stock = $data['stock'];
        $menu->save();

        return redirect()
            ->route('stock.index')
            ->with('success', "Stock " . strtolower($menu->name) . " telah diubah dari {$old} ke {$menu->stock}");
    }
}
