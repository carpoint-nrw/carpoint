<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190525174429 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE salesman_booking (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, book_time DATETIME DEFAULT NULL, INDEX IDX_C752CB75C3C6F69F (car_id), INDEX IDX_C752CB75642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salesman_booking ADD CONSTRAINT FK_C752CB75C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE salesman_booking ADD CONSTRAINT FK_C752CB75642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car ADD salesman_id INT DEFAULT NULL, ADD date_of_booking DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9F7F22E2 FOREIGN KEY (salesman_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D9F7F22E2 ON car (salesman_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE salesman_booking');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D9F7F22E2');
        $this->addSql('DROP INDEX IDX_773DE69D9F7F22E2 ON car');
        $this->addSql('ALTER TABLE car DROP salesman_id, DROP date_of_booking');
    }
}
