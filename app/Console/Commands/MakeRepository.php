<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Repositories/{$name}.php");

        if (file_exists($path)) {
            $this->error('Repository already exists!');
            return;
        }

        (new Filesystem)->ensureDirectoryExists(app_path('Repositories'));

        file_put_contents($path, $this->repositoryStub($name));

        $this->info("Repository {$name} created successfully.");
    }

    protected function repositoryStub($name)
    {
        return <<<PHP
        <?php

        namespace App\Repositories;

        class {$name}
        {
            public function getAll()
            {
                // Fetch all records
            }
        }
        PHP;
    }
}
