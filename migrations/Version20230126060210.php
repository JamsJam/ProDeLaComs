<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126060210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE register_logs (id INT AUTO_INCREMENT NOT NULL, provider_id INT NOT NULL, new_id INT DEFAULT NULL, role VARCHAR(255) NOT NULL, status SMALLINT NOT NULL, token VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_24E8D6FCA53A8AA (provider_id), INDEX IDX_24E8D6FCBD06B3B3 (new_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE register_logs ADD CONSTRAINT FK_24E8D6FCA53A8AA FOREIGN KEY (provider_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE register_logs ADD CONSTRAINT FK_24E8D6FCBD06B3B3 FOREIGN KEY (new_id) REFERENCES membre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE register_logs DROP FOREIGN KEY FK_24E8D6FCA53A8AA');
        $this->addSql('ALTER TABLE register_logs DROP FOREIGN KEY FK_24E8D6FCBD06B3B3');
        $this->addSql('DROP TABLE register_logs');
    }
}
