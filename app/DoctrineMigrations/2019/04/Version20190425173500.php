<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190425173500 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D9E755657');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D542F5B9C');
        $this->addSql('CREATE TABLE standart_complectation (id INT AUTO_INCREMENT NOT NULL, version_id INT DEFAULT NULL, model_id INT DEFAULT NULL, polish LONGTEXT DEFAULT NULL, german LONGTEXT DEFAULT NULL, INDEX IDX_8BA9778F4BBC2705 (version_id), INDEX IDX_8BA9778F7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE standart_complectation ADD CONSTRAINT FK_8BA9778F4BBC2705 FOREIGN KEY (version_id) REFERENCES version (id)');
        $this->addSql('ALTER TABLE standart_complectation ADD CONSTRAINT FK_8BA9778F7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('DROP TABLE standart_complectation_german');
        $this->addSql('DROP TABLE standart_complectation_polish');
        $this->addSql('DROP INDEX IDX_773DE69D542F5B9C ON car');
        $this->addSql('DROP INDEX IDX_773DE69D9E755657 ON car');
        $this->addSql('ALTER TABLE car ADD standart_complectation_polish LONGTEXT DEFAULT NULL, ADD standart_complectation_german LONGTEXT DEFAULT NULL, DROP standart_complectation_polish_id, DROP standart_complectation_german_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE standart_complectation_german (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE standart_complectation_polish (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE standart_complectation');
        $this->addSql('ALTER TABLE car ADD standart_complectation_polish_id INT DEFAULT NULL, ADD standart_complectation_german_id INT DEFAULT NULL, DROP standart_complectation_polish, DROP standart_complectation_german');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D542F5B9C FOREIGN KEY (standart_complectation_polish_id) REFERENCES standart_complectation_polish (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9E755657 FOREIGN KEY (standart_complectation_german_id) REFERENCES standart_complectation_german (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D542F5B9C ON car (standart_complectation_polish_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D9E755657 ON car (standart_complectation_german_id)');
    }
}
