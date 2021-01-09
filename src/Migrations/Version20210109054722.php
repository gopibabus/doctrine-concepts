<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210109054722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Created agreedTerms field on User Entity and default to null';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user ADD agreed_terms_at DATETIME DEFAULT NULL');
        $this->addSql('UPDATE user SET agreed_terms_at = NOW()');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user DROP agreed_terms_at');
    }
}
