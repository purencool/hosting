<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use AcmePhp\Core\AcmeClient;
use AcmePhp\Ssl\KeyPair;
use App\Services\JsonRequestObject;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use App\Http\Controllers\Controller as AppRestApi;

/**
 * Class SiteListDomains
 *
 * The `cli:build` console command displays the domains for a specific site.
 *
 * ## Usage
 * ```
 * php artisan cli:site:domains {default.domain}
 * ```
 *
 * ## Options
 * This command accepts the following arguments:
 * - `default.domain`: The domain of the site to retrieve the configuration for.
 *
 * ## Example Output
 * ```
 * {
 *    "environment": "production",
 *    "site": "test.com",
 *    "domain": "test-com-production.test.app"
 *  }
 * ```
 *
 * @package App\Console\Commands
 */
class BuildCertificates extends Command
{

 


//         $client = new AcmeClient('https://acme-v02.api.letsencrypt.org/directory');
//         $accountKeyPair = KeyPair::generate();
//         $client->registerAccount($accountKeyPair, ['mailto:you@example.com']);

//         $domain = 'yourdomain.com';
//         $domainKeyPair = KeyPair::generate();
//         $order = $client->requestOrder($accountKeyPair, [$domain]);
//         $authorization = $client->authorize($order, $domain);

//         $challenge = $authorization->getHttpChallenge();
//         file_put_contents(
//             public_path('.well-known/acme-challenge/' . $challenge->getToken()),
//             $challenge->getPayload()
//         );

//         $client->challengeAuthorization($challenge);

//         // Polling and finalization steps go here...

//         // Save certificate
//         // file_put_contents(storage_path('ssl/certificate.crt'), $certificatePem);
//     }
// }

   
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:build:certificates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all domains for all environments';

    /**
     * @return 
     */
    public function handle(): void
    { 
       
        $response = (new JsonRequestObject())->getResults([ 
                        'request_type' => 'site_configuration_all',
                        'response_format' => 'raw'
                    ]
          );

        foreach($response as $value)  {
            $siteDirectory = $value['dir_site'];
            $certsDirectory = $value['system']['system']['directories']['certs']['path'];
            print_r($value['domains']);
            $certificateDirectory = $siteDirectory .'/'. $certsDirectory;
            (new HostingEnvironment())->createHostingCertificate(
                $certificateDirectory, 
                'testing.txt', 
                'this is dassstat');
        }
exit;
        $this->info( json_encode($response, JSON_PRETTY_PRINT));
    }
}
