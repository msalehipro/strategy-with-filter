<?php

namespace App\Services\PriceAdjustment\Strategies;

use App\Models\Lodging;
use App\Services\PriceAdjustment\Contracts\PriceAdjustmentStrategyInterface;

class NoroozPriceStrategy implements PriceAdjustmentStrategyInterface
{
    public function __construct(private readonly float $amount)
    {
        $this->amount = $amount;
    }

    public function apply(Lodging $lodging): void
    {
        $lodging->increment('norooz_price',$amount);
    }
}
