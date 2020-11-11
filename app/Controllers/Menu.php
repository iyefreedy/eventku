<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Menu extends BaseController
{
    public function addItem()
    {
        if ($this->request->getPost()) {
            $post = $this->request->getPost();
            $image = $this->request->getFile('image');
            if ($this->validator->run($post, 'additem')) {

                $productModel = new ProductModel();
                $imagename = $image->getRandomName();

                $productModel->save([
                    'name'          => $this->request->getPost('name'),
                    'price'         => $this->request->getPost('price'),
                    'description'   => $this->request->getPost('description'),
                    'image'         => $imagename
                ]);
                $image->move('img', $imagename);

                session()->setFlashdata('success', 'Produk baru telah ditambahkan');
                return redirect()->to('/user');
            }
        }

        $data = [
            'title' => 'Add Item | Eventku',
            'validation' => $this->validator
        ];

        return view('menu/add_item', $data);
    }
}
