<?php

namespace App\Utilities;

/**
 * Class Host IP
 */
class HostIP
{
    
    /**
     * 
     */
    protected function getLocalIPs(): array 
    {
        $ips = [];
        $ifaces = shell_exec("hostname -I 2>/dev/null");
        if ($ifaces) {
            foreach (preg_split('/\s+/', trim($ifaces)) as $ip) {
                if ($ip !== '') $ips[] = $ip;
            }
        }
        return $ips;
    }
    
    
    /**
     * 
     */
    public function get()
    {
       return $this->getLocalIPs()[0];
    }
}
