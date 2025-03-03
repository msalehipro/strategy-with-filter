<?php

namespace App\Services\PriceAdjustment\Filters;

use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class LodgingTypeFilter implements AdjustmentFilterInterface
{

    ;

    public function __construct(private readonly array $lodgingTypes)
    {
    }

    public function apply(Builder $query): void
    {
        $query->whereHas('lodgingTypes', fn (Builder $subQuery) => $subQuery->whereIn('id', $this->lodgingTypes));
    }
}
