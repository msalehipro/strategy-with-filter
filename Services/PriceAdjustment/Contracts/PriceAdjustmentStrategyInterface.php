<?php

namespace App\Services\PriceAdjustment\Contracts;

use App\Models\Lodging;

interface PriceAdjustmentStrategyInterface
{
    public function apply(Lodging $lodging): void;
}
