<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\JsonRequestObject;
use App\Services\AppConfiguration;

/**
 * Class SiteConfigurationUpdate
 *
 * The `cli:site:config:update console command adds a new item to the site configuration.
 *
 * ## Usage
 * ```
 * php artisan cli:site:config:update {default.domain} {environment} {json_string}
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
class SiteConfigurationUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:config:update {default.domain} {environment} {json_string}';

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
        $ifArgumentIsEmpty=false;
        $update = [];

        $update['default.domain'] = $this->argument('default.domain');
        $update['environment'] = $this->argument('environment');
        $data = json_decode( $this->argument('json_string'), true);
        if($data == NULL) {
            $data = [];
        }
        $update['user'] = $data;
        
        $result = json_encode(
                (new JsonRequestObject())->getResults(
                    [
                        'request_type' => 'site_configuration_update',
                        'response_format' => 'raw',
                        'request_data' => [
                            'default.domain' => $update['default.domain'],
                            'environment' => $update['environment'],
                            'user' => $update['user'],
                        ],
                    ]
                ),
            JSON_PRETTY_PRINT
        );
    

        $this->info($result);
    }
}