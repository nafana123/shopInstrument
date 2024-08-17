<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817202224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product DROP description, DROP type, DROP img, DROP id_product, DROP sale');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product ADD description VARCHAR(1255) DEFAULT NULL, ADD type VARCHAR(255) DEFAULT NULL, ADD img VARCHAR(255) DEFAULT NULL, ADD id_product VARCHAR(255) DEFAULT NULL, ADD sale INT DEFAULT NULL');
    }
}
