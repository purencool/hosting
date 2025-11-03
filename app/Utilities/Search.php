<?php

namespace App\Utilities;

/**
 * Class Search
 */
class Search
{
    
    /**
     * 
     */
    protected function searchMultidimensionalArray($searchValue, $array, $currentPath = []) {
    $results = [];

    foreach ($array as $key => $value) {
        $newPath = array_merge($currentPath, [$key]);

        if (is_array($value)) {
            $nestedResults = $this->searchMultidimensionalArray($searchValue, $value, $newPath);
            $results = array_merge($results, $nestedResults);
        } elseif ($value === $searchValue) {
            $results[] = $newPath;
        }
    }
    return $results;
}
    
    
    /**
     * 
     */
    public function get($searchValue, $value)
    {
        return $this->searchMultidimensionalArray($searchValue, $value);
    }
}
