<?php

namespace TwoThirds\ArtisanAnywhere\Shims;

use Orchestra\Testbench\Traits\CreatesApplication;

class TraitApplicationCreator extends BaseApplicationCreator
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
