<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200601152750 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car_file (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, car_id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_47F522BCC54C8C93 (type_id), INDEX IDX_47F522BC642B8210 (admin_id), INDEX IDX_47F522BCC3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_file_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_file ADD CONSTRAINT FK_47F522BCC54C8C93 FOREIGN KEY (type_id) REFERENCES car_file_type (id)');
        $this->addSql('ALTER TABLE car_file ADD CONSTRAINT FK_47F522BC642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car_file ADD CONSTRAINT FK_47F522BCC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_file DROP FOREIGN KEY FK_47F522BCC54C8C93');
        $this->addSql('DROP TABLE car_file');
        $this->addSql('DROP TABLE car_file_type');
    }
}
