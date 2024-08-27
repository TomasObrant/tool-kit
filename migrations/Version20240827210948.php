<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827210948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "application_file" (id INT NOT NULL, application_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, mime VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B735E983E030ACD ON "application_file" (application_id)');
        $this->addSql('ALTER TABLE "application_file" ADD CONSTRAINT FK_7B735E983E030ACD FOREIGN KEY (application_id) REFERENCES "application" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "application_file" DROP CONSTRAINT FK_7B735E983E030ACD');
        $this->addSql('DROP TABLE "application_file"');
    }
}
