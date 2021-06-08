<?php

namespace AdminBundle\Command;

use AdminBundle\Entity\Currency;
use AdminBundle\Traits\ParseCurrency;
use Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ParseCurrencyRate
 *
 * @package AdminBundle\Command
 */
class ParseCurrencyRate extends AbstractCommand
{
    use ParseCurrency;

    /**
     * @var string
     */
    protected static $defaultName = 'app:parse:currency';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var int
     */
    private $tryCount = 0;

    /**
     * DeleteFromDoneList constructor.
     *
     * @param EntityManagerInterface $em     EntityManagerInterface instance.
     * @param LoggerInterface        $logger LoggerInterface.
     */
    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger
    ) {
        parent::__construct();
        $this->em     = $em;
        $this->logger = $logger;
    }

    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Parse currency rate');
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface  $input  An InputInterface instance.
     * @param OutputInterface $output An OutputInterface instance.
     *
     * @return null|integer Null or 0 if everything went fine, or an error code.
     *
     * @see setCode()
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->getCurrencyRate($this->em);
        } catch (\Throwable $exception) {
            $this->logger->error('parse', [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
            ]);
        }

        return 0;
    }
}