<?php

namespace TwoThirds\ArtisanAnywhere\Shims;

use Orchestra\Testbench\Traits\CreatesApplication;
use TwoThirds\ArtisanAnywhere\Shims\BaseApplicationCreator;

class TraitApplicationCreator extends BaseApplicationCreator
{
    use CreatesApplication;
}
