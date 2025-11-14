<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        if (file_exists($path)) {
            $this->error('Service already exists!');
            return;
        }

        (new Filesystem)->ensureDirectoryExists(app_path('Services'));

        file_put_contents($path, $this->serviceStub($name));

        $this->info("Service {$name} created successfully.");
    }

    protected function serviceStub($name)
    {
        return <<<PHP
        <?php

        namespace App\Services;

        class {$name}
        {
            public function handle()
            {
                // Your service logic here
            }
        }
        PHP;
    }
}
