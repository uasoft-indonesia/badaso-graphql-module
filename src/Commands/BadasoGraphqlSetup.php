<?php

namespace Uasoft\Badaso\Module\Graphql\Commands;

use Illuminate\Console\Command;

class BadasoGraphqlSetup extends Command
{
    private $force;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badaso-graphql:setup {--force=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->force = $this->option('force');
            if ($this->force == null || $this->force == 'true') {
                $this->force = true;
            } else {
                $this->force = false;
            }

            $this->publishLightHouse();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function publishLightHouse()
    {
        $this->call('php artisan vendor:publish', [
            '--tag' => 'lighthouse-schema',
        ]);
        $this->call('php artisan vendor:publish', [
            '--tag' => 'graphql-playground-config',
        ]);
    }
}
