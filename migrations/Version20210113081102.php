<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113081102 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD order_backup_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982F3A1CB1 FOREIGN KEY (order_backup_id) REFERENCES order_backup (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993982F3A1CB1 ON `order` (order_backup_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993982F3A1CB1');
        $this->addSql('DROP INDEX UNIQ_F52993982F3A1CB1 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP order_backup_id');
    }
}
