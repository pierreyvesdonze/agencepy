<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210112195636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_order ADD order_valid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_order ADD CONSTRAINT FK_62321F7757444F5 FOREIGN KEY (order_valid_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_62321F7757444F5 ON post_order (order_valid_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_order DROP FOREIGN KEY FK_62321F7757444F5');
        $this->addSql('DROP INDEX IDX_62321F7757444F5 ON post_order');
        $this->addSql('ALTER TABLE post_order DROP order_valid_id');
    }
}
