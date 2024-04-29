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
        return $this->render('products/index.html.twig', 
        [
            'products' => $productsRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'detail')]
    public function detail(Products $product): Response
    {
        return $this->render('products/product.html.twig', compact('product'));
    }
}
