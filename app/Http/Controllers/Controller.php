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
     * Array keys for json request.
     */
    private $switchArr = [
       'build_containers',
       'site_configuration',
       'site_configuration_all',
       'site_configuration_find',
       'site_configuration_list',
       'site_configuration_remove',
       'site_configuration_replace',
       'site_configuration_update',
       'site_creation',
       'site_list_domains'

    ];

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
            case $this->switchArr[0]:
                $return = $config->buildAllContainers();
                break;
               
            case $this->switchArr[1]:
                $return = $config->getConfiguration(
                    $default['request_data']['default.domain'],
                );
                break;
                
            case $this->switchArr[2]:
                $return = $config->getSiteConfigurationAll();
                break;
  
            case $this->switchArr[3]:
                $return = $config->getSiteConfigurationFind($default['request_data']);   
                break;

            case $this->switchArr[4]:
                $return = $config->getSitesConfigList(); 
                break;

            case $this->switchArr[5]:
                $return = $config->siteConfigurationRemove(
                    $default['request_data']['default.domain'],
                    $default['request_data']['user'],
                    $default['request_data']['environment'],
                );
                break;    
                
            case $this->switchArr[6]:
               $return = ['Replace Configuration'];
               // $return = $config->siteConfigurationReplace(
               //     $default['request_data']['default.domain'],
               //     $default['request_data']['user'],
               //     $default['request_data']['environment'],
               // );
                break;

            case $this->switchArr[7]:
                $return = $config->siteConfigurationUpdate(
                    $default['request_data']['default.domain'],
                    $default['request_data']['user'],
                    $default['request_data']['environment'],
                );
                break;    
                
            case $this->switchArr[8]:
                $requestreturn = $config->create($default['request_data']);
                break;    
            
            case $this->switchArr[9]:
                $return = $config->getListDomains();
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
