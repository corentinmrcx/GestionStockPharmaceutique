<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211164448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7B6A1BD45');
        $this->addSql('DROP INDEX IDX_BA388B7B6A1BD45 ON cart');
        $this->addSql('ALTER TABLE cart DROP cart_line_id');
        $this->addSql('ALTER TABLE cart_line DROP unit_price, CHANGE cart_id cart_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_line ADD unit_price DOUBLE PRECISION DEFAULT NULL, CHANGE cart_id cart_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD cart_line_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7B6A1BD45 FOREIGN KEY (cart_line_id) REFERENCES cart_line (id)');
        $this->addSql('CREATE INDEX IDX_BA388B7B6A1BD45 ON cart (cart_line_id)');
    }
}
