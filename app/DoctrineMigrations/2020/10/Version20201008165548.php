<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201008165548 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car_file_permission (car_file_type_id INT NOT NULL, admin_id INT NOT NULL, INDEX IDX_6202105AC7F38A40 (car_file_type_id), INDEX IDX_6202105A642B8210 (admin_id), PRIMARY KEY(car_file_type_id, admin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_file_permission ADD CONSTRAINT FK_6202105AC7F38A40 FOREIGN KEY (car_file_type_id) REFERENCES car_file_type (id)');
        $this->addSql('ALTER TABLE car_file_permission ADD CONSTRAINT FK_6202105A642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE car_file_permission');
    }
}
