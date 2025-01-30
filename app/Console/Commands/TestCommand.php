<?php

namespace App\Console\Commands;

use App\Models\Test;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command {code?} {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Test Table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = [];
        $data['code'] = $this->argument('code') ?? 'code';
        $data['name'] = $this->argument('name') ?? 'code';

        Test::create($data);
    }
}
