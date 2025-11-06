<?php

namespace App\Services;

use App\Services\AppSitesConfiguration\ChangeState\ArrayRemove;
use App\Services\AppSitesConfiguration\ChangeState\ArrayUpdate;
use App\Services\AppSitesConfiguration\SiteConfiguration;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use App\Services\AppContainerConfiguration\ContainerConfiguration;

/**
 *
 */
class AppConfiguration
{
    /**
     * @param $resultsFromTheQuestions
     * @return string
     */
    public function create($resultsFromTheQuestions): string
    {
        $manager = new HostingEnvironment();
        $manager->createBaseDirectory();
        $manager->createEnvironmentDirectories();
        $uniqueDomain = $resultsFromTheQuestions['default.domain'];
        if($manager->sitesEnvironmentDirectoriesCount($uniqueDomain) > 0) {
            return $uniqueDomain. ' unique domain already exists and can\'t be use.';
        }
        preg_replace('/[^a-zA-Z0-9.]/', '', $uniqueDomain);
        $manager->createSiteDirectories(strtolower($uniqueDomain));
        $manager->createSiteDefaultConfiguration($uniqueDomain);
        $this->update($uniqueDomain, $resultsFromTheQuestions);
        return "$uniqueDomain has been created successfully.";
    }

    /**
     * Update site arrays for configuration.
     *
     * @param string $siteName
     * @param array $arrayUpdates
     * @param string $environment
     * @return array
     */
    public function siteConfigurationUpdate(string $siteName, array $arrayUpdates, string $environment = 'all'): array
    {
        if( empty($arrayUpdates)) {
            return ["No updates were made to $siteName. The update array is broken."];
        }
        $siteArray = (new SiteConfiguration())->getSitesConfiguration($siteName);

        if(empty($siteArray)) {
            return ["No updates were made to $siteName as $siteName doesn't exit."];
        }

        if(empty($siteArray[$environment])) {
            return ["No updates were made to $siteName as $environment doesn't exit."];
        }
        // Update configuration.
        (new SiteConfiguration())->setDefaultConfiguration(
           (new ArrayUpdate())->update(
                $siteArray,
                $arrayUpdates, 
                $environment
            ) 
        );

        // Return response.
        if($environment != 'all') {
            return (new SiteConfiguration())->getSitesConfiguration($siteName)[$environment];
        }

        return (new SiteConfiguration())->getSitesConfiguration($siteName);
    }

    /**
     * @param string $siteName
     * @param array $arrayItemToRemoved
     * @param string $environment
     * @return array
     */
    public function siteConfigurationRemove(string $siteName, array $arrayItemToRemoved, string $environment): array
    {
        
        if(empty($arrayItemToRemoved)) {
            return ["No updates were made to $siteName. The update array is broken."];
        }
        
        // Remove configuration
        $siteArray = (new SiteConfiguration())->getSitesConfiguration($siteName);
       
        if(empty($siteArray)) {
            return ["No updates were made to $siteName as $siteName doesn't exit."];
        }

        if(empty($siteArray[$environment])) {
            return ["No updates were made to $siteName as $environment doesn't exit."];
        }

        $removeItem = new ArrayRemove($siteArray[$environment]['user'], $arrayItemToRemoved);
        $siteArray[$environment]['user'] = $removeItem->getResult();
        (new SiteConfiguration())->setDefaultConfiguration($siteArray);

        return (new SiteConfiguration())->getSitesConfiguration($siteName);

    }

    /**
     * Get all configuration for a siteName
     *
     * @param $siteName
     * @return array
     */
    public function getConfiguration($siteName): array
    {
        return (new SiteConfiguration())->getSitesConfiguration($siteName);
    }

    /**
     * Ge a list of all sites configuration
     *
     * @return array
     */
    public function getSiteConfigurationAll(): array
    {
        return (new SiteConfiguration())->getSiteConfigurationAll();
    }


    /**
     * Ge a list of all sites configuration
     *
     * @return array
     */
    public function getSiteConfigurationFind($data): array
    {
        return (new SiteConfiguration())->getSiteConfigurationFind($data);
    }


    /**
     * Get a list of all domains for all environments.
     *
     * @return array
     */    public function getListDomains(): array
    {
        return (new SiteConfiguration())->getListDomains();
    }

    /**
     * Build all containers for all sites.
     *
     * @return array
     */
    public function buildAllContainers(): array
    {
        return (new ContainerConfiguration())->generate('all');
    }
}
