<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190820194157 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D2CBA3505');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D3D62E199');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D44F5D008');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D61813B1B');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D64D218E');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D6C15F291');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D6C755722');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D80D7D0B2');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D84042C99');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D8DE820D9');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D914AEB04');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D9395C3F3');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D97C79677');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D9F7F22E2');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DABDB36D0');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DB62F846A');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DDA6A219');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DDC058279');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DE4DF36A3');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DEC141BC3');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DEE8724AC');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF603EE73');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF738EC52');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D2CBA3505 FOREIGN KEY (body_type_id) REFERENCES body_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D3D62E199 FOREIGN KEY (color_polish_id) REFERENCES color (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D61813B1B FOREIGN KEY (version_german_id) REFERENCES version (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D6C15F291 FOREIGN KEY (car_status_id) REFERENCES car_status (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D6C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D80D7D0B2 FOREIGN KEY (client_status_id) REFERENCES client_status (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D84042C99 FOREIGN KEY (tax_type_id) REFERENCES tax_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D914AEB04 FOREIGN KEY (target_unload_id) REFERENCES target_unload (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D97C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9F7F22E2 FOREIGN KEY (salesman_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DABDB36D0 FOREIGN KEY (version_polish_id) REFERENCES version (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DB62F846A FOREIGN KEY (ort_id) REFERENCES ort (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DDA6A219 FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DE4DF36A3 FOREIGN KEY (forwarder_id) REFERENCES forwarder (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DEC141BC3 FOREIGN KEY (place_of_issue_id) REFERENCES location (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DEE8724AC FOREIGN KEY (payment_condition_id) REFERENCES payment_condition (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF738EC52 FOREIGN KEY (color_german_id) REFERENCES color (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F6DA6A219');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F6DA6A219 FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C37975B7E7');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C37975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D2CBA3505');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D6C15F291');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D80D7D0B2');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D97C79677');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DB62F846A');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DEE8724AC');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DDC058279');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D84042C99');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D9F7F22E2');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D44F5D008');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D61813B1B');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DABDB36D0');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D3D62E199');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF738EC52');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D8DE820D9');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF603EE73');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DDA6A219');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D9395C3F3');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D914AEB04');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DE4DF36A3');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D64D218E');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DEC141BC3');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D6C755722');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D2CBA3505 FOREIGN KEY (body_type_id) REFERENCES body_type (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D6C15F291 FOREIGN KEY (car_status_id) REFERENCES car_status (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D80D7D0B2 FOREIGN KEY (client_status_id) REFERENCES client_status (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D97C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DB62F846A FOREIGN KEY (ort_id) REFERENCES ort (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DEE8724AC FOREIGN KEY (payment_condition_id) REFERENCES payment_condition (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D84042C99 FOREIGN KEY (tax_type_id) REFERENCES tax_type (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9F7F22E2 FOREIGN KEY (salesman_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D61813B1B FOREIGN KEY (version_german_id) REFERENCES version (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DABDB36D0 FOREIGN KEY (version_polish_id) REFERENCES version (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D3D62E199 FOREIGN KEY (color_polish_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF738EC52 FOREIGN KEY (color_german_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DDA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D914AEB04 FOREIGN KEY (target_unload_id) REFERENCES target_unload (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DE4DF36A3 FOREIGN KEY (forwarder_id) REFERENCES forwarder (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DEC141BC3 FOREIGN KEY (place_of_issue_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D6C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id)');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F6DA6A219');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F6DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C37975B7E7');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C37975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
    }
}
