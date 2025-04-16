<?php

namespace App\Console\Commands;

use App\Models\Status;
use Illuminate\Console\Command;

class InitializeStatusCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the status counts for existing tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Initializing status counts...');

        $status = Status::updateCounts();

        $this->info('Status counts initialized:');
        $this->info("Pending: {$status->pending}");
        $this->info("In Progress: {$status->in_progress}");
        $this->info("Complete: {$status->complete}");

        return Command::SUCCESS;
    }
}
