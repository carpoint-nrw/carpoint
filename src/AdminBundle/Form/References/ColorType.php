<?php

namespace AdminBundle\Form\References;

use AdminBundle\Entity\References\Color;
use AdminBundle\Entity\References\BaseColor;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class ColorType
 *
 * @package AdminBundle\Form\References
 */
class ColorType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder.
     * @param array                $options The options.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('polish', null, ['required' => false])
            ->add('german', null, ['required' => false])
            ->add('baseColor',  EntityType::class, [
                'required' => true,
                'class' => BaseColor::class,
                'placeholder' => ' -- ',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')->orderBy('c.german', 'ASC');
                    },
                'choice_label' =>  function (?BaseColor $entity) {
                        return $entity ? $entity->getGerman() . ' / ' . $entity->getPolish()  : '';
                    },
                 ]);
    }
}