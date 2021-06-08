<?php

namespace AdminBundle\Command;

use AdminBundle\Entity\Car;
use Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ResetPayDateClick
 *
 * @package AdminBundle\Command
 */
class ResetPayDateClick extends AbstractCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:reset:date:pay:click';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DeleteFromDoneList constructor.
     *
     * @param EntityManagerInterface $em EntityManagerInterface instance.
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Reset date click');
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
        $cars = $this->em->getRepository(Car::class)->carsWithClickDate();
        foreach ($cars as $car) {
            $paidDate = $car->getPaidClick();
            if ($paidDate instanceof \DateTime) {
                $currentDate = new \DateTime();
                $diff = $currentDate->diff($paidDate)->format("%a");
                if ((int) $diff >= 2) {
                    $car->setPaidClick(null);
                }
            }
            $payDate = $car->getPayClick();
            if ($payDate instanceof \DateTime) {
                $currentDate = new \DateTime();
                $diff = $currentDate->diff($payDate)->format("%a");
                if ((int) $diff >= 2) {
                    $car->setPayClick(null);
                }
            }
        }
        $this->em->flush();

        return 0;
    }
}