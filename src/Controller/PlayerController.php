<?php

namespace App\Controller;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/apifoot/player")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("s", name="playerIndex")
     */
    public function index(PlayerRepository $playerRepository): Response
    {
        $players = $playerRepository->findAll();

        return $this->json($players);
    }

    /**
     * @Route("/{id}", name="playerShow", requirements={"id":"\d+"})
     */
    public function show(Player $player): Response
    {
        return $this->json($player);
    }

    /**
     * @Route("/create", name="playerCreate", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $manager, SerializerInterface $serializer): Response
    {
        $data = $request->getContent();

        $player = $serializer->deserialize($data, Player::class, 'json');

        $manager->persist($player);
        $manager->flush();

        return $this->json($player);
    }

    /**
     * @Route("/delete/{id}", name="playerDelete", methods={"DELETE"})
     */
    public function delete(Player $player, EntityManagerInterface $manager): Response
    {
        $manager->remove($player);
        $manager->flush();

        return $this->json("REMOVE OK");
    }
}
