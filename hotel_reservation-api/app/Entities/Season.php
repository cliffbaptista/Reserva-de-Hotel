<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

#[ORM\Entity(repositoryClass: \App\Repositories\SeasonRepository::class)]
#[ORM\Table(name: 'seasons')]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $type;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface $startDate;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface $endDate;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private float $multiplier;

    public function getId(): ?int { return $this->id; }
    public function getType(): string { return $this->type; }
    public function setType(string $type): void { $this->type = $type; }
    public function getStartDate(): DateTimeInterface { return $this->startDate; }
    public function setStartDate(DateTimeInterface $startDate): void { $this->startDate = $startDate; }
    public function getEndDate(): DateTimeInterface { return $this->endDate; }
    public function setEndDate(DateTimeInterface $endDate): void { $this->endDate = $endDate; }
    public function getMultiplier(): float { return (float)$this->multiplier; }
    public function setMultiplier(float $multiplier): void { $this->multiplier = $multiplier; }

    public function toArray(): array
{
    return [
        'id'         => $this->id,
        'type'       => $this->type,
        'start_date' => $this->startDate->format('Y-m-d'),
        'end_date'   => $this->endDate->format('Y-m-d'),
        'multiplier' => (float) $this->multiplier,
    ];
}
}