<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\JsonRequestObject;
use App\Services\AppConfiguration;

/**
 * Class SiteCreation
 *
 * The `cli:site:creation` console command creates a new site configuration.
 *
 * ## Usage
 * ```
 * php artisan cli:site:creation {default.domain}
 * ```
 *
 * ## Options
 * This command accepts the following arguments:
 * - `default.domain`: The domain of the site to create the configuration for.
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
class SiteCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:creation {default.domain?}';

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
        $creation = new AppConfiguration();

        // 1. What is your unique domain or will check the one provided?
        if ($this->argument('default.domain')) {
           $resultsFromTheQuestions['default.domain'] = $this->argument('default.domain');
       } else {
          $domain = $this->ask('What is the systems unique domain to be used for this application (eg: hotels.com)?');
          $resultsFromTheQuestions['default.domain'] = $domain;
        }

        // 2. What type of software are you using?
        $softwareType = $this->choice('What type of software are you using?', ['Html' ,'NodeJS', 'Drupal','Laravel','Wordpress']);
        $resultsFromTheQuestions['software'] = $softwareType;

        // 3. Please provide a description of what this app does.
        $description = $this->ask('Please provide a description of what this app does.');
        $resultsFromTheQuestions['description'] = $description;

        // 4. Which Docker or Podman container are you using?
        $containerType = $this->choice('Name container are you using?', ['Apache', 'Drupal', 'Drupal Solr', 'Laravel', 'Node' ,'Hyper']);
        $resultsFromTheQuestions['container_type'] = $containerType;

        // 5. Are you using a code management tool like git?
        $gitUrl = "";
        $gitAuth = "";
        if ($this->confirm('Are you using a code management tool like git?')) {
            // Request url and authentication
            $gitUrl = $this->ask('Please provide the Git repository URL');
            $gitAuth = $this->secret('Please enter your Git authentication credentials');
        }
        $resultsFromTheQuestions['code_management']['url'] = $gitUrl;
        $resultsFromTheQuestions['code_management']['auth'] = $gitAuth;

        // Action updates
        $actionUpdate = $this->ask('What actions do you want to run on each deployment separate with a comma (eg: composer update, next command)?');
        $resultsFromTheQuestions['code_management']['actions'] = $actionUpdate;

        // 6. What type of database names system will be used for this application?
        $databaseManagementSystem = $this->ask('What are the database names need for this application separate with a comma?');
        $resultsFromTheQuestions['database_names'] = $databaseManagementSystem;        
        
        // 7. What type of database names system will be used for this application?
        $groupManagementSystem = $this->ask('What group is this application be a part of?');
        $resultsFromTheQuestions['group_name'] = $groupManagementSystem;

        $this->info(
            json_encode(
                (new JsonRequestObject())->getResults(
                    [
                        'response_format' => 'raw',
                        'request_type' => 'sites_creation',
                        'request_data' => $resultsFromTheQuestions,
                    ]
                ),
                JSON_PRETTY_PRINT
            )
        );
    }
}
