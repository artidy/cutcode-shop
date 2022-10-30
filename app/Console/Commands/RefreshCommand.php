<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'shop:refresh';
    protected $description = 'Refresh database';

    public function handle(): int
    {
        if (app()->isProduction()) {
            return self::SUCCESS;
        }

        Storage::deleteDirectory('images/brands');
        Storage::deleteDirectory('images/products');

        $this->call('migrate:fresh', [
            '--seed' => true
        ]);

        return self::SUCCESS;
    }
}
