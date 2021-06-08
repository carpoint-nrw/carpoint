<?php

namespace AdminBundle\Form;

use AdminBundle\Entity\User\User;
use AdminBundle\Form\User\AbstractUserType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class UserType
 * @package AdminBundle\Form
 */
class UserType extends AbstractUserType
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
        $formType = $options['attr']['type'];
        $passwordRequired = $formType === 'new' ? true : false;

        $data = $builder->getData();

        $builder
            ->add('email', EmailType::class, ['constraints' => new NotBlank()])
            ->add('password', PasswordType::class, ['required' => $passwordRequired])
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
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
                'data' => 'Male',
                'expanded' => true,
                'required' => true,
            ])
            ->add('abbreviation', null, ['required' => false])
            ->add('targetUnload', null, [
                'required'      => false,
                'query_builder' => function (EntityRepository $er) use ($data) {
                    $targetUnloadId = $data->getTargetUnload() !== null ? $data->getTargetUnload()->getId() : null;

                    $query = $er->createQueryBuilder('u')
                        ->leftJoin('u.user', 'user')
                        ->where('user.targetUnload is null');

                    if ($targetUnloadId !== null) {
                        $query
                            ->orWhere('u.id = :id')
                            ->setParameter('id', $targetUnloadId);
                    }

                    return $query;
                },
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