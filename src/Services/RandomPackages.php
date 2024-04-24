<?php

namespace App\Services;

use App\Entity\Packages;
use Doctrine\ORM\EntityManagerInterface;
use Exception;


/**Sélectionne un carton au hasard dans la table 'Packages' est retourne son id.
Cette classe sert à remplir le champs 'id_packages' de la table 'Products' lors des fixtures */
/**Selects a box at random from the 'Packages' table and returns its id.
This class is used to fill the 'id_packages' field of the 'Products' table during fixtures */


Class RandomPackages
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getRandomPackagesId(): ?int
    {
                // Récupérer un ID aléatoire à partir de la base de données
                // Retrieve random ID from database
                $repository = $this->entityManager->getRepository(Packages::class);
                $packages = $repository->findAll();
        
                if (empty($packages)) {
                    return throw new Exception('No packages available to assign to product');
                }
        
                // Choisir un carton aléatoire et récupérez son ID
                // Choose a random box and get its ID
                $randomPackage = $packages[array_rand($packages)];
                return $randomPackage->getId();
    }
}