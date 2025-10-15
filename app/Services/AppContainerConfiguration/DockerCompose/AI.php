<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

/**
 * Class AI
 *
 * This class AI builds the configuration for AI.
 *
 * @package App\Services\AppConfigurationConfigration\DockerCompose
 */
class AI extends Generator
{

    /**
     * Generates the configuration for each server name in the array.
     *
     * @return array
     */
    public function generateConfiguration(): array
    {
         /**
     * @var array|\array[][]
     */
    $proxyYamlArr = [
        'services' => [
            'ollama' => [
                'image' => 'ollama/ollama',
                'container_name' => 'ollama',
                'ports' => ['11434:11434'],
                'volumes' => ['ollama_models:/root/.ollama'],
                'networks' => ['shared_app_network_hosting'],
                'restart' => 'always',
            ],
            'open-webui' => [
                'image' => 'ghcr.io/open-webui/open-webui:main',
                'container_name' => 'open-webui',
                'ports' => ['8080:8080'],
                'environment' => ['OLLAMA_BASE_URL=http://ollama:11434'],
                'volumes' => ['open-webui_data:/app/backend/data'],
                'depends_on' => ['ollama'],
                'networks' => ['shared_app_network_hosting'],
                'restart' => 'always',
            ],
        ],
        'volumes' => [
            'ollama_models'   => new \stdClass(),
            'open-webui_data' => new \stdClass(),
        ],
        'networks' => [
           'shared_app_network_hosting' => [
               'external' => true,
            ],
        ],
    ];

        return [
            'container' => $this->containerYamlCreation('ai','docker-composer_ai.yml',  $proxyYamlArr),
        ];
    }


    /**
     * @inherit
     */
    public function fileName():string
    {
        return 'ai/docker-composer_ai.yml';
    }
}
