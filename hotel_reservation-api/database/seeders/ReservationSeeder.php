<?php
namespace Database\Seeders;
use App\Entities\Reservation;
use App\Services\PriceCalculationService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function __construct(
    private EntityManagerInterface $em,
    private PriceCalculationService $priceService
) {}
    public function run(): void
    {
        
        $priceService = app(PriceCalculationService::class);

        $roomRepo = $this->em->getRepository(\App\Entities\Room::class);
        $guestRepo = $this->em->getRepository(\App\Entities\Guest::class);

        $data = [
            [1, 1, '2025-04-10', '2025-04-15'],
            [2, 2, '2025-12-23', '2025-12-27'],
            [3, 3, '2025-12-29', '2026-01-03'],
            [1, 4, '2025-07-05', '2025-07-10'],
            [4, 5, '2025-11-28', '2025-11-30'],
        ];

        foreach ($data as [$roomId, $guestId, $in, $out]) {
            $room = $roomRepo->find($roomId);
            $guest = $guestRepo->find($guestId);
            $checkIn = new \DateTimeImmutable($in);
            $checkOut = new \DateTimeImmutable($out);

            $total = $priceService->calculateTotalPrice($checkIn, $checkOut, $room->getBasePrice());

            $res = new Reservation();
            $res->setRoom($room);
            $res->setGuest($guest);
            $res->setCheckIn($checkIn);
            $res->setCheckOut($checkOut);
            $res->setTotalPrice($total);
            $res->setStatus('active');
            $this->em->persist($res);
        }

        $this->em->flush();
        $this->command->info('5 reservas criadas com preço automático!');
    }
}