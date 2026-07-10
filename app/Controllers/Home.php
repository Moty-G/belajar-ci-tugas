<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DiscountModel;

class Home extends BaseController
{
    protected $productModel;
    protected $discountModel;

    function __construct()
    {
        helper(['number', 'form']);
        $this->productModel  = new ProductModel();
        $this->discountModel = new DiscountModel();
    }

    public function index(): string
    {
        $todayDiscount = $this->discountModel->getTodayDiscount();
        $activeDiscount = $todayDiscount ? $todayDiscount['nominal'] : null;

        // Store in session so header can access it without an extra query
        session()->set('active_discount', $activeDiscount);

        $products = $this->productModel->findAll();
        $data = [
            'products'       => $products,
            'active_discount' => $activeDiscount,
        ];

        return view('v_home', $data);
    }

    public function profile()
    {
        return view('v_profile');
    }
}
