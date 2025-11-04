<?php

namespace App\Utilities;

/**
 * Class Search
 * 
 * Finds end point in array and shows the end user where it's postitioned.
 * 
 */
class Search
{
    
    /**
     * inputArray
     */
    protected array $inputArray = [];

    /**
     * Description
     * 
     * @param string $searchValue 
     * @param array $searchArray
     * @param array $currentPath 
     * 
     * @return array
     */
    protected function searchMultidimensionalArray($searchValue,  array $searchArray,  $currentPath = []) : array
    {   
        $results  =  [];    
        
        foreach ($searchArray as $key => $value) {
            $newPath = array_merge($currentPath, [$key]);
            if (is_array($value)) { 
                $nestedResults =  $this->searchMultidimensionalArray($searchValue, $value, $newPath);
                foreach ($nestedResults as &$result) {  
                    $results[] =  $result; 
             }
            } elseif ($value === $searchValue) {
                $itemNum =$newPath[0];
                $domain = $this->inputArray[$itemNum]['system']['system']['default.domain'];
                $enviroment = $this->inputArray[$itemNum]['system']['system']['environment'];
                $results[] = [ 
                   'results' => "domain:$domain, environment:$enviroment, path:" . implode(' -> ', $newPath) . ' -> '. $searchValue,
                   'results_raw' => $newPath,
                   'input' => $this->inputArray[$itemNum]['system']['system']
                ];
            }   
        } 
    
        return $results;         
    }  
    
    
    /**
     * 
     * 
     * @return array
     */
    public function get($searchValue, $inputArray) : array
    {
        $this->inputArray = $inputArray;
        return $this->searchMultidimensionalArray($searchValue, $inputArray);
    }
}
