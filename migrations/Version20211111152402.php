<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211111152402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_169E6FB95E237E06 (name), UNIQUE INDEX UNIQ_169E6FB9989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enroll_course (trainee_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', course_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', finished_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_14BBB41636C682D0 (trainee_id), INDEX IDX_14BBB416591CC992 (course_id), PRIMARY KEY(trainee_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enroll_course ADD CONSTRAINT FK_14BBB41636C682D0 FOREIGN KEY (trainee_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE enroll_course ADD CONSTRAINT FK_14BBB416591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enroll_course DROP FOREIGN KEY FK_14BBB416591CC992');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE enroll_course');
    }
}
