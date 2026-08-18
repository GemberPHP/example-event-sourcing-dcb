<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260818130000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE TABLE `saga_store_lock` (
              `boundary_hash` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
              PRIMARY KEY (`boundary_hash`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            SQL
        );
    }
}
