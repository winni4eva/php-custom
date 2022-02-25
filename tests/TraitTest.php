<?php
namespace Tests\Unit;

use Winnipass\Wfx\App\Database;

trait TraitTest
{
    public function refreshDatabase(): void
    {
        $db = (new Database())->connect();
        $db->exec('DROP table if exists transactions');
        $db->exec('DROP table if exists accounts');
        $db->exec('DROP table if exists customers');
        $db->exec('CREATE TABLE `customers` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
          )');
        $db->exec('CREATE TABLE `accounts` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_id` int(11) NOT NULL,
            `amount` bigint(20) unsigned NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `customer_id` (`customer_id`),
            CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
          )');
        $db->exec('CREATE TABLE `transactions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `account_id` int(11) NOT NULL,
            `amount` bigint(20) unsigned NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `account_id` (`account_id`),
            CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
          )');
    }
}