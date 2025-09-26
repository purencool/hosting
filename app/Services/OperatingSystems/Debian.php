<?php

namespace App\Services\OperatingSystems;

use Illuminate\Support\Facades\Artisan;

class Debian
{

    /**
     * @param $password
     * @param $command
     * @return void
     */
    protected function shellExec($password, $command): void
    {
        $run = "echo $password | sudo -S $command";
        shell_exec($run);
    }

    /**
     * Install UpdateOS software.
     *
     * @param string $password
     * @return string
     */
    public function updateOSSoftware( string $password ): string
    {
        $this->shellExec($password, 'apt update');
        return 'updated';
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
     * @return string
     */
    public function installLampSoftware(): string
    {
      //Artisan::call('command:');
     // Artisan::output();
        return 'Updated';
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
