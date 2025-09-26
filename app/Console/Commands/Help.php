<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Help
 *
 * The `cli:help` console command displays detailed help information
 * about the application, its available commands, and usage instructions.
 *
 * ## Usage
 * ```
 * php artisan cli:help
 * ```
 *
 * ## Options
 * This command does not accept any arguments or options.
 *
 * ## Example Output
 * ```
 * Application Help
 * -----------------------------
 * Available commands:
 *   cli:help Show this help message
 * ```
 *
 * @package App\Console\Commands
 */
class Help extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:help';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display help information for Sitenpro commands';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('-------------------------------------');
        $this->info('Help');
        $this->line('-------------------------------------');
        $this->line('Available commands:');
        $this->line('cli:help  Show this help message');
        $this->line('-------------------------------------');
        return 0;
    }
}
