<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

use Illuminate\Http\Request;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;
use App\Services\JsonRequestObject;

/**
 * Class ApacheGenerator
 *
 * This class Apache configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationCreator
 */
class ApacheGenerator extends Generator
{
       
    /*
     *
     */
    protected array $createdConfigration;

    /**
     * 
     */
    protected string $appName;

    /**
     * 
     */
    public function setConfiguration(array $appConfig, string $port = "8500") : void
    {
        
        $uniqueId = $appConfig['unique_id'];
        $this->appName = 'docker-composer_'.$uniqueId.'.yml';
        $volumes = $appConfig["dir_web"]; 
  
        $yamlArr = [
         'services' => [
                $uniqueId => [
                    'image' => 'httpd:alpine3.22',
                    'container_name' => "apache_$uniqueId",
                    'ports' => [''. $port .':80'],
                    'volumes' => [''. $volumes.':/usr/local/apache2/htdocs'],
                    'networks' => ['shared_app_network_hosting']
                ],
            ],
            'networks' => [
                'shared_app_network_hosting' => [
                    'external' => true,
                ],  
            ],
        ];

        $this->createdConfigration = [
            'container' => $this->containerYamlCreation('apache',$this->appName, $yamlArr), 
        ];
    }

    /**
     * Generates the configuration for each server name in the array.
     *
     * @return array
     */
    public function generateConfiguration(): array
    {
        return $this->createdConfigration;
    }

    /**
     * @inherit
     */
    public function fileName():string 
    {
        return "apache/$this->appName";
    }
}
