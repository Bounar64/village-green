<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824130155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add brand product';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products ADD brand VARCHAR(80) NOT NULL');
        $this->addSql('ALTER TABLE products RENAME INDEX fk_b3ba5a5a12469de2 TO IDX_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE products RENAME INDEX fk_b3ba5a5af7bfe87c TO IDX_B3BA5A5AF7BFE87C');
        $this->addSql('ALTER TABLE sub_category RENAME INDEX fk_bce3f79812469de2 TO IDX_BCE3F79812469DE2');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP brand');
        $this->addSql('ALTER TABLE products RENAME INDEX idx_b3ba5a5a12469de2 TO FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE products RENAME INDEX idx_b3ba5a5af7bfe87c TO FK_B3BA5A5AF7BFE87C');
        $this->addSql('ALTER TABLE sub_category RENAME INDEX idx_bce3f79812469de2 TO FK_BCE3F79812469DE2');
    }
}
