<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251002195234 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE TABLE `saga_store` (
              `id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `saga_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `payload` json NOT NULL,
              `created_at` timestamp(6) NOT NULL,
              `updated_at` timestamp(6) NULL DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            SQL
        );

        $this->addSql(
            <<<'SQL'
            CREATE TABLE `saga_store_relation` (
              `id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `saga_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              PRIMARY KEY (`id`,`saga_id`),
              KEY `saga_id` (`saga_id`),
              CONSTRAINT `saga_store_relation_ibfk_1` FOREIGN KEY (`id`) REFERENCES `saga_store` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            SQL
        );
    }
}
