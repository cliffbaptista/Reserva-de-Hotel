<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251213184659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guests (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4D11BCB2E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, guest_id INT NOT NULL, check_in DATE NOT NULL, check_out DATE NOT NULL, total_price NUMERIC(10, 2) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_4DA23954177093 (room_id), INDEX IDX_4DA2399A4AA658 (guest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) NOT NULL, base_price NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_7CA11A9696901F54 (number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seasons (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, multiplier NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23954177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2399A4AA658 FOREIGN KEY (guest_id) REFERENCES guests (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23954177093');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2399A4AA658');
        $this->addSql('DROP TABLE guests');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE seasons');
    }
}
