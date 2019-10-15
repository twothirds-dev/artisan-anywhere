<?php

namespace TwoThirds\ArtisanAnywhere\Shims;

use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;

abstract class BaseApplicationCreator
{
    /**
     * Creates and returns an application
     *
     * @return \Illuminate\Foundation\Application
     */
    public function create()
    {
        return $this->createApplication();
    }

    /**
     * Define environment setup.
     *     This method is requred for the testbench CreatesApplication
     *
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param mixed $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Define your environment setup.
    }

    /**
     * Get application providers.
     *
     * @param \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getApplicationProviders($app)
    {
        $providers = $app['config']['app.providers'];

        foreach ($providers as $key => $provider) {
            if ($provider === ConsoleSupportServiceProvider::class) {
                unset($providers[$key]);
            }
        }

        return $providers;
    }
}
