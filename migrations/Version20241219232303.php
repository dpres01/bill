<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219232303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE billed_maker (id INT AUTO_INCREMENT NOT NULL, billed_ref_id INT NOT NULL, billed_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', start_at_period DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_at_period DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', payment_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_FFB8FEA942888CF1 (billed_ref_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billed_maker ADD CONSTRAINT FK_FFB8FEA942888CF1 FOREIGN KEY (billed_ref_id) REFERENCES billed (id)');
        $this->addSql('ALTER TABLE billed ADD created_at DATE DEFAULT NOW() NOT NULL, ADD updated_at DATE DEFAULT NOW() NOT NULL, DROP start_date, DROP end_date, DROP invoice_date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billed_maker DROP FOREIGN KEY FK_FFB8FEA942888CF1');
        $this->addSql('DROP TABLE billed_maker');
        $this->addSql('ALTER TABLE billed ADD start_date DATE NOT NULL, ADD end_date DATE NOT NULL, ADD invoice_date DATE NOT NULL, DROP created_at, DROP updated_at');
    }
}
