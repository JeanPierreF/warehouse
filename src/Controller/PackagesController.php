<?php

namespace App\Controller;

use App\Entity\Packages;
use App\Form\PackagesType;
use App\Repository\PackagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/packages', name: 'packages_')]
class PackagesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request,PackagesRepository $packagesRepository): Response
    {

        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');

        dump('DIRECTION'.$direction);

        if ($sort && $direction) {
            $package = $packagesRepository->findBy([], [$sort => $direction]);
        } else {
            $package = $packagesRepository->findAll();
        }
        
        return $this->render('packages/index.html.twig', [
            'packages' => $package
        ]);
    }


    #[Route('/edit/{id}', name: 'edit', requirements: ['id' => '\d+'])]
    public function edit(Packages $packages, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PackagesType::class, $packages);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success','Modification enregistrée');
            return $this->redirectToRoute('packages_index');
        }
        return $this->render('packages/edit.html.twig', [
            'packages' => $packages,
            'formedit' => $form
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $orders = new Packages() ;
        
        $form = $this->createForm(PackagesType::class, $orders);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            $em->persist($orders);
            $em->flush();
            $this->addFlash('success','Modification enregistrée');
            return $this->redirectToRoute('packages_index');
        }
        return $this->render('packages/add.html.twig', [
            'formedit' => $form
        ]);
    }
}
