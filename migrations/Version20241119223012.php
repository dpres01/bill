<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119223012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billed ADD person_id INT NOT NULL, DROP from_date');
        $this->addSql('ALTER TABLE billed ADD CONSTRAINT FK_2B45A92217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_2B45A92217BBB47 ON billed (person_id)');
        $this->addSql('ALTER TABLE person ADD from_date DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billed DROP FOREIGN KEY FK_2B45A92217BBB47');
        $this->addSql('DROP INDEX IDX_2B45A92217BBB47 ON billed');
        $this->addSql('ALTER TABLE billed ADD from_date DATE NOT NULL, DROP person_id');
        $this->addSql('ALTER TABLE person DROP from_date');
    }
}
