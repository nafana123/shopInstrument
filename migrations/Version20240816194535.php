<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816194535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_characteristics (id INT AUTO_INCREMENT NOT NULL, characteristic VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, product_id INT NOT NULL, INDEX IDX_42BCB4CB4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE product_characteristics ADD CONSTRAINT FK_42BCB4CB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_characteristics DROP FOREIGN KEY FK_42BCB4CB4584665A');
        $this->addSql('DROP TABLE product_characteristics');
    }
}
