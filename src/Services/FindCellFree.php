<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class FindCellFree
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    private function getSqlQuery(): string
    {
        return "
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
            WHERE sub.remaining_quantity > 0 AND sub.type = :type AND sub.remaining_quantity = :space
            ORDER BY `sub`.`id` ASC 
            LIMIT :limit;
            ";
    }
    
    
    /**
     * findFreeStorage
     *
     * @param  sting $type Type de colis
     * @param  int $limit Nombre d'emplacements proposés
     * @param  int $space taille des emplacements proposés
     * @return array
     */
    public function findFreeStorage(string $type, int $limit, int $space): array
    {
        $conn = $this->entityManager->getConnection();
    
        $sql = $this->getSqlQuery();
    
        return $conn->executeQuery(
            $sql,
            ['type' => $type, 'limit' => $limit, 'space' =>$space],
            ['type' => \Doctrine\DBAL\Types\Types::STRING, 'limit' => \Doctrine\DBAL\ParameterType::INTEGER, 'space' => \Doctrine\DBAL\ParameterType::INTEGER ]
        )->fetchAllAssociative();
    }
    
    
}
