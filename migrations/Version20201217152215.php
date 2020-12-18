<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217152215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE witch_format (id INT AUTO_INCREMENT NOT NULL, witch_product_id INT NOT NULL, size VARCHAR(5) NOT NULL, price NUMERIC(10, 0) NOT NULL, stock INT NOT NULL, INDEX IDX_23396F06D984E543 (witch_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE witch_format ADD CONSTRAINT FK_23396F06D984E543 FOREIGN KEY (witch_product_id) REFERENCES witch_product (id)');
        $this->addSql('ALTER TABLE witch_product ADD CONSTRAINT FK_2CB8EDC076B135A1 FOREIGN KEY (witch_category_id) REFERENCES witch_category (id)');
        $this->addSql('CREATE INDEX IDX_2CB8EDC076B135A1 ON witch_product (witch_category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE witch_format');
        $this->addSql('ALTER TABLE witch_product DROP FOREIGN KEY FK_2CB8EDC076B135A1');
        $this->addSql('DROP INDEX IDX_2CB8EDC076B135A1 ON witch_product');
    }
}
