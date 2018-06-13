<?php

namespace TwoThirds\Testing;

use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;

/**
 * This class is basically a copy of \Symfony\Component\Console\Output\ConsoleOutput because
 * they use private methods that can't be overridden so we gotta do this copy / paste bullshit
 */
class TestConsoleOutput extends StreamOutput implements ConsoleOutputInterface
{
    protected $outputStream;
    protected $errorStream;
    private $stderr;
    private $consoleSectionOutputs = [];

    /**
     * @param resource $outputStream
     * @param resource|null $errorStream
     * @param int $verbosity
     * @param bool|null $decorated
     * @param \Symfony\Component\Console\Formatter\OutputFormatterInterface|null $formatter
     */
    public function __construct(
        $outputStream,
        $errorStream = null,
        int $verbosity = self::VERBOSITY_NORMAL,
        bool $decorated = null,
        OutputFormatterInterface $formatter = null
    ) {
        $this->outputStream = $outputStream;
        $this->errorStream  = $errorStream ?? @fopen('php://stderr', 'w');

        parent::__construct($this->outputStream, $verbosity, $decorated, $formatter);

        $actualDecorated = $this->isDecorated();
        $this->stderr    = new StreamOutput($this->errorStream, $verbosity, $decorated, $this->getFormatter());

        if ($decorated === null) {
            $this->setDecorated($actualDecorated && $this->stderr->isDecorated());
        }
    }

    /**
     * Creates a new output section.
     */
    public function section() : ConsoleSectionOutput
    {
        return new ConsoleSectionOutput($this->getStream(), $this->consoleSectionOutputs, $this->getVerbosity(), $this->isDecorated(), $this->getFormatter());
    }

    /**
     * {@inheritdoc}
     */
    public function setDecorated($decorated)
    {
        parent::setDecorated($decorated);
        $this->stderr->setDecorated($decorated);
    }

    /**
     * {@inheritdoc}
     */
    public function setFormatter(OutputFormatterInterface $formatter)
    {
        parent::setFormatter($formatter);
        $this->stderr->setFormatter($formatter);
    }

    /**
     * {@inheritdoc}
     */
    public function setVerbosity($level)
    {
        parent::setVerbosity($level);
        $this->stderr->setVerbosity($level);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorOutput()
    {
        return $this->stderr;
    }

    /**
     * {@inheritdoc}
     */
    public function setErrorOutput(OutputInterface $error)
    {
        $this->stderr = $error;
    }
}
