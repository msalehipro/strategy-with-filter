# Strategy with filter
A real-world example to use strategy design pattern with filtering in PHP/Laravel

# How to use

```php
// can be positive or negative
$amount = 100000;

$priceTypes = [
    SeasonPriceTypeEnum::WEEKEND,
];

$seasons = [
    SeasonEnum::Spring,
    SeasonEnum::Summer,
];

$filters = [
    new ProvinceFilter(89),
    new CityFilter(332),
    new LodgingTypeFilter([1, 2]),
    new LodgingLocationFilter([14, 15]),
];

$strategies = [
    new NoroozPriceStrategy($amount),
    new SeasonPriceStrategy($amount, $priceTypes, $seasons),
];

$adjust = new PriceAdjustmentService($filters, $strategies);

$adjust->adjustPrices();

```
