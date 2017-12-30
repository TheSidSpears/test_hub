<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171215130624 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, created_tests_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D6496A2187C6 (created_tests_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496A2187C6 FOREIGN KEY (created_tests_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE test ADD questions_id INT DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL, ADD time_limit TIME NOT NULL, ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CBCB134CE FOREIGN KEY (questions_id) REFERENCES question (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D87F7E0C989D9B62 ON test (slug)');
        $this->addSql('CREATE INDEX IDX_D87F7E0CBCB134CE ON test (questions_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CBCB134CE');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX UNIQ_D87F7E0C989D9B62 ON test');
        $this->addSql('DROP INDEX IDX_D87F7E0CBCB134CE ON test');
        $this->addSql('ALTER TABLE test DROP questions_id, DROP slug, DROP time_limit, DROP description');
    }
}
