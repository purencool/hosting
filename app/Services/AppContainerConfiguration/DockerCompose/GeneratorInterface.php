<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

/**
 * Class ProxyGenerator
 *
 * This class generates proxy configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationConfigration\DockerCompose
 */
interface GeneratorInterface
{
    public function fileName():string;
}
