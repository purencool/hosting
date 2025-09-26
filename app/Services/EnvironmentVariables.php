<?php

namespace App\Services;

use Illuminate\Support\Facades\App;

class EnvironmentVariables
{

    /**
     * Operating system.
     *
     * @return string
     */
    public function getHostingOS(): string
    {
        return env('HOSTING_SITE_OS', '');
    }

    /**
     * Hosting environments string.
     *
     * @return string
     */
    public function getHostingSiteEnvironments(): string
    {
        return env('HOSTING_SITE_ENVIRONMENTS', '');
    }

    /**
     * Hosting an environment array.
     *
     * @return array
     */
    public function getHostingSiteEnvironmentsArray(): array
    {
        $hostEnvironments = explode(',', $this->getHostingSiteEnvironments());
        return is_array($hostEnvironments) ? $hostEnvironments : [];
    }

    /**
     * Base path for site installation
     *
     * @return string
     */
    public function getHostingSiteBaseDirectory(): string
    {
        return env('HOSTING_SITE_DEFAULT_PATH', 'default_path');
    }

    /**
     * Get the default hosting site path from the environment.
     *
     * @return string
     */
    public function getHostingSiteBaseDirectoryPath(): string
    {
        return app_path(
            "/../../". $this->getHostingSiteBaseDirectory()
        );
    }

    /**
     * Default hosting domain.
     *
     * @return string
     */
    public function getHostingDomain(): string
    {
        return env('HOSTING_DEFAULT_DOMAIN', '');
    }
}
