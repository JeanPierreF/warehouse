<?php

namespace App\Controller;

use App\Services\FindCellFree;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;


class MainController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'main')]
    public function index(FindCellFree $findCellFree): Response
    {
        $type ='A';
        $result = $findCellFree->findFreeStorage($type, 10, 2);
       
        return $this->render('main/index.html.twig', [
            'results' => $result,
        ]);
    }
}
