<?php

namespace App\Services\PriceAdjustment;

use App\Models\Lodging;
use App\Services\PriceAdjustment\Contracts\AdjustmentFilterInterface;
use App\Services\PriceAdjustment\Contracts\PriceAdjustmentStrategyInterface;

class PriceAdjustmentService
{
    private array $filters;
    private array $strategies;

    public function __construct(array $filters, array $strategies)
    {
        $this->filters = $filters;
        $this->strategies = $strategies;
    }

    public function adjustPrices(): void
    {
        $lodgings = $this->applyFilters(Lodging::query())->get();

        $lodgings->each(function ($lodging) {
            foreach ($this->strategies as $strategy) {
                if ($strategy instanceof PriceAdjustmentStrategyInterface) {
                    $strategy->apply($lodging);
                }
            }
        });
    }

    private function applyFilters($query)
    {
        foreach ($this->filters as $filter) {
            if ($filter instanceof AdjustmentFilterInterface) {
                $filter->apply($query);
            }
        }

        return $query;
    }
}
