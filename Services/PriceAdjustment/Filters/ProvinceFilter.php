<?php

namespace App\Services\PriceAdjustment\Filters;

use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class ProvinceFilter implements AdjustmentFilterInterface
{

    public function __construct(private readonly int $provinceId)
    {
    }

    public function apply(Builder $query): void
    {
        $query->whereHas('city.province', fn (Builder $subQuery) => $subQuery->where('id', $this->provinceId));
    }
}
