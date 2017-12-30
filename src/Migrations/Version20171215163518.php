<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171215163518 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question ADD test_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E1E5D0459 ON question (test_id)');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CBCB134CE');
        $this->addSql('DROP INDEX IDX_D87F7E0CBCB134CE ON test');
        $this->addSql('ALTER TABLE test CHANGE questions_id author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D87F7E0CF675F31B ON test (author_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496A2187C6');
        $this->addSql('DROP INDEX IDX_8D93D6496A2187C6 ON user');
        $this->addSql('ALTER TABLE user DROP created_tests_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E1E5D0459');
        $this->addSql('DROP INDEX IDX_B6F7494E1E5D0459 ON question');
        $this->addSql('ALTER TABLE question DROP test_id');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CF675F31B');
        $this->addSql('DROP INDEX IDX_D87F7E0CF675F31B ON test');
        $this->addSql('ALTER TABLE test CHANGE author_id questions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CBCB134CE FOREIGN KEY (questions_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_D87F7E0CBCB134CE ON test (questions_id)');
        $this->addSql('ALTER TABLE user ADD created_tests_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496A2187C6 FOREIGN KEY (created_tests_id) REFERENCES test (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6496A2187C6 ON user (created_tests_id)');
    }
}
