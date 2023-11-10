<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929051836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE carrier_weight_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE carrier_weight_category (id INT NOT NULL, carrier_id INT NOT NULL, beginning INT NOT NULL, ending INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_44ECAFF621DFC797 ON carrier_weight_category (carrier_id)');
        $this->addSql('ALTER TABLE carrier_weight_category ADD CONSTRAINT FK_44ECAFF621DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE carrier_weight_category_id_seq CASCADE');
        $this->addSql('ALTER TABLE carrier_weight_category DROP CONSTRAINT FK_44ECAFF621DFC797');
        $this->addSql('DROP TABLE carrier_weight_category');
    }
}
