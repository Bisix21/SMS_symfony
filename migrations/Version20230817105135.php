<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230817105135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_subject DROP FOREIGN KEY FK_A3C3207023EDC87');
        $this->addSql('ALTER TABLE user_subject DROP FOREIGN KEY FK_A3C32070A76ED395');
        $this->addSql('ALTER TABLE subject_study_class DROP FOREIGN KEY FK_2A38915B23EDC87');
        $this->addSql('ALTER TABLE subject_study_class DROP FOREIGN KEY FK_2A38915B49891E99');
        $this->addSql('DROP TABLE user_subject');
        $this->addSql('DROP TABLE subject_study_class');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64949891E99');
        $this->addSql('DROP INDEX IDX_8D93D64949891E99 ON user');
        $this->addSql('ALTER TABLE user DROP study_class_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_subject (user_id INT NOT NULL, subject_id INT NOT NULL, INDEX IDX_A3C3207023EDC87 (subject_id), INDEX IDX_A3C32070A76ED395 (user_id), PRIMARY KEY(user_id, subject_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE subject_study_class (subject_id INT NOT NULL, study_class_id INT NOT NULL, INDEX IDX_2A38915B49891E99 (study_class_id), INDEX IDX_2A38915B23EDC87 (subject_id), PRIMARY KEY(subject_id, study_class_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_subject ADD CONSTRAINT FK_A3C3207023EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_subject ADD CONSTRAINT FK_A3C32070A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subject_study_class ADD CONSTRAINT FK_2A38915B23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subject_study_class ADD CONSTRAINT FK_2A38915B49891E99 FOREIGN KEY (study_class_id) REFERENCES study_class (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD study_class_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64949891E99 FOREIGN KEY (study_class_id) REFERENCES study_class (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D64949891E99 ON user (study_class_id)');
    }
}
