<?php

namespace App\Services\AppSitesConfiguration\ChangeState;

/**
 * Class ArrayRemove
 * 
 * This class is responsible for unsetting 
 * items in the configuration. 
 */
class ArrayRemove
{

    /**
     * @var array $result
     */
    private array $result = [];

    /**
     * @param array $siteArray
     * @param array $arrayItemToRemove
     */
    public function __construct(array $siteArray, array $arrayItemToRemove) 
    {
        $this->result = $this->removeItems($siteArray, $arrayItemToRemove);
    }

    /**
     * Recursively matches the structure and value of $arrayItemToRemove in $siteArray,
     * and removes the matching value(s) the current configuration..
     * 
     * @param array $siteArray
     * @param array $arrayItemToRemove
     * @return array
     */
    private function removeItems(array $siteArray, array $arrayItemToRemove): array
    {
        foreach ($arrayItemToRemove as $key => $valueToRemove) {
            if (array_key_exists($key, $siteArray)) {
                if (is_array($valueToRemove) && is_array($siteArray[$key])) {
                    if (empty($valueToRemove)) {
                        unset($siteArray[$key]);
                    } else {
                        $siteArray[$key] = $this->removeItems($siteArray[$key], $valueToRemove);
                    }
                }
               
                elseif (is_array($siteArray[$key])) {
                    foreach ($siteArray[$key] as $subKey => $subVal) {
                        if ($subVal === $valueToRemove) {
                            unset($siteArray[$key][$subKey]);
                        }
                    }
                    
                    if (array_values($siteArray[$key]) === $siteArray[$key]) {
                        $siteArray[$key] = array_values($siteArray[$key]);
                    }
                }
                
                elseif ($siteArray[$key] === $valueToRemove) {
                    unset($siteArray[$key]);
                }
            }
        }
        return $siteArray;
    }

    /**
     * 
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}