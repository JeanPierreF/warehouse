CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) UNIQUE,
  `password` VARCHAR(255),
  `active` BOOLEAN,
  `role` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `packages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `reference` VARCHAR(255),
  `length` INT,
  `width` INT,
  `height` INT,
  `palletizable` BOOLEAN,
  `occupancy` TINYINT,
  `storage` VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `id_packages` INT
) ENGINE=InnoDB;

CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `date_order` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `supplier_name` VARCHAR(255),
  `id_products` INT,
  `quantity_order` INT,
  FOREIGN KEY (`id_products`) REFERENCES `products` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `packagings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_products` INT,
  `id_packages` INT,
  `quantity_max` INT DEFAULT 0,
  FOREIGN KEY (`id_products`) REFERENCES `products` (`id`),
  FOREIGN KEY (`id_packages`) REFERENCES `packages` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `parcels` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_orders` INT,
  `id_packagings` INT,
  `eancode` VARCHAR(255),
  `quantity` INT,
  FOREIGN KEY (`id_orders`) REFERENCES `orders` (`id`),
  FOREIGN KEY (`id_packagings`) REFERENCES `packagings` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `storages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` CHAR(1),
  `emplacement` VARCHAR(255),
  `quantity` INT
) ENGINE=InnoDB;

CREATE TABLE `stored_in` (
  `id_parcels` INT,
  `id_storages` INT,
  `entered_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `released_on` DATETIME,
  PRIMARY KEY (`id_parcels`, `id_storages`),
  FOREIGN KEY (`id_parcels`) REFERENCES `parcels` (`id`),
  FOREIGN KEY (`id_storages`) REFERENCES `storages` (`id`)
) ENGINE=InnoDB;
