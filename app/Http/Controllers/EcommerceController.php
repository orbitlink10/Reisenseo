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
        $productIds = array_map('intval', site_option_array('home_products'));

        if (!empty($productIds)) {
            $found = Post::where('type', 'product')->whereIn('id', $productIds)->get()->keyBy('id');
            $products = collect($productIds)
                ->map(function ($id) use ($found) {
                    return $found->get($id);
                })
                ->filter()
                ->values();
        } else {
            $products = Post::where('type', 'product')->latest()->take(8)->get();
        }

        return view('theme.marketi.index', compact('products'));
    }
}
