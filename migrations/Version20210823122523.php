<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210823122523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create products table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(80) NOT NULL, short_label VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, reference VARCHAR(80) NOT NULL, color VARCHAR(50) NOT NULL, material VARCHAR(80) NOT NULL, service TINYINT(1) NOT NULL, discount SMALLINT DEFAULT NULL, image VARCHAR(100) NOT NULL, price NUMERIC(7, 2) NOT NULL, stock SMALLINT NOT NULL, stock_alert SMALLINT NOT NULL, actived TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE products');
    }
}
