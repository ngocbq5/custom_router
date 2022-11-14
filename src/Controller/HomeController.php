<?php

namespace App\Controller;

use App\Models\BaseModel;
use App\Models\CategoryModel;
use App\Models\TestModel;

class HomeController extends BaseController
{
    public function index()
    {
        echo __CLASS__ . "<br>";
        echo "HOME CONTROLLER PAGE";

        $test = TestModel::where('id', '=', 77)->orWhere('price', '>', 50000)->first();
        echo "<pre>";
        var_dump($test);
        echo "</pre>";
        return $this->view('admin.index', []);
    }
    public function contact()
    {
        echo "Contact Page";
        echo "<h2>Contact default</h2>";
    }
    public function addProduct()
    {

        // $product = new TestModel;
        // $p = $product->insert($arr);
        // var_dump($p);
        // TestModel::find(120)->update($arr);
        $category = CategoryModel::all();
        // var_dump($category);
        return $this->view(
            'admin.add',
            [
                'title' => 'Trang thêm sản phẩm',
                'category' => $category
            ]
        );
    }
    public function save()
    {
        // $arr = [
        //     'name' => 'test2',
        //     'image' => 'test2.png',
        //     'cate_id' => 3,
        //     'price' => 239,
        //     'short_desc' => 'test mẫu 123',
        //     'detail' => 'nội dung chi tiết'
        // ];
        $request = $_POST;
        // echo "<pre>";
        // var_dump($request);
        // var_dump($arr);
        $errors = [];
        if (!preg_match('/^\w{8,}$/', $request['name'])) {
            $errors['name'] = "bạn phải nhập ít nhất 8 ký tự";
        }
        $file = $_FILES['image'];
        if ($file['size'] > 0) {
            $image = $file['name'];
            move_uploaded_file($file['tmp_name'], 'images/' . $image);
            $request['image'] = $image;
        } else {
            $errors['image'] = 'Bạn chưa nhập ảnh';
        }
        if (!array_filter($errors)) {
            $product = new TestModel;
            $product->insert($request);
            header("location:/product/add");
            exit();
        } else {
            $category = CategoryModel::all();
            // var_dump($category);
            return $this->view(
                'admin.add',
                [
                    'title' => 'Trang thêm sản phẩm',
                    'category' => $category,
                    'request' => $request,
                    'errors' => $errors
                ]
            );
        }
    }
}
