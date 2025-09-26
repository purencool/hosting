<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;


/**
 * Class DebugGenerator
 *
 * This class Debug configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationCreator
 */
class DebugGenerator extends Generator
{
       
  /**
    *  
    */
   protected array $proxyYamlArr = [
        'services' => [
            'debug' => [
                'image' => 'busybox:latest', 
                'command' => 'sleep 3600', 
                'networks' => ['shared_app_network_hosting'],
                'restart' => 'no'
            ],
        ],
        'networks' => [
           'shared_app_network_hosting' => [
                'external' => true,
            ],  
        ],
    ];

    /**
     * Generates the configuration for each server name in the array.
     *
     * @return array
     */
    public function generateConfiguration(): array
    {
        return [
            'container' => $this->containerYamlCreation('debug','docker-composer_debug.yml', $this->proxyYamlArr),
        ];
    }


    /**
     * @inherit
     */
    public function fileName():string 
    {
        return 'debug/docker-composer_debug.yml';
    }
}
