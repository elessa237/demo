<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730095955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, auteur VARCHAR(255) NOT NULL, contenu CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_67F068BC7294869C ON commentaire (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
    }
}
