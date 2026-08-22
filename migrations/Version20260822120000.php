<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260822120000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE TABLE `snapshot_store` (
              `boundary_hash` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
              `last_event_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `event_count` int NOT NULL,
              `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
              `created_at` timestamp(6) NOT NULL,
              `updated_at` timestamp(6) NULL DEFAULT NULL,
              PRIMARY KEY (`boundary_hash`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            SQL
        );
    }
}
