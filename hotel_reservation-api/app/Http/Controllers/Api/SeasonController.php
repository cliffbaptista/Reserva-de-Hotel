<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Entities\Season;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function index()
    {
        $seasons = $this->em->getRepository(Season::class)->findAll();
        return response()->json(array_map(fn($seasons) => $seasons->toArray(), $seasons));
    }

    public function show(int $id)
    {
        $season = $this->em->find(Season::class, $id);
        return $season ? response()->json($season->toArray()) : response()->json(['error' => 'Não encontrado'], 404);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:high,low,holiday,promotion',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'multiplier' => 'required|numeric|min:0.1|max:10',
        ]);

        $season = new Season();
        $season->setType($data['type']);
        $season->setStartDate(new \DateTime($data['start_date']));
        $season->setEndDate(new \DateTime($data['end_date']));
        $season->setMultiplier($data['multiplier']);

        $this->em->persist($season);
        $this->em->flush();

        return response()->json(['msg' => 'inserido com sucesso'], 201);
    }
}