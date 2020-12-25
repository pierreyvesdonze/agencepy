<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225162046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE witch_format ADD CONSTRAINT FK_23396F06D984E543 FOREIGN KEY (witch_product_id) REFERENCES witch_product (id)');
        $this->addSql('CREATE INDEX IDX_23396F06D984E543 ON witch_format (witch_product_id)');
        $this->addSql('ALTER TABLE witch_product DROP product_img_path');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE witch_format DROP FOREIGN KEY FK_23396F06D984E543');
        $this->addSql('DROP INDEX IDX_23396F06D984E543 ON witch_format');
        $this->addSql('ALTER TABLE witch_product ADD product_img_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
