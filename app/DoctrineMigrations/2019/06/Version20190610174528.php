<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190610174528 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF738EC52');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D3D62E199');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, german LONGTEXT DEFAULT NULL, polish LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE color_german');
        $this->addSql('DROP TABLE color_polish');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D3D62E199 FOREIGN KEY (color_polish_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF738EC52 FOREIGN KEY (color_german_id) REFERENCES color (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D3D62E199');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF738EC52');
        $this->addSql('CREATE TABLE color_german (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_polish (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE color');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D3D62E199 FOREIGN KEY (color_polish_id) REFERENCES color_polish (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF738EC52 FOREIGN KEY (color_german_id) REFERENCES color_german (id)');
    }
}
