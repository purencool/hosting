<?php

namespace App\Services\OperatingSystems;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class Fedora
{
    /**
     * Install UpdateOS software.
     *
     * @return bool
     */
    public function installUpdateOSSoftware(): bool
    {
        Artisan::call('command:');
        return true;
    }


    /**
     * Install base software.
     *
     * @return bool
     */
    public function installBaseSoftware(): bool
    {
        Artisan::call('command:');
        return true;
    }

    /**
     * Install Lamp software.
     *
     * @return bool
     */
    public function installLampSoftware(): bool
    {
        Artisan::call('command:');
        return true;
    }

    /**
     * Install LNMP software.
     *
     * @return bool
     */
    public function installLNMPSoftware(): bool
    {
        Artisan::call('command:');
        return true;
    }


    /**
     * Install LocalDNS software.
     *
     * @return bool
     */
    public function installLocalDNSSoftware(): bool
    {
        Artisan::call('command:');
        return true;
    }

    /**
     * Install LocalDNS software.
     *
     * @return bool
     */
    public function installVarnishSoftware(): bool
    {
        Artisan::call('command:');
        return true;
    }
}
