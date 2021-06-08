<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190606184438 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D4BBC2705');
        $this->addSql('DROP INDEX IDX_773DE69D4BBC2705 ON car');
        $this->addSql('ALTER TABLE car ADD version_polish_id INT DEFAULT NULL, CHANGE version_id version_german_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D61813B1B FOREIGN KEY (version_german_id) REFERENCES version (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DABDB36D0 FOREIGN KEY (version_polish_id) REFERENCES version (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D61813B1B ON car (version_german_id)');
        $this->addSql('CREATE INDEX IDX_773DE69DABDB36D0 ON car (version_polish_id)');
        $this->addSql('ALTER TABLE version ADD german LONGTEXT DEFAULT NULL, ADD polish LONGTEXT DEFAULT NULL, DROP title');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D61813B1B');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DABDB36D0');
        $this->addSql('DROP INDEX IDX_773DE69D61813B1B ON car');
        $this->addSql('DROP INDEX IDX_773DE69DABDB36D0 ON car');
        $this->addSql('ALTER TABLE car ADD version_id INT DEFAULT NULL, DROP version_german_id, DROP version_polish_id');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D4BBC2705 FOREIGN KEY (version_id) REFERENCES version (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D4BBC2705 ON car (version_id)');
        $this->addSql('ALTER TABLE version ADD title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP german, DROP polish');
    }
}
