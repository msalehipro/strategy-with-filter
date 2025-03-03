<?php

namespace App\Services\PriceAdjustment\Strategies;

use App\Enums\SeasonPriceTypeEnum;
use App\Models\Lodging;
use App\Models\SeasonPrice;
use App\Services\PriceAdjustment\Contracts\PriceAdjustmentStrategyInterface;

class SeasonPriceStrategy implements PriceAdjustmentStrategyInterface
{
    private string $editType;
    private float $amount;
    private array $priceTypes;
    private array $seasons;

    /**
     * @param string $editType
     * @param float $amount
     * @param array $priceTypes
     * @param array $seasons
     */
    public function __construct(string $editType, float $amount, array $priceTypes = [], array $seasons = [])
    {
        $this->editType = $editType;
        $this->amount = $amount;
        $this->priceTypes = $priceTypes;
        $this->seasons = $seasons;
    }

    public function apply(Lodging $lodging): void
    {
        $adjustment = $this->editType === 'increase' ? $this->amount : -$this->amount;

        SeasonPrice::where('lodging_id', $lodging->id)
            ->whereIn('season', $this->seasons)
            ->each(function ($seasonPrice) use ($adjustment) {
                $this->adjustSeasonPrice($seasonPrice, $adjustment);
            });
    }

    private function adjustSeasonPrice(SeasonPrice $seasonPrice, float $adjustment): void
    {
        $strategies = [
            SeasonPriceTypeEnum::MIDWEEK->value => fn($amount) => $seasonPrice->midweek_price += $amount,
            SeasonPriceTypeEnum::WEEKEND->value => fn($amount) => $seasonPrice->weekend_price += $amount,
            SeasonPriceTypeEnum::PEAK->value => fn($amount) => $seasonPrice->peak_price += $amount,
        ];

        foreach ($this->priceTypes as $priceType) {
            if (isset($strategies[$priceType])) {
                $strategies[$priceType]($adjustment);
            }
        }

        $seasonPrice->save();
    }
}
