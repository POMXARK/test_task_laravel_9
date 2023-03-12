<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    /**
     * Возвращает список всех продуктов или фильтрованный список
     * Пример запроса с фильтрацией:
     * /products?properties[color][]=red&properties[color][]=white&properties[weight][]=1000
     *
     * @param Request $request
     * @return Collection
     */
    public function products(Request $request): Collection
    {
        $inputs = $request->input();
        if (empty($inputs)) {
            return Product::all();
        }
        $products = Product::filter($inputs['properties']);

        return $products->get();
    }
}
