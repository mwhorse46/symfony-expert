<?php

declare(strict_types=1);

namespace App\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803145102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE permission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE permission (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN permission.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN permission.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER INDEX idx_5a8a6c8d605d5ae6 RENAME TO IDX_5A8A6C8DEA9FDD75');
        $this->addSql('ALTER INDEX idx_5a8a6c8d52301061 RENAME TO IDX_5A8A6C8DF8A43BA0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE permission_id_seq CASCADE');
        $this->addSql('DROP TABLE permission');
        $this->addSql('ALTER INDEX idx_5a8a6c8df8a43ba0 RENAME TO idx_5a8a6c8d52301061');
        $this->addSql('ALTER INDEX idx_5a8a6c8dea9fdd75 RENAME TO idx_5a8a6c8d605d5ae6');
    }
}
