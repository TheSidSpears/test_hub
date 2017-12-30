<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171230135627 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE test CHANGE time_limit time_limit TIME NOT NULL');
        $this->addSql('ALTER TABLE test_tag RENAME INDEX fk_7af46b44bad26311 TO IDX_7AF46B44BAD26311');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE test CHANGE time_limit time_limit INT NOT NULL');
        $this->addSql('ALTER TABLE test_tag RENAME INDEX idx_7af46b44bad26311 TO FK_7AF46B44BAD26311');
    }
}
