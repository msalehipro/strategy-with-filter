<?php

namespace App\Services\PriceAdjustment\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface AdjustmentFilterInterface
{
    public function apply(Builder $query): void;
}
