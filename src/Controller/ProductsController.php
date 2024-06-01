<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, ProductsRepository $productsRepository): Response
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');

        if ($sort && $direction) {
            $products = $productsRepository->findProductsWithPackage($sort, $direction);
        } else {
            $products = $productsRepository->findProductsWithPackage();
        }
       
        return $this->render('products/index.html.twig', 
        [
            'products' => $products
        ]);
    }



     #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'])]
    public function detail(Products $product): Response
    {
        return $this->render('products/product.html.twig', compact('product'));
    }

    #[Route('/edit/{id}', name:'edit', requirements: ['id' => '\d+'])]
    public function edit(Products $products, Request $request,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProductsType::class, $products);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success','Modification enregistrée');
            return $this->redirectToRoute('products_index');
        }
        return $this->render('products/edit.html.twig', [
            'products' => $products,
            'formedit' => $form
        ]);
    }

    #[Route('/add', name:'add')]
    public function add(Request $request, EntityManagerInterface $em)
    {
        $products = new Products();
        $form = $this->createForm(ProductsType::class, $products);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){

            $em->persist($products);
            $em->flush();
            $this->addFlash('success','Produit ajouté');
            return  $this->redirectToRoute('products_index');  
        }

        return $this->render('Products/add.html.twig', ['formedit' => $form]);

    }

}
