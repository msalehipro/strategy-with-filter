<?php

namespace App\Services\PriceAdjustment\Strategies;

use App\Enums\SeasonPriceTypeEnum;
use App\Models\Lodging;
use App\Models\SeasonPrice;
use App\Services\PriceAdjustment\Contracts\PriceAdjustmentStrategyInterface;

class SeasonPriceStrategy implements PriceAdjustmentStrategyInterface
{
    public function __construct(
        private readonly float $amount;
        private readonly array $priceTypes = [];
        private readonly array $seasons = [];
    )
    {
    }

    public function apply(Lodging $lodging): void
    {
        SeasonPrice::where('lodging_id', $lodging->id)
            ->whereIn('season', $this->seasons)
            ->each(fn (SeasonPrice $seasonPrice) => $this->adjustSeasonPrice($seasonPrice, $amount));
    }

    private function adjustSeasonPrice(SeasonPrice $seasonPrice, float $amount): void
    {
        foreach ($this->priceTypes as $priceType) {
            match($priceType){
                SeasonPriceTypeEnum::MIDWEEK => $seasonPrice->increment('midweek_price', $amount),
                SeasonPriceTypeEnum::WEEKEND => $seasonPrice->increment('weekend_price', $amount),
                SeasonPriceTypeEnum::PEAK => $seasonPrice->increment('peak_price', $amount),
                default => throw new \InvalidArgumentException("Invalid price type")
            };
        }
    }
}
