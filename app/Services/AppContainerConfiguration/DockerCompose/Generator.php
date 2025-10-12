<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

use Illuminate\Http\Request;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;
use App\Services\JsonRequestObject;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Generator
 *
 * This class generates configuration for multiple server.
 *
 * @package App\Services\AppConfigurationConfigration\DockerCompose
 */
class Generator implements GeneratorInterface
{
    /**
     * @var string
     */
    protected string $directory = 'default';

    /**
     * An array for the server and configurations.
     *
     * @var array
     */
    protected array $config = [];

    /**
     * Yaml configuration file.
     *
     * @var array
     */
    protected array $yamlArr = [];

    /**
     * Recursively creates configuration blocks from an associative array.
     *
     * @param array $config
     * @param int $indentLevel
     * @return string
     */
    protected function createConfigBlock(array $config, int $indentLevel = 0): string
    {
        $indent = str_repeat('    ', $indentLevel);
        $pConfig = '';

        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $pConfig .= "{$indent}{$key} {\n";
                $pConfig .= $this->createConfigBlock($value, $indentLevel + 1);
                $pConfig .= "{$indent}}\n";
            } else {
                $pConfig .= "{$indent}{$key} {$value}\n";
            }
        }

        return $pConfig;
    }


    /**
     * Creates service configuration.
     *
     * @param $directory
     * @param $fileName
     * @param $config
     * @return array
     */
    public function configCreation($directory, $fileName, $config): array
    {
        $configString = '';
        $configString .= $this->createConfigBlock($config);

        (new HostingEnvironment())->updateContainerFiles($directory, $fileName, $configString);

        return [
            'config_file' => $fileName,
            'config' => $configString,
        ];
    }


    /**
     * Creates yaml files
     *
     * @param $directory
     * @param $fileName
     * @param $yamlArr
     * @return array
     */
    public function containerYamlCreation($directory, $fileName, $yamlArr): array
    {
        $config = Yaml::dump($yamlArr, 4, 2, Yaml::DUMP_OBJECT_AS_MAP);
        (new HostingEnvironment())->updateContainerFiles($directory, $fileName, $config);
        return [];
    }

    /**
     * @inherit
     */
    public function fileName():string
    {
        return 'generator';
    }

}
