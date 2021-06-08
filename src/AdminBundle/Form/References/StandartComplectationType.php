<?php

namespace AdminBundle\Form\References;

use AdminBundle\Entity\References\Brand;
use AdminBundle\Entity\References\Model;
use AdminBundle\Entity\References\StandartComplectation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class StandartComplectationType
 *
 * @package AdminBundle\Form\References
 */
class StandartComplectationType extends AbstractType
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
        parent::buildForm($builder, $options);

        $data = $builder->getData();
        $version = $data->getVersion();
        $model = $version !== null ? $version->getModel() : null;
        $brand = $model !== null ? $model->getBrand() : null;

        $builder
            ->add('brand', EntityType::class, [
                'required' => true,
                'class' => Brand::class,
                'data' => $brand,
            ])
            ->add('model', EntityType::class, [
                'required' => true,
                'class' => Model::class,
                'data' => $model,
            ])
            ->add('version', null, ['required' => true])
            ->add('polish')
            ->add('german');
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => StandartComplectation::class,
            ]
        );
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}