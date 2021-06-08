<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190418182140 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, vendor_id INT DEFAULT NULL, place_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, target_unload_id INT DEFAULT NULL, forwarder_id INT DEFAULT NULL, location_id INT DEFAULT NULL, buyer_id INT DEFAULT NULL, notes_id INT DEFAULT NULL, client_id INT DEFAULT NULL, reservation VARCHAR(255) NOT NULL, sold VARCHAR(255) NOT NULL, vin_number VARCHAR(255) DEFAULT NULL, brand VARCHAR(255) DEFAULT NULL, model VARCHAR(255) DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, color_polish VARCHAR(255) DEFAULT NULL, color_german VARCHAR(255) DEFAULT NULL, complectation_polish VARCHAR(255) DEFAULT NULL, complectation_german VARCHAR(255) DEFAULT NULL, car_registration DATETIME DEFAULT NULL, car_mileage VARCHAR(255) DEFAULT NULL, initial_vat_price DOUBLE PRECISION DEFAULT NULL, initial_price_with_out_vat DOUBLE PRECISION DEFAULT NULL, discount DOUBLE PRECISION DEFAULT NULL, minimum_selling_price DOUBLE PRECISION DEFAULT NULL, completed DATETIME DEFAULT NULL, invoice_number VARCHAR(255) DEFAULT NULL, payment_date DATETIME DEFAULT NULL, paid DATETIME DEFAULT NULL, documents VARCHAR(255) DEFAULT NULL, download_date DATETIME DEFAULT NULL, transport_invoice_number VARCHAR(255) DEFAULT NULL, order_number VARCHAR(255) DEFAULT NULL, radio_code VARCHAR(255) DEFAULT NULL, sales_invoice_number VARCHAR(255) DEFAULT NULL, information LONGTEXT DEFAULT NULL, announcement LONGTEXT DEFAULT NULL, discharge VARCHAR(255) DEFAULT NULL, selling_price DOUBLE PRECISION DEFAULT NULL, declaration VARCHAR(255) DEFAULT NULL, import_tax DOUBLE PRECISION DEFAULT NULL, tax_number VARCHAR(255) DEFAULT NULL, tax_returned VARCHAR(255) DEFAULT NULL, INDEX IDX_773DE69DF603EE73 (vendor_id), INDEX IDX_773DE69DDA6A219 (place_id), INDEX IDX_773DE69D9395C3F3 (customer_id), INDEX IDX_773DE69D914AEB04 (target_unload_id), INDEX IDX_773DE69DE4DF36A3 (forwarder_id), INDEX IDX_773DE69D64D218E (location_id), INDEX IDX_773DE69D6C755722 (buyer_id), INDEX IDX_773DE69DFC56F556 (notes_id), INDEX IDX_773DE69D19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DDA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D914AEB04 FOREIGN KEY (target_unload_id) REFERENCES target_unload (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DE4DF36A3 FOREIGN KEY (forwarder_id) REFERENCES forwarder (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D6C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DFC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE car');
    }
}
