<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard | Eventku'
        ];

        return view('user/index', $data);
    }
}
