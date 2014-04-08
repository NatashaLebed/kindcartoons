<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140408141944 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, video_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_D889262229C1004E (video_id), INDEX IDX_D8892622A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, video_id INT DEFAULT NULL, title VARCHAR(64) NOT NULL, src VARCHAR(255) NOT NULL, thumblnail VARCHAR(255) NOT NULL, INDEX IDX_C53D045F29C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE rating ADD CONSTRAINT FK_D889262229C1004E FOREIGN KEY (video_id) REFERENCES video (id)");
        $this->addSql("ALTER TABLE rating ADD CONSTRAINT FK_D8892622A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE image ADD CONSTRAINT FK_C53D045F29C1004E FOREIGN KEY (video_id) REFERENCES video (id)");
        $this->addSql("ALTER TABLE videos_users DROP PRIMARY KEY");
        $this->addSql("ALTER TABLE videos_users ADD PRIMARY KEY (user_id, video_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE rating");
        $this->addSql("DROP TABLE image");
        $this->addSql("ALTER TABLE videos_users DROP PRIMARY KEY");
        $this->addSql("ALTER TABLE videos_users ADD PRIMARY KEY (video_id, user_id)");
    }
}
