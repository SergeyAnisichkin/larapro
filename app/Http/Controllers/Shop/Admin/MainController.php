<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\Request;
use App\Repositories\Admin\MainRepository;
use MetaTag;

class MainController extends AdminBaseController
{
    private $orderRepository;
    private $productRepository;


    public function __construct()
    {
        parent::__construct();
        $this->orderRepository = app(OrderRepository::class);
        $this->productRepository = app(ProductRepository::class);
    }


    public function index()
    {
        MetaTag::setTags(['title' => 'Админ панель']);

        $countOrders = MainRepository::getCountOrders();
        $countUsers = MainRepository::getCountUsers();
        $countProducts = MainRepository::getCountProducts();
        $countCategories = MainRepository::getCountCategories();

        $perPage = 4;
        $last_orders = $this->orderRepository->getAllOrders($perPage);
        $last_products = $this->productRepository->getLastProducts($perPage);

        return view('shop.admin.main.index',
            compact('countOrders', 'countUsers', 'countProducts', 'countCategories',
                'last_orders', 'last_products'));
    }
}
