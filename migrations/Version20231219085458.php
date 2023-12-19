<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219085458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE suggestion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE suggestion (id INT NOT NULL, event_id INT NOT NULL, issent_id INT DEFAULT NULL, product VARCHAR(255) NOT NULL, is_taken BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DD80F31B71F7E88B ON suggestion (event_id)');
        $this->addSql('CREATE INDEX IDX_DD80F31BEAF003B8 ON suggestion (issent_id)');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31BEAF003B8 FOREIGN KEY (issent_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE suggestion_id_seq CASCADE');
        $this->addSql('ALTER TABLE suggestion DROP CONSTRAINT FK_DD80F31B71F7E88B');
        $this->addSql('ALTER TABLE suggestion DROP CONSTRAINT FK_DD80F31BEAF003B8');
        $this->addSql('DROP TABLE suggestion');
    }
}
