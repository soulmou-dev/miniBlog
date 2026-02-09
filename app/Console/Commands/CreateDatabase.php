<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

/**
 * Important: Cette classe permet de créer uniquement une DB mysql
 * 
 */
class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Créer la base de données si elle existe pas';

    public function handle()
    {
        $dbName = env('DB_DATABASE');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', 3306);
        $dbUser = env('DB_USERNAME', 'root');
        $dbPassword = env('DB_PASSWORD', '');
        
        if( env('DB_CONNECTION') ==='mysql'){
            try {
                // On se connecte à MySQL sans préciser de database
                $pdo = new PDO(
                    "mysql:host={$dbHost};port={$dbPort}",
                    $dbUser,
                    $dbPassword,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );

                $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

                $this->info("Database `$dbName` created (or already exists).");

            } catch (\PDOException $e) {
                $this->error("Could not create database `$dbName`: " . $e->getMessage());
            }
        }else {
           $this->info("La commande $this->signature permet de créer uniquement une base de données mysql."); 
        }
    }
}