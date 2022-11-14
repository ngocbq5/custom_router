<?php

namespace App\Controller;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductController
{
    public function index()
    {
        $data = ProductModel::all();
        var_dump($data);
    }
    public function show($id)
    {

        $data = ProductModel::find($id);
        echo "<pre>";
        var_dump($data);
    }
    public function showCate($id)
    {
        $data = CategoryModel::find($id);
        echo "<pre>";
        var_dump($data);
    }
}
