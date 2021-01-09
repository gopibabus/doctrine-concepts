<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210109055213 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Default value to not null on agreedTerms field on User Entity';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user CHANGE agreed_terms_at agreed_terms_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user CHANGE agreed_terms_at agreed_terms_at DATETIME DEFAULT NULL');
    }
}
