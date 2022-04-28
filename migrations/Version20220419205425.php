<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419205425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY avis_ibfk_2');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY avis_ibfk_1');
        $this->addSql('ALTER TABLE avis CHANGE id_hbg id_hbg INT DEFAULT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FE6E88D7 FOREIGN KEY (idUser) REFERENCES utilisateurs (idUser)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0A33C560E FOREIGN KEY (id_hbg) REFERENCES thebergement (id_hbg)');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY categorie_ibfk_1');
        $this->addSql('ALTER TABLE categorie CHANGE id_hbg id_hbg INT NOT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634A33C560E FOREIGN KEY (id_hbg) REFERENCES thebergement (id_hbg)');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY paiement_ibfk_1');
        $this->addSql('ALTER TABLE paiement CHANGE idRes idRes INT DEFAULT NULL, CHANGE canceled canceled INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E58FAC7CF FOREIGN KEY (idRes) REFERENCES reservation (idRes)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY reclamation_ibfk_1');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY reclamation_ibfk_2');
        $this->addSql('ALTER TABLE reclamation CHANGE id_hbg id_hbg INT DEFAULT NULL, CHANGE traite traite INT NOT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404FE6E88D7 FOREIGN KEY (idUser) REFERENCES utilisateurs (idUser)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A33C560E FOREIGN KEY (id_hbg) REFERENCES thebergement (id_hbg)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_1');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_2');
        $this->addSql('ALTER TABLE reservation CHANGE idUser idUser INT DEFAULT NULL, CHANGE idHebr idHebr INT DEFAULT NULL, CHANGE idVol idVol INT NOT NULL, CHANGE valide valide INT DEFAULT NULL, CHANGE nbPersonne nbPersonne INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FE6E88D7 FOREIGN KEY (idUser) REFERENCES utilisateurs (idUser)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955BF74E90 FOREIGN KEY (idHebr) REFERENCES thebergement (id_hbg)');
        $this->addSql('ALTER TABLE reservationevent DROP FOREIGN KEY reservationevent_ibfk_1');
        $this->addSql('ALTER TABLE reservationevent CHANGE idRes idRes INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT FK_70B2B7D458FAC7CF FOREIGN KEY (idRes) REFERENCES reservation (idRes)');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY ticket_ibfk_1');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY ticket_ibfk_2');
        $this->addSql('ALTER TABLE ticket CHANGE idPmt idPmt INT DEFAULT NULL, CHANGE idRes idRes INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA358FAC7CF FOREIGN KEY (idRes) REFERENCES reservation (idRes)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3DC30C0A FOREIGN KEY (idPmt) REFERENCES paiement (idPmt)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0FE6E88D7');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0A33C560E');
        $this->addSql('ALTER TABLE avis CHANGE id_hbg id_hbg INT NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT avis_ibfk_2 FOREIGN KEY (idUser) REFERENCES utilisateurs (idUser) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT avis_ibfk_1 FOREIGN KEY (id_hbg) REFERENCES thebergement (id_hbg) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634A33C560E');
        $this->addSql('ALTER TABLE categorie CHANGE id_hbg id_hbg INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT categorie_ibfk_1 FOREIGN KEY (id_hbg) REFERENCES thebergement (id_hbg) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E58FAC7CF');
        $this->addSql('ALTER TABLE paiement CHANGE canceled canceled INT DEFAULT 0 NOT NULL, CHANGE idRes idRes INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT paiement_ibfk_1 FOREIGN KEY (idRes) REFERENCES reservation (idRes) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404FE6E88D7');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A33C560E');
        $this->addSql('ALTER TABLE reclamation CHANGE id_hbg id_hbg INT NOT NULL, CHANGE traite traite INT DEFAULT 0 NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT reclamation_ibfk_1 FOREIGN KEY (id_hbg) REFERENCES thebergement (id_hbg) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT reclamation_ibfk_2 FOREIGN KEY (idUser) REFERENCES utilisateurs (idUser) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955FE6E88D7');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955BF74E90');
        $this->addSql('ALTER TABLE reservation CHANGE idVol idVol INT DEFAULT NULL, CHANGE valide valide INT DEFAULT 0, CHANGE nbPersonne nbPersonne INT DEFAULT NULL, CHANGE idUser idUser INT NOT NULL, CHANGE idHebr idHebr INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_1 FOREIGN KEY (idHebr) REFERENCES thebergement (id_hbg) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_2 FOREIGN KEY (idUser) REFERENCES utilisateurs (idUser) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservationevent DROP FOREIGN KEY FK_70B2B7D458FAC7CF');
        $this->addSql('ALTER TABLE reservationevent CHANGE idRes idRes INT NOT NULL');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT reservationevent_ibfk_1 FOREIGN KEY (idRes) REFERENCES reservation (idRes) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA358FAC7CF');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3DC30C0A');
        $this->addSql('ALTER TABLE ticket CHANGE deleted deleted INT DEFAULT 0, CHANGE idRes idRes INT NOT NULL, CHANGE idPmt idPmt INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT ticket_ibfk_1 FOREIGN KEY (idPmt) REFERENCES paiement (idPmt) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT ticket_ibfk_2 FOREIGN KEY (idRes) REFERENCES reservation (idRes) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
