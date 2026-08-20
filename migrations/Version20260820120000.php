<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260820120000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE TABLE `outbox` (
              `id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `message_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
              `message_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `payload` json NOT NULL,
              `created_at` timestamp(6) NOT NULL,
              `retry_count` int NOT NULL DEFAULT 0,
              `processed_at` timestamp(6) NULL DEFAULT NULL,
              `dead_lettered_at` timestamp(6) NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `outbox_unprocessed` (`processed_at`, `dead_lettered_at`, `created_at`, `id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            SQL
        );
    }
}
