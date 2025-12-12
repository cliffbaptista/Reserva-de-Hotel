<?php

namespace Database\Seeders;

use App\Entities\Room;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function __construct(private EntityManagerInterface $em) {}
    public function run(): void
    {
        

        $rooms = [
            ['101', 280.00], ['102', 320.00], ['201', 450.00],
            ['202', 480.00], ['303', 250.00], ['305', 290.00],
        ];

        foreach ($rooms as [$number, $price]) {
            $room = new Room();
            $room->setNumber($number);
            $room->setBasePrice($price);
            $this->em->persist($room);
        }

        $this->em->flush();
        $this->command->info('Quartos criados!');
    }
}