<?php

namespace App\Services;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Exception;


/**Sélectionne un carton au hasard dans la table 'Products' est retourne son id.
Cette classe sert à remplir le champs 'id_products' de la table 'Products' lors des fixtures */
/**Selects a box at random from the 'Products' table and returns its id.
This class is used to fill the 'id_products' field of the 'Products' table during fixtures */


Class RandomProducts
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getRandomProductId(): ?int
    {
                // Récupérer un ID aléatoire à partir de la base de données
                // Retrieve random ID from database
                $repository = $this->entityManager->getRepository(Products::class);
                $products = $repository->findAll();
        
                if (empty($products)) {
                    return throw new Exception('No products available to assign to product');
                }
        
                // Choisir un carton aléatoire et récupérez son ID
                // Choose a random box and get its ID
                $randomProducts = $products[array_rand($products)];
                return $randomProducts->getId();
    }
}