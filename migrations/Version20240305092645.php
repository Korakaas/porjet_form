<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305092645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instruction (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pattern (id INT AUTO_INCREMENT NOT NULL, instructions_id INT DEFAULT NULL, categories_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, yardage INT NOT NULL, image VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', price DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_A3BCFC8E5E75C823 (instructions_id), INDEX IDX_A3BCFC8EA21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pattern_yarn (pattern_id INT NOT NULL, yarn_id INT NOT NULL, INDEX IDX_1F48F99FF734A20F (pattern_id), INDEX IDX_1F48F99FE6DFB9C4 (yarn_id), PRIMARY KEY(pattern_id, yarn_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE yarn (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, color VARCHAR(255) NOT NULL, weight VARCHAR(255) NOT NULL, fiber VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pattern ADD CONSTRAINT FK_A3BCFC8E5E75C823 FOREIGN KEY (instructions_id) REFERENCES instruction (id)');
        $this->addSql('ALTER TABLE pattern ADD CONSTRAINT FK_A3BCFC8EA21214B7 FOREIGN KEY (categories_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pattern_yarn ADD CONSTRAINT FK_1F48F99FF734A20F FOREIGN KEY (pattern_id) REFERENCES pattern (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pattern_yarn ADD CONSTRAINT FK_1F48F99FE6DFB9C4 FOREIGN KEY (yarn_id) REFERENCES yarn (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pattern DROP FOREIGN KEY FK_A3BCFC8E5E75C823');
        $this->addSql('ALTER TABLE pattern DROP FOREIGN KEY FK_A3BCFC8EA21214B7');
        $this->addSql('ALTER TABLE pattern_yarn DROP FOREIGN KEY FK_1F48F99FF734A20F');
        $this->addSql('ALTER TABLE pattern_yarn DROP FOREIGN KEY FK_1F48F99FE6DFB9C4');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE instruction');
        $this->addSql('DROP TABLE pattern');
        $this->addSql('DROP TABLE pattern_yarn');
        $this->addSql('DROP TABLE yarn');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
