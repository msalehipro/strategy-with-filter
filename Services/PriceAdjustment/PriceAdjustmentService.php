<?php

namespace App\Services\PriceAdjustment;

use App\Models\Lodging;
use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use App\Services\PriceAdjustment\Contracts\PriceAdjustmentStrategyInterface;
use Illuminate\Database\Eloquent\Builder;

class PriceAdjustmentService
{
    public function __construct(private readonly array $filters, private readonly array $strategies)
    {
    }

    public function adjustPrices(): void
    {
        $lodgings = $this->applyFilters(Lodging::query())->get();

        $lodgings->each(function (Lodging $lodging) {
            foreach ($this->strategies as $strategy) {
                if ($strategy instanceof PriceAdjustmentStrategyInterface) {
                    $strategy->apply($lodging);
                }
            }
        });
    }

    private function applyFilters(Builder $query)
    {
        foreach ($this->filters as $filter) {
            if ($filter instanceof AdjustmentFilterInterface) {
                $filter->apply($query);
            }
        }

        return $query;
    }
}
