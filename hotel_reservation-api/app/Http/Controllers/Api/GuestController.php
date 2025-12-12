<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Entities\Guest;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function index()
    {
        $guests = $this->em->getRepository(Guest::class)->findAll();
        return response()->json(array_map(fn($guests) => $guests->toArray(), $guests));
    }

    public function show(int $id)
    {
        $guest = $this->em->find(Guest::class, $id);
        return $guest ? response()->json($guest->toArray()) : response()->json(['error' => 'Não encontrado'], 404);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:guests,email',
        ]);

        $guest = new Guest();
        $guest->setName($data['name']);
        $guest->setEmail($data['email']);

        $this->em->persist($guest);
        $this->em->flush();

        return response()->json(['msg' => 'inserido com sucesso'], 201);
    }


}