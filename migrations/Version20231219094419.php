<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219094419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE contribution_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contribution (id INT NOT NULL, response_profile_id INT DEFAULT NULL, event_id INT DEFAULT NULL, suggestion_id INT DEFAULT NULL, product VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EA351E151F02E558 ON contribution (response_profile_id)');
        $this->addSql('CREATE INDEX IDX_EA351E1571F7E88B ON contribution (event_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA351E15A41BB822 ON contribution (suggestion_id)');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E151F02E558 FOREIGN KEY (response_profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E1571F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E15A41BB822 FOREIGN KEY (suggestion_id) REFERENCES suggestion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE contribution_id_seq CASCADE');
        $this->addSql('ALTER TABLE contribution DROP CONSTRAINT FK_EA351E151F02E558');
        $this->addSql('ALTER TABLE contribution DROP CONSTRAINT FK_EA351E1571F7E88B');
        $this->addSql('ALTER TABLE contribution DROP CONSTRAINT FK_EA351E15A41BB822');
        $this->addSql('DROP TABLE contribution');
    }
}
