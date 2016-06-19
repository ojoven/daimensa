<?php

namespace App\Console\Commands;

use Log;
use App\Builder\Builder;
use Illuminate\Console\Command;

class BuilderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'builder {task} {lang}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build the data related to a language';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::useFiles('php://stdout', 'info');
        $builder = new Builder();
        $builder->build($this->argument('task'), $this->argument('lang'));
    }
}
