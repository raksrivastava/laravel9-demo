<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class deleteOldRecord extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:record';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete 30 days old records each hour';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {

        \App\Models\User::whereDate('created_at', '<=', now()->subDays(30))->delete();
    }

}
