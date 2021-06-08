<?php

namespace AdminBundle\Form\References;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RegistrationCertificateType
 *
 * @package AdminBundle\Form\References
 */
class RegistrationCertificateType extends AbstractReferencesType
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

        $builder->add('description');
    }
}