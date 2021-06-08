<?php


namespace AdminBundle\DataFixtures\ORM;

use AdminBundle\Entity\User\AbstractUser;
use AdminBundle\Entity\User\Admin;
use AdminBundle\Enum\UserRoleEnum;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserFixture extends AbstractFixtures implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager A ObjectManager instance.
     */
    public function load(ObjectManager $manager)
    {
        /** @var EncoderFactoryInterface $encoderFactory */
        $encoderFactory = $this->container->get('security.encoder_factory');
        $encoder = $encoderFactory->getEncoder(AbstractUser::class);

        $admin = new Admin();
        $admin->setEmail('admin@admin.com');
        $admin->setPassword($encoder->encodePassword('admin', ''));
        $admin->setRole(UserRoleEnum::ROLE_ADMIN_1);
        $manager->persist($admin);
        $this->addReference('admin-1', $admin);

        $manager->flush();
    }
}