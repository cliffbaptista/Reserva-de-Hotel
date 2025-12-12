<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Repositories\RoomRepository::class)]
#[ORM\Table(name: 'rooms')]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    private string $number;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $basePrice;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNumber(): string
    {
        return $this->number;
    }
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }
    public function getBasePrice(): float
    {
        return (float) $this->basePrice;
    }
    public function setBasePrice(float $basePrice): void
    {
        $this->basePrice = $basePrice;
    }

    // Dentro da classe Room
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'basePrice' => (float) $this->basePrice,
        ];
    }
}