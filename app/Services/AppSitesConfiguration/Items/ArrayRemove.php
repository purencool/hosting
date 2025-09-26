<?php

namespace App\Services\AppSitesConfiguration\Items;


/**
 * Represents a site configuration.
 */
class ArrayRemove
{
    private $array = [];

    public function setArray(array $array)
    {
        $this->array = $array;
        return $this;
    }

    public function remove(array $path, $childKeyToUnset)
    {
        $ref =& $this->array;
        foreach ($path as $key) {
            if (isset($ref[$key]) && is_array($ref[$key])) {
                $ref =& $ref[$key];
            } else {
                // Path does not exist; nothing to do
                return $this;
            }
        }
        unset($ref[$childKeyToUnset]);
        return $this;
    }

    public function getArray()
    {
        return $this->array;
    }
}
