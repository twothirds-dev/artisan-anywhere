<?php

namespace TwoThirds\ArtisanAnywhere;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\Kernel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Orchestra\Testbench\Concerns\CreatesApplication;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use NunoMaduro\Collision\Adapters\Laravel\CollisionServiceProvider;

class Artisan
{
    use CreatesApplication;

    /**
     * Application instance
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Kernel instance
     *
     * @var \Illuminate\Foundation\Console\Kernel
     */
    protected $kernel;

    /**
     * Boots Artisan for packages
     *
     * @param \Illuminate\Foundation\Application|null $app
     * @param string $basePath
     */
    public function __construct(Application $app = null, string $basePath = __DIR__)
    {
        $this->app = $app ?? $this->createApplication()
            ->setBasePath($basePath);

        $this->app->register(CollisionServiceProvider::class);

        $this->kernel = $this->app->make(Kernel::class);
    }

    /**
     * Get the application
     *
     * @return Illuminate\Foundation\Application
     */
    public function getApplication()
    {
        return $this->app;
    }

    /**
     * Get the kernel
     *
     * @return Illuminate\Foundation\Console\Kernel
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Handle the input and terminate
     *
     * @param \Symfony\Component\Console\Input\InputInterface|null $input
     * @param \Symfony\Component\Console\Output\OutputInterface|null $output
     *
     * @return int
     */
    public function handle(InputInterface $input = null, OutputInterface $output = null)
    {
        $status = $this->kernel->handle(
            $input,
            $output ?? new ConsoleOutput
        );

        $this->kernel->terminate($input, $status);

        return $status;
    }

    /**
     * Register a command with the kernel
     *
     * @param mixed $command
     *
     * @return $this
     */
    public function registerCommand($command)
    {
        $this->kernel->registerCommand(
            is_string($command) ? app($command) : $command
        );

        return $this;
    }

    /**
     * Register an array of commands with the kernel
     *
     * @param array $commands
     *
     * @return $this
     */
    public function registerCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->registerCommand($command);
        }

        return $this;
    }

    /**
     * Set a config in the app
     *
     * @param array $config
     *
     * @return $this
     */
    public function setConfig(array $config)
    {
        foreach ($config as $key => $value) {
            app('config')->set($key, $value);
        }

        return $this;
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

    /**
     * Define environment setup.
     *     This method is requred for the testbench CreatesApplication
     *
     * @return void
     */
    protected function getEnvironmentSetUp()
    {
        // Define your environment setup.
    }
}
