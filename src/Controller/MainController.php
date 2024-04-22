<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\RandomPackages;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(RandomPackages $randomPackages): Response
    {
        return $this->render('main/index.html.twig', []);
    }
}
