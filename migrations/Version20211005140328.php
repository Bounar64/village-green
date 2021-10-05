<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211005140328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create relation between Product and Supplier';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('SET GLOBAL FOREIGN_KEY_CHECKS=0'); aide à désactivé les clés étrangères 
        $this->addSql('ALTER TABLE products ADD supplier_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A2ADD6D8C ON products (supplier_id)');   
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A2ADD6D8C');
        $this->addSql('DROP INDEX IDX_B3BA5A5A2ADD6D8C ON products');
        $this->addSql('ALTER TABLE products DROP supplier_id');
    }
}
