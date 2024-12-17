<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217155805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billed DROP FOREIGN KEY FK_2B45A92217BBB47');
        $this->addSql('DROP INDEX IDX_2B45A92217BBB47 ON billed');
        $this->addSql('ALTER TABLE billed ADD owner_id INT NOT NULL, CHANGE person_id renter_id INT NOT NULL');
        $this->addSql('ALTER TABLE billed ADD CONSTRAINT FK_2B45A92E289A545 FOREIGN KEY (renter_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE billed ADD CONSTRAINT FK_2B45A927E3C61F9 FOREIGN KEY (owner_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_2B45A92E289A545 ON billed (renter_id)');
        $this->addSql('CREATE INDEX IDX_2B45A927E3C61F9 ON billed (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billed DROP FOREIGN KEY FK_2B45A92E289A545');
        $this->addSql('ALTER TABLE billed DROP FOREIGN KEY FK_2B45A927E3C61F9');
        $this->addSql('DROP INDEX IDX_2B45A92E289A545 ON billed');
        $this->addSql('DROP INDEX IDX_2B45A927E3C61F9 ON billed');
        $this->addSql('ALTER TABLE billed ADD person_id INT NOT NULL, DROP renter_id, DROP owner_id');
        $this->addSql('ALTER TABLE billed ADD CONSTRAINT FK_2B45A92217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_2B45A92217BBB47 ON billed (person_id)');
    }
}
