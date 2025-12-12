<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Services\Contracts\PriceCalculationStrategyInterface;
use App\Services\Strategies\HolidaySeasonStrategy;
use App\Services\Strategies\HighSeasonStrategy;
use App\Services\Strategies\LowSeasonStrategy;
use App\Services\Strategies\DefaultStrategy;
use DateTimeImmutable;

class PriceCalculationService
{
    private array $strategies = [];

    public function __construct(private EntityManagerInterface $em)
    {
        $this->registerStrategy(new HolidaySeasonStrategy());
        $this->registerStrategy(new HighSeasonStrategy());
        $this->registerStrategy(new LowSeasonStrategy());
        $this->registerStrategy(new DefaultStrategy());
    }

    private function registerStrategy(PriceCalculationStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
        usort($this->strategies, fn($a, $b) => $b->getPriority() <=> $a->getPriority());
    }

    public function calculateDailyPrice(float $basePrice, DateTimeImmutable $date): float
    {
        
        $seasonRepo = $this->em->getRepository(\App\Entities\Season::class);
        if (!$seasonRepo instanceof \App\Repositories\SeasonRepository) {
            throw new \RuntimeException('Erro: SeasonRepository não está sendo usado!');
        }

        $seasons = $seasonRepo->findApplicableSeasons($date);

        foreach ($this->strategies as $strategy) {
            $price = $strategy->calculate($basePrice, $date, $seasons);
            if ($price !== $basePrice) {
                return round($price, 2);
            }
        }

        return round($basePrice, 2);
    }

    public function calculateTotalPrice(DateTimeImmutable $checkIn, DateTimeImmutable $checkOut, float $basePrice): float
    {
        $total = 0.0;
        $current = clone $checkIn;

        while ($current < $checkOut) {
            $total += $this->calculateDailyPrice($basePrice, $current);
            $current = $current->modify('+1 day');
        }

        return round($total, 2);
    }
}