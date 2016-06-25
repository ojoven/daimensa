<?php

namespace App\Console\Commands;

use Log;
use Illuminate\Console\Command;
use App\ContentRetriever\ContentRetriever;

class ContentRetrieverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content_retriever {task} {lang} {additional?}';

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
        $builder = new ContentRetriever();
        $builder->retrieve($this->argument('task'), $this->argument('lang'), $this->argument('additional'));
    }
}
