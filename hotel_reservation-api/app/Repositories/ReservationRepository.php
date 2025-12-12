<?php

namespace App\Repositories;

use App\Entities\Reservation;
use Doctrine\ORM\EntityRepository;
use DateTimeImmutable;

class ReservationRepository extends EntityRepository
{
    public function create(Reservation $reservation): Reservation
    {
        $this->_em->persist($reservation);
        $this->_em->flush();
        return $reservation;
    }

    public function cancel(Reservation $reservation): void
    {
        $reservation->setStatus('cancelled');
        $this->_em->flush();
    }

    public function hasConflict(int $roomId, DateTimeImmutable $checkIn, DateTimeImmutable $checkOut, ?int $excludeId = null): bool
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('COUNT(r.id)')
            ->from(Reservation::class, 'r')
            ->where('r.room = :roomId')
            ->andWhere('r.status = :status')
            ->andWhere('r.checkIn < :checkOut')
            ->andWhere('r.checkOut > :checkIn')
            ->setParameters([
                'roomId'   => $roomId,
                'status'   => 'active',
                'checkIn'  => $checkIn,
                'checkOut' => $checkOut,
            ]);

        if ($excludeId) {
            $qb->andWhere('r.id != :excludeId')->setParameter('excludeId', $excludeId);
        }

        return $qb->getQuery()->getSingleScalarResult() > 0;
    }
}