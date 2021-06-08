<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200629172523 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_order_number (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, user_id INT DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, INDEX IDX_D5D37383C3C6F69F (car_id), INDEX IDX_D5D37383A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_order_number ADD CONSTRAINT FK_D5D37383C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user_order_number ADD CONSTRAINT FK_D5D37383A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car_file DROP FOREIGN KEY FK_47F522BC642B8210');
        $this->addSql('ALTER TABLE car_file DROP FOREIGN KEY FK_47F522BCC3C6F69F');
        $this->addSql('ALTER TABLE car_file DROP FOREIGN KEY FK_47F522BCC54C8C93');
        $this->addSql('ALTER TABLE car_file ADD CONSTRAINT FK_47F522BC642B8210 FOREIGN KEY (admin_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car_file ADD CONSTRAINT FK_47F522BCC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car_file ADD CONSTRAINT FK_47F522BCC54C8C93 FOREIGN KEY (type_id) REFERENCES car_file_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car_edit_history DROP FOREIGN KEY FK_C49D7419642B8210');
        $this->addSql('ALTER TABLE car_edit_history DROP FOREIGN KEY FK_C49D7419C3C6F69F');
        $this->addSql('ALTER TABLE car_edit_history ADD CONSTRAINT FK_C49D7419642B8210 FOREIGN KEY (admin_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car_edit_history ADD CONSTRAINT FK_C49D7419C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user_order DROP FOREIGN KEY FK_17EB68C0A76ED395');
        $this->addSql('ALTER TABLE user_order DROP FOREIGN KEY FK_17EB68C0C3C6F69F');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C0C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE salesman_booking DROP FOREIGN KEY FK_C752CB75642B8210');
        $this->addSql('ALTER TABLE salesman_booking DROP FOREIGN KEY FK_C752CB75C3C6F69F');
        $this->addSql('ALTER TABLE salesman_booking ADD CONSTRAINT FK_C752CB75642B8210 FOREIGN KEY (admin_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE salesman_booking ADD CONSTRAINT FK_C752CB75C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_order_number');
        $this->addSql('ALTER TABLE car_edit_history DROP FOREIGN KEY FK_C49D7419C3C6F69F');
        $this->addSql('ALTER TABLE car_edit_history DROP FOREIGN KEY FK_C49D7419642B8210');
        $this->addSql('ALTER TABLE car_edit_history ADD CONSTRAINT FK_C49D7419C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE car_edit_history ADD CONSTRAINT FK_C49D7419642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car_file DROP FOREIGN KEY FK_47F522BCC54C8C93');
        $this->addSql('ALTER TABLE car_file DROP FOREIGN KEY FK_47F522BC642B8210');
        $this->addSql('ALTER TABLE car_file DROP FOREIGN KEY FK_47F522BCC3C6F69F');
        $this->addSql('ALTER TABLE car_file ADD CONSTRAINT FK_47F522BCC54C8C93 FOREIGN KEY (type_id) REFERENCES car_file_type (id)');
        $this->addSql('ALTER TABLE car_file ADD CONSTRAINT FK_47F522BC642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car_file ADD CONSTRAINT FK_47F522BCC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE salesman_booking DROP FOREIGN KEY FK_C752CB75C3C6F69F');
        $this->addSql('ALTER TABLE salesman_booking DROP FOREIGN KEY FK_C752CB75642B8210');
        $this->addSql('ALTER TABLE salesman_booking ADD CONSTRAINT FK_C752CB75C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE salesman_booking ADD CONSTRAINT FK_C752CB75642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_order DROP FOREIGN KEY FK_17EB68C0A76ED395');
        $this->addSql('ALTER TABLE user_order DROP FOREIGN KEY FK_17EB68C0C3C6F69F');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C0C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
    }
}
