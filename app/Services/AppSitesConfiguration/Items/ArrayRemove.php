<?php

namespace App\Services\AppSitesConfiguration\Items;


/**
 * Represents a site configuration.
 */
class ArrayRemove
{
    /**
     * @var array
     */
    private array $array = [];

    /**
     * @param array $array
     * @return $this
     */
    public function setArray(array $array): static
    {
        $this->array = $array;
        return $this;
    }

    /**
     * @param array $path
     * @param $childKeyToUnset
     * @return $this
     */
    public function remove(array $path, $childKeyToUnset): static
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

    /**
     * @return array
     */
    public function getArray(): array
    {
        return $this->array;
    }
}
