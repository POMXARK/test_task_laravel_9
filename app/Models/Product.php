<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Каталог товаров
 */
class Product extends Model
{
    use HasFactory;

    // чтобы этот столбец автоматически приводился из JSON в массив
    protected $casts = [
        'properties' => 'array'
    ];

    /**
     * Формирует запрос на фильтрацию списка товаров
     *
     * @param array $properties список фильтров
     *
     * @return Builder
     */
    static public function filter(array $properties): Builder
    {
        $query = self::query();
        foreach($properties as $key => $value) {
            if (count($value) > 1) {
                $query->whereJsonContains('properties->' . $key, $value);
            } else {
                $query->where('properties->' . $key, $value);
                $query->orWhereJsonContains('properties->' . $key, $value);
            }
        }

        return $query;
    }
}
