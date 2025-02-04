<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203214917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE settings (id SERIAL NOT NULL, key VARCHAR(255) NOT NULL, value JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E545A0C58A90ABA9 ON settings (key)');
        $this->addSql('ALTER TABLE post_tag DROP CONSTRAINT fk_5ace3af04b89032c');
        $this->addSql('ALTER TABLE post_tag DROP CONSTRAINT fk_5ace3af0bad26311');
        $this->addSql('DROP TABLE post_tag');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT fk_5a8a6c8df675f31b');
        $this->addSql('DROP INDEX idx_5a8a6c8df675f31b');
        $this->addSql('ALTER TABLE post ADD tags JSON NOT NULL');
        $this->addSql('ALTER TABLE post DROP author_id');
        $this->addSql('ALTER TABLE post DROP created_at');
        $this->addSql('ALTER TABLE post DROP updated_at');
        $this->addSql('ALTER TABLE tag ADD posts JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(post_id, tag_id))');
        $this->addSql('CREATE INDEX idx_5ace3af0bad26311 ON post_tag (tag_id)');
        $this->addSql('CREATE INDEX idx_5ace3af04b89032c ON post_tag (post_id)');
        $this->addSql('ALTER TABLE post_tag ADD CONSTRAINT fk_5ace3af04b89032c FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_tag ADD CONSTRAINT fk_5ace3af0bad26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE settings');
        $this->addSql('ALTER TABLE post ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE post ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE post DROP tags');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT fk_5a8a6c8df675f31b FOREIGN KEY (author_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5a8a6c8df675f31b ON post (author_id)');
        $this->addSql('ALTER TABLE tag DROP posts');
    }
}
