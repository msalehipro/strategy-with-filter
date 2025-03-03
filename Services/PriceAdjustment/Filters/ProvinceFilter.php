<?php

namespace App\Services\PriceAdjustment\Filters;

use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class ProvinceFilter implements AdjustmentFilterInterface
{

    private int $provinceId;

    public function __construct(int $provinceId)
    {
        $this->provinceId = $provinceId;
    }

    public function apply(Builder $query): void
    {
        $query->whereHas('city.province', function ($subQuery) {
            $subQuery->where('id', $this->provinceId);
        });
    }
}
