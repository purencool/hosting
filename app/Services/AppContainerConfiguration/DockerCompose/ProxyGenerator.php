<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

use Illuminate\Http\Request;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;
use App\Services\JsonRequestObject;
use Symfony\Component\Yaml\Yaml;
use App\Utilities\HostIP;

/**
 * Class ProxyGenerator
 *
 * This class generates proxy configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationCreator
 */
class ProxyGenerator extends Generator
{
    
    /**
     * An array of server names and their configurations.
     * 
     * This array need to create the following proxy configuration:
     * 
     * @example
     * ```
     *  server {
     *    listen 80;
     *    server_name <domaian1> <domain2>;
     *    location / {
     *       proxy_pass <domain proxy>:<port>;
     *       proxy_set_header Host $host;
     *       proxy_set_header X-Real-IP $remote_addr;
     *     }
     *   }
     * ```
     *
     * @var array
     */
    protected string $createdConfigration = '';

   /**
    * 
    */
   protected array $proxyYamlArr = [
        'services' => [
            'nginx' => [
                'image' => 'nginx:latest',
                'ports' => ['80:80'],   
                'networks' => ['shared_app_network_hosting'],
                'volumes' => ['./../proxy/nginx.conf:/etc/nginx/conf.d/default.conf:ro'],
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
    public function setSitesConfiguration(array $appConfig, string $port = "8500") : void
    {
        $uniqueId = $appConfig['unique_id'];
        $domains = $appConfig['domains'];
        $this->createdConfigration .=  <<<EOT
server {
    listen 80; 
    listen [::]:80; # IPV6 needed for local request
    server_name $domains;

    location / {
        proxy_pass http://$uniqueId:$port;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
    }
} 

server {
    listen 443;
    listen [::]:443; # IPV6 needed for local request
    server_name $domains;

    location / {
        proxy_pass http://$uniqueId:$port;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
    }
} 

##
# Domains $domains
##

EOT;
    }

    /**
     * Generates the configuration for each server name in the array.
     *
     * @return array
     */
    public function generateConfiguration(): array
    {
       //$ip = (new HostIP())->get();
       //$this->proxyYamlArr['services']['nginx']['ports'] = [
       //   '80:80',
       //   "$ip:80:80/tcp"
       //];   
       
        (new HostingEnvironment())->updateContainerFiles('proxy', 'nginx.conf', $this->createdConfigration);
        return [
            'proxy' => $this->createdConfigration,
            'container' => $this->containerYamlCreation('proxy','docker-composer_proxy.yml', $this->proxyYamlArr),
        ];
    }

    /**
     * @inherited
     */
    public function fileName():string 
    {
        return 'proxy/docker-composer_proxy.yml';
    }
}
