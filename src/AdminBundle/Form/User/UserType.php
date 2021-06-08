<?php

namespace AdminBundle\Form\User;

use AdminBundle\Enum\UserRoleEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class UserType
 *
 * @package AdminBundle\Form\User
 */
class UserType extends AbstractUserType
{
    /**
     * @var TokenStorageInterface
     */
    private $storage;

    /**
     * UserType constructor.
     *
     * @param TokenStorageInterface $storage
     */
    public function __construct(TokenStorageInterface $storage)
    {
        $this->storage = $storage;
    }

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

        $user = $this->storage->getToken()->getUser();

        $builder
            ->add('role', ChoiceType::class, [
                'choices'  => UserRoleEnum::getRoles()
            ])
            ->add('locale', ChoiceType::class, [
                'choices'  => [
                    $user->getLocale() === 'pl' ? 'Polskie' : 'Polieren' => 'pl',
                    $user->getLocale() === 'pl' ? 'Deutsch' : 'Deutsch' => 'de',
                ],
            ])
            ->add('isVisible', null, [
                'required' => false,
                'label' => 'Not visible'
            ]);
    }
}