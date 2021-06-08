<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190428173130 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car ADD price_role_five DOUBLE PRECISION DEFAULT NULL, ADD price_role_five_type VARCHAR(255) DEFAULT NULL, ADD price_role_six DOUBLE PRECISION DEFAULT NULL, ADD price_role_six_type VARCHAR(255) DEFAULT NULL, ADD price_role_seven DOUBLE PRECISION DEFAULT NULL, ADD price_role_seven_type VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP price_role_five, DROP price_role_five_type, DROP price_role_six, DROP price_role_six_type, DROP price_role_seven, DROP price_role_seven_type');
    }
}
