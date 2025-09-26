<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;

/**
 * Class JsonRequestObject
 *
 * This class generates JSON request objects for multiple server names.
 *
 * @package App\Services\JsonRequestObject
 */
class JsonRequestObject
{
    
    /**
     * Generates the JSON request object for each server name in the array.
     *
     * @param array $dataArray
     * @return mixed
     */
    public function getResults(array $dataArray): mixed
    {
        $jsonData = json_encode($dataArray);

        $request = Request::create(
            '/', 
            'GET', 
            [],
            [], 
            [], 
            ['CONTENT_TYPE' => 'application/json'], 
            $jsonData 
        );

        // Create an instance of AppRestApi and get domain list
        $creation = new AppRestApi();
        return $creation->RequestHandler($request);
    }
}
