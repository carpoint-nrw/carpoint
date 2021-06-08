<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190526174250 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client_status (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ort (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax_type (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE body_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_condition (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_status (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD phone_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD body_type_id INT DEFAULT NULL, ADD car_status_id INT DEFAULT NULL, ADD client_status_id INT DEFAULT NULL, ADD fuel_id INT DEFAULT NULL, ADD ort_id INT DEFAULT NULL, ADD payment_condition_id INT DEFAULT NULL, ADD payment_type_id INT DEFAULT NULL, ADD tax_type_id INT DEFAULT NULL, ADD datum DATETIME DEFAULT NULL, ADD pts_number VARCHAR(255) DEFAULT NULL, ADD deposit VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D2CBA3505 FOREIGN KEY (body_type_id) REFERENCES body_type (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D6C15F291 FOREIGN KEY (car_status_id) REFERENCES car_status (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D80D7D0B2 FOREIGN KEY (client_status_id) REFERENCES client_status (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D97C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DB62F846A FOREIGN KEY (ort_id) REFERENCES ort (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DEE8724AC FOREIGN KEY (payment_condition_id) REFERENCES payment_condition (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D84042C99 FOREIGN KEY (tax_type_id) REFERENCES tax_type (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D2CBA3505 ON car (body_type_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D6C15F291 ON car (car_status_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D80D7D0B2 ON car (client_status_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D97C79677 ON car (fuel_id)');
        $this->addSql('CREATE INDEX IDX_773DE69DB62F846A ON car (ort_id)');
        $this->addSql('CREATE INDEX IDX_773DE69DEE8724AC ON car (payment_condition_id)');
        $this->addSql('CREATE INDEX IDX_773DE69DDC058279 ON car (payment_type_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D84042C99 ON car (tax_type_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D80D7D0B2');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DB62F846A');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DDC058279');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D84042C99');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D2CBA3505');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D97C79677');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DEE8724AC');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D6C15F291');
        $this->addSql('DROP TABLE client_status');
        $this->addSql('DROP TABLE ort');
        $this->addSql('DROP TABLE payment_type');
        $this->addSql('DROP TABLE tax_type');
        $this->addSql('DROP TABLE body_type');
        $this->addSql('DROP TABLE fuel');
        $this->addSql('DROP TABLE payment_condition');
        $this->addSql('DROP TABLE car_status');
        $this->addSql('DROP INDEX IDX_773DE69D2CBA3505 ON car');
        $this->addSql('DROP INDEX IDX_773DE69D6C15F291 ON car');
        $this->addSql('DROP INDEX IDX_773DE69D80D7D0B2 ON car');
        $this->addSql('DROP INDEX IDX_773DE69D97C79677 ON car');
        $this->addSql('DROP INDEX IDX_773DE69DB62F846A ON car');
        $this->addSql('DROP INDEX IDX_773DE69DEE8724AC ON car');
        $this->addSql('DROP INDEX IDX_773DE69DDC058279 ON car');
        $this->addSql('DROP INDEX IDX_773DE69D84042C99 ON car');
        $this->addSql('ALTER TABLE car DROP body_type_id, DROP car_status_id, DROP client_status_id, DROP fuel_id, DROP ort_id, DROP payment_condition_id, DROP payment_type_id, DROP tax_type_id, DROP datum, DROP pts_number, DROP deposit');
        $this->addSql('ALTER TABLE user DROP phone_number');
    }
}
