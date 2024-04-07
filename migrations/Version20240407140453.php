<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407140453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stored_in (id_parcels_id INT NOT NULL, id_storages_id INT NOT NULL, entered_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', released_on DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A06A89474B0B2FBE (id_parcels_id), INDEX IDX_A06A8947F30264D (id_storages_id), PRIMARY KEY(id_parcels_id, id_storages_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stored_in ADD CONSTRAINT FK_A06A89474B0B2FBE FOREIGN KEY (id_parcels_id) REFERENCES parcels (id)');
        $this->addSql('ALTER TABLE stored_in ADD CONSTRAINT FK_A06A8947F30264D FOREIGN KEY (id_storages_id) REFERENCES storages (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stored_in DROP FOREIGN KEY FK_A06A89474B0B2FBE');
        $this->addSql('ALTER TABLE stored_in DROP FOREIGN KEY FK_A06A8947F30264D');
        $this->addSql('DROP TABLE stored_in');
    }
}
