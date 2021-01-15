<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113080249 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_backup (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_order ADD order_backup_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_order ADD CONSTRAINT FK_62321F772F3A1CB1 FOREIGN KEY (order_backup_id) REFERENCES order_backup (id)');
        $this->addSql('CREATE INDEX IDX_62321F772F3A1CB1 ON post_order (order_backup_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_order DROP FOREIGN KEY FK_62321F772F3A1CB1');
        $this->addSql('DROP TABLE order_backup');
        $this->addSql('DROP INDEX IDX_62321F772F3A1CB1 ON post_order');
        $this->addSql('ALTER TABLE post_order DROP order_backup_id');
    }
}
