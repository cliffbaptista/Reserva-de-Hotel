<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

#[ORM\Entity(repositoryClass: \App\Repositories\ReservationRepository::class)]
#[ORM\Table(name: 'reservations')]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Room::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Room $room;

    #[ORM\ManyToOne(targetEntity: Guest::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Guest $guest;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface $checkIn;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface $checkOut;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $totalPrice;

    #[ORM\Column(type: 'string')]
    private string $status = 'active';

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getRoom(): Room
    {
        return $this->room;
    }
    public function setRoom(Room $room): void
    {
        $this->room = $room;
    }
    public function getGuest(): Guest
    {
        return $this->guest;
    }
    public function setGuest(Guest $guest): void
    {
        $this->guest = $guest;
    }
    public function getCheckIn(): DateTimeInterface
    {
        return $this->checkIn;
    }
    public function setCheckIn(DateTimeInterface $checkIn): void
    {
        $this->checkIn = $checkIn;
    }
    public function getCheckOut(): DateTimeInterface
    {
        return $this->checkOut;
    }
    public function setCheckOut(DateTimeInterface $checkOut): void
    {
        $this->checkOut = $checkOut;
    }
    public function getTotalPrice(): float
    {
        return (float) $this->totalPrice;
    }
    public function setTotalPrice(float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'room' => $this->room->toArray(),
            'guest' => $this->guest->toArray(),
            'check_in' => $this->checkIn->format('Y-m-d'),
            'check_out' => $this->checkOut->format('Y-m-d'),
            'total_price' => (float) $this->totalPrice,
            'status' => $this->status,
        ];
    }
}