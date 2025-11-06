<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\JsonRequestObject;
use App\Services\AppConfiguration;

/**
 * Class SiteConfigurationFind
 *
 * The `cli:site:config:find` console command displays the configuration.
 *
 * ## Usage
 * ```
 * php artisan cli:site:config:find {data}
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
class SiteConfigurationFind extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:config:find {data} {flag?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Site configuration find data';

    /**
     * @return void
     */
    public function handle(): void
    {

        $configArray = [
            'response_format' => 'raw',
            'request_type' => 'site_configuration_find',
            'request_data' => $this->argument('data')
        ];
        $search = (new JsonRequestObject())->getResults($configArray);
        
        
        $flag = $this->argument('flag');
        if($flag == 'raw') {
            $result = $search;
        } else {
            foreach($search as $value) {
                $result[] = [
                    "results" => $value["results"],
                    "results_raw" => $value["results_raw"],
                ];
            }
        }

        if(empty($result)) {
            $result = '';
        }
        
        $this->info(json_encode($result,JSON_PRETTY_PRINT));

    }
}
