<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup {--commit : Commit vers Git}';
    protected $description = 'Sauvegarde de la base de données MemoireInscriptionPaiement';

    public function handle()
    {
        $this->info('Début de la sauvegarde...');

        // Configuration
        $dbName = 'MemoireInscriptionPaiement';
        $username = 'root';
        $host = '127.0.0.1';
        $mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

        $backupPath = database_path('dumps');
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "MemoireInscriptionPaiement_latest.sql";

        // Créer le dossier si nécessaire
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        // Vérifier mysqldump
        if (!file_exists($mysqldumpPath)) {
            $this->error('mysqldump non trouvé dans XAMPP');
            return 1;
        }

        try {
            // Créer la commande
            $command = "\"{$mysqldumpPath}\" --host={$host} --user={$username} {$dbName}";

            // Exécuter
            $output = shell_exec($command);

            if ($output === null) {
                $this->error('Erreur lors du backup');
                return 1;
            }

            // Sauvegarder
            File::put($backupPath . '/' . $filename, $output);

            $this->info('Backup créé: ' . $filename);

            // Git si demandé
            if ($this->option('commit')) {
                shell_exec('git add database/dumps/' . $filename);
                shell_exec('git commit -m "Backup automatique"');
                $this->info('Ajouté à Git');
            }

            return 0;

        } catch (\Exception $e) {
            $this->error('Erreur: ' . $e->getMessage());
            return 1;
        }
    }
}
