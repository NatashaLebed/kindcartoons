<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140327103014 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE video ADD category_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)");
        $this->addSql("CREATE INDEX IDX_7CC7DA2C12469DE2 ON video (category_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C12469DE2");
        $this->addSql("DROP INDEX IDX_7CC7DA2C12469DE2 ON video");
        $this->addSql("ALTER TABLE video DROP category_id");
    }
}
