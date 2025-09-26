<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\JsonRequestObject;
use App\Services\AppConfiguration;

/**
 * Class SiteConfiguration
 *
 * The `cli:site:config` console command displays the configuration for a specific site.
 *
 * ## Usage
 * ```
 * php artisan cli:site:config {default.domain}
 * ```
 *
 * ## Options
 * This command accepts the following arguments:
 * - `default.domain`: The domain of the site to retrieve the configuration for.
 *
 * ## Example Output
 * ```
 * {
 *   "domain": "example.com",
 *   "settings": {
 *     "theme": "default",
 *     "language": "en"
 *   }
 * }
 * ```
 *
 * @package App\Console\Commands
 */
class SiteConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:config {default.domain?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new site configuration';

    /**
     * @return void
     */
    public function handle(): void
    {
        $resultsFromTheQuestions = [];
        
        $configArray = [
            'response_format' => 'raw',
            'request_type' => 'sites_config_all',
            'request_data' => 'all'
        ];

        if(!$this->argument('default.domain') == '') {
            $resultsFromTheQuestions['default.domain'] = $this->argument('default.domain');
            $configArray = [
                'response_format' => 'raw',
                'request_type' => 'sites_config',
                'request_data' => $resultsFromTheQuestions,
            ];
        }


        $this->info(
            json_encode(
                (new JsonRequestObject())->getResults($configArray),
                JSON_PRETTY_PRINT
            )
        );
    }
}
