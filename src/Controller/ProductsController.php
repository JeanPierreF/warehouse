<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductsRepository $productsRepository): Response
    {
       
/*         $produits = $productsRepository->findProductsWithPackage();

        // Utilisation de dd() pour afficher les produits
        dd($produits); */


        return $this->render('products/index.html.twig', 
        [
            'products' => $productsRepository->findProductsWithPackage()
        ]);
    }

     #[Route('/{id}', name: 'detail')]
    public function detail(Products $product): Response
    {
        return $this->render('products/product.html.twig', compact('product'));
    }
}
