<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108191130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Dispensers table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dispensers (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, flow_volume FLOAT NOT NULL, opened_at DATETIME, closed_at DATETIME, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dispensers');
    }
}
