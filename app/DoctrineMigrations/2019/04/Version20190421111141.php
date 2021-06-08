<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190421111141 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car ADD our_discount_price DOUBLE PRECISION DEFAULT NULL, ADD our_discount_price_type VARCHAR(255) DEFAULT NULL, ADD shipping_cost DOUBLE PRECISION DEFAULT NULL, ADD shipping_cost_type VARCHAR(255) DEFAULT NULL, ADD sale_price_with_out_vat DOUBLE PRECISION DEFAULT NULL, ADD sale_price_with_out_vattype VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP our_discount_price, DROP our_discount_price_type, DROP shipping_cost, DROP shipping_cost_type, DROP sale_price_with_out_vat, DROP sale_price_with_out_vattype');
    }
}
