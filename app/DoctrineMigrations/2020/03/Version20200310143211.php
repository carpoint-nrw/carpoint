<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200310143211 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car ADD ek_netto DOUBLE PRECISION DEFAULT NULL, ADD zakup_brut DOUBLE PRECISION DEFAULT NULL, ADD vat DOUBLE PRECISION DEFAULT NULL, ADD nr_pro DOUBLE PRECISION DEFAULT NULL, ADD data_pro DATETIME DEFAULT NULL, ADD nr_fv DOUBLE PRECISION DEFAULT NULL, ADD data_fv DATETIME DEFAULT NULL, ADD pay4 TINYINT(1) DEFAULT \'0\', ADD data1 DATETIME DEFAULT NULL, ADD rech_nr DOUBLE PRECISION DEFAULT NULL, ADD data2 DATETIME DEFAULT NULL, ADD preis_tr DOUBLE PRECISION DEFAULT NULL, ADD pay5 TINYINT(1) DEFAULT \'0\', ADD nr_pro2 DOUBLE PRECISION DEFAULT NULL, ADD data_pro2 DATETIME DEFAULT NULL, ADD data_fv2 DATETIME DEFAULT NULL, ADD zysk DOUBLE PRECISION DEFAULT NULL, ADD datum2 DATETIME DEFAULT NULL, ADD gewinn DOUBLE PRECISION DEFAULT NULL, ADD restsumme DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP ek_netto, DROP zakup_brut, DROP vat, DROP nr_pro, DROP data_pro, DROP nr_fv, DROP data_fv, DROP pay4, DROP data1, DROP rech_nr, DROP data2, DROP preis_tr, DROP pay5, DROP nr_pro2, DROP data_pro2, DROP data_fv2, DROP zysk, DROP datum2, DROP gewinn, DROP restsumme');
    }
}
