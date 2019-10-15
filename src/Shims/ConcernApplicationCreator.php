<?php

namespace TwoThirds\ArtisanAnywhere\Shims;

use Orchestra\Testbench\Concerns\CreatesApplication;
use TwoThirds\ArtisanAnywhere\Shims\BaseApplicationCreator;

class ConcernApplicationCreator extends BaseApplicationCreator
{
    use CreatesApplication;
}
