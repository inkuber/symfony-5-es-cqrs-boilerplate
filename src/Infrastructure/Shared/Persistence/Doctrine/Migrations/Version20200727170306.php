<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200727170306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (id BINARY(16) NOT NULL COMMENT \'(DC2Type:user_id)\', created_at DATETIME(6) NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME(6) DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', credentials_email VARCHAR(255) NOT NULL COMMENT \'(DC2Type:email)\', credentials_password VARCHAR(255) NOT NULL COMMENT \'(DC2Type:hashed_password)\', UNIQUE INDEX UNIQ_1483A5E9299C9369 (credentials_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domain_events (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', string VARCHAR(255) NOT NULL, payload LONGTEXT NOT NULL, recorded_on DATETIME(6) NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE domain_events');
    }
}
