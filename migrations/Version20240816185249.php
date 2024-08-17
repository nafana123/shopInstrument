<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816185249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product DROP name, DROP price, DROP sale, DROP stock, DROP manufacturer, DROP weight, DROP volume, DROP voltage, DROP rown, DROP engine, DROP power, DROP mixtures, DROP time, DROP drive, DROP retainer, DROP connections, DROP wheels, DROP dimensions, DROP country, DROP motherland');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product ADD name VARCHAR(255) DEFAULT NULL, ADD price INT DEFAULT NULL, ADD sale VARCHAR(255) DEFAULT NULL, ADD stock VARCHAR(255) DEFAULT NULL, ADD manufacturer VARCHAR(255) DEFAULT NULL, ADD weight VARCHAR(255) DEFAULT NULL, ADD volume VARCHAR(255) DEFAULT NULL, ADD voltage VARCHAR(255) DEFAULT NULL, ADD rown VARCHAR(255) DEFAULT NULL, ADD engine VARCHAR(255) DEFAULT NULL, ADD power VARCHAR(255) DEFAULT NULL, ADD mixtures VARCHAR(255) DEFAULT NULL, ADD time VARCHAR(255) DEFAULT NULL, ADD drive VARCHAR(255) DEFAULT NULL, ADD retainer VARCHAR(255) DEFAULT NULL, ADD connections VARCHAR(255) DEFAULT NULL, ADD wheels VARCHAR(255) DEFAULT NULL, ADD dimensions VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD motherland VARCHAR(255) DEFAULT NULL');
    }
}
