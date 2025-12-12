<?php
namespace Database\Seeders;
use App\Entities\Season;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    public function __construct(private EntityManagerInterface $em) {}
    public function run(): void
    {
        

        $seasons = [
            ['high', '2025-12-15', '2026-03-15', 1.80],
            ['holiday', '2025-12-24', '2025-12-26', 2.80],
            ['holiday', '2025-12-30', '2026-01-02', 3.50],
            ['low', '2025-06-01', '2025-08-31', 0.65],
            ['holiday', '2025-11-28', '2025-11-30', 0.55],
        ];

        foreach ($seasons as [$type, $start, $end, $mult]) {
            $s = new Season();
            $s->setType($type);
            $s->setStartDate(new \DateTime($start));
            $s->setEndDate(new \DateTime($end));
            $s->setMultiplier($mult);
            $this->em->persist($s);
        }

        $this->em->flush();
        $this->command->info('5 temporadas criadas!');
    }
}