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
 * @package App\Services\AppConfigurationConfigration\DockerCompose
 */
class ProxyGenerator extends Generator
{

    /**
     *
     * This array need to create the following proxy configuration:
     *
     * @example
     * ```
     *  server {
     *    listen 80;
     *    server_name <domain1> <domain2>;
     *    location / {
     *       proxy_pass <domain proxy>:<port>;
     *       proxy_set_header Host $host;
     *       proxy_set_header X-Real-IP $remote_addr;
     *     }
     *   }
     * ```
     *
     * @var string
     */
    protected string $createdConfiguration = '';

    /**
     * @var array|\array[][]
     */
   protected array $proxyYamlArr = [
        'services' => [
            'nginx' => [
                'image' => 'nginx:latest',
                'container_name' => "proxy_services",
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
     * @param array $appConfig
     * @param string $port
     * @return void
     */
    public function setSitesConfiguration(array $appConfig, string $port = "8500") : void
    {
        $uniqueId = $appConfig['unique_id'];
        $domains = $appConfig['domains'];
        $this->createdConfiguration .=  <<<EOT
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
     * @return array
     */
    public function generateConfiguration(): array
    {
        (new HostingEnvironment())->updateContainerFiles('proxy', 'nginx.conf', $this->createdConfiguration);
        return [
            'proxy' => $this->createdConfiguration,
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
