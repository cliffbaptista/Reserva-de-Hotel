<?php

namespace App\Repositories;

use App\Entities\Guest;
use Doctrine\ORM\EntityRepository;

class GuestRepository extends EntityRepository
{
    public function create(array $data): Guest
    {
        $guest = new Guest();
        $guest->setName($data['name']);
        $guest->setEmail($data['email']);

        $this->_em->persist($guest);
        $this->_em->flush();

        return $guest;
    }

    public function update(Guest $guest, array $data): Guest
    {
        if (isset($data['name'])) $guest->setName($data['name']);
        if (isset($data['email'])) $guest->setEmail($data['email']);

        $this->_em->flush();
        return $guest;
    }

    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('COUNT(g.id)')
            ->from(Guest::class, 'g')
            ->where('g.email = :email')
            ->setParameter('email', $email);

        if ($excludeId) {
            $qb->andWhere('g.id != :id')->setParameter('id', $excludeId);
        }

        return $qb->getQuery()->getSingleScalarResult() > 0;
    }
}