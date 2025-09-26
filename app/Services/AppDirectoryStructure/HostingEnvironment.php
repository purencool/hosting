<?php

namespace App\Services\AppDirectoryStructure;

use App\Services\AppSitesConfiguration\SiteConfiguration;
use App\Services\EnvironmentVariables;

/**
 * Class HostingEnvironmentManager
 *
 * Handles retrieval of hosting environment variables and directory creation.
 *
 * @package App\Services
 */
class HostingEnvironment
{
    /**
     * @var object
     */
    protected object $envVar;

    /**
     *
     */
    public function __construct(){
      $this->envVar = new EnvironmentVariables();
    }

    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createBaseDirectory(): bool
    {
        if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath())) {
            return mkdir($this->envVar->getHostingSiteBaseDirectoryPath());
        }
        return true;
    }

    /**
     * Destroy a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function destroyBaseDirectory(): bool
    {
        if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath())) {
            return rmdir($this->envVar->getHostingSiteBaseDirectoryPath());
        }
        return true;
    }

    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createConfigDirectory(): bool
    {
        if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/config")) {
            return mkdir($this->envVar->getHostingSiteBaseDirectoryPath()."/config");
        }
        return true;
    }

    /**
     * Destroy a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function destroyConfigDirectory(): bool
    {
        if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/config")) {
            return rmdir($this->envVar->getHostingSiteBaseDirectoryPath()."/config");
        }
        return true;
    }


    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createContainersDirectory(): bool
    {
        if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/config/containers")) {
            return mkdir($this->envVar->getHostingSiteBaseDirectoryPath()."/config/containers");
        }
        return true;
    }

    /**
     * Get the path to the containers directory.
     *
     * @return string
     */
    public function getContainersDirectoryPath(): string
    {
        return $this->envVar->getHostingSiteBaseDirectoryPath()."/config/containers";
    }

    /**
     * Destroy a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function destroyContainersDirectory(): bool
    {
        if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/config/containers")) {
            return rmdir($this->envVar->getHostingSiteBaseDirectoryPath()."/config/containers");
        }
        return true;
    }

    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createContainersBackupDirectory(): bool
    {
        if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/config/backup")) {
            return mkdir($this->envVar->getHostingSiteBaseDirectoryPath()."/config/backup");
        }
        return true;
    }

    /**
     * Get the path to the containers directory.
     *
     * @return string
     */
    public function getContainersBackupDirectoryPath(): string
    {
        return $this->envVar->getHostingSiteBaseDirectoryPath()."/config/backup";
    }

    /**
     * Destroy a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function destroyContainersBackupDirectory(): bool
    {
        if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/config/backup")) {
            return rmdir($this->envVar->getHostingSiteBaseDirectoryPath()."/config/backup");
        }
        return true;
    }

    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createEnvironmentDirectories(): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment)) {
                 mkdir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment);
            }
        }
        return true;
    }

    /**
     * Destroy a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function destroyEnvironmentDirectories(): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment)) {
                rmdir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment);
            }
        }
        return true;
    }

    /**
     * Count if sites are in environment.
     *
     * @param string $siteName
     * @return int
     */
    public function sitesEnvironmentDirectoriesCount(string $siteName): int
    {
        $siteNameCount = 0;
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment)) {
                if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment."/" . $siteName)) {
                   $siteNameCount++;
                }
            }
        }
        return $siteNameCount;
    }

    /**
     * Create site directories.
     *
     * @param string $siteName
     * @return bool
     */
    public function createSiteDirectories(string $siteName): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName)) {
                mkdir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName);
            }
        }
        return true;
    }

    /**
     * Destroy site directories.
     *
     * @param string $siteName
     * @return bool
     */
    public function destroySiteDirectories(string $siteName): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName)) {
                rmdir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName);
            }
        }
        return true;
    }

    /**
     * Create site configuration.
     *
     * @param string $siteName
     * @return bool
     */
    public function createSiteDefaultConfiguration(string $siteName): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (!is_file($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName)) {
                (new siteConfiguration())->createDefaultConfiguration(
                    $siteName,
                    $environment,
                );
            }
        }
        return true;
    }

    /**
     * Create backup of container configuration.
     *  
     * @return array 
     */
    public function createContainerConfigBackup() : array
    {
        $sourceDir = $this->getContainersDirectoryPath(); 
        $destinationDir = $this->getContainersBackupDirectoryPath(); 

        // Generate a timestamped name for the compressed archive
        $timestamp = date('Ymd_His'); 
        $archiveName = basename($sourceDir) . '_' . $timestamp . '.zip';
        $tempArchiveFilePath = sys_get_temp_dir() . '/' . $archiveName;
        $finalArchiveFilePath = $destinationDir . '/' . $archiveName;

        // Ensure destination directory exists
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0777, true);
        }

        // Create a ZIP archive
        $zip = new \ZipArchive();
        if ($zip->open($tempArchiveFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {

            // Lamba function to add files and directories recursively
            $addFilesToZip = function ($dir, $baseDir = '') use (&$zip, &$addFilesToZip) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );

                foreach ($files as $file) {
                    $relativePath = str_replace($baseDir, '', $file->getPathname());
                    if ($file->isDir()) {
                        $zip->addEmptyDir($relativePath);
                    } else if ($file->isFile()) {
                        $zip->addFile($file->getPathname(), $relativePath);
                    }
                }
            };

            $addFilesToZip($sourceDir, $sourceDir . '/');
            $zip->close();
            $return[] = ["Directory compressed successfully to: " . $tempArchiveFilePath ];

            // Move the compressed archive to the final destination
            if (rename($tempArchiveFilePath, $finalArchiveFilePath)) {
                $return[] = ["Compressed archive moved to: " . $finalArchiveFilePath];
            } else {
                $return[] = ["Error moving the compressed archive."];
                unlink($tempArchiveFilePath); 
            }
        } else {
            $return[] = ["Error creating ZIP archive."];
        }
        return $return;
    }

    /**
     * Update and backup container Files.
     *
     * @param string $directory
     * @param string $fileName
     * @param string $data
     * @return array 
     */
    public function updateContainerFiles($directory,$fileName,$data) : array
    {
       
        $dirPath = $this->getContainersDirectoryPath(); 
        if(!is_dir($dirPath.'/'.$directory)){
            mkdir($dirPath.'/'.$directory);
        }
     
        file_put_contents($dirPath.'/'.$directory.'/'.$fileName, $data);
        return ['Configuration update to '.$fileName];
    }
}
