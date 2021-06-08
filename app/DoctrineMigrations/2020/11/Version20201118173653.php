<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201118173653 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registration_certificate (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD registration_certificate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DBEBCD1AF FOREIGN KEY (registration_certificate_id) REFERENCES registration_certificate (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_773DE69DBEBCD1AF ON car (registration_certificate_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DBEBCD1AF');
        $this->addSql('DROP TABLE registration_certificate');
        $this->addSql('DROP INDEX IDX_773DE69DBEBCD1AF ON car');
        $this->addSql('ALTER TABLE car DROP registration_certificate_id');
    }
}
