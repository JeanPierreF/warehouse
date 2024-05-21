<?php

namespace App\Controller;

use App\Repository\ParcelsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/parcels', name: 'parcels_')]
class ParcelsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ParcelsRepository $parcelsRepository): Response
    {
        return $this->render('parcels/index.html.twig', [
            'parcels' => $parcelsRepository->findAll(),
        ]);
    }
}
