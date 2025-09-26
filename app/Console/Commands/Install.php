<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Services\AppDirectoryStructure\HostingEnvironment;


/**
 * Class SiteListDomains
 *
 * The `cli:install` console command displays the domains for a specific site.
 *
 * ## Usage
 * ```
 * php artisan cli:install
 * ```
 *
 * ## Options
 *
 * @package App\Console\Commands
 */
class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install application hosting environment.';

    /**
     * @return 
     */
    public function handle(): void
    {
        $manager = new HostingEnvironment();
        $manager->createBaseDirectory();
        $manager->createEnvironmentDirectories();
        $manager->createConfigDirectory();
        $manager->createContainersDirectory();
        $manager->createContainersBackupDirectory();
    }
}
