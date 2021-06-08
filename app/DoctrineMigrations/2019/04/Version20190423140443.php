<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190423140443 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DFC56F556');
        $this->addSql('CREATE TABLE version (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE standart_complectation_german (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_polish (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_german (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE standart_complectation_polish (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP INDEX IDX_773DE69DFC56F556 ON car');
        $this->addSql('ALTER TABLE car ADD model_id INT DEFAULT NULL, ADD version_id INT DEFAULT NULL, ADD color_polish_id INT DEFAULT NULL, ADD color_german_id INT DEFAULT NULL, ADD standart_complectation_polish_id INT DEFAULT NULL, ADD standart_complectation_german_id INT DEFAULT NULL, ADD seller_id INT DEFAULT NULL, ADD place_of_issue_id INT DEFAULT NULL, ADD invoice_date DATETIME DEFAULT NULL, ADD additional_work LONGTEXT DEFAULT NULL, ADD notes LONGTEXT DEFAULT NULL, ADD date DATETIME DEFAULT NULL, DROP brand, DROP model, DROP version, DROP color_polish, DROP color_german, CHANGE notes_id brand_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D4BBC2705 FOREIGN KEY (version_id) REFERENCES version (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D3D62E199 FOREIGN KEY (color_polish_id) REFERENCES color_polish (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF738EC52 FOREIGN KEY (color_german_id) REFERENCES color_german (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D542F5B9C FOREIGN KEY (standart_complectation_polish_id) REFERENCES standart_complectation_polish (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9E755657 FOREIGN KEY (standart_complectation_german_id) REFERENCES standart_complectation_german (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DEC141BC3 FOREIGN KEY (place_of_issue_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D44F5D008 ON car (brand_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D7975B7E7 ON car (model_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D4BBC2705 ON car (version_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D3D62E199 ON car (color_polish_id)');
        $this->addSql('CREATE INDEX IDX_773DE69DF738EC52 ON car (color_german_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D542F5B9C ON car (standart_complectation_polish_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D9E755657 ON car (standart_complectation_german_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D8DE820D9 ON car (seller_id)');
        $this->addSql('CREATE INDEX IDX_773DE69DEC141BC3 ON car (place_of_issue_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D4BBC2705');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D9E755657');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D3D62E199');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF738EC52');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D44F5D008');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D542F5B9C');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE version');
        $this->addSql('DROP TABLE standart_complectation_german');
        $this->addSql('DROP TABLE color_polish');
        $this->addSql('DROP TABLE color_german');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE standart_complectation_polish');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D8DE820D9');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DEC141BC3');
        $this->addSql('DROP INDEX IDX_773DE69D44F5D008 ON car');
        $this->addSql('DROP INDEX IDX_773DE69D7975B7E7 ON car');
        $this->addSql('DROP INDEX IDX_773DE69D4BBC2705 ON car');
        $this->addSql('DROP INDEX IDX_773DE69D3D62E199 ON car');
        $this->addSql('DROP INDEX IDX_773DE69DF738EC52 ON car');
        $this->addSql('DROP INDEX IDX_773DE69D542F5B9C ON car');
        $this->addSql('DROP INDEX IDX_773DE69D9E755657 ON car');
        $this->addSql('DROP INDEX IDX_773DE69D8DE820D9 ON car');
        $this->addSql('DROP INDEX IDX_773DE69DEC141BC3 ON car');
        $this->addSql('ALTER TABLE car ADD notes_id INT DEFAULT NULL, ADD brand VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD model VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD version VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD color_polish VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD color_german VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP brand_id, DROP model_id, DROP version_id, DROP color_polish_id, DROP color_german_id, DROP standart_complectation_polish_id, DROP standart_complectation_german_id, DROP seller_id, DROP place_of_issue_id, DROP invoice_date, DROP additional_work, DROP notes, DROP date');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DFC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id)');
        $this->addSql('CREATE INDEX IDX_773DE69DFC56F556 ON car (notes_id)');
    }
}
