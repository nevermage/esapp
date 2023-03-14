<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use App\Models\Book;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /** @var Client */
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Reindex stared');

        foreach (Book::cursor() as $book) {
            $this->elasticsearch->index([
                'index' => $book->getTable(),
                'type' => $book->getTable(),
                'id' => $book->getKey(),
                'body' => $book->toArray(),
            ]);
        }

        $this->info('Reindex finished');
    }
}
