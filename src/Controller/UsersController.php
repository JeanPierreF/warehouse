<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'users_')]
    public function index(Users $users, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UsersType::class, $users);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success','Modification enregistrée');
            return $this->redirectToRoute('orders_index');
        }

        return $this->render('users/index.html.twig', [
            'formedit' => $form,
            'users' => $users,
        ]);
    }
}
