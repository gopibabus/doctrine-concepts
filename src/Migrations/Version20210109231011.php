<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210109231011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create a new field location on Article Entity';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE article ADD location VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE article DROP location');
    }
}
