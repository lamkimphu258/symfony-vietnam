<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211112032031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enroll_lesson (trainee_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', lesson_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', finished_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_FA51AF5C36C682D0 (trainee_id), INDEX IDX_FA51AF5CCDF80196 (lesson_id), PRIMARY KEY(trainee_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enroll_lesson ADD CONSTRAINT FK_FA51AF5C36C682D0 FOREIGN KEY (trainee_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE enroll_lesson ADD CONSTRAINT FK_FA51AF5CCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE lesson CHANGE status status ENUM(\'draft\', \'published\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE enroll_lesson');
        $this->addSql('ALTER TABLE lesson CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
