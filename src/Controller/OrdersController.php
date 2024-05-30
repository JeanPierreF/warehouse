<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/orders', name: 'orders_')]
class OrdersController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, OrdersRepository $ordersRepository): Response
    {

        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');

        dump('DIRECTION'.$direction);

        if ($sort && $direction) {
            //$orders = $ordersRepository->findBy([], [$sort => $direction]);
            $orders = $ordersRepository->getOrderList($sort, $direction);
        } else {
            //$orders = $ordersRepository->findAll();
            $orders = $ordersRepository->getOrderList();
        }


        return $this->render('orders/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', requirements: ['id' => '\d+'])]
    public function edit(Orders $orders, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(OrdersType::class, $orders);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success','Modification enregistrée');
            return $this->redirectToRoute('orders_index');
        }
        return $this->render('orders/edit.html.twig', [
            'orders' => $orders,
            'formedit' => $form
        ]);
    }

    
    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $orders = new Orders() ;
        
        $form = $this->createForm(OrdersType::class, $orders);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            $em->persist($orders);
            $em->flush();
            $this->addFlash('success','Modification enregistrée');
            return $this->redirectToRoute('orders_index');
        }
        return $this->render('orders/add.html.twig', [
            'formedit' => $form
        ]);
    }
}
