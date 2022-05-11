<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511210940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id_avis INT AUTO_INCREMENT NOT NULL, desc_avis VARCHAR(3000) NOT NULL, etoile INT NOT NULL, dateAjoutavis DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, idUser INT DEFAULT NULL, INDEX idUser (idUser), PRIMARY KEY(id_avis)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id_hbg INT NOT NULL, etoile INT NOT NULL, PRIMARY KEY(id_hbg)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id_event INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, nb_place INT NOT NULL, prix_event INT NOT NULL, debut DATE NOT NULL, PRIMARY KEY(id_event)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hebergement (id_hbg INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, date_ajout DATE NOT NULL, adress VARCHAR(255) NOT NULL, nom_hotel VARCHAR(30) NOT NULL, nb_chambres INT NOT NULL, nb_suites INT NOT NULL, piscine INT NOT NULL, image VARCHAR(255) NOT NULL, prix INT NOT NULL, PRIMARY KEY(id_hbg)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (idPmt INT AUTO_INCREMENT NOT NULL, datePmt DATETIME NOT NULL, methode VARCHAR(30) NOT NULL, montant DOUBLE PRECISION NOT NULL, canceled INT NOT NULL, idRes INT DEFAULT NULL, INDEX idRes (idRes), PRIMARY KEY(idPmt)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id_rec INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, desc_rec VARCHAR(3000) NOT NULL, traite INT NOT NULL, dateAjoutrec DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, dateTraitrec DATETIME DEFAULT NULL, idUser INT DEFAULT NULL, INDEX type_id (type_id), INDEX idUser (idUser), PRIMARY KEY(id_rec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (idRes INT AUTO_INCREMENT NOT NULL, idVol INT NOT NULL, valide INT DEFAULT NULL, nbPersonne INT NOT NULL, forfait VARCHAR(25) NOT NULL, nbChambre INT NOT NULL, nbSuite INT NOT NULL, dateArr DATE NOT NULL, dateDep DATE NOT NULL, dateRes DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deadlineAnnulation DATETIME NOT NULL, idHebr INT DEFAULT NULL, idUser INT DEFAULT NULL, INDEX idUser (idUser), INDEX idHebr (idHebr), PRIMARY KEY(idRes)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservationevent (idEvent INT DEFAULT NULL, idRes INT NOT NULL, INDEX idRes (idRes), PRIMARY KEY(idRes)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (idTicket INT AUTO_INCREMENT NOT NULL, deleted INT DEFAULT NULL, idPmt INT DEFAULT NULL, idRes INT DEFAULT NULL, INDEX idRes (idRes), INDEX idPmt (idPmt), PRIMARY KEY(idTicket)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FE6E88D7 FOREIGN KEY (idUser) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634A33C560E FOREIGN KEY (id_hbg) REFERENCES hebergement (id_hbg)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E58FAC7CF FOREIGN KEY (idRes) REFERENCES reservation (idRes)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404FE6E88D7 FOREIGN KEY (idUser) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955BF74E90 FOREIGN KEY (idHebr) REFERENCES hebergement (id_hbg)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FE6E88D7 FOREIGN KEY (idUser) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT FK_70B2B7D458FAC7CF FOREIGN KEY (idRes) REFERENCES reservation (idRes)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3DC30C0A FOREIGN KEY (idPmt) REFERENCES paiement (idPmt)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA358FAC7CF FOREIGN KEY (idRes) REFERENCES reservation (idRes)');
        $this->addSql('ALTER TABLE utilisateurs CHANGE voiture voiture VARCHAR(255) NOT NULL, CHANGE isVerified isVerified INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634A33C560E');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955BF74E90');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3DC30C0A');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E58FAC7CF');
        $this->addSql('ALTER TABLE reservationevent DROP FOREIGN KEY FK_70B2B7D458FAC7CF');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA358FAC7CF');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404C54C8C93');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE hebergement');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservationevent');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE utilisateurs CHANGE voiture voiture VARCHAR(255) DEFAULT NULL, CHANGE isVerified isVerified INT DEFAULT NULL');
    }
}
