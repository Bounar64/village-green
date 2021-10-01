<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211001162218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add fulltext index for research';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE FULLTEXT INDEX IDX_B3BA5A5AEA750E88EA2F0ED1C52F958AEA34913 ON products (label, short_label, brand, reference)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_B3BA5A5AEA750E88EA2F0ED1C52F958AEA34913 ON products');
    }
}
