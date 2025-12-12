<?php
namespace App\Services\Strategies;
use App\Services\Contracts\PriceCalculationStrategyInterface;
use DateTimeImmutable;

class HolidaySeasonStrategy implements PriceCalculationStrategyInterface
{
    public function calculate(float $basePrice, DateTimeImmutable $date, array $seasons): float
    {
        foreach ($seasons as $season) {
            if ($season->getType() === 'holiday' && $date >= $season->getStartDate() && $date <= $season->getEndDate()) {
                return $basePrice * $season->getMultiplier();
            }
        }
        return $basePrice;
    }

    public function getPriority(): int { return 90; }
}