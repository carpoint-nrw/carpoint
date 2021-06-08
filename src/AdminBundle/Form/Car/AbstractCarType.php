<?php

namespace AdminBundle\Form\Car;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\User\Admin;
use AdminBundle\Enum\CarConditionEnum;
use AdminBundle\Enum\UserRoleEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class CarType
 *
 * @package AdminBundle\Form\Car
 */
abstract class AbstractCarType extends AbstractType
{
    /**
     * @var TokenStorageInterface
     */
    private $storage;

    /**
     * AbstractCarType constructor.
     *
     * @param TokenStorageInterface $storage
     */
    public function __construct(TokenStorageInterface $storage)
    {
        $this->storage = $storage;
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
                'data_class' => Car::class,
                'allow_extra_fields' => true
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

    /**
     * @param FormBuilderInterface $builder
     * @param string               $role
     *
     * @return array
     */
    protected function getCarCondition(FormBuilderInterface $builder, string $role = ''): array
    {
        $data = $builder->getData();
        $user = $this->storage->getToken()->getUser();
        $result = [
            'choices'  => [
                '' => '',
                'Sold' => 'sold',
            ],
            'required' => false
        ];

        $customer = $data->getCustomer() !== null ? $data->getCustomer()->getTitle() : '';
        if ($customer === 'Carpoint') {
            $result['required'] = true;
            $result['choices']['Reservation'] = 'reservation';
            unset($result['choices']['']);
            return $result;
        }

        if (
            $data->getCarCondition() === CarConditionEnum::RESERVATION
            && !in_array(
                $role,
                [
                    UserRoleEnum::ROLE_ADMIN_1,
                    UserRoleEnum::ROLE_ADMIN_12,
                    UserRoleEnum::ROLE_ADMIN_13,
                    UserRoleEnum::ROLE_ADMIN_9,
                    UserRoleEnum::ROLE_ADMIN_8,
                    UserRoleEnum::ROLE_ADMIN_11,
                ]
            )
        ) {
            $salesmanId = $data->getSalesman() !== null ? $data->getSalesman()->getId() : '';
            if ($user->getId() !== $salesmanId) {
                $result['disabled'] = 'disabled';
            }
            $result['choices']['Reservation'] = 'reservation';
            return $result;
        }

        if ($data->getCarCondition() === CarConditionEnum::SOLD && $role === UserRoleEnum::ROLE_ADMIN_14) {
            $result['disabled'] = 'disabled';

            return $result;
        }

        if ($this->getPermissionForCarCondition($data, $user)) {
            $result['choices']['Reservation'] = 'reservation';
        }

        return $result;
    }

    /**
     * @param Car   $car
     * @param Admin $admin
     *
     * @return boolean
     */
    private function getPermissionForCarCondition(Car $car, Admin $admin): bool
    {
        $userId = $admin->getId();
        $userBookings = [];
        foreach ($car->getSalesmanBookings() as $booking) {
            if ($booking->getAdmin()->getId() === $userId) {
                $userBookings[] = $booking;
            }
        }

        $date = (new \DateTime())->modify('-1 week');
        foreach ($userBookings as $key => $booking) {
            if ($booking->getBookTime() < $date) {
                unset($userBookings[$key]);
            }
        }

        return !(\count($userBookings) >= 2);
    }
}