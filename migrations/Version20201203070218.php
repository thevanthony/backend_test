<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203070218 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        // Add postgresql extension to autogenerate id
        $this->addSql('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        // Create users table with auto geneterated uuid solely based on random numbers
        $this->addSql('CREATE TABLE "users" (id UUID NOT NULL DEFAULT uuid_generate_v4(), email VARCHAR(180) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON "users" (email)');
        $this->addSql('COMMENT ON COLUMN "users".id IS \'(DC2Type:uuid)\'');

        // create a default user for demo
        $this->addSql("INSERT INTO users (email, first_name, last_name, password, roles) VALUES ('email@email.fr', 'anthony', 'thevenin', '$2y$13\$mk/H0QofGFcBHAWRlSKaIOuzYFtLi09l7GTzckKe7dqZLSpE8jNfO', '{}')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE "users"');
    }
}
