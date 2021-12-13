<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->limit(6)->orderBy('id','DESC')->get();
        $stores = \App\Store::limit(3)->orderBy('id','DESC')->get();
        return view('welcome', compact('products','stores'));
    }

    public function single($slug)
    {
        $product = $this->product->whereSlug($slug)->first();

        return view('single', compact('product'));
    }
}

/*
 * Middleware: dentro de aplicações web, ele é um código ou programa que é executado entre a requisição(Request) e a nos
 * sa aplicação (é a lógica executada pelo acesso a uma determinada rota)
 *
 * Request -> Middleware -> Aplicação (Acesso qualquer rota) <- Marketplace
 *
 * */
