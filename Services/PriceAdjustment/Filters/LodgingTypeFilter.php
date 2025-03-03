<?php

namespace App\Services\PriceAdjustment\Filters;

use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class LodgingTypeFilter implements AdjustmentFilterInterface
{

    private array $lodgingTypes;

    public function __construct(array $lodgingTypes)
    {
        $this->lodgingTypes = $lodgingTypes;
    }

    public function apply(Builder $query): void
    {
        $query->whereHas('lodgingTypes', function ($subQuery) {
            $subQuery->whereIn('id', $this->lodgingTypes);
        });
    }
}
