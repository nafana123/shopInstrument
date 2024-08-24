<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240824075740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE checks ADD product_id INT NOT NULL, DROP id_products');
        $this->addSql('ALTER TABLE checks ADD CONSTRAINT FK_9F8C00794584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_9F8C00794584665A ON checks (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C4584665A');
        $this->addSql('DROP TABLE test');
        $this->addSql('ALTER TABLE checks DROP FOREIGN KEY FK_9F8C00794584665A');
        $this->addSql('DROP INDEX IDX_9F8C00794584665A ON checks');
        $this->addSql('ALTER TABLE checks ADD id_products VARCHAR(255) NOT NULL, DROP product_id');
    }
}
