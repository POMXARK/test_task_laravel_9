<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Возвращает список всех продуктов или фильтрованный список
     * Пример запроса с фильтрацией:
     * /products?properties[color][]=red&properties[color][]=white&properties[weight][]=1000
     *
     * @param Request $request
     * @return LengthAwarePaginator|Collection
     */
    public function products(Request $request): LengthAwarePaginator|Collection
    {
        $perPage = 40;
        $inputs = $request->input();
        if (empty($inputs['properties'])) {
            return Product::paginate($perPage, ['*'], 'page', $request->input('page'));
        }

        return Product::filter($inputs['properties'])->paginate($perPage, ['*'], 'page', $request->input('page'));
    }

    public function create(Request $request)
    {
        return Product::create([
                         'name'       => $request->name,
                         'price'      => $request->price,
                         'amount'     => $request->amount,
                         'properties' => $request->properties
            ]);
    }
}
