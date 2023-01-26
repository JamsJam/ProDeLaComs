<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126061553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, affnommarque SMALLINT NOT NULL, mailnomparque SMALLINT NOT NULL, mailtelephone TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre ADD options_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB293ADB05F1 FOREIGN KEY (options_id) REFERENCES `option` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6B4FB293ADB05F1 ON membre (options_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB293ADB05F1');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP INDEX UNIQ_F6B4FB293ADB05F1 ON membre');
        $this->addSql('ALTER TABLE membre DROP options_id');
    }
}
