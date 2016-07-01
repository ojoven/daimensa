<?php

namespace App\Console\Commands;

use Log;
use Illuminate\Console\Command;
use App\Retriever\Retriever;

class RetrieverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retriever {task} {lang} {additional?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve the content for the lang';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::useFiles('php://stdout', 'info');
        $builder = new Retriever();
        $builder->retrieve($this->argument('task'), $this->argument('lang'), $this->argument('additional'));
    }
}
