<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511215007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pickup (id INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, adresseDepart VARCHAR(50) NOT NULL, adresseArrivee VARCHAR(50) NOT NULL, heureDepart VARCHAR(50) NOT NULL, prix VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vol (id INT AUTO_INCREMENT NOT NULL, compagnie VARCHAR(100) NOT NULL, destination VARCHAR(100) NOT NULL, dateDepart DATE NOT NULL, heureDepart VARCHAR(20) NOT NULL, heureArrivee VARCHAR(20) NOT NULL, avion VARCHAR(50) NOT NULL, places INT NOT NULL, prix VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hebergement CHANGE date_ajout date_ajout DATE DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pickup');
        $this->addSql('DROP TABLE vol');
        $this->addSql('ALTER TABLE hebergement CHANGE date_ajout date_ajout DATE NOT NULL, CHANGE image image VARCHAR(255) NOT NULL');
    }
}
