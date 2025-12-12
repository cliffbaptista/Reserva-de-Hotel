<?php
namespace Database\Seeders;
use App\Entities\Guest;
use Illuminate\Database\Seeder;
use Doctrine\ORM\EntityManagerInterface;

class GuestSeeder extends Seeder
{
    public function __construct(private EntityManagerInterface $em) {}
    public function run(): void
    {
        

        $guests = [
            ['Ana Silva', 'ana@email.com'],
            ['João Costa', 'joao@email.com'],
            ['Maria Oliveira', 'maria@email.com'],
            ['Carlos Santos', 'carlos@email.com'],
            ['Fernanda Lima', 'fernanda@email.com'],
        ];

        foreach ($guests as [$name, $email]) {
            $guest = new Guest();
            $guest->setName($name);
            $guest->setEmail($email);
            $this->em->persist($guest);
        }

        $this->em->flush();
        $this->command->info('5 hóspedes criados!');
    }
}