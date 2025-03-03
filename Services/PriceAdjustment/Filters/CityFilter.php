<?php

namespace App\Services\PriceAdjustment\Filters;

use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class CityFilter implements AdjustmentFilterInterface
{

    private int $cityId;

    public function __construct(int $cityId)
    {
        $this->cityId = $cityId;
    }

    public function apply(Builder $query): void
    {
        $query->where('city_id', $this->cityId);
    }
}
