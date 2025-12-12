<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Entities\Room;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function index()
    {
        $rooms = $this->em->getRepository(Room::class)->findAll();
        return response()->json(array_map(fn($r) => $r->toArray(), $rooms));
    }

    public function show(int $id)
    {
        $rooms = $this->em->find(Room::class, $id);
        return $rooms ? response()->json($rooms->toArray()) : response()->json(['error' => 'Não encontrado'], 404);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|string|unique:rooms,number',
            'base_price' => 'required|numeric|min:0',
        ]);

        $room = new Room();
        $room->setNumber($data['number']);
        $room->setBasePrice($data['base_price']);

        $this->em->persist($room);
        $this->em->flush();

        return response()->json(['msg' => 'inserido com sucesso'], 201);
    }

    
    public function update(Request $request, int $id)
    {
        $room = $this->em->find(Room::class, $id);
        if (!$room)
            return response()->json(['error' => 'Quarto não encontrado'], 404);

        $data = $request->validate([
            'number' => 'sometimes|string|unique:rooms,number,' . $id,
            'base_price' => 'sometimes|numeric|min:0',
        ]);

        if (isset($data['number']))
            $room->setNumber($data['number']);
        if (isset($data['base_price']))
            $room->setBasePrice($data['base_price']);

        $this->em->flush();

        return response()->json(['msg' => 'atualizado com sucesso']);
    }

    public function destroy(int $id)
    {
        $room = $this->em->find(Room::class, $id);
        if (!$room)
            return response()->json(['error' => 'Quarto não encontrado'], 404);

        $this->em->remove($room);
        $this->em->flush();

        return response()->json(['message' => 'Quarto excluído']);
    }
}