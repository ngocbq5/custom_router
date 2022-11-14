<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/config-data.php";

use App\Controller\HomeController;
use App\Controller\ProductController;
use App\Controller\CategoryController;
use App\Router;

$route = new Router;

$route->get('/', [HomeController::class, 'index']);
$route->get('/new', function () {
    echo "New page";
});
$route->get('/post/{id}/{slug}', function ($id, $slug) {
    echo "Post page id $id và slug: $slug";
});
$route->get('/contact', function () {
    echo "Contact page";
});
$route->get('/{id}/product', [ProductController::class, 'show']);
$route->get('/{id}/category', [ProductController::class, 'showCate']);
$route->get('/about', function () {
    echo "About page";
});

$route->addNotFoundHandler(function () {
    echo "404 not Found abc.";
});

$route->get('/product', [ProductController::class, 'index']);

$route->get('/admin/category/store', [CategoryController::class, 'store']);
$route->get('/admin/category/edit', [CategoryController::class, 'edit']);
$route->get('/admin/category/delete/{id}', [CategoryController::class, 'delete']);
$route->get('/product/add', [HomeController::class, 'addProduct']);
$route->post('/product/add', [HomeController::class, 'save']);
$route->run();
