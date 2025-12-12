<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Entities\Room;
use App\Entities\Guest;
use App\Entities\Reservation;
use App\Services\PriceCalculationService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use DateTimeImmutable;

class ReservationController extends Controller
{
    public function __construct(
        private EntityManagerInterface $em,
        private PriceCalculationService $priceService
    ) {
    }

    public function index()
    {
        $reservations = $this->em->getRepository(Reservation::class)->findAll();
        return response()->json(array_map(fn($r) => $r->toArray(), $reservations));
    }

    public function show(int $id)
    {
        $reservation = $this->em->find(Reservation::class, $id);
        return $reservation ? response()->json($reservation->toArray()) : response()->json(['error' => 'Reserva não encontrada'], 404);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_id' => 'required|exists:guests,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $room = $this->em->find(Room::class, $data['room_id']);
        $guest = $this->em->find(Guest::class, $data['guest_id']);

        if (!$room || !$guest) {
            return response()->json(['error' => 'Quarto ou hóspede não encontrado'], 404);
        }

        $checkIn = new DateTimeImmutable($data['check_in']);
        $checkOut = new DateTimeImmutable($data['check_out']);

        // Verifica conflito
        $conflict = $this->em->getRepository(Reservation::class)
            ->createQueryBuilder('r')
            ->where('r.room = :room')
            ->andWhere('r.status = :status')
            ->andWhere('r.checkOut > :checkIn AND r.checkIn < :checkOut')
            ->setParameter('room', $room)
            ->setParameter('status', 'active')
            ->setParameter('checkIn', $checkIn)
            ->setParameter('checkOut', $checkOut)
            ->getQuery()
            ->getOneOrNullResult();

        if ($conflict) {
            return response()->json(['error' => 'Quarto já reservado neste período'], 409);
        }

        // CÁLCULO AUTOMÁTICO DE PREÇO
        $totalPrice = $this->priceService->calculateTotalPrice(
            $checkIn,
            $checkOut,
            $room->getBasePrice()
        );

        $reservation = new Reservation();
        $reservation->setRoom($room);
        $reservation->setGuest($guest);
        $reservation->setCheckIn($checkIn);
        $reservation->setCheckOut($checkOut);
        $reservation->setTotalPrice($totalPrice);
        $reservation->setStatus('active');

        $this->em->persist($reservation);
        $this->em->flush();

        return response()->json($room->toArray(), 201);
    }

    public function cancel(int $id)
    {
        $reservation = $this->em->find(Reservation::class, $id);
        if (!$reservation) {
            return response()->json(['error' => 'Reserva não encontrada'], 404);
        }

        if ($reservation->getStatus() === 'cancelled') {
            return response()->json(['error' => 'Reserva já cancelada'], 400);
        }

        $now = new DateTimeImmutable();
        if ($now->modify('+1 day') >= $reservation->getCheckIn()) {
            return response()->json(['error' => 'Cancelamento só até 24h antes'], 403);
        }

        $reservation->setStatus('cancelled');
        $this->em->flush();

        return response()->json(['message' => 'Reserva cancelada com sucesso']);
    }
}