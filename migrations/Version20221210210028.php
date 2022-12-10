<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221210210028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achievement (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, plant_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, created_at DATE NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, INDEX IDX_96737FF1A76ED395 (user_id), INDEX IDX_96737FF11D935652 (plant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, plante_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, text VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, INDEX IDX_DADD4A25177B16E8 (plante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hint (id INT AUTO_INCREMENT NOT NULL, plante_id INT NOT NULL, text VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, INDEX IDX_34C60353177B16E8 (plante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, plant_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_16DB4F891D935652 (plant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, level INT NOT NULL, is_enable_for_user TINYINT(1) NOT NULL, is_enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, experience INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achievement ADD CONSTRAINT FK_96737FF1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE achievement ADD CONSTRAINT FK_96737FF11D935652 FOREIGN KEY (plant_id) REFERENCES plant (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25177B16E8 FOREIGN KEY (plante_id) REFERENCES plant (id)');
        $this->addSql('ALTER TABLE hint ADD CONSTRAINT FK_34C60353177B16E8 FOREIGN KEY (plante_id) REFERENCES plant (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F891D935652 FOREIGN KEY (plant_id) REFERENCES plant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achievement DROP FOREIGN KEY FK_96737FF1A76ED395');
        $this->addSql('ALTER TABLE achievement DROP FOREIGN KEY FK_96737FF11D935652');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25177B16E8');
        $this->addSql('ALTER TABLE hint DROP FOREIGN KEY FK_34C60353177B16E8');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F891D935652');
        $this->addSql('DROP TABLE achievement');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE hint');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE plant');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
