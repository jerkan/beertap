<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221110153511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Dispenser usage';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dispenser_usages (id VARCHAR(255) NOT NULL, opened_at DATETIME NOT NULL, flow_volume FLOAT NOT NULL, cost_per_unit FLOAT NOT NULL, closed_at DATETIME, PRIMARY KEY(id, opened_at))');
        $this->addSql('alter table dispensers drop column opened_at');
        $this->addSql('alter table dispensers drop column closed_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dispenser_usages');
        $this->addSql('alter table dispensers add column opened_at DATETIME');
        $this->addSql('alter table dispensers add column closed_at DATETIME');
    }
}
