<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230608140256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment CHANGE author_id author_id INT NOT NULL, CHANGE episode_id episode_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment RENAME INDEX idx_9474526c444e6803 TO IDX_9474526C362B62A0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment CHANGE author_id author_id INT DEFAULT NULL, CHANGE episode_id episode_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment RENAME INDEX idx_9474526c362b62a0 TO IDX_9474526C444E6803');
    }
}
