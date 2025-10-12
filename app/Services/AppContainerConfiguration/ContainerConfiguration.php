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

        $startStop = new StartStopGenerator();

        $request = (new JsonRequestObject())->getResults([
            'response_format' => 'raw',
            'request_type' => 'sites_config_all',
            'request_data' => 'all'
        ]);


        $dns = new DnsGenerator();
        $startStop->setPathAndFileNames($dns->fileName());
        $proxy = new ProxyGenerator();
        $proxy->setSitesHeaderConfiguration();
        $startStop->setPathAndFileNames($proxy->fileName());
        $debug = new DebugGenerator();
        $startStop->setPathAndFileNames($debug->fileName());
        $ai = new AI();
        $startStop->setPathAndFileNames($ai->fileName());
        
        $returnContainer = [];
        foreach ($request as $site) {
            // Proxy server
            $proxy->setSitesConfiguration($site,80);

            // DNS service
            $dns->setSitesDnsConfiguration($site,80);

            // Backend containers
            if($site['container'] == 'Apache') {
                $apache = new ApacheGenerator();
                $apache->setConfiguration($site,$this->usedPortNumber);

                $startStop->setPathAndFileNames($apache->fileName());
                $returnContainer[] = $apache->generateConfiguration();

            } elseif ($site['container'] == 'Drupal') {
                $returnContainer[] = 'Drupal';
            } else {
                $returnContainer[] = $site['unique_id'].' does not have a container';
            }

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
