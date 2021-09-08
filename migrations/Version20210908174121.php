<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908174121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create employees table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, roles JSON NOT NULL, social_security_number BIGINT NOT NULL, first_name VARCHAR(80) NOT NULL, last_name VARCHAR(80) NOT NULL, email VARCHAR(80) NOT NULL, sex TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, marital_status VARCHAR(50) NOT NULL, dependent_child SMALLINT NOT NULL, address VARCHAR(80) NOT NULL, city VARCHAR(80) NOT NULL, zip_code VARCHAR(50) NOT NULL, phone VARCHAR(50) NOT NULL, degree VARCHAR(80) NOT NULL, salary NUMERIC(7, 2) NOT NULL, rib VARCHAR(80) NOT NULL, first_name_contact_person VARCHAR(80) NOT NULL, last_name_contact_person VARCHAR(80) NOT NULL, address_contact_person VARCHAR(80) NOT NULL, zip_code_contact_person VARCHAR(50) NOT NULL, country_contact_person VARCHAR(10) NOT NULL, phone_contact_person VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_BA82C300E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE employees');
    }
}
