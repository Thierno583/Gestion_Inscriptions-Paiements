<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DatabaseRestore extends Command
{
    protected $signature = 'db:restore {file? : Fichier à restaurer}';
    protected $description = 'Restaure la base de données MemoireInscriptionPaiement';

    public function handle()
    {
        $this->info('Restauration de la base de données');

        $backupPath = database_path('dumps');

        if (!File::exists($backupPath)) {
            $this->error('Dossier de backup non trouvé');
            return 1;
        }

        // Lister les fichiers
        $files = collect(File::files($backupPath))
            ->filter(function($file) {
                return $file->getExtension() === 'sql';
            })
            ->map(function($file) {
                return $file->getFilename();
            })
            ->values();

        if ($files->isEmpty()) {
            $this->error('Aucun fichier de backup trouvé');
            return 1;
        }

        // Afficher les fichiers
        foreach ($files as $file) {
            $this->line($file);
        }

        // Sélectionner le fichier
        $filename = $this->argument('file');

        if (!$filename) {
            $filename = $this->ask('Nom du fichier à restaurer');
        }

        if (!$files->contains($filename)) {
            $this->error('Fichier non trouvé');
            return 1;
        }

        $filePath = $backupPath . '/' . $filename;

        // Confirmation
        if (!$this->confirm('Confirmer la restauration ? Cela va écraser les données actuelles !')) {
            $this->info('Restauration annulée');
            return 0;
        }

        try {
            // Configuration
            $dbName = 'MemoireInscriptionPaiement';
            $username = 'root';
            $host = '127.0.0.1';
            $mysqlPath = 'C:\\xampp\\mysql\\bin\\mysql.exe';

            if (!file_exists($mysqlPath)) {
                $this->error('mysql.exe non trouvé dans XAMPP');
                return 1;
            }

            // Restaurer
            $command = "\"{$mysqlPath}\" --host={$host} --user={$username} {$dbName} < \"{$filePath}\"";
            $output = shell_exec($command . ' 2>&1');

            if ($output && strpos($output, 'ERROR') !== false) {
                $this->error('Erreur lors de la restauration: ' . $output);
                return 1;
            }

            $this->info('Base de données restaurée avec succès !');
            return 0;

        } catch (\Exception $e) {
            $this->error('Erreur: ' . $e->getMessage());
            return 1;
        }
    }
}
