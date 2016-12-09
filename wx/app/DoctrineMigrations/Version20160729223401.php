<?php

namespace Application\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160729223401 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shares ADD device_id INT DEFAULT NULL, ADD parent_id INT DEFAULT NULL, ADD read_count INT NOT NULL');
        $this->addSql('ALTER TABLE shares ADD CONSTRAINT FK_905F717C94A4C7D4 FOREIGN KEY (device_id) REFERENCES devices (id)');
        $this->addSql('ALTER TABLE shares ADD CONSTRAINT FK_905F717C727ACA70 FOREIGN KEY (parent_id) REFERENCES shares (id)');
        $this->addSql('CREATE INDEX IDX_905F717C94A4C7D4 ON shares (device_id)');
        $this->addSql('CREATE INDEX IDX_905F717C727ACA70 ON shares (parent_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shares DROP FOREIGN KEY FK_905F717C94A4C7D4');
        $this->addSql('ALTER TABLE shares DROP FOREIGN KEY FK_905F717C727ACA70');
        $this->addSql('DROP INDEX IDX_905F717C94A4C7D4 ON shares');
        $this->addSql('DROP INDEX IDX_905F717C727ACA70 ON shares');
        $this->addSql('ALTER TABLE shares DROP device_id, DROP parent_id, DROP read_count');
    }
}
