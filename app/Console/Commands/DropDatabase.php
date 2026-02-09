<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

/**
 * Important: Cette commande permet de supprimer uniquement une DB mysql
 * 
 */
class DropDatabase extends Command
{
    protected $signature = 'db:drop';
    protected $description = 'Supprimer la base de données si elle existe';

    public function handle()
    {
        $dbName = env('DB_DATABASE');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', 3306);
        $dbUser = env('DB_USERNAME', 'root');
        $dbPassword = env('DB_PASSWORD', '');
        
        if( env('DB_CONNECTION') ==='mysql'){
            
            // Afficher un message d'avertissement
            $this->warn("Attention: Vous etes sur le point de supprimer la base de données $dbName de façon irréversible !");
            
            // Confirmation YES / NO
            if(!$this->confirm('Êtes-vous sûr de vouloir continuer ?', false)){
                $this->info('Action annulée.');
                return 0;
            }
            
            //action confirmée => suppression de la base de données
            try {
                // On se connecte à MySQL sans préciser de database
                $pdo = new PDO(
                    "mysql:host={$dbHost};port={$dbPort}",
                    $dbUser,
                    $dbPassword,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );

                $pdo->exec("DROP DATABASE IF EXISTS `$dbName`");

                $this->info("Database `$dbName` dropped (or not exists).");

            } catch (\PDOException $e) {
                $this->error("Could not drop database `$dbName`: " . $e->getMessage());
            }
        }else {
           $this->info("La commande $this->signature permet de supprimer uniquement une base de données mysql."); 
        }
    }
}