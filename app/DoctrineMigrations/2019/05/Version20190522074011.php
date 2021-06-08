<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190522074011 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE standart_complectation DROP INDEX IDX_8BA9778F4BBC2705, ADD UNIQUE INDEX UNIQ_8BA9778F4BBC2705 (version_id)');
        $this->addSql('ALTER TABLE standart_complectation DROP FOREIGN KEY FK_8BA9778F7975B7E7');
        $this->addSql('DROP INDEX IDX_8BA9778F7975B7E7 ON standart_complectation');
        $this->addSql('ALTER TABLE standart_complectation DROP model_id');
        $this->addSql('ALTER TABLE version ADD model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C37975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C37975B7E7 ON version (model_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE standart_complectation DROP INDEX UNIQ_8BA9778F4BBC2705, ADD INDEX IDX_8BA9778F4BBC2705 (version_id)');
        $this->addSql('ALTER TABLE standart_complectation ADD model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE standart_complectation ADD CONSTRAINT FK_8BA9778F7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_8BA9778F7975B7E7 ON standart_complectation (model_id)');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C37975B7E7');
        $this->addSql('DROP INDEX IDX_BF1CD3C37975B7E7 ON version');
        $this->addSql('ALTER TABLE version DROP model_id');
    }
}
