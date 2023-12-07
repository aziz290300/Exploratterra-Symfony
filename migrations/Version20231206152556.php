<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206152556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE billet (id INT AUTO_INCREMENT NOT NULL, vol_id INT NOT NULL, nom_billet VARCHAR(255) NOT NULL, INDEX IDX_1F034AF69F2BFB7A (vol_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, user_id INT DEFAULT NULL, start_date DATETIME NOT NULL, finish_date DATETIME NOT NULL, nombre INT NOT NULL, INDEX IDX_E00CEDDE3243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_restaurant (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT DEFAULT NULL, user_id INT DEFAULT NULL, start_date DATETIME NOT NULL, nombre INT NOT NULL, INDEX IDX_720F714EB1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_vol (id INT AUTO_INCREMENT NOT NULL, vol_id INT NOT NULL, user_id INT DEFAULT NULL, nombre INT NOT NULL, INDEX IDX_2F39AE3C9F2BFB7A (vol_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, date_debut DATE DEFAULT NULL, description VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, places_dispo INT NOT NULL, INDEX IDX_B26681EBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, name_hotel VARCHAR(255) NOT NULL, rating_hotel DOUBLE PRECISION NOT NULL, image_hotel VARCHAR(255) DEFAULT NULL, description_hotel LONGTEXT DEFAULT NULL, number_of_rooms INT DEFAULT NULL, INDEX IDX_3535ED9C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, type_reclamation_id INT DEFAULT NULL, contenu_reclamation VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, objet LONGTEXT NOT NULL, INDEX IDX_CE6064047BA88B4D (type_reclamation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, name_restaurant VARCHAR(255) NOT NULL, rating_restaurant DOUBLE PRECISION NOT NULL, number_of_rooms INT DEFAULT NULL, image_restaurant VARCHAR(255) DEFAULT NULL, description_restaurant LONGTEXT DEFAULT NULL, INDEX IDX_EB95123FC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8CDE57295E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_reclamation (id INT AUTO_INCREMENT NOT NULL, libelle_type_reclamation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(500) NOT NULL, prenomuser VARCHAR(500) NOT NULL, numtel VARCHAR(500) NOT NULL, email VARCHAR(500) NOT NULL, password VARCHAR(500) NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vol (id INT AUTO_INCREMENT NOT NULL, nom_vol VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, nombre INT NOT NULL, start_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF69F2BFB7A FOREIGN KEY (vol_id) REFERENCES vol (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE booking_restaurant ADD CONSTRAINT FK_720F714EB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE booking_vol ADD CONSTRAINT FK_2F39AE3C9F2BFB7A FOREIGN KEY (vol_id) REFERENCES vol (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047BA88B4D FOREIGN KEY (type_reclamation_id) REFERENCES type_reclamation (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF69F2BFB7A');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE3243BB18');
        $this->addSql('ALTER TABLE booking_restaurant DROP FOREIGN KEY FK_720F714EB1E7706E');
        $this->addSql('ALTER TABLE booking_vol DROP FOREIGN KEY FK_2F39AE3C9F2BFB7A');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EBCF5E72D');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9C54C8C93');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047BA88B4D');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FC54C8C93');
        $this->addSql('DROP TABLE billet');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_restaurant');
        $this->addSql('DROP TABLE booking_vol');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE type_reclamation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vol');
    }
}
