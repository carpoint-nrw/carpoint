<?php

namespace AdminBundle\Command;

use AdminBundle\Entity\References\Color;
use AdminBundle\Entity\References\BaseColor;
use Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ResetCarCreatedAt
 *
 * @package AdminBundle\Command
 */
class ParseColor extends AbstractCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:parse:color';

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
        $this->setDescription('Parse Color');
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
        /** @var \AppBundle\Repository\References\ColorRepository $repo */
        
        $colorRepo = $this->em->getRepository(Color::class);
        $baseColorRepo = $this->em->getRepository(BaseColor::class);
        //$colors = $colorRepo->getAll();
        $baseColors = $baseColorRepo->findAll();
        
        foreach ($baseColors as $baseColor) {
            /** @var \AdminBundle\Entity\References\BaseColor $baseColor */
            echo 'Base color: ';
            dump( $baseColor->getGerman());
            // For compare change name
            $name_baseColor = mb_strtolower($baseColor->getGerman());
            
            //Find colors that contains word "base color"
            $colors = $colorRepo->findByBaseColor($name_baseColor);
            foreach ($colors as $color){
                /** @var \AdminBundle\Entity\References\Color $color */
                // For compare change name
                $name_color = mb_strtolower($color->getGerman());
                
                //For exclude double color, where base color is second one
                if(false !== strpos(explode('und', $name_color)[0], $name_baseColor)){
                    dump($color->getGerman());
                    $color->setBaseColor($baseColor);
                }
                
                //Check for metallic
                if(false !== strpos( $name_color, 'metal')){
                    echo 'is metlic: ';
                    dump($color->getGerman());
                    $color->setMetallic(true);
                }
                
            }
            
        }
        
        $this->em->flush();

        return 0;
    }
}