<?php
namespace App\Repositories;
use App\Entities\Room;
use Doctrine\ORM\EntityRepository;

class RoomRepository extends EntityRepository
{
    public function isAvailable(int $roomId, \DateTime $checkIn, \DateTime $checkOut): bool
    {
        $count = $this->_em->createQueryBuilder()
            ->select("COUNT(r.id)")
            ->from("App\Entities\Reservation", "r")
            ->where("r.room = :roomId")
            ->andWhere("r.status = :status")
            ->andWhere("r.checkIn < :checkOut")
            ->andWhere("r.checkOut > :checkIn")
            ->setParameters(["roomId" => $roomId, "status" => "active", "checkIn" => $checkIn, "checkOut" => $checkOut])
            ->getQuery()->getSingleScalarResult();

        return $count == 0;
    }
}
