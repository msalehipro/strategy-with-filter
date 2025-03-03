<?php

namespace App\Services\PriceAdjustment\Filters;

use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class LodgingLocationFilter implements AdjustmentFilterInterface
{

    private array $lodgingLocations;

    public function __construct(array $lodgingLocations)
    {
        $this->lodgingLocations = $lodgingLocations;
    }

    public function apply(Builder $query): void
    {
        $query->whereHas('lodgingLocationTypes', function ($subQuery) {
            $subQuery->whereIn('id', $this->lodgingLocations);
        });
    }
}
