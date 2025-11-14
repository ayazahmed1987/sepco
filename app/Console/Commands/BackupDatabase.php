<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup the MySQL database and store it in database-backups folder';

    public function handle()
    {
        $dbName     = env('DB_DATABASE');
        $dbUser     = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');
        $dbHost     = env('DB_HOST', '127.0.0.1');
        $backupPath = base_path('database-backups');

        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $filename = $backupPath . '/' . $dbName . '_' . date('Y-m-d_H-i-s') . '.sql';

        $command = "mysqldump -h {$dbHost} -u {$dbUser} -p\"{$dbPassword}\" {$dbName} > \"{$filename}\"";

        $result = null;
        $output = null;

        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("Database backup created successfully: {$filename}");
        } else {
            $this->error("Database backup failed. Please check credentials or permissions.");
        }
    }
}
