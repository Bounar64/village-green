<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922072636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create orders table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `orders` (id INT AUTO_INCREMENT NOT NULL, ref VARCHAR(10) NOT NULL, type_payment VARCHAR(50) NOT NULL, shipping VARCHAR(50) NOT NULL, address_second VARCHAR(80) DEFAULT NULL, total NUMERIC(7, 2) NOT NULL, date_payment DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_sent DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `orders`');
    }
}
