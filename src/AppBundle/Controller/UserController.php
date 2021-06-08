<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\User\AbstractUser;
use AdminBundle\Entity\User\Admin;
use AdminBundle\Entity\User\User;
use AppBundle\Form\RegistrationType;
use AppBundle\Form\UserDataType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class UserController
 *
 * @Route("/user")
 *
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("")
     * @Template
     *
     * @param Request                 $request A http Request instance.
     * @param EncoderFactoryInterface $encoder Encoder Factory Interface.
     *
     * @return Response|array
     */
    public function indexAction(Request $request,  EncoderFactoryInterface $encoder)
    {
        $user = $this->getUser();
        if ($user === null) {
            throw new AccessDeniedException();
        }

        if ($user->getEmail() === 'test@mail.com') {
            throw new AccessDeniedException();
        }

        $form = $this
            ->createForm(UserDataType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $email = $user->getEmail();
            if ($this->checkEmail($email, $user->getId())) {
                return ['form' => $form->addError(new FormError('User with this email already exist'))->createView()];
            }
            $firmNumber = $user->getUstIdNr();
            if ($this->checkFirmNumber($firmNumber)) {
                return ['form' => $form->addError(new FormError('This USt-IdNr incorrect'))->createView()];
            }

            $newPassword = $user->getPlainPassword();
            if ($newPassword !== null) {
                $encoder = $encoder->getEncoder(AbstractUser::class);
                $user->setPassword($encoder->encodePassword($newPassword, $user->getSalt()));
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Ihre Daten wurden erfolgreich geändert');

            return $this->redirectToRoute('app_user_index');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @param string $email
     * @param string $userId
     *
     * @return bool
     */
    private function checkEmail(string $email, string $userId): bool
    {
        $em = $this->getDoctrine()->getManager();
        $checkUser = $em->getRepository(User::class)->checkEmail($email, $userId);
        $checkAdmin = $em->getRepository(Admin::class)->checkEmail($email, $userId);

        if ($checkUser !== null || $checkAdmin !== null) {

            return true;
        }

        return false;
    }

    /**
     * @param string $firmNumber
     *
     * @return bool
     */
    private function checkFirmNumber(string $firmNumber): bool
    {
        $letters = substr($firmNumber, 0, 2);
        $numbers = substr($firmNumber, 2);

        if (mb_strtoupper($letters) !== 'DE') {

            return true;
        }
        if ($numbers === false) {

            return true;
        }
        if (!is_numeric($numbers) || mb_strlen($numbers) !== 9) {

            return true;
        }

        return false;
    }
}