<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;


class FindCellFree
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findFreeStorage()
    {
        $conn = $this->entityManager->getConnection();
    
        $sql = "
            SELECT sub.*
            FROM (
                SELECT 
                    storages.*, 
                    (storages.quantity - IFNULL(SUM(packages.occupancy), 0)) AS remaining_quantity
                FROM `storages`
                LEFT JOIN (SELECT * FROM `stored_in` WHERE `released_on` IS NULL ) AS `filtered_stored_in` 
                ON `filtered_stored_in`.`id_storages_id` = `storages`.`id`
                LEFT JOIN `parcels` ON `filtered_stored_in`.`id_parcels_id` = `parcels`.`id`
                LEFT JOIN `packagings` ON `parcels`.`id_packagings_id` = `packagings`.`id`
                LEFT JOIN `packages` ON `packagings`.`id_packages_id` = `packages`.`id`
                GROUP BY `storages`.`id`, `packages`.`occupancy`, `packages`.`storage`
                ORDER BY `filtered_stored_in`.`id_parcels_id` DESC
            ) AS sub
            WHERE sub.remaining_quantity > 0 AND sub.type = 'A'
            ORDER BY `sub`.`id` ASC;
        ";
    
        $stmt = $conn->executeQuery($sql);

        //dd($stmt->fetchAllAssociative());
    
        return $stmt->fetchAllAssociative();
    }
    
    

}
