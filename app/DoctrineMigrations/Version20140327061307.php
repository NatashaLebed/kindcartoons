<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140327061307 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE video ADD country_id INT DEFAULT NULL, ADD language_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL, ADD year INT NOT NULL");
        $this->addSql("ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)");
        $this->addSql("ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)");
        $this->addSql("ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)");
        $this->addSql("CREATE INDEX IDX_7CC7DA2CF92F3E70 ON video (country_id)");
        $this->addSql("CREATE INDEX IDX_7CC7DA2C82F1BAF4 ON video (language_id)");
        $this->addSql("CREATE INDEX IDX_7CC7DA2CC54C8C93 ON video (type_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C82F1BAF4");
        $this->addSql("ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CC54C8C93");
        $this->addSql("ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CF92F3E70");
        $this->addSql("DROP TABLE language");
        $this->addSql("DROP TABLE type");
        $this->addSql("DROP TABLE country");
        $this->addSql("DROP INDEX IDX_7CC7DA2CF92F3E70 ON video");
        $this->addSql("DROP INDEX IDX_7CC7DA2C82F1BAF4 ON video");
        $this->addSql("DROP INDEX IDX_7CC7DA2CC54C8C93 ON video");
        $this->addSql("ALTER TABLE video DROP country_id, DROP language_id, DROP type_id, DROP year");
    }
}
