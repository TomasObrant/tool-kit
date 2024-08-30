<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Shared\Infrastructure\Helpers\InsertHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827203147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "application" (id INT NOT NULL, creator_id INT DEFAULT NULL, status_id INT DEFAULT NULL, topic VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A45BDDC161220EA6 ON "application" (creator_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC16BF700BD ON "application" (status_id)');
        $this->addSql('CREATE TABLE "application_status" (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE "application" ADD CONSTRAINT FK_A45BDDC161220EA6 FOREIGN KEY (creator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "application" ADD CONSTRAINT FK_A45BDDC16BF700BD FOREIGN KEY (status_id) REFERENCES "application_status" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql(InsertHelper::insertApplicationStatus());
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "application" DROP CONSTRAINT FK_A45BDDC161220EA6');
        $this->addSql('ALTER TABLE "application" DROP CONSTRAINT FK_A45BDDC16BF700BD');
        $this->addSql('DROP TABLE "application"');
        $this->addSql('DROP TABLE "application_status"');
    }
}
