<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Services\JsonRequestObject;
use App\Http\Controllers\Controller as AppRestApi;

/**
 * Class SiteItemUpdate
 *
 * The `cli:site:item:update` console command updates an existing item in the site configuration.
 *
 * ## Usage
 * ```
 * php artisan cli:site:item:update {default.domain} {environment} {json_string}
 * ```
 *
 * ## Options
 * This command accepts the following arguments:
 * - `default.domain`: The domain of the site to update the configuration for.
 * - `environment`: The environment to update the configuration for.
 * - `json_string`: The JSON string containing the updated configuration.
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
class SiteItemUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:item:update {default.domain} {environment} {json_string}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update an existing site configuration';

    /**
     * @return void
     */
    public function handle(): void
    {
        $resultsFromTheQuestions = [];
        $resultsFromTheQuestions['default.domain'] = $this->argument('default.domain');
        $resultsFromTheQuestions['user'] = json_decode( $this->argument('json_string'), true);
        $resultsFromTheQuestions['environment'] = $this->argument('environment');
        
        $jsonData = [
            'response_format' => 'raw',
            'request_type' => 'sites_item_update',
            'request_data' => [
                'default.domain' => $resultsFromTheQuestions['default.domain'],
                'environment' => $resultsFromTheQuestions['environment'],
                'user' => $resultsFromTheQuestions['user'],
            ],
        ];

        $this->info(
            json_encode(
                (new JsonRequestObject())->getResults(
                    $jsonData
                ),
                JSON_PRETTY_PRINT
            )
        );
    }
}