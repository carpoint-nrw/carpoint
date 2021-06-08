<?php

namespace AdminBundle\Form;

use AdminBundle\Entity\User\Admin;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CarFileTypeFormType
 *
 * @package AdminBundle\Form
 */
class CarFileTypeFormType extends AbstractType
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
            ->add('type')
            ->add(
                'carFilePermission',
                EntityType::class,
                [
                    'class'         => Admin::class,
                    'required'      => false,
                    'expanded'      => true,
                    'multiple'      => true,
                    'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('admin')
                            ->orderBy('admin.firstName', 'ASC');
                    },
                ]
            );
    }
}