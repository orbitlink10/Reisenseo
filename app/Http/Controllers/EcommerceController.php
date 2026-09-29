<?php

namespace App\Http\Controllers;


use App\Models\Category;


class EcommerceController extends Controller
{
    /**
     * Display the e-commerce homepage with featured categories.
     */
    public function home()
    {
        $categoryIds = array_map('intval', site_option_array('home_shop_categories'));

        if (!empty($categoryIds)) {
            $found = Category::where('cat_type', 4)->whereIn('id', $categoryIds)->get()->keyBy('id');
            $shopCategories = collect($categoryIds)
                ->map(function ($id) use ($found) {
                    return $found->get($id);
                })
                ->filter()
                ->values();
        } else {
            $shopCategories = Category::where('cat_type', 4)->orderBy('name')->take(8)->get();
        }

        return view('theme.marketi.index', compact('shopCategories'));
    }
}
