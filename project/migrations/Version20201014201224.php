<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014201224 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_tasks (id INT AUTO_INCREMENT NOT NULL, creator_id INT DEFAULT NULL, performer_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_97FC7EB761220EA6 (creator_id), INDEX IDX_97FC7EB76C6B33F3 (performer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_F6415EB17BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task_tasks ADD CONSTRAINT FK_97FC7EB761220EA6 FOREIGN KEY (creator_id) REFERENCES user_users (id)');
        $this->addSql('ALTER TABLE task_tasks ADD CONSTRAINT FK_97FC7EB76C6B33F3 FOREIGN KEY (performer_id) REFERENCES user_users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_tasks DROP FOREIGN KEY FK_97FC7EB761220EA6');
        $this->addSql('ALTER TABLE task_tasks DROP FOREIGN KEY FK_97FC7EB76C6B33F3');
        $this->addSql('DROP TABLE task_tasks');
        $this->addSql('DROP TABLE user_users');
    }
}
