-- =============================================================
-- Digirisers — full schema + seeded test users
-- Run inside the database `digirise_digirisers` (or whichever
-- database your DB_DATABASE points at). Idempotent: re-running
-- on an empty DB is safe; on an existing DB the CREATE TABLE
-- statements will fail by design — that's your "already done" signal.
-- =============================================================

SET FOREIGN_KEY_CHECKS=0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+00:00';

-- -------------------------------------------------------------
-- Tables
-- -------------------------------------------------------------

CREATE TABLE `users` (
  `id`                bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name`        varchar(255) NOT NULL,
  `last_name`         varchar(255) NOT NULL,
  `email`             varchar(255) NOT NULL,
  `phone`             varchar(40)  DEFAULT NULL,
  `company`           varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp    NULL DEFAULT NULL,
  `password`          varchar(255) NOT NULL,
  `remember_token`    varchar(100) DEFAULT NULL,
  `google_id`         varchar(255) DEFAULT NULL,
  `role`              varchar(20)  NOT NULL DEFAULT 'customer',
  `created_at`        timestamp    NULL DEFAULT NULL,
  `updated_at`        timestamp    NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`),
  KEY `users_role_index` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email`      varchar(255) NOT NULL,
  `token`      varchar(255) NOT NULL,
  `created_at` timestamp    NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id`            varchar(255) NOT NULL,
  `user_id`       bigint(20) unsigned DEFAULT NULL,
  `ip_address`    varchar(45) DEFAULT NULL,
  `user_agent`    text DEFAULT NULL,
  `payload`       longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key`        varchar(255) NOT NULL,
  `value`      mediumtext   NOT NULL,
  `expiration` int(11)      NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key`        varchar(255) NOT NULL,
  `owner`      varchar(255) NOT NULL,
  `expiration` int(11)      NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id`           bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue`        varchar(255) NOT NULL,
  `payload`      longtext     NOT NULL,
  `attempts`     tinyint(3) unsigned NOT NULL,
  `reserved_at`  int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at`   int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id`             varchar(255) NOT NULL,
  `name`           varchar(255) NOT NULL,
  `total_jobs`     int(11) NOT NULL,
  `pending_jobs`   int(11) NOT NULL,
  `failed_jobs`    int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options`        mediumtext DEFAULT NULL,
  `cancelled_at`   int(11) DEFAULT NULL,
  `created_at`     int(11) NOT NULL,
  `finished_at`    int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id`         bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid`       varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue`      text NOT NULL,
  `payload`    longtext NOT NULL,
  `exception`  longtext NOT NULL,
  `failed_at`  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id`        int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch`     int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Migrations registry (so Laravel knows these migrations ran)
-- -------------------------------------------------------------

INSERT INTO `migrations` (`migration`, `batch`) VALUES
  ('0001_01_01_000000_create_users_table', 1),
  ('0001_01_01_000001_create_cache_table', 1),
  ('0001_01_01_000002_create_jobs_table',  1),
  ('2026_05_01_000000_add_google_id_to_users_table', 1);

-- -------------------------------------------------------------
-- Seed: test customer + admin
--   Customer: customer@digirisers.test / password123
--   Admin:    admin@digirisers.test    / admin123
-- -------------------------------------------------------------

INSERT INTO `users`
  (`first_name`, `last_name`, `email`, `phone`, `company`, `password`, `role`, `created_at`, `updated_at`)
VALUES
  ('Casey', 'Customer', 'customer@digirisers.test', '+1 555 010 1010', 'Demo Co.',
   '$2y$12$Nv8xXc1hR3KMKqFY8ealFuhI2kmLXn77sO1TFpMzZEnu3KSszaYOK',
   'customer', NOW(), NOW()),
  ('Avery', 'Admin',    'admin@digirisers.test',    '+1 555 020 2020', 'Digirisers HQ',
   '$2y$12$9zwV0Q6lbwZXP06fDjLVnOaVjb4UfC..aujExlg8ljdlRyw5EzfQa',
   'admin', NOW(), NOW());

SET FOREIGN_KEY_CHECKS=1;
