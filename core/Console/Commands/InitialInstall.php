<?php

namespace Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Core\Jobs\CompileAssets;

class InitialInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:aecms';

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
     * @return int
     */
    public function handle()
    {
        try
        {            
                $this->line('Running from core');
                
            if(!Config::get('aecms.init'))
            {
                $this->line('Running migrate...');
                Artisan::call('migrate --path=/Core/database/migrations');
                $this->info('Migration complete!');
                
                $this->line('Running seeder...');
                Artisan::call('db:seed');
                $this->info('Seeder complete!');
                
                $this->line('Running compiler...');
                CompileAssets::dispatch();
                $this->info('Compiler complete!');
                
                if (!file_exists(public_path('js/templates'))) {
                    mkdir(public_path('js/templates'));
                    $this->info('JS templates folder created');
                }
                if (!file_exists(public_path('css/templates'))) {
                    mkdir(public_path('css/templates'));
                    $this->info('CSS templates folder created');
                }
                if (!file_exists(database_path('migrations'))) {
                    mkdir(database_path('migrations'));
                    $this->info('database migration folder created');
                }
                if (!file_exists(resource_path('views/templates'))) {
                    mkdir(resource_path('views/templates'));
                    $this->info('Resource templates folder created');
                }
                
                $this->updateConfig();
                
                Log::info('Installation complete! Goodluck!!');
                $this->line('');
                $this->info('Installation complete! Goodluck!!');
                exit;
            }
            
            Log::warning('Application already installed!');
            $this->info('Application already installed!');
            exit;

        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            $this->error($ex->getMessage());
        }
    }
    
    private function updateConfig()
    {
        $file = file_get_contents(config_path('aecms.php'));

        $str = preg_replace("/('init)+\W.(=>)+\s+(false)/", "'init' => true" ,$file);

        file_put_contents(config_path('aecms.php'), $str);
        
        $this->line('Running config:clear');
        Artisan::call('config:clear');
        $this->info('Running config:clear DONE..');
        
        $this->line('Running cache:clear');
        Artisan::call('cache:clear');
        $this->info('Running cache:clear DONE..');
        
        $this->line('Running clear-compiled');
        Artisan::call('clear-compiled');
        $this->info('Running clear-compiled DONE..');
    }
}
