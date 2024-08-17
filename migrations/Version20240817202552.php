<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817202552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product ADD type VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(1255) DEFAULT NULL, ADD img VARCHAR(255) DEFAULT NULL, ADD sale INT DEFAULT NULL, ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE info_product ADD CONSTRAINT FK_518F2D334584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_518F2D334584665A ON info_product (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product DROP FOREIGN KEY FK_518F2D334584665A');
        $this->addSql('DROP INDEX IDX_518F2D334584665A ON info_product');
        $this->addSql('ALTER TABLE info_product DROP type, DROP description, DROP img, DROP sale, DROP product_id');
    }
}
