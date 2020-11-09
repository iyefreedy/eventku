<?php

namespace App\Controllers;

class Menu extends BaseController
{
    public function addItem()
    {
        $data = [
            'title' => 'Add Item | Eventku'
        ];
        return view('menu/add_item', $data);
    }
}
