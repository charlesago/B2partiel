<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218103333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD private_status BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE event ADD private_place BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE event DROP status');
        $this->addSql('ALTER TABLE event DROP typeofplace');
        $this->addSql('ALTER TABLE event ALTER startof TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE event ALTER endof TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN event.startof IS NULL');
        $this->addSql('COMMENT ON COLUMN event.endof IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE event ADD typeofplace VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE event DROP private_status');
        $this->addSql('ALTER TABLE event DROP private_place');
        $this->addSql('ALTER TABLE event ALTER startof TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE event ALTER endof TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN event.startof IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN event.endof IS \'(DC2Type:datetime_immutable)\'');
    }
}
