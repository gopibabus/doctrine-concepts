<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210102170317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Removed author column from article table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE article DROP author');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE article ADD author VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
