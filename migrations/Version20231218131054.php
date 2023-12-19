<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218131054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE invitation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE invitation (id INT NOT NULL, receive_id INT DEFAULT NULL, to_event_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F11D61A24CB96DCC ON invitation (receive_id)');
        $this->addSql('CREATE INDEX IDX_F11D61A2BCAE7625 ON invitation (to_event_id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A24CB96DCC FOREIGN KEY (receive_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2BCAE7625 FOREIGN KEY (to_event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE invitation_id_seq CASCADE');
        $this->addSql('ALTER TABLE invitation DROP CONSTRAINT FK_F11D61A24CB96DCC');
        $this->addSql('ALTER TABLE invitation DROP CONSTRAINT FK_F11D61A2BCAE7625');
        $this->addSql('DROP TABLE invitation');
    }
}
