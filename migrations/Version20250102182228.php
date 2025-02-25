<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250102182228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD total_price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE18D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD total_price DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP total_price');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE18D9F6D38');
        $this->addSql('ALTER TABLE cart DROP total_price');
    }
}
