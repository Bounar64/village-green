<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211015162003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add codepromo relation with order';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders ADD promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEED0C07AFF FOREIGN KEY (promo_id) REFERENCES code_promo (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEED0C07AFF ON orders (promo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `orders` DROP FOREIGN KEY FK_E52FFDEED0C07AFF');
        $this->addSql('DROP INDEX IDX_E52FFDEED0C07AFF ON `orders`');
        $this->addSql('ALTER TABLE `orders` DROP promo_id');
    }
}
