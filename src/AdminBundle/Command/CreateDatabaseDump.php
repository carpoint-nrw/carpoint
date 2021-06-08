<?php

namespace AdminBundle\Command;

use AdminBundle\Entity\DatabaseDump;
use Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDatabaseDump extends AbstractCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:create:dump';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $dumpPath;

    /**
     * @var string
     */
    private $databaseName;

    /**
     * @var string
     */
    private $databaseUser;

    /**
     * @var string|null
     */
    private $databasePassword;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * DeleteFromDoneList constructor.
     *
     * @param EntityManagerInterface $em               EntityManagerInterface instance.
     * @param string                 $dumpPath
     * @param string                 $databaseName
     * @param string                 $databaseUser
     * @param string|null            $databasePassword
     * @param LoggerInterface        $logger
     */
    public function __construct(
        EntityManagerInterface $em,
        string $dumpPath,
        string $databaseName,
        string $databaseUser,
        $databasePassword,
        LoggerInterface $logger
    ) {
        parent::__construct();
        $this->em               = $em;
        $this->dumpPath         = $dumpPath;
        $this->databaseName     = $databaseName;
        $this->databaseUser     = $databaseUser;
        $this->databasePassword = $databasePassword;
        $this->logger           = $logger;
    }

    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Create database dump');
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
            $this->logger->info('createDump', ['message' => 'init']);
            $fileName = time();

            $dump = (new DatabaseDump())
                ->setFileName($fileName . '.sql')
                ->setDate(new \DateTime());
            $this->em->persist($dump);
            $this->em->flush();

            exec('mysqldump -u' . $this->databaseUser
//                . ' -p' . $this->databasePassword
                . ' ' . $this->databaseName
                .' > '
                . $this->dumpPath . '/' . $fileName . '.sql 2>&1', $output, $return_var
            );
            if ($return_var) {
                foreach ($output as $message){
                    throw new \ErrorException($message);
                }
            }

            if (!file_exists($this->dumpPath . '/' . $fileName . '.sql')) {
                throw new \ErrorException('Mysql file not found');
            }

            $this->logger->info('createDump', ['message' => 'complete']);
        } catch (\Throwable $exception) {
            $this->logger->error('createDump', [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
            ]);
            $this->em->remove($dump);
            $this->em->flush();
        }

        return 0;
    }
}