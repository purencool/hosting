<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\JsonRequestObject;
use App\Services\AppConfiguration;

/**
 * Class SiteConfigurationRemvoe
 *
 * The `cli:site:config:remove` console command removes an existing item from the site configuration.
 *
 * ## Usage
 * ```
 * php artisan cli:site:config:remove {default.domain} {environment} {json_string}
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
class SiteConfigurationRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:config:remove {default.domain} {environment} {json_string}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove items in existing site configuration';

    /**
     * @return void
     */
    public function handle(): void
    {
        
        $remove = [];
        $remove['default.domain'] = $this->argument('default.domain');
        $remove['environment'] = $this->argument('environment');

        $data = json_decode( $this->argument('json_string'), true);
        if($data == NULL) {
            $data = [];
        }
        $remove['user'] = $data;


        $result = (new JsonRequestObject())->getResults(
            [
                'request_type' => 'site_configuration_remove',
                'response_format' => 'raw',
                'request_data' => [
                    'default.domain' => $remove['default.domain'],
                    'environment' => $remove['environment'],
                    'user' => $remove['user'],
                ],
            ]
         );


        if(empty($result)) {
            $result = '';
        }
        
        $this->info(json_encode($result,JSON_PRETTY_PRINT));

    }
}
