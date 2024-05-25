# Affectation des colis à un emplacement - Assigning packages to a location

Le but est de trouver les emplacements libres pour y placer les nouveaux colis (parcels).  
La capacité de stockage de l'emplacement est dans le champs 'storages.quantity' et le volume occupé par un colis est dans 'packages.occupancy'  
The goal is to find free locations to place the new packages (parcels).  
The storage capacity of the location is in the 'storages.quantity' field and the volume occupied by a package is in 'packages.occupancy'
``` SQL
SELECT sub.*
FROM (
    SELECT 
        storages.*, 
        (storages.quantity - IFNULL(SUM(packages.occupancy), 0)) AS remaining_quantity
        -- fait l'opération pour connaitre l'occupation de l'emplacement de stockage ('remaining_quantity' = 0 vaut emplacement plein)
        -- La somme est faite pour calculer l'occupation des emplacements contenant plusieurs colis
        -- Perform the operation to determine the occupancy of the storage emplacement ('remaining_quantity' = 0  means the emplacement is full)
        -- The sum is made to calculate the occupancy of locations containing several packages
    FROM `storages`
    LEFT JOIN (
        SELECT *
        FROM `stored_in`
        WHERE `released_on` IS NULL 
        -- On passe la requête dans la jointure pour afficher tous les éléments de `storages` et seuls ceux de `stored_in` où il y a des enregistrements correspondants
        -- We use a subquery in the join to display all elements from `storages` and only those from `stored_in` where there are matching records
    ) AS `filtered_stored_in` 
    ON `filtered_stored_in`.`id_storages_id` = `storages`.`id`
    LEFT JOIN `parcels` ON `filtered_stored_in`.`id_parcels_id` = `parcels`.`id`
    LEFT JOIN `packagings` ON `parcels`.`id_packagings_id` = `packagings`.`id`
    LEFT JOIN `packages` ON `packagings`.`id_packages_id` = `packages`.`id`
    GROUP BY `storages`.`id`, `packages`.`occupancy`, `packages`.`storage`
    ORDER BY `filtered_stored_in`.`id_parcels_id` DESC
) AS sub
WHERE sub.remaining_quantity > 0 AND sub.type = 'A'
-- on masque les emplacements pleins et on passe la zone de stockage souhaitée en paramétre
-- we hide the full emplacements and pass the desired storage area as a parameter
ORDER BY `sub`.`id` ASC;
```