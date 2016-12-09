<?php

namespace Application\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160726152951 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE devices (id INT AUTO_INCREMENT NOT NULL, lead_id INT DEFAULT NULL, fingerprint VARCHAR(255) NOT NULL, platform VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_11074E9AFC0B754A (fingerprint), INDEX IDX_11074E9A55458D (lead_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leads (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, firstName VARCHAR(255) DEFAULT NULL, lastName VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, position VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, wechat VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_17904552E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(767) NOT NULL, UNIQUE INDEX UNIQ_2074E575F47645AE (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET ascii COLLATE ascii_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sessions (sess_id VARBINARY(255) NOT NULL, sess_data LONGBLOB NOT NULL, sess_time INT NOT NULL, sess_lifetime INT NOT NULL, PRIMARY KEY(sess_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shares (id INT AUTO_INCREMENT NOT NULL, source VARCHAR(255) NOT NULL, target VARCHAR(255) NOT NULL, shared_date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visits (id INT AUTO_INCREMENT NOT NULL, device_id INT DEFAULT NULL, sess_id VARCHAR(255) NOT NULL, url LONGTEXT NOT NULL, referer LONGTEXT DEFAULT NULL, date_hit DATETIME NOT NULL, date_left DATETIME DEFAULT NULL, ip VARCHAR(255) DEFAULT NULL, user_agent LONGTEXT DEFAULT NULL, INDEX IDX_444839EA94A4C7D4 (device_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visits_shares (id INT AUTO_INCREMENT NOT NULL, visit_id INT DEFAULT NULL, to_share_id INT DEFAULT NULL, from_share_id INT DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_913CE5215F37A13B (token), INDEX IDX_913CE52175FA0FF2 (visit_id), UNIQUE INDEX UNIQ_913CE521E7BFA175 (to_share_id), INDEX IDX_913CE5216C09DF41 (from_share_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE devices ADD CONSTRAINT FK_11074E9A55458D FOREIGN KEY (lead_id) REFERENCES leads (id)');
        $this->addSql('ALTER TABLE visits ADD CONSTRAINT FK_444839EA94A4C7D4 FOREIGN KEY (device_id) REFERENCES devices (id)');
        $this->addSql('ALTER TABLE visits_shares ADD CONSTRAINT FK_913CE52175FA0FF2 FOREIGN KEY (visit_id) REFERENCES visits (id)');
        $this->addSql('ALTER TABLE visits_shares ADD CONSTRAINT FK_913CE521E7BFA175 FOREIGN KEY (to_share_id) REFERENCES shares (id)');
        $this->addSql('ALTER TABLE visits_shares ADD CONSTRAINT FK_913CE5216C09DF41 FOREIGN KEY (from_share_id) REFERENCES shares (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visits DROP FOREIGN KEY FK_444839EA94A4C7D4');
        $this->addSql('ALTER TABLE devices DROP FOREIGN KEY FK_11074E9A55458D');
        $this->addSql('ALTER TABLE visits_shares DROP FOREIGN KEY FK_913CE521E7BFA175');
        $this->addSql('ALTER TABLE visits_shares DROP FOREIGN KEY FK_913CE5216C09DF41');
        $this->addSql('ALTER TABLE visits_shares DROP FOREIGN KEY FK_913CE52175FA0FF2');
        $this->addSql('DROP TABLE devices');
        $this->addSql('DROP TABLE leads');
        $this->addSql('DROP TABLE pages');
        $this->addSql('DROP TABLE sessions');
        $this->addSql('DROP TABLE shares');
        $this->addSql('DROP TABLE visits');
        $this->addSql('DROP TABLE visits_shares');
    }
}
