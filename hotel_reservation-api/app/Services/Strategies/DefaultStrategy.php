<?php
namespace App\Services\Strategies;
use App\Services\Contracts\PriceCalculationStrategyInterface;
use DateTimeImmutable;

class DefaultStrategy implements PriceCalculationStrategyInterface
{
    public function calculate(float $basePrice, DateTimeImmutable $date, array $seasons): float
    {
        return $basePrice;
    }

    public function getPriority(): int { return 10; }
}