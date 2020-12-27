<?php
declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201227190403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Created isDeleted Column on Comment Table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE comment ADD is_deleted TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE comment DROP is_deleted');
    }
}
