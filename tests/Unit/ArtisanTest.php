<?php

namespace TwoThirds\Testing\Unit;

use TwoThirds\Testing\TestCase;
use Illuminate\Foundation\Application;
use TwoThirds\ArtisanAnywhere\Artisan;
use TwoThirds\Testing\TestConsoleOutput;
use Illuminate\Foundation\Console\Kernel;
use Symfony\Component\Console\Input\ArgvInput;
use Illuminate\Foundation\Console\TestMakeCommand;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;

class ArtisanTest extends TestCase
{
    /**
     * The application implementation.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->app = (new Artisan)->getApplication();

        parent::setUp();
    }

    /**
     * @test
     */
    public function artisanConstructsApplication()
    {
        $artisan = new Artisan($this->app);

        $this->assertInstanceOf(Application::class, $artisan->getApplication());
    }

    /**
     * @test
     */
    public function artisanConstructsKernel()
    {
        $artisan = new Artisan($this->app);

        $this->assertInstanceOf(Kernel::class, $artisan->getKernel());
    }

    /**
     * @test
     */
    public function artisanRemovesConsoleSupportServiceProvider()
    {
        $artisan = new Artisan($this->app);

        $this->assertNotContains(
            ConsoleSupportServiceProvider::class,
            $artisan->getApplication()['config']['app.providers']
        );
    }

    /**
     * @test
     */
    public function artisanRegistersCommands()
    {
        $artisan = new Artisan($this->app);

        $this->assertNotContains(
            'make:test',
            array_keys($artisan->getKernel()->all())
        );

        $artisan->registerCommand(TestMakeCommand::class);

        $this->assertContains(
            'make:test',
            array_keys($artisan->getKernel()->all())
        );
    }

    /**
     * @test
     */
    public function artisanRegistersMultipleCommands()
    {
        $artisan = new Artisan($this->app);

        $this->assertNotContains(
            'make:test',
            array_keys($artisan->getKernel()->all())
        );

        $this->assertNotContains(
            'make:migration',
            array_keys($artisan->getKernel()->all())
        );

        $artisan->registerCommands([
            MigrateMakeCommand::class,
            TestMakeCommand::class,
        ]);

        $this->assertContains(
            'make:test',
            array_keys($artisan->getKernel()->all())
        );

        $this->assertContains(
            'make:migration',
            array_keys($artisan->getKernel()->all())
        );
    }

    /**
     * @test
     */
    public function artisanHandlesIO()
    {
        $artisan = new Artisan($this->app);

        $output = fopen('php://memory', 'rw');

        $artisan->handle(
            new ArgvInput([]),
            new TestConsoleOutput($output)
        );

        rewind($output);
        $output = stream_get_contents($output);

        $this->assertContains('Laravel Framework', $output);
        $this->assertContains('Available commands', $output);
    }

    /**
     * @test
     */
    public function artisanSetsConfigOnApp()
    {
        $artisan = new Artisan($this->app);

        $artisan->setConfig([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        $this->assertEquals('bar', $artisan->getApplication()['config']['foo']);
        $this->assertEquals('baz', $artisan->getApplication()['config']['bar']);
    }
}
