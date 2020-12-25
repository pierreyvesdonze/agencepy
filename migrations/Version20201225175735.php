<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225175735 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66DFAC46C1');
        $this->addSql('DROP INDEX UNIQ_23A0E66DFAC46C1 ON article');
        $this->addSql('ALTER TABLE article DROP witch_format_id');
        $this->addSql('ALTER TABLE witch_format ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE witch_format ADD CONSTRAINT FK_23396F067294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_23396F067294869C ON witch_format (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD witch_format_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66DFAC46C1 FOREIGN KEY (witch_format_id) REFERENCES witch_format (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66DFAC46C1 ON article (witch_format_id)');
        $this->addSql('ALTER TABLE witch_format DROP FOREIGN KEY FK_23396F067294869C');
        $this->addSql('DROP INDEX IDX_23396F067294869C ON witch_format');
        $this->addSql('ALTER TABLE witch_format DROP article_id');
    }
}
