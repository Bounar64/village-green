<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922081001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation between TypePayment & Order';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders ADD type_payment_id INT NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE19C0759E FOREIGN KEY (type_payment_id) REFERENCES type_payment (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE19C0759E ON orders (type_payment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `orders` DROP FOREIGN KEY FK_E52FFDEE19C0759E');
        $this->addSql('DROP INDEX IDX_E52FFDEE19C0759E ON `orders`');
        $this->addSql('ALTER TABLE `orders` DROP type_payment_id');
    }
}
