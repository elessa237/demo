<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210807140008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__articles AS SELECT id, auteur, contenu, created_at, images FROM articles');
        $this->addSql('DROP TABLE articles');
        $this->addSql('CREATE TABLE articles (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, auteur VARCHAR(255) NOT NULL COLLATE BINARY, contenu VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, images VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_BFDD3168A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO articles (id, auteur, contenu, created_at, images) SELECT id, auteur, contenu, created_at, images FROM __temp__articles');
        $this->addSql('DROP TABLE __temp__articles');
        $this->addSql('CREATE INDEX IDX_BFDD3168A76ED395 ON articles (user_id)');
        $this->addSql('DROP INDEX IDX_B4BEBBB81EBAF6CC');
        $this->addSql('DROP INDEX IDX_B4BEBBB8BCF5E72D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__articles_categorie AS SELECT articles_id, categorie_id FROM articles_categorie');
        $this->addSql('DROP TABLE articles_categorie');
        $this->addSql('CREATE TABLE articles_categorie (articles_id INTEGER NOT NULL, categorie_id INTEGER NOT NULL, PRIMARY KEY(articles_id, categorie_id), CONSTRAINT FK_B4BEBBB81EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B4BEBBB8BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO articles_categorie (articles_id, categorie_id) SELECT articles_id, categorie_id FROM __temp__articles_categorie');
        $this->addSql('DROP TABLE __temp__articles_categorie');
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
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_BFDD3168A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__articles AS SELECT id, auteur, contenu, created_at, images FROM articles');
        $this->addSql('DROP TABLE articles');
        $this->addSql('CREATE TABLE articles (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, images VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO articles (id, auteur, contenu, created_at, images) SELECT id, auteur, contenu, created_at, images FROM __temp__articles');
        $this->addSql('DROP TABLE __temp__articles');
        $this->addSql('DROP INDEX IDX_B4BEBBB81EBAF6CC');
        $this->addSql('DROP INDEX IDX_B4BEBBB8BCF5E72D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__articles_categorie AS SELECT articles_id, categorie_id FROM articles_categorie');
        $this->addSql('DROP TABLE articles_categorie');
        $this->addSql('CREATE TABLE articles_categorie (articles_id INTEGER NOT NULL, categorie_id INTEGER NOT NULL, PRIMARY KEY(articles_id, categorie_id))');
        $this->addSql('INSERT INTO articles_categorie (articles_id, categorie_id) SELECT articles_id, categorie_id FROM __temp__articles_categorie');
        $this->addSql('DROP TABLE __temp__articles_categorie');
        $this->addSql('CREATE INDEX IDX_B4BEBBB81EBAF6CC ON articles_categorie (articles_id)');
        $this->addSql('CREATE INDEX IDX_B4BEBBB8BCF5E72D ON articles_categorie (categorie_id)');
        $this->addSql('DROP INDEX IDX_67F068BC7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, article_id, auteur, contenu, created_at FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, auteur VARCHAR(255) NOT NULL, contenu CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO commentaire (id, article_id, auteur, contenu, created_at) SELECT id, article_id, auteur, contenu, created_at FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC7294869C ON commentaire (article_id)');
    }
}
