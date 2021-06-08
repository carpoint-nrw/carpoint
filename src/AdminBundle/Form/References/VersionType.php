<?php

namespace AdminBundle\Form\References;

use AdminBundle\Entity\References\Brand;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class VersionType
 *
 * @package AdminBundle\Form\References
 */
class VersionType extends AbstractType
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
        $data = $builder->getData();
        $model = $data->getModel();
        $brand = $model !== null ? $model->getBrand() : null;

        $builder
            ->add('brand', EntityType::class, [
                'required' => true,
                'class' => Brand::class,
                'data' => $brand,
            ])
            ->add('model', null, ['required' => true])
            ->add('polish', null, ['required' => false])
            ->add('german', null, ['required' => false])
            ->add('isVisible', null, [
                'required' => false,
                'label' => 'Not visible'
            ])
            ->add('sort', null, [
                'required' => false,
                'data' => 1
            ]);
    }
}