<?php

namespace AppBundle\Form;

use AdminBundle\Entity\User\User;
use AdminBundle\Form\User\AbstractUserType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserDataType
 *
 * @package AppBundle\Form
 */
class UserDataType extends AbstractUserType
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
            ->add('email', EmailType::class)
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type'            => PasswordType::class,
                    'invalid_message' => 'The password fields must match',
                    'required'        => false,
                    'error_bubbling'  => true,
                ]
            )
            ->add('firstName', null, ['required' => true])
            ->add('lastName', null, ['required' => true])
            ->add('phoneNumber')
            ->add('firmNumber', null, ['required' => true])
            ->add('ustIdNr', null, ['required' => true])
            ->add('street', null, ['required' => true])
            ->add('placeIndex', null, ['required' => true])
            ->add('city', null, ['required' => true])
            ->add('country', ChoiceType::class, [
                'choices'  => [
                    'DE Deutschland' => 'DE Deutschland',
                    'AT Österreich'  => 'AT Österreich',
                    'PL Polska'      => 'PL Polska',
                    'IT Italia'      => 'IT Italia',
                    'FR France'      => 'FR France',
                    'CZ Česká'       => 'CZ Česká',
                    'BE Belgien'     => 'BE Belgien',
                ],
                'required' => true,
            ])
            ->add('mobileNumber', null, ['required' => true])
            ->add('fax')
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Mann' => 'Male',
                    'Frau' => 'Female',
                ],
                'expanded' => true,
                'required' => true,
            ]);
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
                'data_class' => User::class,
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