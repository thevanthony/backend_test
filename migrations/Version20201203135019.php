<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203135019 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create column users.token for authentication';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE users ADD token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "users" DROP token');
    }
}
