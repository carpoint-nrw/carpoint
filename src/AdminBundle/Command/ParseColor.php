<?php

namespace AdminBundle\Command;

use AdminBundle\Entity\References\Color;
use AdminBundle\Entity\References\BaseColor;

use Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
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
        $rsm = new ResultSetMapping();
        $insertQuery = $this->em->createNativeQuery('INSERT IGNORE INTO base_color(polish, german)'
                . ' VALUES '
                . "('Biały', 'Weiß'), "
                . "( 'Czerwone', 'Rot'),"
                . "( 'Pomaramcowy', 'Orange'),"
                . "( 'Szary', 'Grau'),"
                . "( 'Zelone', 'Grün'),"
                . "( 'Czarny', 'Schwarz'),"
                . "( 'Bez', 'Beige'),"
                . "( 'Niebieski', 'Blau'),"
                . "( 'Brązowy', 'Braun'),"
                . "( 'Wielobarwny', 'Mehrfarbig'),"
                . "( 'Żółty', 'Gelb'),"
                . "( 'Purpurowy', 'Lila'),"
                . "( 'Srebrny', 'Silber')"
                . '', $rsm);
       $insertQuery->execute();
       $insertQuery = $this->em->createNativeQuery('UPDATE car SET color_description_id = color_german_id ', $rsm);
       $insertQuery->execute();
       
       
        /** @var \AppBundle\Repository\References\ColorRepository $repo */
        $colorRepo = $this->em->getRepository(Color::class);
        $baseColorRepo = $this->em->getRepository(BaseColor::class);
        //$colors = $colorRepo->getAll();
        $baseColors = $baseColorRepo->findAll();
        
        foreach ($baseColors as $baseColor) {
                        
            $advancedColor = $colorRepo->findOneBy(['polish' => $baseColor->getPolish()]);
            if (null === $advancedColor){
                /** @var \AdminBundle\Entity\References\Color $newAdvancedColor  */
                $newAdvancedColor = new Color();
                $newAdvancedColor->setBaseColor($baseColor);
                $newAdvancedColor->setGerman($baseColor->getGerman());
                $newAdvancedColor->setPolish($baseColor->getPolish());
                $this->em->persist($newAdvancedColor);
                $this->em->flush();
            }
            
            
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
                $name_color_german = mb_strtolower($color->getGerman());
                $name_color_polish = mb_strtolower($color->getPolish());
                
                //For exclude double color, where base color is second one
                if(false !== strpos(explode('und', $name_color_german)[0], $name_baseColor)){
                    dump($color->getGerman());
                    $color->setBaseColor($baseColor);
                }
                
                //Check for metallic
                $posMetallicGerman = strpos( $name_color_german, 'metal') ;
                $posMetallicPolish = strpos( $name_color_polish, 'metal') ;
                if(false !== $posMetallicGerman ){
                    echo "is metallic: \n";
                    dump($color->getGerman());
                    dump($color->getPolish());
                    $color->setGerman(trim(substr_replace($color->getGerman(), '', $posMetallicGerman), ' -'));
                    if(false !== $posMetallicPolish){
                        $color->setPolish(trim(substr_replace($color->getPolish(), '', $posMetallicPolish), ' -'));
                    }
                    $color->setMetallic(true);
                }
                $doubleColors = $colorRepo->findBy([
                                                'german' => substr_replace($color->getGerman(), '', $posMetallicGerman),
                                                'polish' => substr_replace($color->getPolish(), '', $posMetallicPolish)
                                            ]);
                dump($color->getGerman());
                dump($color->getPolish());
                dump(count($doubleColors));
                if ( 1 == count($doubleColors)){
                    foreach ($color->getCarsGerman() as $car ){
                        $car->setColorGerman($doubleColors[0]);
                        $car->setColorPolish($doubleColors[0]);
                        $car->setColorDescription($doubleColors[0]);
                        $car->setColorMetallic($color->getMetallic());
                    }
                    $this->em->remove($color);

                }else{
                    foreach ($color->getCarsGerman() as $car ){
                        $car->setBaseColor($color->getBaseColor());
                        $car->setColorMetallic($color->getMetallic());
                        $car->setColorDescription($color);
                    }

                }
                    
                    
                
            
                $this->em->flush();
            }
            
        }
        
        

        return 0;
    }
}