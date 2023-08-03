<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230802154035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subject_study_class (subject_id INT NOT NULL, study_class_id INT NOT NULL, INDEX IDX_2A38915B23EDC87 (subject_id), INDEX IDX_2A38915B49891E99 (study_class_id), PRIMARY KEY(subject_id, study_class_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subject_study_class ADD CONSTRAINT FK_2A38915B23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subject_study_class ADD CONSTRAINT FK_2A38915B49891E99 FOREIGN KEY (study_class_id) REFERENCES study_class (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject_study_class DROP FOREIGN KEY FK_2A38915B23EDC87');
        $this->addSql('ALTER TABLE subject_study_class DROP FOREIGN KEY FK_2A38915B49891E99');
        $this->addSql('DROP TABLE subject_study_class');
    }
}
