<?php

namespace App\Controller;

use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    public function create()
    {
    }
    public function store()
    {
        $request = $_POST;
        $cate = new CategoryModel();
        $cate->cate_name = 'Iphone';
        $cate->save();
    }
    public function edit()
    {
        $id = 15;
        $cate = CategoryModel::find($id);
        $cate->cate_name = 'Samsung';
        $cate->save();
    }
    public function delete($id)
    {
        // $id = $_GET['id'];
        echo CategoryModel::destroy($id);
    }
}
