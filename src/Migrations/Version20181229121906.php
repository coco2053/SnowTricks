<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181229121906 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trick (id INT AUTO_INCREMENT NOT NULL, trick_group_id INT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D8F0A91E9B875DF8 (trick_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_group (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_image (id INT AUTO_INCREMENT NOT NULL, trick_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, INDEX IDX_E1204E0B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, trick_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_7CC7DA2CB281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E9B875DF8 FOREIGN KEY (trick_group_id) REFERENCES trick_group (id)');
        $this->addSql('ALTER TABLE trick_image ADD CONSTRAINT FK_E1204E0B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trick_image DROP FOREIGN KEY FK_E1204E0B281BE2E');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CB281BE2E');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E9B875DF8');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP TABLE trick_group');
        $this->addSql('DROP TABLE trick_image');
        $this->addSql('DROP TABLE video');
    }
}
