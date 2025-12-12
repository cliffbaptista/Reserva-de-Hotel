<?php

namespace App\Repositories;

use App\Entities\Season;
use Doctrine\ORM\EntityRepository;
use DateTimeImmutable;

class SeasonRepository extends EntityRepository
{
    public function findApplicableSeasons(DateTimeImmutable $date): array
    {
        // USA $this->getEntityManager() — É O JEITO CORRETO E MODERNO
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from(Season::class, 's')
            ->where(':date BETWEEN s.startDate AND s.endDate')
            ->setParameter('date', $date->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }

    // Outros métodos (create, update, etc) continuam normais
    public function create(array $data): Season
    {
        $season = new Season();
        $season->setType($data['type']);
        $season->setStartDate(new \DateTime($data['start_date']));
        $season->setEndDate(new \DateTime($data['end_date']));
        $season->setMultiplier($data['multiplier']);

        $this->getEntityManager()->persist($season);
        $this->getEntityManager()->flush();

        return $season;
    }
}