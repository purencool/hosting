<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

use Illuminate\Http\Request;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;
use App\Services\JsonRequestObject;
use App\Utilities\HostIP;

/**
 * Class DnsGenerator
 *
 * This class Dns configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationCreator
 */
class DnsGenerator extends Generator
{
    
    /**
     * An array of server names and their configurations.
     * 
     * This array need to create the following proxy configuration:
     * 
     * @example
     *
     * @var array
     */
    protected string $createdConfigration = '';

   /**
    * 
    */
    protected array $yamlArr = [
        'services' => [
            'coredns' => [
                'image' => 'coredns/coredns:latest',
                'container_name' => 'coredns',
                'command' => '-conf /etc/coredns/Corefile',
                'ports' => ['53:53/udp','53:53/tcp'],
                'volumes' => ['./:/etc/coredns', './:/zones:ro'],
                'networks' => ['shared_app_network_hosting'],
                'restart' => 'on-failure',
            ],
        ],           
        'networks' => [
            'shared_app_network_hosting' => [
                'external' => true,
            ],  
        ],

    ];



    /**
     * 
     */
    public function defaultConfiguration() : string
    {
        $ip = (new HostIP())->get();

        $zone =  <<<EOT
\$TTL 3600
@   IN SOA ns1.example.local. admin.example.local. (
        2025092301 ; serial
        3600
        600
        604800
        3600 )
    IN NS ns1.example.local.
ns1 IN A $ip 

@   IN A $ip 
www IN A $ip        
EOT;       

        (new HostingEnvironment())->updateContainerFiles('dns', 'example.local.db', $zone);

        $config =  <<<EOT
example.local:53 {
    file /zones/example.local.db
    log
    errors
}

$this->createdConfigration

.:53 {
    forward . 1.1.1.1 1.1.1.1
    cache 30
    log
    errors
}

EOT;

        (new HostingEnvironment())->updateContainerFiles('dns', 'Corefile', $config);

        return $config;
    }


    /**
     * 
     */
    public function setSitesDnsConfiguration(array $appConfig, string $port = "8500") : void
    {
        $uniqueId = $appConfig['unique_id'];
        $domains = $appConfig['domains'];
        $this->createdConfigration .=  <<<EOT

$domains:53 {
    file  /zones/$domains.db
    log
    errors
}

EOT;
        $ip = (new HostIP())->get();
        $config =  <<<EOT
\$TTL 3600
@   IN SOA ns1.$domains. admin.$domains. (
        2025092301 ; serial
        3600
        600
        604800
        3600 )
    IN NS ns1.$domains.
ns1 IN A $ip

@   IN A $ip
$domains. IN A $ip

EOT;

        (new HostingEnvironment())->updateContainerFiles('dns', "$domains.db", $config);
    
    }
  
    /**
     * Generates the configuration for each server name in the array.
     *
     * @return array
     */
    public function generateConfiguration(): array
    {
        return [
            'configuration' => $this->defaultConfiguration(),
            'container' => $this->containerYamlCreation('dns', 'docker-composer_dns.yml', $this->yamlArr), 
        ];
    }

    
    /**
     * @inherit
     */
    public function fileName():string 
    {
        return 'dns/docker-composer_dns.yml';
    }
}
