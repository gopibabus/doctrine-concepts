<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210102023432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Added twitter username column to the user';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user ADD twitter_username VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user DROP twitter_username');
    }
}
