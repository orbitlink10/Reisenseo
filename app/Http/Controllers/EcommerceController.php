<?php

namespace App\Http\Controllers;


use App\Models\Post;


class EcommerceController extends Controller
{
    /**
     * Display the e-commerce homepage with featured products.
     */
    public function home()
    {

        $products = Post::where('type', 'product')->latest()->take(8)->get();
        return view('theme.marketi.index', compact('products'));

    }
}
