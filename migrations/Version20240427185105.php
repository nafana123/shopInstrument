<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240427185105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product ADD manufacturer VARCHAR(255) NOT NULL, ADD weight VARCHAR(255) NOT NULL, ADD volume VARCHAR(255) NOT NULL, ADD voltage VARCHAR(255) NOT NULL, ADD rown VARCHAR(255) NOT NULL, ADD engine VARCHAR(255) NOT NULL, ADD power VARCHAR(255) NOT NULL, ADD mixtures VARCHAR(255) NOT NULL, ADD time VARCHAR(255) NOT NULL, ADD drive VARCHAR(255) NOT NULL, ADD retainer VARCHAR(255) NOT NULL, ADD type_of_drive VARCHAR(255) NOT NULL, ADD connections VARCHAR(255) NOT NULL, ADD wheels VARCHAR(255) NOT NULL, ADD dimensions VARCHAR(255) NOT NULL, ADD country VARCHAR(255) NOT NULL, ADD motherland VARCHAR(255) NOT NULL, DROP advantages');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product ADD advantages VARCHAR(1255) NOT NULL, DROP manufacturer, DROP weight, DROP volume, DROP voltage, DROP rown, DROP engine, DROP power, DROP mixtures, DROP time, DROP drive, DROP retainer, DROP type_of_drive, DROP connections, DROP wheels, DROP dimensions, DROP country, DROP motherland');
    }
}
