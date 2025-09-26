<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Services\AppConfiguration;


/**
 * Class Controller
 *
 * This is the base controller class that other controllers extend.
 *
 * It includes methods for handling API requests and routing them to the appropriate services.
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
    * Handle incoming API requests.
    */
    public function RequestAPI(Request $request)
    {
       return $this->RequestHandler($request);
    }

    /**
    * Handle incoming requests. 
    */
    public function RequestHandler(Request $request)
    {
        $default = $request->json()->all();
        if (!isset($default['request_type'])) {
            return response()->json(['status' => 'error', 'message' => 'No type specified.'], 400);
        }

        if (!isset($default['response_format'])) {
            $default['response_format'] = "json";
        }
           
        $config = new AppConfiguration();
        switch ($default['request_type']) {   
            case 'build_containers':
                $return = $config->buildAllContainers();
                break;
               
            case 'sites_config':
                $return = $config->getConfiguration(
                    $default['request_data']['default.domain'],
                );
                break;
                
            case 'sites_config_all':
                $return = $config->getAllSitesConfiguration();
                break;

            case 'sites_creation':
                $return = $config->create($default['request_data']);
                break;    
            
            case 'sites_list_config':
                $return = $config->getSitesConfigList();
                break;

            case 'sites_list_domains':
                $return = $config->getListDomains();
                break;
                
            case 'sites_item_update':
                $return = $config->update(
                    $default['request_data']['default.domain'],
                    $default['request_data']['user'],
                    $default['request_data']['environment'],
                );
                break;

            default:
                return response()->json(['status' => 'error', 'message' => 'Not able complete action.'], 400);
        }

        if ($default['response_format'] === "json") {
            return response()->json($return);
        }
        return $return;
    }
}
