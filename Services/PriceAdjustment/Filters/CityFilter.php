<?php

namespace App\Services\PriceAdjustment\Filters;

use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class CityFilter implements AdjustmentFilterInterface
{


    public function __construct(private readonly int $cityId)
    {
    }

    public function apply(Builder $query): void
    {
        $query->where('city_id', $this->cityId);
    }
}
