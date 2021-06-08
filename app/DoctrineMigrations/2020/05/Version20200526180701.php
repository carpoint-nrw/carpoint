<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200526180701 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD target_unload_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649914AEB04 FOREIGN KEY (target_unload_id) REFERENCES target_unload (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649914AEB04 ON user (target_unload_id)');
        $this->addSql('ALTER TABLE vendor ADD address VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649914AEB04');
        $this->addSql('DROP INDEX IDX_8D93D649914AEB04 ON user');
        $this->addSql('ALTER TABLE user DROP target_unload_id');
        $this->addSql('ALTER TABLE vendor DROP address');
    }
}
