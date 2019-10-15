<?php

namespace TwoThirds\ArtisanAnywhere\Shims;

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
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Define your environment setup.
    }
}
