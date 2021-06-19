<?php

namespace App\Http\Controllers\Luckypin\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\MainRepository;
use MetaTag;

class MainController extends AdminBaseController
{
    //private $orderRepository;
    //private $productRepository;


    public function __construct()
    {
        parent::__construct();
        //$this->orderRepository = app(OrderRepository::class);
        //$this->productRepository = app(ProductRepository::class);
    }


    public function index()
    {
        MetaTag::setTags(['title' => 'Админ панель']);

        $countUsers = MainRepository::getCountUsers();
        $countPartners = 99; //$countProducts = MainRepository::getCountProducts();
        $countPostamats = 999; //$countCategories = MainRepository::getCountCategories();

        //$perPage = 4;
        //$last_orders = $this->orderRepository->getAllOrders($perPage);
        //$last_products = $this->productRepository->getLastProducts($perPage);

        return view('luckypin.admin.main.index',
            compact('countPartners', 'countUsers', 'countPostamats'
               )); // 'last_orders', 'last_products'
    }
}
