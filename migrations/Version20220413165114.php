<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220413165114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages ADD sender_id INT DEFAULT NULL, ADD receiver_id INT DEFAULT NULL, DROP sender, DROP receiver');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F624B39D FOREIGN KEY (sender_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_DB021E96F624B39D ON messages (sender_id)');
        $this->addSql('CREATE INDEX IDX_DB021E96CD53EDB6 ON messages (receiver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96F624B39D');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96CD53EDB6');
        $this->addSql('DROP INDEX IDX_DB021E96F624B39D ON messages');
        $this->addSql('DROP INDEX IDX_DB021E96CD53EDB6 ON messages');
        $this->addSql('ALTER TABLE messages ADD sender INT NOT NULL, ADD receiver INT NOT NULL, DROP sender_id, DROP receiver_id');
    }
}
