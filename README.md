# Strategy with filter
A real-world example to use strategy design pattern with filtering in PHP/Laravel

# How to use

```php
$editType = 'increase';
$amount = 100000;
$priceTypes = [
    SeasonPriceTypeEnum::WEEKEND->value,
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
    new NoroozPriceStrategy($editType, $amount),
    new SeasonPriceStrategy($editType, $amount, $priceTypes, $seasons),
];
$adjust = new PriceAdjustmentService($filters, $strategies);

$adjust->adjustPrices();

```
