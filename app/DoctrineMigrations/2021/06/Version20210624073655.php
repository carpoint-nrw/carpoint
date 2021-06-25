<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624073655 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE base_color (id INT AUTO_INCREMENT NOT NULL, german VARCHAR(255) DEFAULT NULL, polish VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_DB7DD93BA23440A1 (german), UNIQUE INDEX UNIQ_DB7DD93BD00F37B5 (polish), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD base_color_id INT DEFAULT NULL, ADD color_description_id INT DEFAULT NULL, ADD color_metallic TINYINT(1) DEFAULT \'0\'');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D3031BC4D FOREIGN KEY (base_color_id) REFERENCES base_color (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DB7CDA150 FOREIGN KEY (color_description_id) REFERENCES color (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_773DE69D3031BC4D ON car (base_color_id)');
        $this->addSql('CREATE INDEX IDX_773DE69DB7CDA150 ON car (color_description_id)');
        $this->addSql('ALTER TABLE color ADD base_color_id INT DEFAULT NULL, ADD metallic TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE color ADD CONSTRAINT FK_665648E93031BC4D FOREIGN KEY (base_color_id) REFERENCES base_color (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_665648E93031BC4D ON color (base_color_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D3031BC4D');
        $this->addSql('ALTER TABLE color DROP FOREIGN KEY FK_665648E93031BC4D');
        $this->addSql('DROP TABLE base_color');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DB7CDA150');
        $this->addSql('DROP INDEX IDX_773DE69D3031BC4D ON car');
        $this->addSql('DROP INDEX IDX_773DE69DB7CDA150 ON car');
        $this->addSql('ALTER TABLE car DROP base_color_id, DROP color_description_id, DROP color_metallic');
        $this->addSql('DROP INDEX IDX_665648E93031BC4D ON color');
        $this->addSql('ALTER TABLE color DROP base_color_id, DROP metallic');
    }
}
