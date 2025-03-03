<?php

namespace App\Services\PriceAdjustment\Strategies;

use App\Models\Lodging;
use App\Services\PriceAdjustment\Contracts\PriceAdjustmentStrategyInterface;

class NoroozPriceStrategy implements PriceAdjustmentStrategyInterface
{

    private string $editType;
    private float $amount;

    public function __construct(string $editType, float $amount)
    {
        $this->editType = $editType;
        $this->amount = $amount;
    }

    public function apply(Lodging $lodging): void
    {
        $adjustment = $this->editType === 'increase' ? $this->amount : -$this->amount;
        $lodging->norooz_price += $adjustment;
        $lodging->save();
    }
}
