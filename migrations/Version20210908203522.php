<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908203522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(80) NOT NULL, roles JSON NOT NULL, reference VARCHAR(80) NOT NULL, password VARCHAR(100) NOT NULL, last_name VARCHAR(80) DEFAULT NULL, first_name VARCHAR(80) DEFAULT NULL, compagny VARCHAR(80) DEFAULT NULL, vta_number VARCHAR(30) DEFAULT NULL, rcs_number VARCHAR(30) DEFAULT NULL, type TINYINT(1) NOT NULL, coeff SMALLINT NOT NULL, sex TINYINT(1) DEFAULT NULL, address VARCHAR(80) NOT NULL, additional_address VARCHAR(80) DEFAULT NULL, city VARCHAR(80) NOT NULL, zip_code VARCHAR(50) NOT NULL, phone VARCHAR(50) NOT NULL, phone_fixe VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');

    }
}
