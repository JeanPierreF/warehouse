<?php

namespace App\Controller;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrdersController extends AbstractController
{
    #[Route('/orders', name: 'orders_')]
    public function index(Request $request, OrdersRepository $ordersRepository): Response
    {

/*         return $this->render('orders/index.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]); */


            $sort = $request->query->get('sort');
            $direction = $request->query->get('direction');
    
            if ($sort && $direction) {
                $orders = $ordersRepository->findBy([], [$sort => $direction]);
            } else {
                $orders = $ordersRepository->findAll();
            }
            

            return $this->render('orders/index.html.twig', [
                'orders' => $orders,
            ]);
        




    }
}
