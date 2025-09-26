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
 * @package App\Services\AppConfigurationCreator
 */
class Generator implements GeneratorInterface
{
    /**
     * An string directory name.
     *
     * @var $directory
     */
    protected string $directory = 'default';
    
    /**
     * An array for the server and configurations.
     *
     * @var array
     */
    protected array $config = [];

    /**
     * 
     * Yaml configuration file.
     * 
     */
    protected array $yamlArr = [];

    /**
     * Recursively creates configuration blocks from an associative array.
     *
     * @param array $config The configuration array.
     * @param int $indentLevel The current indentation level.
     * @return string The generated Nginx configuration block.
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
     * Create the configuration for the Nginx server.
     * 
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
     * Create yaml server configuration.
     * 
     * @return array
     */
    public function containerYamlCreation($directory, $fileName, $yamlArr): array
    {
        $config = Yaml::dump($yamlArr, 4, 2, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
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
