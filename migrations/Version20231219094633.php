<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219094633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suggestion ADD of_contribution_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31BCD40B077 FOREIGN KEY (of_contribution_id) REFERENCES contribution (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DD80F31BCD40B077 ON suggestion (of_contribution_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE suggestion DROP CONSTRAINT FK_DD80F31BCD40B077');
        $this->addSql('DROP INDEX UNIQ_DD80F31BCD40B077');
        $this->addSql('ALTER TABLE suggestion DROP of_contribution_id');
    }
}
