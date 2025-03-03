<?php

namespace App\Services\PriceAdjustment\Filters;

use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class LodgingLocationFilter implements AdjustmentFilterInterface
{


    public function __construct(private readonly array $lodgingLocations)
    {
    }

    public function apply(Builder $query): void
    {
        $query->whereHas('lodgingLocationTypes', fn ($subQuery)=> $subQuery->whereIn('id', $this->lodgingLocations));
    }
}
