<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207142159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guide (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, langue_parle VARCHAR(255) NOT NULL, disponiblite VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voyage (id VARCHAR(255) NOT NULL, guide_id INT DEFAULT NULL, destination VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, date_depart DATE NOT NULL, place_disponible VARCHAR(255) NOT NULL, date_retour DATE NOT NULL, image VARCHAR(255) NOT NULL, itineraire VARCHAR(255) NOT NULL, INDEX IDX_3F9D8955D7ED1D4B (guide_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955D7ED1D4B FOREIGN KEY (guide_id) REFERENCES guide (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D8955D7ED1D4B');
        $this->addSql('DROP TABLE guide');
        $this->addSql('DROP TABLE voyage');
    }
}
