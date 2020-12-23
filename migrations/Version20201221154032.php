<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201221154032 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_witch_format (cart_id INT NOT NULL, witch_format_id INT NOT NULL, INDEX IDX_55B6FD6F1AD5CDBF (cart_id), INDEX IDX_55B6FD6FDFAC46C1 (witch_format_id), PRIMARY KEY(cart_id, witch_format_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, cart_id INT NOT NULL, UNIQUE INDEX UNIQ_F52993981AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_witch_format ADD CONSTRAINT FK_55B6FD6F1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_witch_format ADD CONSTRAINT FK_55B6FD6FDFAC46C1 FOREIGN KEY (witch_format_id) REFERENCES witch_format (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart ADD is_valid TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD phone_number VARCHAR(255) NOT NULL, ADD street_address VARCHAR(255) NOT NULL, ADD number_street_address INT NOT NULL, ADD postal_code SMALLINT NOT NULL, ADD town VARCHAR(125) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cart_witch_format');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE cart DROP is_valid');
        $this->addSql('ALTER TABLE user DROP phone_number, DROP street_address, DROP number_street_address, DROP postal_code, DROP town');
    }
}
