<?php

namespace App\Services\AppContainerConfiguration;

use App\Services\AppContainerConfiguration\DockerCompose\AI;
use App\Services\AppContainerConfiguration\DockerCompose\ApacheGenerator;
use App\Services\AppContainerConfiguration\DockerCompose\DnsGenerator;
use App\Services\AppContainerConfiguration\DockerCompose\ProxyGenerator;
use App\Services\AppContainerConfiguration\DockerCompose\StartStopGenerator;
use App\Services\AppContainerConfiguration\DockerCompose\DebugGenerator;
use App\Services\JsonRequestObject;
use App\Services\AppDirectoryStructure\HostingEnvironment;

/**
 * Class ContainerConfiguration
 *
 * This class is responsible for generating Container Compose files using a generator class.
 *
 * @package App\Services\AppContainerConfiguration
 */
class ContainerConfiguration
{

    /**
     * List of ports already used.
     *
     * @var int
     */
    protected int $usedPortNumber = 7500;


    /**
     * Generate a Composer Compose file using a generator class.
     *
     * @param $type
     *   Setting up for different types of containerisation.
     * @param $dns
     *   Setting up for different types of dns configuration
     *
     * @return array
     */
    public function generate(string $type = 'docker_compose' , $dns = 'cordns'): array
    {

        // Request Json Object for configuration.
        $request = (new JsonRequestObject())->getResults([
            'response_format' => 'raw',
            'request_type' => 'site_configuration_all',
            'request_data' => 'all'
        ]);

        // Set file and path for each configuration file 
        // for start and stop scripts.
        $startStop = new StartStopGenerator();
        $dns = new DnsGenerator();
        $startStop->setPathAndFileNames($dns->fileName());
        $proxy = new ProxyGenerator();
        $proxy->setSitesHeaderConfiguration();
        $startStop->setPathAndFileNames($proxy->fileName());
        $debug = new DebugGenerator();
        $startStop->setPathAndFileNames($debug->fileName());
        $ai = new AI();
        $startStop->setPathAndFileNames($ai->fileName());

        // Configuration generation.
        $returnContainer = [];
        $proxyFlag = 0;
        foreach ($request as $site) {

            // Creation of backend containers that can be any type of 
            // service as it can communicate over port 80 or 443. 
            if($site['container'] == 'Apache') {
                $apache = new ApacheGenerator();
                $apache->setConfiguration($site,$this->usedPortNumber);
                $startStop->setPathAndFileNames($apache->fileName());
                $returnContainer[] = $apache->generateConfiguration();
                $proxyFlag = 1;

            } elseif ($site['container'] == 'Drupal') {
                $returnContainer[] = 'Drupal';

            } elseif ($site['container'] == 'Laravel') {
                $returnContainer[] = 'Laravel';

            } else {
                $returnContainer[] = $site['unique_id'].' does not have a container';

            }

            // Proxy flag needs to be set to 1 so that it can be added to proxy 
            // configuration. If it's added without a backed service it breaks
            // proxy service from working.
            if($proxyFlag == 1) {
                // Proxy server configuration.
                //$proxy->setSitesConfiguration($site,$this->usedPortNumber);
                $proxy->setSitesConfiguration($site,'80');
                $proxyFlag = 0;
            }
    
            // DNS service
            $dns->setSitesDnsConfiguration($site,$this->usedPortNumber);

            $this->usedPortNumber++;
        }

        return ['configuration' => [
            'ai' => $ai->generateConfiguration(),
            'dns' => $dns->generateConfiguration(),
            'proxy' => $proxy->generateConfiguration(),
            'apache' => $returnContainer,
            'start_stop' => $startStop->generateStartStopConfiguration(),
            'backup' => (new HostingEnvironment())->createContainerConfigBackup(),
            'debug' => $debug->generateConfiguration(),
        ]];
    }
}
