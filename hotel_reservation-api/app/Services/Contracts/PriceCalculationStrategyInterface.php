<?php
namespace App\Services\Contracts;
use DateTimeImmutable;

interface PriceCalculationStrategyInterface
{
    public function calculate(float $basePrice, DateTimeImmutable $date, array $seasons): float;
    public function getPriority(): int;
}
