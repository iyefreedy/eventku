<?php

namespace App\Controllers;

use App\Models\ProductModel;

class User extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $data = [
            'title'     => 'Dashboard | Eventku',
            'product'   => $productModel->findAll()
        ];

        return view('user/index', $data);
    }
}
