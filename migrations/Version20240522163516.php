<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522163516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product CHANGE id_product id_product VARCHAR(255) DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE price price INT DEFAULT NULL, CHANGE description description VARCHAR(1255) DEFAULT NULL, CHANGE sale sale VARCHAR(255) DEFAULT NULL, CHANGE stock stock VARCHAR(255) DEFAULT NULL, CHANGE manufacturer manufacturer VARCHAR(255) DEFAULT NULL, CHANGE weight weight VARCHAR(255) DEFAULT NULL, CHANGE volume volume VARCHAR(255) DEFAULT NULL, CHANGE voltage voltage VARCHAR(255) DEFAULT NULL, CHANGE rown rown VARCHAR(255) DEFAULT NULL, CHANGE engine engine VARCHAR(255) DEFAULT NULL, CHANGE power power VARCHAR(255) DEFAULT NULL, CHANGE mixtures mixtures VARCHAR(255) DEFAULT NULL, CHANGE time time VARCHAR(255) DEFAULT NULL, CHANGE drive drive VARCHAR(255) DEFAULT NULL, CHANGE retainer retainer VARCHAR(255) DEFAULT NULL, CHANGE connections connections VARCHAR(255) DEFAULT NULL, CHANGE wheels wheels VARCHAR(255) DEFAULT NULL, CHANGE dimensions dimensions VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(255) DEFAULT NULL, CHANGE motherland motherland VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE img img VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_product CHANGE id_product id_product VARCHAR(255) NOT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE price price INT NOT NULL, CHANGE description description VARCHAR(1255) NOT NULL, CHANGE sale sale VARCHAR(255) NOT NULL, CHANGE manufacturer manufacturer VARCHAR(255) NOT NULL, CHANGE weight weight VARCHAR(255) NOT NULL, CHANGE volume volume VARCHAR(255) NOT NULL, CHANGE voltage voltage VARCHAR(255) NOT NULL, CHANGE rown rown VARCHAR(255) NOT NULL, CHANGE engine engine VARCHAR(255) NOT NULL, CHANGE power power VARCHAR(255) NOT NULL, CHANGE mixtures mixtures VARCHAR(255) NOT NULL, CHANGE time time VARCHAR(255) NOT NULL, CHANGE drive drive VARCHAR(255) NOT NULL, CHANGE retainer retainer VARCHAR(255) NOT NULL, CHANGE connections connections VARCHAR(255) NOT NULL, CHANGE wheels wheels VARCHAR(255) NOT NULL, CHANGE dimensions dimensions VARCHAR(255) NOT NULL, CHANGE country country VARCHAR(255) NOT NULL, CHANGE motherland motherland VARCHAR(255) NOT NULL, CHANGE stock stock VARCHAR(255) NOT NULL, CHANGE img img VARCHAR(255) NOT NULL');
    }
}
