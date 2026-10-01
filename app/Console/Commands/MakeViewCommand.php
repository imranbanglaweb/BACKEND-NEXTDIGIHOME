<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
class MakeViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
     protected $signature = 'make:view {view}';

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
        // return 0;

         $view = $this->argument('view');
  
        $path = $this->viewPath($view);
  
        $this->createDir($path);
  
        if (File::exists($path))
        {
            $this->error("File {$path} already exists!");
            return;
        }
  
        File::put($path, $path);
  
        $this->info("File {$path} created.");
    }

    public function viewPath($view)
    {
        $view = str_replace('.', '/', $view) . '.blade.php';
  
        $path = "resources/views/{$view}";
  
        return $path;
    }
    
     public function createDir($path)
    {
        $dir = dirname($path);
  
        if (!file_exists($dir))
        {
            mkdir($dir, 0777, true);
        }
    }


}
