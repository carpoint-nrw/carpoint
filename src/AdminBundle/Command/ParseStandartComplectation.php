<?php

namespace AdminBundle\Command;

use AdminBundle\Entity\Car;
use Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ResetCarCreatedAt
 *
 * @package AdminBundle\Command
 */
class ParseStandartComplectation extends AbstractCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:parse:standart:complectation';

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
        $this->setDescription('Parse Standart Complectation');
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
        /** @var \AppBundle\Repository\CarRepository $carRepo */
        
        $carRepo = $this->em->getRepository(Car::class);
        $cars = $carRepo->findAll(['carVisibility' => true]);
        
        foreach ($cars as $car) {
        /** @var \AdminBundle\Entity\Car $car */
            dump($car->getId(), $car->getStandartComplectationGerman());
            
        }
        dump(count($cars));
        
//        $this->em->flush();

        return 0;
    }
}