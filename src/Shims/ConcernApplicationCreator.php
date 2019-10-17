<?php

namespace TwoThirds\ArtisanAnywhere\Shims;

use Orchestra\Testbench\Traits\CreatesApplication;

class ConcernApplicationCreator extends BaseApplicationCreator
{
    use CreatesApplication;

    /**
     * {@inheritdoc}
     */
    protected function getApplicationProviders($app)
    {
        return parent::getApplicationProviders($app);
    }
}
