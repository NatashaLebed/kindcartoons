<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140417102443 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE fos_user CHANGE first_name first_name VARCHAR(64) DEFAULT NULL, CHANGE last_name last_name VARCHAR(64) DEFAULT NULL, CHANGE time_limit time_limit TIME DEFAULT NULL, CHANGE gender gender VARCHAR(16) DEFAULT NULL, CHANGE birth_day birth_day DATE DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE fos_user CHANGE first_name first_name VARCHAR(64) NOT NULL, CHANGE last_name last_name VARCHAR(64) NOT NULL, CHANGE gender gender VARCHAR(16) NOT NULL, CHANGE birth_day birth_day DATE NOT NULL, CHANGE time_limit time_limit TIME NOT NULL");
    }
}
