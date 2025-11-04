<?php

namespace App\Services\AppSitesConfiguration\Items;


use App\Services\AppSitesConfiguration\SiteConfiguration;

/**
 * Represents a site configuration.
 */
class ArrayUpdate
{
    /**
     * Update site arrays for configuration.
     *
     * @param array $siteArray
     * @param array $arrayUpdates
     * @param string $environment
     * @return array
     */
    public function update( array $siteArray, array $arrayUpdates, string $environment = 'all'): array
    {

        if($environment == 'all') {
            foreach($siteArray as $siteKey => $site) {
                $siteArray[$siteKey]['user'] = array_merge_recursive($siteArray[$siteKey]['user'], $arrayUpdates);
            }
        } else {

            $siteArray[$environment]['user'] = array_merge_recursive($siteArray[$environment]['user'], $arrayUpdates);
        }
        return $siteArray;
    }


  //  function updateConfig(&$config, $keys, $newValue) {
  //  if (is_array($keys)) {  // multiple levels deep
  //    foreach($keys as $key) {  
  //         updateConfig($config[$key], $keys, $newValue);  
  //    }       
  //  } else {  // single level key
  //       $config = $newValue;    
  //  }  
  //}
}
