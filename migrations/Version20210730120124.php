<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730120124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles_categorie (articles_id INTEGER NOT NULL, categorie_id INTEGER NOT NULL, PRIMARY KEY(articles_id, categorie_id))');
        $this->addSql('CREATE INDEX IDX_B4BEBBB81EBAF6CC ON articles_categorie (articles_id)');
        $this->addSql('CREATE INDEX IDX_B4BEBBB8BCF5E72D ON articles_categorie (categorie_id)');
        $this->addSql('DROP INDEX IDX_67F068BC7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, article_id, auteur, contenu, created_at FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, auteur VARCHAR(255) NOT NULL COLLATE BINARY, contenu CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, CONSTRAINT FK_67F068BC7294869C FOREIGN KEY (article_id) REFERENCES articles (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO commentaire (id, article_id, auteur, contenu, created_at) SELECT id, article_id, auteur, contenu, created_at FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC7294869C ON commentaire (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE articles_categorie');
        $this->addSql('DROP INDEX IDX_67F068BC7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, article_id, auteur, contenu, created_at FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, auteur VARCHAR(255) NOT NULL, contenu CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO commentaire (id, article_id, auteur, contenu, created_at) SELECT id, article_id, auteur, contenu, created_at FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC7294869C ON commentaire (article_id)');
    }
}
