<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407135054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, id_products_id INT DEFAULT NULL, date_order DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', supplier_name VARCHAR(255) NOT NULL, quantity_order INT NOT NULL, INDEX IDX_E52FFDEE74984C5E (id_products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE packages (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, length INT NOT NULL, width INT NOT NULL, height INT NOT NULL, palletizable TINYINT(1) NOT NULL, occupancy SMALLINT NOT NULL, storage VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9BB5C0A7AEA34913 (reference), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE packagings (id INT AUTO_INCREMENT NOT NULL, id_product_id INT NOT NULL, id_packages_id INT NOT NULL, quantity_max INT NOT NULL, INDEX IDX_866333A9E00EE68D (id_product_id), INDEX IDX_866333A9D295D3F4 (id_packages_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcels (id INT AUTO_INCREMENT NOT NULL, id_order_id INT NOT NULL, id_packagings_id INT NOT NULL, eancode VARCHAR(255) NOT NULL, quantity INT NOT NULL, INDEX IDX_5675350EDD4481AD (id_order_id), INDEX IDX_5675350E2E1027EE (id_packagings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, id_packages_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B3BA5A5AD295D3F4 (id_packages_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE storages (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(2) NOT NULL, emplacement VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE74984C5E FOREIGN KEY (id_products_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE packagings ADD CONSTRAINT FK_866333A9E00EE68D FOREIGN KEY (id_product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE packagings ADD CONSTRAINT FK_866333A9D295D3F4 FOREIGN KEY (id_packages_id) REFERENCES packages (id)');
        $this->addSql('ALTER TABLE parcels ADD CONSTRAINT FK_5675350EDD4481AD FOREIGN KEY (id_order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE parcels ADD CONSTRAINT FK_5675350E2E1027EE FOREIGN KEY (id_packagings_id) REFERENCES packagings (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AD295D3F4 FOREIGN KEY (id_packages_id) REFERENCES packages (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE74984C5E');
        $this->addSql('ALTER TABLE packagings DROP FOREIGN KEY FK_866333A9E00EE68D');
        $this->addSql('ALTER TABLE packagings DROP FOREIGN KEY FK_866333A9D295D3F4');
        $this->addSql('ALTER TABLE parcels DROP FOREIGN KEY FK_5675350EDD4481AD');
        $this->addSql('ALTER TABLE parcels DROP FOREIGN KEY FK_5675350E2E1027EE');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AD295D3F4');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE packages');
        $this->addSql('DROP TABLE packagings');
        $this->addSql('DROP TABLE parcels');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE storages');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
